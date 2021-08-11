<?php

namespace App\Http\Controllers;

use App\Models\Masterassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MasterassociationController extends Controller
{

    public function index()
    {
        $master=Masterassociation::first();
        $validate = array('legalName','name','address1','city','country','state','pincode','phoneNo','email','einNumber');
        return view('admin.properties.masterassociations.index', ['data' => $master,'validate'=>$validate]);
    }
   /* public function create()
    {
        $validate = array('legalName','name','address1','city','country','state','pincode','phoneNo','email','einNumber','fax');
        return view('admin.properties.masterassociations.create',['validate'=>$validate]);
    }*/
    public function store(Request $request)
    {
        $name="Master Associations";
        $path="master-association";


        if (isset($request->id)) {
            $store = Masterassociation:: find($request->id);
            foreach($request->files as $kk=>$r){
                $forimgupdate[$kk]=$store->$kk;
            }
        } else {
            $store = new Masterassociation();
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
        foreach($request->files as $kk=>$r){
            if (isset($request->id)) {
                $store->$kk = $this->replaceimage($request, $kk, $forimgupdate[$kk]);
            } else {
                $store->$kk = $this->uploadimage($request, $kk);
            }
        }
        $store->save();
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name." has been Updated.");
            return redirect("/".$path);
        } else {
            $request->session()->flash("message", $name." has been added.");
            return redirect("/".$path);
        }
        //dont touch below ends
    }

    /*public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $validate = array('legalName','name','address1','city','country','state','pincode','phoneNo','email','einNumber','fax');
        $master=Masterassociation::where('id',$id)->first();
        return view('admin.properties.masterassociations.create',['data'=>$master,'validate'=>$validate]);
    }*/

    public function destroy($id)
    {
        $deletedata = Masterassociation::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
