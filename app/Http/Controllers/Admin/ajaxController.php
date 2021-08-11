<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\City;
use App\Models\Guest;
use App\Models\Owner;
use App\Models\PaymentBracket;
use App\Models\Property;
use App\Models\Resident;
use Illuminate\Http\Request;
use DB;
use Storage;

class ajaxController extends Controller
{
    public function index()
    {

    }

    public function getcity(Request $request)
    {
        $city = City::where('state', $request->state)->get();
        echo '<option value="">--Select City--</option>';
        foreach ($city as $c) {
            echo '<option value="' . $c->cityName . '">' . $c->cityName . '</option>';
        }

    }

    public function getfloor($id)
    {
        $building = Building::where('id', $id)->first();
        echo '<option value="">--Select Floor--</option>';
        for ($x = 1; $x <= $building->noOfFloors; $x++) {
            if ($x == 13) {
                if ($building->is13 == 1) {
                    echo '<option value="' . $x . '">' . $x . '</option>';
                }
            } else {
                echo '<option value="' . $x . '">' . $x . '</option>';
            }

        }

    }

    public
    function deleteimg($table, $field, $id)
    {

        $allfield = DB::table($table)->where('id', $id)->get();
        $file = $allfield[0]->$field;
        DB::table($table)->where('id', $id)->update(array($field => ''));
        Storage::delete('/public/uploads/' . $file);
        Storage::delete('/public/uploads/thumb/' . $file);
    }


    public
    function statuschange($table, $field, $id)
    {
        $allfield = DB::table($table)->where('id', $id)->get();
        $status = $allfield[0]->$field;
        if ($status == 1) {
            DB::table($table)->where('id', $id)->update(array($field => '0'));
        } else {
            DB::table($table)->where('id', $id)->update(array($field => '1'));
        }

    }

    public function getresponsible($type)
    {
        if ($type == "Owner") {
            $data = Owner::get();
        }
        if ($type == "Residents") {
            $data = Resident::get();
        }
        if ($type == "Guests") {
            $data = Guest::get();
        }
        echo '<option value="">--choose--</option>';
        foreach ($data as $t) {
            if ($t->firstName) {
                echo '<option value="' . $t->id . '">' . $t->firstName . ' ' . $t->lastName . '</option>';
            }
        }
    }

    public function getbuilding($association)
    {
        $data = Building::where('associationId', $association)->get();

        echo '<option value="">--choose--</option>';
        foreach ($data as $t) {

            echo '<option value="' . $t->id . '">' . $t->building . '</option>';

        }
    }


    public function paymentbracket($association)
    {
        $data = PaymentBracket::where('associationId', $association)->get();

        echo '<option value="">--choose--</option>';
        foreach ($data as $t) {

            echo '<option value="' . $t->id . '">' . $t->payBracketName . '</option>';

        }
    }


    public function getproperty($association)
    {
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->where('properties.associationId', $association)
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        echo '<option value="">--choose--</option>';
        foreach ($property as $p) {
            if ($p->type == "Multi Dwelling") {
                echo '<option type="' . $p->type . '" value="' . $p->id . '">' . $p->building . ' - ' . $p->aptNumber . '</option>';
            } else {
                echo '<option type="' . $p->type . '" value="' . $p->id . '">' . $p->building . ' - ' . $p->address1 . '</option>';
            }

        }

    }

}
