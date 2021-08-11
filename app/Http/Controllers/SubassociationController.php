<?php

namespace App\Http\Controllers;

use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SubassociationController extends Controller
{
    public function index()
    {
        $sub = Subassociation::orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status']==1) {
                $sub = $sub->where('status', 1);
            }elseif ($_GET['status']==2) {
                $sub = $sub->where('status', 0);
            }
        } else {
            $sub=$sub->where('status', 1);
        }
        //filter

        $sub=$sub->get();

        foreach ($sub as $k => $v) {
            $sub[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.properties.subassociations.index', ['alldata' => $sub]);
    }

    public function create()
    {
        $validate = array('legalName', 'name','address1', 'city', 'country', 'state', 'pincode', 'phoneNo', 'email', 'einNumber');
        return view('admin.properties.subassociations.create', ['validate' => $validate]);
    }

    public function store(Request $request)
    {
        $name = "Sub Associations";
        $path = "sub-association";


        if (isset($request->id)) {
            $store = Subassociation:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Subassociation();
            $request->validate([
                'name' => 'required'
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
        $validate = array('legalName', 'name', 'address1', 'city', 'country', 'state', 'pincode', 'phoneNo', 'email', 'einNumber');
        $sub = Subassociation::where('id', $id)->first();
        return view('admin.properties.subassociations.create', ['data' => $sub, 'validate' => $validate]);
    }

    public function destroy($id)
    {
        $deletedata = Subassociation::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
