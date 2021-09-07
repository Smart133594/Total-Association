<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentTask;
use App\Models\Payroll;
use App\Models\WorkForce;
use Illuminate\Support\Facades\Crypt;
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;
use Throwable;

class WorkForceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $workers = WorkForce::get();
        foreach ($workers as $key => $value) {
            $departname = "";
            if($value->Department != null){
                $departname = $value->Department->department;
            }
            $workers[$key]['departname'] = $departname;
            
            $workers[$key]['edit_id'] = Crypt::encryptString($value->id);
        }
        return view("admin.workForce.index", compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::get()->sortby('order');
        $worker = null;
        $edit_id = null;
        return view("admin.workForce.create", compact('departments', 'worker', 'edit_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $birthday = date("$request->year-$request->month-$request->date");
        $phone = $request->phoneNo;
        $edit_id = $request->edit_id;

        $workforce_data = $request->merge(compact('birthday', 'phone'));
        if($request['choose-avatar']) {
            $avatar =  $this->uploadimage($request,"choose-avatar");
            $workforce_data = $request->merge(compact('avatar'));
        }
        if($request['choose-idcard']) {
            $idcard_image =  $this->uploadimage($request,"choose-idcard");
            $workforce_data = $request->merge(compact('idcard_image'));
        }
        if($request['choose-contracts']) {
            $contract_image =  $this->uploadimage($request,"choose-contracts");
            $workforce_data = $request->merge(compact('contract_image'));
        }
        $workforce_data = $request->all();
        
        // payroll
        $payroll_data = [
            "bank" => $request->bank,
            "routing_number" => $request->routing_number,
            "account_number" => $request->account_number,
            "filing_status" => $request->filing_status,
        ];
        
        if($edit_id) {
            $workerid = Crypt::decryptString($edit_id);
            WorkForce::find($workerid)->update($workforce_data);
        
            foreach ($payroll_data as $key => $value) {
                if($key && $value){
                    $exist = Payroll::where(compact('workerid', 'key'))->count();
                    if($exist > 0) {
                        $exist = Payroll::where(compact('workerid', 'key'))->update(compact('value'));
                    }else{
                        Payroll::create(compact('workerid', 'key', 'value'));
                    }
                }
            }
        }else{
            $workerid = WorkForce::create($workforce_data)->id;
            foreach ($payroll_data as $key => $value) {
                if($key && $value){
                    Payroll::create(compact('workerid', 'key', 'value'));
                }
            }
        }
        return redirect()->route("work-force.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decryptString($id);
        $worker = WorkForce::where('id', $id)->first();
        try {
            $number = PhoneNumber::parse($worker->phone);
            $worker->format_phone = $number->format(PhoneNumberFormat::INTERNATIONAL);
        }
        catch (Throwable $e) {
            $worker->format_phone = $worker->phone;
        }
        try {
            $number = PhoneNumber::parse($worker->whatsapp);
            $worker->format_whatsapp = $number->format(PhoneNumberFormat::INTERNATIONAL);
        }
        catch (Throwable $e) {
            $worker->format_whatsapp = $worker->whatsapp;
        }
        return view("admin.workForce.detail", compact('worker'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit_id = $id;
        $id = Crypt::decryptString($id);
        $departments = Department::get()->sortby('order');
        $worker = WorkForce::where('id', $id)->first();
        $birthday = strtotime($worker->birthday);
        $worker->year = intval(date('Y', $birthday));
        $worker->month = intval(date('m', $birthday));
        $worker->date = intval(date('d', $birthday));
        $worker->Payroll = $worker->Payroll();
        return view("admin.workForce.create", compact('departments', 'worker', 'edit_id'));
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
        //
        $id = Crypt::decryptString($id);
        $delete = WorkForce::where('id', $id)->delete();
        if($delete){
            session()->flash('error', "Deleted Successfully.");
        }else{
            session()->flash('error', "Something went wrong.");
        }
        return redirect()->back();
    }
}
