<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Pet;
use App\Models\Petdocument;
use App\Models\Property;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Pettype;

class PetController extends Controller
{
    public function index()
    {
        $pet = Pet::orderby('id', 'desc');
        $property = array();
        $pettype = array();
        $owner = array();

        $properties = Property::get();
        $pettypes = Pettype::get();
        $owners = Owner::get();
        foreach ($properties as $p) {
            $property[$p->id] = $p->Building ? $p->Building->building : $p->id;
        }
        foreach ($pettypes as $p) {
            $pettype[$p->id] = $p->petType;
        }
        foreach ($owners as $p) {
            $owner[$p->id] = $p->firstName . " " . $p->lastName;
        }


        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $pet = $pet->where('status', 1);
            } elseif ($_GET['status'] == 2) {
                $pet = $pet->where('status', 2);
            } else {
                $pet = $pet->where('status', '<', 3);
            }
        } else {
            $pet = $pet->where('status', 0);
        }
        //filter

        $pet = $pet->get();

        foreach ($pet as $k => $v) {
            $pet[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.member.pet.pet.index', ['alldata' => $pet, 'owner' => $owner, 'pettype' => $pettype, 'property' => $property]);
    }

    public function create()
    {
        $ref = Pet::first();
        if ($ref) {
            $ref = $ref->id + 1;
        } else {
            $ref = 1;
        }
        $pet_documents = Petdocument::where('pet_ref', $ref)->get();
        foreach ($pet_documents as $v) {
            $pet_document[$v->tags] = $v;
        }
//dd($pet_document);
        $property = Property::get();
        $pettype = Pettype::where('status', 1)->get();
        $validate = array('pettypeId', 'propertyId', 'ownerId', 'petName', 'breedAndDesc', 'image', 'shotsValidDate', 'documents', 'supportAnimal');
        return view('admin.member.pet.pet.create', ['validate' => $validate, 'property' => $property, 'pettype' => $pettype, 'ref' => $ref, 'pet_document' => $pet_document]);
    }

    public function store(Request $request)
    {
        $name = "Pet Type";
        $path = "pet";

        if (isset($request->id)) {
            $store = Pet:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Pet();
            $request->validate([
                'petName' => 'required'
            ]);
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
            if (isset($request->approveDate)) {
                $request->session()->flash("message", $name . " has been approved.");
                return redirect("/" . $path);
            } else {
                $request->session()->flash("message", $name . " has been Updated.");
                return redirect("/" . $path . "/" . Crypt::encryptString($request->id) . "/edit");
            }
        } else {
            $request->session()->flash("message", $name . " has been added.");
            return redirect("/" . $path);
        }
        //dont touch below ends
    }

    public function show($id)
    {
        $data = Pet::where('id', $id)->first();

        echo '<table class="table">';
        echo '<tr><td style="width: 150px">Pet Name</td><td>' . $data->petName . '</td></tr>';
        echo '<tr><td style="width: 150px">Breed And Desc</td><td>' . $data->breedAndDesc . '</td></tr>';
        echo '<tr><td style="width: 150px">shotsValidDate</td><td>' . $data->shotsValidDate . '</td></tr>';
        echo '<tr><td>Image</td><td> <a href="/upload/' . $data->image . '" target="_blank"><img src="/thumb/' . $data->image . '" style="border-radius:0px;max-width:100px;"></a></td></tr>';
        echo '<tr><td>Documents</td><td> <a href="/upload/' . $data->documents . '" target="_blank">' . $data->documents . '</a></td></tr>';
        if ($data->supportAnimal == 1) {
            echo '<tr><td>Support Animal</td><td>No</td></tr>';
        } else {
            echo '<tr><td>Support Animal</td><td>Yes</td></tr>';
            echo '<tr><td>Support Documents</td><td> <a href="/upload/' . $data->supportDocuments . '" target="_blank">' . $data->supportDocuments . '</a></td></tr>';
        }
        if ($data->status == 1) {
            echo '<tr><td>Status</td><td>Approve</td></tr>';
        }
        if ($data->status == 0) {
            echo '<tr><td>Status</td><td>In Process</td></tr>';
        }
        if ($data->status == 2) {
            echo '<tr><td>Status</td><td>Denied</td></tr>';
        }
        echo '<tr><td>Approve Date</td><td>' . $data->approveDate . '</td></tr>';
        echo '<tr><td>Approve By</td><td>' . $data->approveBy . '</td></tr>';
        echo '<tr><td>Approve Documents</td><td> <a href="/upload/' . $data->approvalDocument . '" target="_blank">' . $data->approvalDocument . '</a></td></tr>';
        echo '</table>';
    }

    public function edit($id)
    {

        $id = Crypt::decryptString($id);
        $property = Property::get();
        $pettype = Pettype::where('status', 1)->get();
        $validate = array('pettypeId', 'propertyId', 'ownerId', 'petName', 'breedAndDesc', 'image', 'shotsValidDate', 'documents', 'supportAnimal');

        $pet = Pet::where('id', $id)->first();
        $ref = $pet->pet_ref;
        $pet_documents = Petdocument::where('pet_ref', $ref)->get();
        foreach ($pet_documents as $v) {
            $pet_document[$v->tags] = $v;
        }
        $owner = Owner::where('propertyId', $pet->propertyId)->get();
        return view('admin.member.pet.pet.create', ['data' => $pet, 'validate' => $validate, 'property' => $property, 'pettype' => $pettype, 'owner' => $owner, 'ref' => $ref, 'pet_document' => $pet_document]);
    }

    public function destroy($id)
    {
        $deletedata = Pet::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function declined($id)
    {
        $pet = Pet::where('id', $id)->update(['status' => 2]);
        return redirect()->back();
    }

    public function getsowner($id)
    {
        $owner = Owner::where('propertyId', $id)->get();
        echo "<option value=''>--choose--</option>";
        foreach ($owner as $o) {
            echo "<option value='" . $o->id . "'>" . $o->firstName . "</option>";
        }
    }

    public function approve($id)
    {
        $pet = Pet::where('id', $id)->first();
        return view('admin.member.pet.pet.approve-form', ['data' => $pet]);
    }

    public function getvaccination($id, $ref)
    {
        $pettype = Pettype::where('id', $id)->first();
        return view('admin.member.pet.pet.vdetails', ['ref' => $ref, 'pettype' => $pettype]);
    }

    public function showdetails($tags, $pet_ref)
    {
        $doc = Petdocument::where('pet_ref', $pet_ref)->where('tags', $tags)->first();;
        if($doc->documents == '') {
            echo '<p>Sorry. Not inputed file</p>';
            return;
        }
        if (strpos($doc->documents, 'pdf') == false) {
            echo '<img src="/upload/' . $doc->documents . '" style="width:100%">';
        } else {
            echo '<iframe src="/upload/' . $doc->documents . '" style="width:100%;height: 600px"></iframe>';
        }
    }

    public function uploaddocument(Request $request)
    {

        $chk = Petdocument::where('pet_ref', $request->pet_ref)->where('tags', $request->tags)->count();
        if ($chk == 0) {
            $store = new Petdocument();
        } else {
            $store = Petdocument::where('pet_ref', $request->pet_ref)->where('tags', $request->tags)->first();
        }

        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            $store->$kk = $this->uploadimage($request, $kk);
        }
        $store->save();
        return $store;
    }

}
