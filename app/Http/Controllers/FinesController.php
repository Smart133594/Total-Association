<?php

namespace App\Http\Controllers;

use App\Mail\MailSend;
use App\Models\Fines;
use App\Models\Guest;
use App\Models\Incident;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Resident;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class FinesController extends Controller
{

    public function index()
    {
        $incident = Incident::where('outcome', 'Fine')->orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $incident = $incident->where('status', 1);
            } elseif ($_GET['status'] == 2) {
                $incident = $incident->where('status', 0);
            }
        } else {
            $incident = $incident->where('status', 1);
        }
        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $fliter_id = Crypt::decryptString($_GET['id']);
            if ($_GET['filter'] == "owner") {
                $incident = $incident->where('individualType', 'Owner')->where('responsiblePersonId', $fliter_id);
            }
            if ($_GET['filter'] == "resident") {
                $incident = $incident->where('individualType', 'Residents')->where('responsiblePersonId', $fliter_id);
            }
            if ($_GET['filter'] == "property") {
                $incident = $incident->where('propertyId', $fliter_id);
            }

        }

        //filter

        $incident = $incident->get();
        $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
            ->get(['properties.*', 'property_types.type', 'buildings.building']);
        foreach ($properties as $k => $v) {
            $property[$v->id] = $v;
        }

        foreach ($incident as $k => $v) {
            $incident[$k]['edit_id'] = Crypt::encryptString($v->id);
            if ($v->individualType == "Owner") {
                $user = Owner::where('id', $v->responsiblePersonId)->first();
                $incident[$k]['ind'] = $user->firstName . " " . $user->lastName;
            }
            if ($v->individualType == "Residents") {
                $user = Resident::where('id', $v->responsiblePersonId)->first();
                $incident[$k]['ind'] = $user->firstName . " " . $user->lastName;
            }
            if ($v->individualType == "Guests") {
                $user = Guest::where('id', $v->responsiblePersonId)->first();
                $incident[$k]['ind'] = $user->firstName . " " . $user->lastName;
            }
            if ($v->individualType == "Unregistered") {
                $incident[$k]['ind'] = $v->name_of_description;
            }
        }


        return view('admin.fines.index', ['alldata' => $incident, 'property' => $property]);

    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $incident = Incident::where('id', $id)->orderby('id', 'desc')->first();
        $ref = $incident->ref;
        $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
            ->get(['properties.*', 'property_types.type', 'buildings.building']);
        foreach ($properties as $k => $v) {
            $property[$v->id] = $v;
        }

        if ($incident->individualType == "Owner") {
            $user = Owner::where('id', $incident->responsiblePersonId)->first();
            $incident['ind'] = $user->firstName . " " . $user->lastName;
        }
        if ($incident->individualType == "Residents") {
            $user = Resident::where('id', $incident->responsiblePersonId)->first();
            $incident['ind'] = $user->firstName . " " . $user->lastName;
        }
        if ($incident->individualType == "Guests") {
            $user = Guest::where('id', $incident->responsiblePersonId)->first();
            $incident['ind'] = $user->firstName . " " . $user->lastName;
        }
        if ($incident->individualType == "Unregistered") {
            $incident['ind'] = $incident->name_of_description;
        }


        return view('admin.fines.edit', ['data' => $incident, 'property' => $property, 'ref' => $ref]);
    }


    public function fineupdate(Request $request)
    {

        $name = "Fine";
        $path = "fines";

        $store = Incident:: find($request->id);
        //save all field
        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            $store->$kk = $this->uploadimage($request, $kk);
        }
        $store->save();

        //save all field
        if ($request->fine_status == 1) {
            $request->session()->flash("message", $name . " has been Closed.");
            return redirect("/" . $path);
        } else {
            $request->session()->flash("message", $name . " has been added.");
            return redirect("/" . $path . "/" . Crypt::encryptString($request->id) . "/edit");
        }
        //dont touch below ends

    }

    public function resendemail($id)
    {

        $fine = Incident::where('id', $id)->first();

        $s = Setting::where('slug', 'incidentEmail')->first();
        $email1 = $s->value;
        if (!empty($fine->individualType)) {
            if ($fine->individualType == "Owner") {
                $user = Owner::where('id', $fine->responsiblePersonId)->first();
                $email2 = $user->email;
            }
            if ($fine->individualType == "Residents") {
                $user = Resident::where('id', $fine->responsiblePersonId)->first();
                $email2 = $user->email;
            }
            if ($fine->individualType == "Guests") {
                $user = Guest::where('id', $fine->responsiblePersonId)->first();
                $email2 = $user->email;
            }

        }


        //sendmail
        $details = '
                            <h2>Title: ' . $fine->incidentTitle . '</h2>
                            <p> ' . $fine->incidentDescription . ' </p>

        ';

        if (isset($email1) && !empty($email1)) {
            Mail::to($email1)->send(new MailSend($details, 'Incident'));
        }

        if (isset($email2) && !empty($email2)) {
            Mail::to($email2)->send(new MailSend($details, 'Incident'));
        }

        //sendmail
        session()->flash("message", "mail has been resent");
        return redirect()->back();
    }

}
