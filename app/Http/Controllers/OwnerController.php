<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Setting;
use App\Models\Subassociation;
use App\Models\Userdocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OwnerController extends Controller
{
    public function index()
    {
        $filter['association'] = Subassociation::where('status', 1)->orderBy('name')->get();


        if (isset($_GET['association']) && !empty($_GET['association'])) {

            $filter['building'] = Building::where('status', 1)->where('associationId',$_GET['association'])->get();
            $filter['property'] = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
                ->where('properties.associationId',$_GET['association'])
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


        $owner = Owner::leftjoin('properties', 'properties.id', '=', 'owners.propertyId')->orderby('id', 'desc');
        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $owner = $owner->where('owners.status', 1);
            } elseif ($_GET['status'] == 2) {
                $owner = $owner->where('owners.status', 0);
            }
        } else {
            $owner = $owner->where('owners.status', 1);
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $owner = $owner->where('owners.associationId', $_GET['association']);
        }
        if (isset($_GET['building']) && !empty($_GET['building'])) {
            $owner = $owner->where('owners.buildingId', $_GET['building']);
        }
        if (isset($_GET['property']) && !empty($_GET['property'])) {
            $owner = $owner->where('owners.propertyId', $_GET['property']);
        }

        //filter
        $owner = $owner->get(['owners.*', 'properties.id as property_id']);
        foreach ($owner as $k => $v) {
            $owner[$k]['edit_id'] = Crypt::encryptString($v->id);
        }

        return view('admin.member.owner.index', ['alldata' => $owner, 'property' => $property, 'filter' => $filter]);

    }

    public function create()
    {
        $ref = Owner::first();
        if ($ref) {
            $ref = $ref->id + 1;
        } else {
            $ref = 1;
        }

        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('firstName', 'lastName', 'propertyId', 'mailingAddress1', 'city', 'country', 'state', 'zip', 'phoneNumber', 'email', 'isCompany', 'einNumber', 'companyLegalName', 'inCorporation', 'contactPerson');
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }

        $building = Building::get();
        return view('admin.member.owner.create', ['validate' => $validate, 'property' => $property, 'subasso' => $subasso, 'building' => $building, 'ref' => $ref]);
    }

    public function store(Request $request)
    {
        $name = "Owner";
        $path = "owner";


        if (isset($request->id)) {
            $store = Owner:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Owner();
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
        $validate = array('firstName', 'middleName', 'lastName', 'propertyId', 'mailingAddress1', 'city', 'country', 'state', 'pincode', 'phoneNumber', 'email', 'einNumber', 'companyLegalName', 'inCorporation', 'isCompany', 'contactPerson');
        $owner = Owner::where('id', $id)->first();
        $ref = $owner->ref;


        $is_association = Setting::where('slug', 'is_subassociations')->first();
        if ($is_association->value == 1) {
            $building = Building::where('status', 1)->where('associationId', $owner->associationId)->get();
            $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
                ->where('properties.associationId', $owner->associationId)
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
        return view('admin.member.owner.create', ['data' => $owner, 'validate' => $validate, 'property' => $property, 'subasso' => $subasso, 'building' => $building, 'ref' => $ref]);
    }

    public function destroy($id)
    {
        $deletedata = Owner::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
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

        return view('admin.member.owner.show', ['data' => $owner, 'property' => $property]);
    }

    public function uploaddoc($ref)
    {
        $doc = Userdocuments::where('ref', $ref)->where('type', 'owner')->get();
        return view('admin.member.owner.docform', ['ref' => $ref, 'data' => $doc]);
    }

    public function uploadownerdocument(Request $request)
    {

        $chk = Userdocuments::where('ref', $request->ref)->where('documentName', $request->documentName)->where('type', 'owner')->count();
        if ($chk == 0) {
            $store = new Userdocuments();
        } else {
            $store = Userdocuments::where('ref', $request->ref)->where('documentName', $request->documentName)->where('type', 'owner')->first();
        }

        $store->uploadOn = date('Y-m-d');
        $store->type = "owner";

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
