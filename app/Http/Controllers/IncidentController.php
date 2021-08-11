<?php

namespace App\Http\Controllers;

use App\Mail\MailSend;
use App\Models\Building;
use App\Models\Guest;
use App\Models\Incident;
use App\Models\Owner;
use App\Models\Resident;
use App\Models\Setting;
use App\Models\Userdocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Property;
use App\Models\Incidentmedia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    public function index()
    {
        $incident = Incident::orderby('id', 'desc');

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
        return view('admin.member.incident.index', ['alldata' => $incident, 'property' => $property]);
    }

    public function create()
    {
        $ref = Incident::first();
        if ($ref) {
            $ref = $ref->id + 1;
        } else {
            $ref = 1;
        }


        $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
            ->get(['properties.*', 'property_types.type', 'buildings.building']);
        foreach ($properties as $k => $v) {
            $property[$v->id] = $v;
        }
        $validate = array('incidentTitle', 'incidentDescription', 'propertyId', 'individual', 'dateTime', 'outcome', 'responsiblePersonId');
        return view('admin.member.incident.create', ['validate' => $validate, 'property' => $property, 'ref' => $ref]);
    }

    public function store(Request $request)
    {
        $name = "Incident";
        $path = "incident";
        $all_images = $request->file('image');
        $all_video = $request->file('video');
        $all_documents = $request->file('documents');

        if (isset($request->id)) {
            $store = Incident:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Incident();
            $request->validate([
                'incidentTitle' => 'required'
            ]);
        }

        //dont touch below
        //save all field
        $all = $request->all();
        unset($all['_token']);
        $store->report_send_time = date('Y-m-d H:m:i');
        $store->fine_status = 0;
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }

        $store->save();


        if (!isset($request->id)) {
            $s = Setting::where('slug', 'incidentEmail')->first();
            $email1 = $s->value;
            if (!empty($request->individualType)) {
                if ($request->individualType == "Owner") {
                    $user = Owner::where('id', $request->responsiblePersonId)->first();
                    $email2 = $user->email;
                }
                if ($request->individualType == "Residents") {
                    $user = Resident::where('id', $request->responsiblePersonId)->first();
                    $email2 = $user->email;
                }
                if ($request->individualType == "Guests") {
                    $user = Guest::where('id', $request->responsiblePersonId)->first();
                    $email2 = $user->email;
                }

            }

            //sendmail
            $details = '
                            <h2>Title: ' . $request->incidentTitle . '</h2>
                            <p> ' . $request->incidentDescription . ' </p>

        ';

            if (isset($email1) && !empty($email1)) {
                Mail::to($email1)->send(new MailSend($details, 'Incident'));
            }

            if (isset($email2) && !empty($email2)) {
                Mail::to($email2)->send(new MailSend($details, 'Incident'));
            }

            //sendmail
        }
        //add extra media

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
        $properties = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->leftjoin('buildings', 'buildings.id', '=', 'properties.buildingId')
            ->get(['properties.*', 'property_types.type', 'buildings.building']);
        foreach ($properties as $k => $v) {
            $property[$v->id] = $v;
        }

        $incident = Incident::where('id', $id)->first();
        if ($incident->individualType == "Owner") {
            $user = Owner::get();
        }
        if ($incident->individualType == "Residents") {
            $user = Resident::get();
        }
        if ($incident->individualType == "Guests") {
            $user = Guest::get();
        }
        $ref = $incident->ref;

        $media = Incidentmedia::where('ref', $incident->ref)->get();
        $validate = array('incidentTitle', 'incidentDescription', 'propertyId', 'individual', 'dateTime', 'outcome', 'responsiblePersonId');
        return view('admin.member.incident.create', ['data' => $incident, 'validate' => $validate, 'property' => $property, 'user' => $user, 'media' => $media, 'ref' => $ref]);
    }

    public function destroy($id)
    {
        $deletedata = Incident::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function removemedia($id)
    {
        $media = Incidentmedia::where('id', $id)->first();
        $deletedata = Incidentmedia::find($id)->delete();
        Storage::delete('/public/uploads/' . $media->url);
        Storage::delete('/public/thumb/' . $media->url);
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function uploaddoc($ref)
    {
        $doc = Incidentmedia::where('ref', $ref)->get();
        return view('admin.member.incident.docform', ['ref' => $ref, 'data' => $doc]);
    }

    public function uploadincidentdocument(Request $request)
    {
        $store = new Incidentmedia();
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
