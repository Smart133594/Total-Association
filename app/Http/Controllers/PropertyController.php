<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Guest;
use App\Models\Masterassociation;
use App\Models\PaymentBracket;
use App\Models\Pet;
use App\Models\Pettype;
use App\Models\Property;
use App\Models\Propertytype;
use App\Models\Resident;
use App\Models\Setting;
use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Owner;

class PropertyController extends Controller
{
    public function index()
    {

        $filter['association'] = Subassociation::where('status', 1)->orderBy('name')->get();

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $filter['building'] = Building::where('status', 1)->where('associationId',$_GET['association'])->get();
        }else{
            $filter['building'] = Building::where('status', 1)->get();
        }

        $building = Building::where('status', 1)->get();
        foreach ($building as $k => $v) {
            $buld[$v->id] = $v->building;
        }

        $owners = Owner::where('status', 1)->get();
        foreach ($owners as $k => $v) {
            if ($v->isCompany == 1) {
                if (isset($owner[$v->propertyId])) {
                    $owner[$v->propertyId] = $owner[$v->propertyId] ." / ".$v->companyLegalName;
                }else{
                    $owner[$v->propertyId] = $v->companyLegalName;
                }
            } else {
                if (isset($owner[$v->propertyId])) {
                    $owner[$v->propertyId] = $owner[$v->propertyId] ." / ". $v->firstName . ' ' . $v->lastName;
                } else {
                    $owner[$v->propertyId] = $v->firstName . ' ' . $v->lastName;
                }

            }
        }
        $residents = Resident::where('status', 1)->get();
        foreach ($residents as $k => $v) {
            $resident[$v->propertyId] = $v->firstName . ' ' . $v->lastName;
        }

