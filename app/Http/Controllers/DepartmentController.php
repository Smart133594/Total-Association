<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentTask;
use App\Models\DepartmentNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = Department::select("*")->orderby('order')->get();
        foreach ($departments as $key => $value) {
            $departments[$key]['edit_id'] = Crypt::encryptString($value->id);
        }
        return view("admin.Department.index" , compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $id = Crypt::decryptString($request->department);
        $department = Department::where('id', $id)->first();
        $department['edit_id'] = Crypt::encryptString($department->id);
        $departmentTask = null;
        return view("admin.Department.create" , compact('department', 'departmentTask'));
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
        $departmentid = $request->departmentid;
        $departmentTaskid = $request->departmentTaskid;
        $departmentid = Crypt::decryptString($departmentid);
        $departmentTaskid = Crypt::decryptString($departmentTaskid);
        $workerid = $request->workerid;
        if(!$workerid) {
            $workerid = 0; 
        }
        if($departmentTaskid > 0) {
            DepartmentTask::find($departmentTaskid)
            ->update($request->merge([
                'workerid' => $workerid, 
                'departmentid' => $departmentid, 
                'state' => $request->status
                ])->all());
        }else{
            $departmentTaskid = DepartmentTask::create($request->merge([
                'workerid' => $workerid,
                'departmentid' => $departmentid,
                'state' => $request->status
            ])->all())->id;
        }
        foreach ($request->note as $key => $value) {
            if($value){
                DepartmentNote::create([
                    'departmenttaskid' => $departmentTaskid,
                    'userid' => Auth::user()->id,
                    'note' => $value
                ]);
            }
        }
        return redirect()->route("department.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decryptString($id);
        $department = Department::where('id', $id)->first();
        $department['edit_id'] = Crypt::encryptString($department->id);
        return view("admin.Department.detail" , compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decryptString($id);
        $departmentTask = DepartmentTask::where('id', $id)->first();
        // $id = Crypt::decryptString($request->department);
        $department = $departmentTask->Department;
        $departmentTask['edit_id'] = Crypt::encryptString($departmentTask->id);
        $department['edit_id'] = Crypt::encryptString($department->id);
        return view("admin.Department.create" , compact('department', 'departmentTask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $id = Crypt::decryptString($id);
        dd($id);
    }
}
