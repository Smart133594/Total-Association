<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BuildingController extends Controller
{

    public function index()
    {
        $filter['association']=Subassociation::where('status',1)->get();

        $building=Building::orderby('id', 'desc');
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $building=$building->where('status',$_GET['status']);
        }
        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $building = $building->where('associationId', $_GET['association']);
        }

        $building=$building->get();

        foreach($building as $k=>$v){
            $building[$k]['edit_id']=Crypt::encryptString($v->id);
        }
        return view('admin.properties.buildings.index', ['alldata' => $building,'filter'=>$filter]);
    }
    public function create()
    {
        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('building','is13','address1','noOfFloors');
        return view('admin.properties.buildings.create',['validate'=>$validate,'subasso'=>$subasso]);
    }
    public function store(Request $request)
    {
        $name="Buildings";
        $path="buildings";


        if (isset($request->id)) {
            $store = Building:: find($request->id);
            foreach($request->files as $kk=>$r){
                $forimgupdate[$kk]=$store->$kk;
            }
        } else {
            $store = new Building();
            $request->validate([
                'building' => 'required'
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
            return redirect("/".$path."/" .Crypt::encryptString($request->id). "/edit");
        } else {
            $request->session()->flash("message", $name." has been added.");
            return redirect("/".$path);
        }
        //dont touch below ends
    }
    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $validate = array('building','is13','address1','noOfFloors');
        $property=Building::where('id',$id)->first();
        $subasso = Subassociation::where('status', 1)->get();
        return view('admin.properties.buildings.create',['data'=>$property,'validate'=>$validate,'subasso'=>$subasso]);
    }

    public function destroy($id)
    {
        $deletedata = Building::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