        $property = Property::leftjoin('sub_associations', 'sub_associations.id', '=', 'properties.associationId')
            ->orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $property = $property->where('properties.status', 1);
            } elseif ($_GET['status'] == 2) {
                $property = $property->where('properties.status', 0);
            }
        } else {
            $property = $property->where('properties.status', 1);
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $property = $property->where('properties.associationId', $_GET['association']);
        }
        if (isset($_GET['building']) && !empty($_GET['building'])) {
            $property = $property->where('properties.buildingId', $_GET['building']);
        }

        //filter
        $property = $property->get(['properties.*', 'sub_associations.name']);

        foreach ($property as $k => $v) {
            $property[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.properties.properties.index', ['alldata' => $property, 'buld' => $buld, 'resident' => $resident, 'owner' => $owner, 'filter' => $filter]);
    }

    public function create()
    {
        $validate = array('typeId', 'buildingId', 'aptNumber', 'floorNumber', 'address1', 'city', 'state', 'country', 'zip');
        $subasso = Subassociation::where('status', 1)->get();
        $masasso = Masterassociation::where('status', 1)->get();
        $ptype = Propertytype::where('status', 1)->get();
        $payment_bracket = PaymentBracket::where('status', 1)->get();
        $building = Building::where('status', 1)->get();
        return view('admin.properties.properties.create', compact(['masasso', 'validate', 'subasso', 'ptype', 'building', 'payment_bracket']));
    }

    public function store(Request $request)
    {

        $name = "Properties";
        $path = "properties";

        if (isset($request->id)) {
            $store = Property:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Property();
            $request->validate([
                'typeId' => 'required'
            ]);
        }
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
        $id = Crypt::decryptString($id);
        $validate = array('typeId', 'buildingId', 'aptNumber', 'floorNumber', 'address1', 'city', 'state', 'country', 'zip');
        $masasso = Masterassociation::where('status', 1)->get();
        $property = Property::where('id', $id)->first();
        $subasso = Subassociation::where('status', 1)->get();
        $ptype = Propertytype::where('status', 1)->get();

        $payment_bracket = PaymentBracket::where('status', 1)->get();

        $is_association = Setting::where('slug', 'is_subassociations')->first();
        if ($is_association->value == 1) {
            $building = Building::where('status', 1)->where('associationId', $property->associationId)->get();
        } else {
            $building = Building::where('status', 1)->get();
        }

        $current_building = Building::where('id', $property->buildingId)->first();
        $floor = array();
        if (isset($current_building->noOfFloors)) {
            for ($x = 1; $x <= $current_building->noOfFloors; $x++) {
                if ($x == 13) {
                    if ($current_building->is13 == 1) {
                        $floor[] = $x;
                    }
                } else {
                    $floor[] = $x;
                }

            }
        }

        return view('admin.properties.properties.create', ['payment_bracket' => $payment_bracket, 'floor' => $floor, 'masasso' => $masasso, 'data' => $property, 'validate' => $validate, 'subasso' => $subasso, 'ptype' => $ptype, 'building' => $building]);
    }

    public function destroy($id)
    {
        $deletedata = Property::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function owner_property()
    {
        $filter['association'] = Subassociation::where('status', 1)->get();
        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $filter['building'] = Building::where('status', 1)->where('associationId',$_GET['association'])->get();
        }else{
            $filter['building'] = Building::where('status', 1)->get();
        }

        $building = Building::where('status', 1)->get();
        foreach ($building as $k => $v) {
            $buld[$v->id] = $v->building;
        }

        $owners = Owner::where('status', 1)->get();
        foreach ($owners as $k => $v) {
            if ($v->isCompany == 1) {
                if (isset($owner[$v->propertyId])) {
                    $owner[$v->propertyId] = $owner[$v->propertyId] ." / ".$v->companyLegalName;
                }else{
                    $owner[$v->propertyId] = $v->companyLegalName;
                }
            } else {
                if (isset($owner[$v->propertyId])) {
                    $owner[$v->propertyId] = $owner[$v->propertyId] ." / ". $v->firstName . ' ' . $v->lastName;
                } else {
                    $owner[$v->propertyId] = $v->firstName . ' ' . $v->lastName;
                }

            }
        }
        $residents = Resident::where('status', 1)->get();
        foreach ($residents as $k => $v) {
            $resident[$v->propertyId] = $v->firstName . ' ' . $v->lastName;
        }
        $property = Property::leftjoin('sub_associations', 'sub_associations.id', '=', 'properties.associationId')
            ->orderby('id', 'desc');


        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $property = $property->where('properties.status', 1);
            } elseif ($_GET['status'] == 2) {
                $property = $property->where('properties.status', 0);
            }
        } else {
            $property = $property->where('properties.status', 1);
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $property = $property->where('properties.associationId', $_GET['association']);
        }
        if (isset($_GET['building']) && !empty($_GET['building'])) {
            $property = $property->where('properties.buildingId', $_GET['building']);
        }

        //filter
        $property = $property->get(['properties.*', 'sub_associations.name']);
        foreach ($property as $k => $v) {
            $property[$k]['edit_id'] = Crypt::encryptString($v->id);
        }

        return view('admin.properties.properties.owner-property', ['alldata' => $property, 'buld' => $buld, 'owner' => $owner, 'resident' => $resident, 'filter' => $filter]);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->where('properties.id', $id)
            ->first(['properties.*', 'property_types.type']);
        $building = Building::where('id', $property->buildingId)->first();
        if ($building) {
            $property['building'] = $building->building;
        } else {
            $property['building'] = "";
        }
        $association = Subassociation::where('id', $property->associationId)->first();
        $property['sub_association'] = $association->name;

        //owner
        $owners = Owner::where('propertyId', $id)->get();

        $residents = Resident::where('propertyId', $id)->get();

        $guest = Guest::where('propertyId', $id)->get();

        $pet = Pet::where('propertyId', $id)->get();

        //owner
        $pettypes = Pettype::get();
        $owner = array();
        $pettype = array();
        foreach ($pettypes as $p) {
            $pettype[$p->id] = $p->petType;
        }
        foreach ($owners as $k => $p) {
            $owner[$p->id] = $p->firstName . " " . $p->lastName;
            $owners[$k]['owner_id'] = Crypt::encryptString($p->id);;
        }
        foreach ($residents as $k => $p) {
            $residents[$k]['owner_id'] = Crypt::encryptString($p->ownerId);;
        }
        foreach ($guest as $k => $p) {
            $guest[$k]['owner_id'] = Crypt::encryptString($p->ownerId);;
        }
        foreach ($pet as $k => $p) {
            $pet[$k]['owner_id'] = Crypt::encryptString($p->ownerId);;
        }


        return view('admin.properties.properties.show', ["property" => $property, 'owners' => $owners, 'owner' => $owner, 'pet' => $pet, 'guest' => $guest, 'residents' => $residents, 'pettype' => $pettype]);
    }
}
