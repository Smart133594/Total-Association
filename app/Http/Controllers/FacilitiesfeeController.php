<?php

namespace App\Http\Controllers;

use App\Models\FacilitiesFee;
use Illuminate\Http\Request;

class FacilitiesfeeController extends Controller
{
    public function facilitiestable($ref)
    {
        $doc = FacilitiesFee::where('ref', $ref)->get();
        return view('admin.facilities.ajaxfees', ['ref' => $ref, 'data' => $doc]);
    }

    public function insertfacilitiesfees(Request $request)
    {
        $store = new FacilitiesFee();
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
