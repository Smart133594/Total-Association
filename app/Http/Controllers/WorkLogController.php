<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Models\WorkForce;
use Illuminate\Http\Request;
use Auth;
use DB;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //
        $worklogs = new WorkLog();
        $workers = WorkForce::get();
        $status = 0;
        $employees = 0;
        $start_date = 0;
        $end_date = 0;
        $dataState = true;
        $editState = false;
        if(isset($request->status)){
            $status = $request->status;
        }
        if(isset($request->employees)){
            $employees = $request->employees;
            if($employees > 0) $worklogs = $worklogs->where('workerid', $employees);
        }
        if(isset($request->start_date)){
            $start_date = $request->start_date;
            $worklogs = $worklogs->where('date', '>=', $start_date);
        }else{
            $dataState = false;
        }
        if(isset($request->end_date)){
            $end_date = $request->end_date;
            $worklogs = $worklogs->where('date', '<=', $end_date);
        }
        $worklogs = $worklogs->get();
        return view("admin.WorkLog.index" , compact('worklogs', 'workers', 'dataState', 'editState'));
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
        //
        $workerid = Auth::user()->id;
        $date = date('Y-m-d', strtotime($request->date));
        $editid = $request->editid;
        if(intval($editid) > 0){
            $from_time = $request->from_time;
            $to_time = $request->to_time;
            $comment = $request->comment;
            WorkLog::where('id', $editid)->update(compact('workerid', 'date', 'from_time', 'to_time', 'comment'));
            session()->flash('success', "Successfully updated.");
        }else{
            WorkLog::create($request->merge(compact('workerid', 'date'))->all());
            session()->flash('success', "Successfully created.");
        }

        $worklogs = new WorkLog();
        $workers = WorkForce::get();
        $status = 0;
        $employees = 0;
        $start_date = 0;
        $end_date = 0;
        $dataState = true;
        $editState = true;

        if(isset($request->edit_status)){
            $status = $request->edit_status;
        }
        if(isset($request->edit_employees)){
            $employees = $request->edit_employees;
            if($employees > 0) $worklogs = $worklogs->where('workerid', $employees);
        }
        if(isset($request->edit_start_date)){
            $start_date = $request->edit_start_date;
            $worklogs = $worklogs->where('date', '>=', $start_date);
        }else{
            $dataState = false;
        }
        if(isset($request->edit_end_date)){
            $end_date = $request->edit_end_date;
            $worklogs = $worklogs->where('date', '<=', $end_date);
        }
        $worklogs = $worklogs->get();
        return view("admin.WorkLog.index" , compact('worklogs', 'workers', 'dataState', 'editState'));
    }

    public function getData(Request $request)
    {

        $employee = $request->employees;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($employee == 0)
        {
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }else{
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.workerid', $employee)
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }
        return $data;
    }

    public function saveData(Request $request){

        $employee = $request->employees;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $workerid = $employee;
        $date = date('Y-m-d', strtotime($request->date));
        $editid = $request->editid;
        if(intval($editid) > 0){
            $from_time = $request->from_time;
            $to_time = $request->to_time;
            $comment = $request->comment;
            WorkLog::where('id', $editid)->update(compact('workerid', 'date', 'from_time', 'to_time', 'comment'));
            session()->flash('success', "Successfully updated.");
        }else{
            WorkLog::create($request->merge(compact('workerid', 'date'))->all());
            session()->flash('success', "Successfully created.");
        }

        if($employee == 0)
        {
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }else{
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.workerid', $employee)
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }
        return $data;
    }

    public function deleteData(Request $request)
    {
        $employee = $request->employees;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        WorkLog::where('id', $request->id)->delete();   

        if($employee == 0)
        {
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }else{
            $data = DB::table('work_logs as A')
                ->leftjoin('work_forces as B', 'A.workerid', '=', 'B.id')
                ->where('A.workerid', $employee)
                ->where('A.date', '>=', $start_date)
                ->where('A.date', '<=', $end_date)
                ->select('A.id as id', 'A.date', 'A.from_time', 'A.to_time', 'A.comment', 'B.firstname', 'B.middlename', 'B.lastname')
                ->get()
                ->toArray();
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkLog  $workLog
     * @return \Illuminate\Http\Response
     */
    public function show(WorkLog $workLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkLog  $workLog
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkLog $workLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkLog  $workLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkLog $workLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkLog  $workLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkLog $workLog)
    {
        //
        $delete = $workLog->delete();
        if($delete){
            session()->flash('error', "Deleted Successfully.");
        }else{
            session()->flash('error', "Something went wrong.");
        }
        return redirect()->back();
    }
}
