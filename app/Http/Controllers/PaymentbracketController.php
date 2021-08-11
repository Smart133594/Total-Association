<?php

namespace App\Http\Controllers;

use App\Models\PaymentBracket;
use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PaymentbracketController extends Controller
{

    public function index()
    {
        if(isset($_GET['status']) && !empty($_GET['status'])){
            $paymentBracket=PaymentBracket::orderby('id', 'desc')->where('status',$_GET['status'])->get();
        }else{
            $paymentBracket=PaymentBracket::orderby('id', 'desc')->get();
        }

        foreach($paymentBracket as $k=>$v){
            $paymentBracket[$k]['edit_id']=Crypt::encryptString($v->id);
        }
        return view('admin.properties.paymentbracket.index', ['alldata' => $paymentBracket]);
    }
    public function create()
    {
        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('payBracketName','feePaidPerMonth','feesValue','budget');
        return view('admin.properties.paymentbracket.create',['validate'=>$validate,'subasso'=>$subasso]);
    }
    public function store(Request $request)
    {
        $name="Payment Bracket";
        $path="payment-bracket";


        if (isset($request->id)) {
            $store = PaymentBracket:: find($request->id);
            foreach($request->files as $kk=>$r){
                $forimgupdate[$kk]=$store->$kk;
            }
        } else {
            $store = new PaymentBracket();
            $request->validate([
                'payBracketName' => 'required'
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
        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('payBracketName','feePaidPerMonth','feesValue','budget');
        $paymentBracket=PaymentBracket::where('id',$id)->first();
        return view('admin.properties.paymentbracket.create',['data'=>$paymentBracket,'validate'=>$validate,'subasso'=>$subasso]);
    }
    public function destroy($id)
    {
        $deletedata = PaymentBracket::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }
}
