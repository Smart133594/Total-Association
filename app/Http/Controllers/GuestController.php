<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Guest;
use App\Models\Masterassociation;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Propertytype;
use App\Models\Resident;
use App\Models\Subassociation;
use App\Models\GuestsBlacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;

class GuestController extends Controller
{
    public function index()
    {


        $filter['association'] = Subassociation::where('status', 1)->orderBy('name')->get();


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


        $properties = Property::get();
        // $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            // ->get(['properties.*', 'property_types.type']);
        foreach ($properties as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$v->id] = $v;
            $property[$v->id]['building'] = $building['building'];
        }


        //filter

        $guest = Guest::leftjoin('properties', 'properties.id', '=', 'guests.propertyId')
            ->leftjoin('residents', 'residents.id', '=', 'guests.residentId')
            ->orderby('id', 'desc');
        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $guest = $guest->where('guests.status', 1);
            } elseif ($_GET['status'] == 2) {
                $guest = $guest->where('guests.status', 0);
            }
        } else {
            $guest = $guest->where('guests.status', 1);
        }


        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $guest = $guest->where('guests.associationId', $_GET['association']);
        }
        if (isset($_GET['building']) && !empty($_GET['building'])) {
            $guest = $guest->where('guests.buildingId', $_GET['building']);
        }
        if (isset($_GET['property']) && !empty($_GET['property'])) {
            $guest = $guest->where('guests.propertyId', $_GET['property']);
        }


        //filter
        $guest = $guest->get(['guests.*', 'properties.id as property_id', 'residents.firstName as rfname', 'residents.lastName as rlname']);

        foreach ($guest as $k => $v) {
            $guest[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.member.guest.index', ['alldata' => $guest, 'property' => $property, 'filter' => $filter,]);
    }

    public function create()
    {
        $validate = array('firstName', 'lastName', 'propertyId', 'residentId', 'phoneNumber', 'email', 'idDocument', 'startingDate', 'endDate');
        $property = Property::where('status', 1)->get();
        $resident = Resident::where('status', 1)->get();
        $subasso = Subassociation::where('status', 1)->get();
        $ptype = Propertytype::where('status', 1)->get();
        $building = Building::where('status', 1)->orderby('building')->get();

        $property_info = Property::get();
        foreach ($property_info as $key => $value) {
            $item_type = Propertytype::where('id', $value->typeId)->get()->first();
            $item_building = Building::where('id', $value->buildingId)->get()->first();
            $property_info[$key]['buildingName'] = $item_building->building;
            $property_info[$key]['type'] = $item_type->type;
        }

        return view('admin.member.guest.create', ['validate' => $validate, 'property' => $property, 'resident' => $resident, 'subasso' => $subasso, 'ptype' => $ptype, 'building' => $building, 'property_info' => $property_info]);
    }

    public function store(Request $request)
    {
        $name = "Guest";
        $path = "guest";


        if (isset($request->id)) {
            $store = Guest:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Guest();
            $request->validate([
                'firstName' => 'required'
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
        $id = Crypt::decryptString($id);
        $validate = array('firstName', 'lastName', 'propertyId', 'residentId', 'phoneNumber', 'email', 'startingDate', 'endDate');
        $guest = Guest::where('id', $id)->first();
        $property = Property::get();
        $resident = Resident::where('status', 1)->get();
        // $resident = Resident::where('propertyId', $guest->propertyId)->get();
        $subasso = Subassociation::where('status', 1)->get();
        $ptype = Propertytype::where('status', 1)->get();
        $building = Building::where('status', 1)->orderby('building')->get();
        $current_building = Building::where('id', $guest->buildingId)->first();
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
        $property_info = Property::get();
        foreach ($property_info as $key => $value) {
            $item_type = Propertytype::where('id', $value->typeId)->get()->first();
            $item_building = Building::where('id', $value->buildingId)->get()->first();
            $property_info[$key]['buildingName'] = $item_building->building;
            $property_info[$key]['type'] = $item_type->type;
        }
        return view('admin.member.guest.create', ['data' => $guest, 'validate' => $validate, 'property' => $property, 'resident' => $resident, 'subasso' => $subasso, 'ptype' => $ptype, 'building' => $building, 'floor' => $floor, 'property_info' => $property_info]);
    }

    public function destroy($id)
    {
        $deletedata = Guest::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function getresidents($id)
    {
        $resident = Resident::where('propertyId', $id)->get();
        echo '<option value="">--choose--</option>';
        foreach ($resident as $r) {
            echo '<option value="' . $r->id . '">' . $r->firstName . ' ' . $r->lastName . '</option>';
        }
    }
    public function addBlacklist($id, Request $request)
    {
        $id = Crypt::decryptString($id);
        $description = $request->block_desc;
        GuestsBlacklist::create([
            'guestid' => $id,
            'isblock' => true,
            'blockuserid' => Auth::user()->id,
            'description' => $description
        ]);
        return redirect('guest');
    }
    public function rmBlacklist($id)
    {
        GuestsBlacklist::where('id', $id)->delete();
        return redirect()->back();
    }
}
