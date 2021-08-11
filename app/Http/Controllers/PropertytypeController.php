<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\PaymentBracket;
use App\Models\Propertytype;
use App\Models\Setting;
use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PropertytypeController extends Controller
{

    public function index()
    {
        $filter['association']=Subassociation::where('status',1)->get();

        $property_type=Propertytype::leftjoin('buildings','buildings.id','=','property_types.whichBuilding')
            ->orderby('property_types.id', 'desc');
        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status']==1) {
                $property_type = $property_type->where('property_types.status', 1);
            }elseif ($_GET['status']==2) {
                $property_type = $property_type->where('property_types.status', 0);
            }
        } else {
            $property_type=$property_type->where('property_types.status', 1);
        }

        if (isset($_GET['association']) && !empty($_GET['association'])) {
            $property_type = $property_type->where('property_types.associationId', $_GET['association']);
        }
        //filter

        $property_type=$property_type->get(['property_types.*','buildings.building']);

        foreach($property_type as $k=>$v){
            $property_type[$k]['edit_id']=Crypt::encryptString($v->id);
            $mf=PaymentBracket::where('id',$v->maintainenceFeeBracketId)->first();
            if($mf) {
                $property_type[$k]['maintainenceFeeBracket'] = $mf->payBracketName;
            }else{
                $property_type[$k]['maintainenceFeeBracket'] = "";
            }
        }
        return view('admin.properties.propertytype.index', ['alldata' => $property_type,'filter'=>$filter]);
    }
    public function create()
    {
        $subasso = Subassociation::where('status', 1)->get();
        $building=Building::where('status',1)->get();
        $payment_bracket=PaymentBracket::where('status',1)->get();
        $validate = array('type','propertyName','whichBuilding','maintainenceFeeBracket');
        return view('admin.properties.propertytype.create',['building'=>$building,'validate'=>$validate,'payment_bracket'=>$payment_bracket,'subasso'=>$subasso]);
    }
    public function store(Request $request)
    {
        $name="Property Type";
        $path="property-type";


        if (isset($request->id)) {
            $store = Propertytype:: find($request->id);
            foreach($request->files as $kk=>$r){
                $forimgupdate[$kk]=$store->$kk;
            }
        } else {
            $store = new Propertytype();
            $request->validate([
                'type' => 'required'
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
        $subasso = Subassociation::where('status', 1)->get();
        $id = Crypt::decryptString($id);
        $building=Building::where('status',1)->get();
        $validate = array('type','propertyName','whichBuilding','maintainenceFeeBracket');
        $property_type=Propertytype::where('id',$id)->first();
        $is_association=Setting::where('slug','is_subassociations')->first();
        if($is_association->value==1) {
            $payment_bracket = PaymentBracket::where('status', 1)->where('associationId', $property_type->associationId)->get();;
        }else{
            $payment_bracket = PaymentBracket::where('status', 1)->get();
        }

        return view('admin.properties.propertytype.create',['building'=>$building,'data'=>$property_type,'validate'=>$validate,'payment_bracket'=>$payment_bracket,'subasso'=>$subasso]);
    }

    public function destroy($id)
    {
        $deletedata = Propertytype::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
