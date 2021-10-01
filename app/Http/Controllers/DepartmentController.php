<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentTask;
use App\Models\DepartmentNote;
use App\Models\WorkForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;

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
        $workforce = WorkForce::get();
        
        $departmentFirstName = DB::table('departments')->first();
        $departments = Department::select("*")->orderby('order')->get();
        foreach ($departments as $key => $value) {
            $departments[$key]['edit_id'] = Crypt::encryptString($value->id);
            
            if(isset($_GET['emp_'.$value->id])) {
                $emp_id = $_GET['emp_'.$value->id];
                if($emp_id > 0) {
                    $departments[$key]->Tasks = $departments[$key]->Tasks->where('workerid', $emp_id);
                }
            }

        }
        return view("admin.Department.index" , compact('departments', 'workforce'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $departs = Department::get();
        $str_departs = '';
        foreach ($departs as $key => $value) {
            $str_departs.="<option value='$value->id'>$value->department</option>";
        }
        $id = Crypt::decryptString($request->department);

        $department = Department::where('id', $id)->first();
        $department['edit_id'] = Crypt::encryptString($department->id);
        $departmentTask = null;
        $display_property = "display: none;";

        $tasks = DepartmentTask::get();

        return view("admin.Department.create" , compact('department', 'departmentTask', 'display_property', 'str_departs', 'tasks'));
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
        $departmentid = $request->depart; //$request->departmentid;
        $departmentid == null ? $departmentid = 0:$departmentid = 0;
        $departmentTaskid = $request->departmentTaskid;
        // $departmentid = Crypt::decryptString($departmentid);
        $workerid = $request->workerid;
        if(!$workerid) {
            $workerid = 0; 
        }
        
        $url = '';
        foreach ($request->files as $kk => $r) {
            $url = $this->uploadimage($request, $kk);
        }
        if($departmentTaskid) {
            $departmentTaskid = Crypt::decryptString($departmentTaskid);
            if($url == '') {
                DepartmentTask::where('id', $departmentTaskid)
                ->update([
                    'workerid' => $workerid, 
                    'departmentid' => $departmentid, 
                    'state' => $request->status,
                    'task' => $request->task,
                    'date' => $request->date,
                    'priority' => $request->priority,
                    'description' => $request->description,
                ]);
            } else {
                DepartmentTask::where('id', $departmentTaskid)
                ->update([
                    'workerid' => $workerid, 
                    'departmentid' => $departmentid, 
                    'state' => $request->status,
                    'task' => $request->task,
                    'date' => $request->date,
                    'priority' => $request->priority,
                    'description' => $request->description,
                    'image' => $url,
                ]);
            }
        }else{
            $departmentTaskid = DepartmentTask::create($request->merge([
                'workerid' => $workerid,
                'departmentid' => $departmentid,
                'state' => $request->status,
                'image' => $url,
            ])->all())->id;
        }
        // foreach ($request->note as $key => $value) {
        //     if($value){
        //         DepartmentNote::create([
        //             'departmenttaskid' => $departmentTaskid,
        //             'userid' => Auth::user()->id,
        //             'note' => $value
        //         ]);
        //     }
        // }
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
        $departs = Department::get();
        
        $departmentTask = DepartmentTask::where('id', $id)->first();
        // $id = Crypt::decryptString($request->department);
        $department = $departmentTask->Department;
        $departmentTask['edit_id'] = Crypt::encryptString($departmentTask->id);
        $departid = $departmentTask->departmentid;

        $str_departs = '';
        foreach ($departs as $key => $value) {
            $str_departs.="<option value='$value->id'>$value->department</option>";
        }

        $department['edit_id'] = Crypt::encryptString($department->id);
        $display_property = "";
        return view("admin.Department.create" , compact('departid', 'department', 'departmentTask', 'display_property', 'str_departs'));
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
        $id = Crypt::decryptString($id);
        $delete = DepartmentTask::where('id', $id)->delete();
        if($delete){
            session()->flash('error', "Deleted Successfully.");
        }else{
            session()->flash('error', "Something went wrong.");
        }
        return redirect()->back();
    }

    public function add_note($note)
    {
        $table = new DepartmentNote;
        $table->note = $note;
        $table->departmenttaskid = 1;
        $table->userid = 1;
        $table->note = $note;
        $table->save();
    }

    public function delete_note($id)
    {
        DepartmentNote::where('id', $id)->delete();   
    }

    public function delete_file($id)
    {
        DepartmentTask::where('id', $id)->delete();
    }
}
