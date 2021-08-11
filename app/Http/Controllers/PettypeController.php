<?php

namespace App\Http\Controllers;

use App\Models\Pettype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
 use App\Models\Property;

class PettypeController extends Controller
{
    public function index()
    {
        $pettype = Pettype::orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status']==1) {
                $pettype = $pettype->where('status', 1);
            }elseif ($_GET['status']==2) {
                $pettype = $pettype->where('status', 0);
            }
        } else {
            $pettype=$pettype->where('status', 1);
        }
        //filter

        $pettype=$pettype->get();

        foreach ($pettype as $k => $v) {
            $pettype[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.member.pet.pettype.index', ['alldata' => $pettype]);
    }

    public function create()
    {

        $validate = array('petType');
        return view('admin.member.pet.pettype.create', ['validate' => $validate]);
    }

    public function store(Request $request)
    {
        $name = "Pet Type";
        $path = "pettype";

        if (isset($request->id)) {
            $store = Pettype:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Pettype();
            $request->validate([
                'petType' => 'required'
            ]);
        }

        $request->vaccinations_list=json_encode($request->vaccinations_list);
        $request->description=json_encode($request->description);
        $request->required_by_law=json_encode($request->required_by_law);
        $request->doc_status=json_encode($request->doc_status);

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

    public function show()
    {

    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $validate = array('petType');
        $pettype = Pettype::where('id', $id)->first();
        return view('admin.member.pet.pettype.create', ['data' => $pettype, 'validate' => $validate]);
    }

    public function destroy($id)
    {
        $deletedata = Pettype::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
