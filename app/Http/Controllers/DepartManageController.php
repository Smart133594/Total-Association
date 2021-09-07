<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Crypt;
use League\CommonMark\Node\Block\Document;

class DepartManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departs = Department::orderby('order')->get();
        return view('admin.departmanage.index', compact('departs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = new Department;
        $order = $store->max('order') + 1;
        $store->department = $request->department;
        $store->order = $order;
        $store->save();
        return redirect()->route("departmanage.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decryptString($id);

        $order = Department::where('id', $id)->value("order");
        $update_order = Department::where('order', '<', $order)->orderby('order', 'desc')->first();
        if($update_order) {
            Department::where('id', $id)->update(['order' => $update_order->order]);
            Department::where('id', $update_order->id)->update(['order' => $order]);
        }
        return redirect()->route("departmanage.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $order = Department::where('id', $id)->value("order");
        $update_order = Department::where('order', ">", $order)->orderby('order')->first();
        if($update_order){
            Department::where('id', $update_order->id)->update(['order' => $order]);
            Department::where('id', $id)->update(['order' => $update_order->value('order')]);
        }
        return redirect()->route("departmanage.index");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Department::where('id', '=', Crypt::decryptString($id))->delete();
        return redirect()->route("departmanage.index");
    }
}
