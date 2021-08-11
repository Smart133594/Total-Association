<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Incident;
use App\Models\Owner;
use App\Models\Resident;
use App\Models\Property;
use App\Models\Setting;
use App\Models\Subassociation;
use App\Models\Userdocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ResidentController extends Controller
{
    public function index()
    {

        $filter['association'] = Subassociation::where('status', 1)->orderBy('name')->get();
        foreach ($filter['association'] as $k => $as) {
            $association[$as->id] = $as->name;
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $filter['building'] = Building::where('status', 1)->where('associationId', $_GET['association'])->get();
            $filter['property'] = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
                ->where('properties.associationId', $_GET['association'])
                ->get(['properties.*', 'property_types.type', 'buildings.building']);
        } else {
            $filter['building'] = Building::where('status', 1)->get();
            $filter['property'] = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
                ->get(['properties.*', 'property_types.type', 'buildings.building']);
        }


        $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($properties as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$v->id] = $v;
            $property[$v->id]['building'] = $building['building'];
        }


        $owner = Resident::leftjoin('properties', 'properties.id', '=', 'residents.propertyId')->orderby('id', 'desc');
        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $owner = $owner->where('residents.status', 1);
            } elseif ($_GET['status'] == 2) {
                $owner = $owner->where('residents.status', 0);
            }
        } else {
            $owner = $owner->where('residents.status', 1);
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $owner = $owner->where('residents.associationId', $_GET['association']);
        }
        if (isset($_GET['building']) && !empty($_GET['building'])) {
            $owner = $owner->where('residents.buildingId', $_GET['building']);
        }
        if (isset($_GET['property']) && !empty($_GET['property'])) {
            $owner = $owner->where('residents.propertyId', $_GET['property']);
        }


        //filter
        $owner = $owner->get(['residents.*', 'properties.id as property_id']);
        foreach ($owner as $k => $v) {
            $incidient_count = Incident::where('responsiblePersonId', $v->id)->count();
            $owner[$k]['troubles'] = $incidient_count;
            $owner[$k]['edit_id'] = Crypt::encryptString($v->id);
        }


        return view('admin.member.resident.index', ['alldata' => $owner, 'property' => $property, 'filter' => $filter, 'association' => $association]);

    }

    public function create()
    {
        $ref = Resident::first();
        if ($ref) {
            $ref = $ref->id + 1;
        } else {
            $ref = 1;
        }

        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $building = Building::get();
        $validate = array('firstName', 'lastName', 'propertyId', 'mailingAddress1', 'mailingAddress2', 'city', 'country', 'state', 'zip', 'phoneNumber', 'email', 'isCompany');
        $validate2 = array('propertyId', 'mailingAddress1', 'mailingAddress2', 'city', 'country', 'state', 'zip', 'phoneNumber', 'email', 'einNumber', 'companyLegalName', 'inCorporation', 'isCompany', 'contactPerson');

        return view('admin.member.resident.create', ['validate' => $validate, 'validate2' => $validate2, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'ref' => $ref]);
    }

    public function store(Request $request)
    {
        $name = "Resident";
        $path = "resident";


        if (isset($request->id)) {
            $store = Resident:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Resident();
            $request->validate([
                'propertyId' => 'required'
            ]);
        }

        if (!isset($request->documentList)) {
            $store->documentList = 0;
        }
        if (!isset($request->history)) {
            $store->history = 0;
        }


        //dont touch below
        //save all field
        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            if (isset($request->id)) {
                $store->$kk = $this->replaceimage($request, $kk, $forimgupdate[$kk]);
            } else {
                $store->$kk = $this->uploadimage($request, $kk);
            }
        }
        $store->save();
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " has been Updated.");
            return redirect("/" . $path . "/" . Crypt::encryptString($request->id) . "/edit");
        } else {
            $request->session()->flash("message", $name . " has been added.");
            return redirect("/" . $path);
        }
        //dont touch below ends
    }

    public function edit($id)
    {
        $subasso = Subassociation::where('status', 1)->get();
        $id = Crypt::decryptString($id);


        $validate = array('firstName', 'lastName', 'propertyId', 'mailingAddress1', 'city', 'country', 'state', 'pincode', 'phoneNumber', 'email', 'einNumber', 'whatsapp', 'companyLegalName', 'inCorporation', 'isCompany', 'contactPerson');
        $resident = Resident::where('id', $id)->first();
        $ref = $resident->ref;

        $is_association = Setting::where('slug', 'is_subassociations')->first();
        if ($is_association->value == 1) {
            $building = Building::where('status', 1)->where('associationId', $resident->associationId)->get();
            $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->where('properties.associationId', $resident->associationId)
                ->get(['properties.*', 'property_types.type']);
        } else {
            $building = Building::where('status', 1)->get();
            $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->get(['properties.*', 'property_types.type']);
        }
        foreach ($property as $k => $v) {
            $build = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $build['building'];
        }

        foreach ($property as $k => $p) {
            $owner = Owner::where('propertyId', $p->id)->where('status', 1)->first();
            if (isset($owner)) {
                $property[$k]['owner'] = $owner->id;
            } else {
                $property[$k]['owner'] = "";
            }
        }

        return view('admin.member.resident.create', ['data' => $resident, 'validate' => $validate, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'ref' => $ref]);
    }

    public function destroy($id)
    {
        $deletedata = Resident::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function getownerdetails($id)
    {
        $owner = Owner::where('propertyId', $id)->first();
        return $owner;
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $owner = Owner::where('id', $id)->first();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->where('properties.id', $owner->propertyId)
            ->first(['properties.*', 'property_types.type']);
        $association = Subassociation::where('id', $property->associationId)->first();
        $property['association'] = $association->name;
        $building = Building::where('id', $property->buildingId)->first();
        if ($building) {
            $property['building'] = $building->building;
        } else {
            $property['building'] = "";
        }
        return view('admin.member.resident.show', ['data' => $owner, 'property' => $property]);
    }

    public function uploaddoc($ref)
    {
        $doc = Userdocuments::where('ref', $ref)->where('type', 'resident')->get();
        return view('admin.member.resident.docform', ['ref' => $ref, 'data' => $doc]);
    }

    public function uploadresidentdocument(Request $request)
    {

        $chk = Userdocuments::where('ref', $request->ref)->where('documentName', $request->documentName)->where('type', 'resident')->count();
        if ($chk == 0) {
            $store = new Userdocuments();
        } else {
            $store = Userdocuments::where('ref', $request->ref)->where('documentName', $request->documentName)->where('type', 'resident')->first();
        }

        $store->uploadOn = date('Y-m-d');
        $store->type = "resident";

        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            $store->$kk = $this->uploadimage($request, $kk);
        }
        $store->save();

    }
}
