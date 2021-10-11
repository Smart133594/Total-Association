<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentTask;
use App\Models\DepartmentNote;
use App\Models\DepartmentFile;
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
        $workforce = WorkForce::get();

        $departs = Department::get();
        $notes = DepartmentNote::get();
        $str_departs = '';
        foreach ($departs as $key => $value) {
            $str_departs.="<option value='$value->id'>$value->department</option>";
        }
        $id = Crypt::decryptString($request->department);

        $department = Department::where('id', $id)->first();
        $department['edit_id'] = Crypt::encryptString($department->id);
        $departmentTask = null;
        $display_property = "display: none;";
        $taskState = false;

        $tasks = DepartmentTask::get();

        return view("admin.Department.create" , compact('department', 'notes', 'departmentTask', 'workforce', 'display_property', 'str_departs', 'tasks', 'taskState'));
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
        $workforce = WorkForce::get();

        $id = Crypt::decryptString($id);
        $departs = Department::get();

        $taskState = true;
        
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

        $files = DB::table('department_files as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $id)->select('A.id', 'B.name', 'A.name as fileName', 'A.type', 'A.note', 'A.updated_at')->get()->toArray();
        $notes = DB::table('department_notes as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $id)->select('A.id', 'B.name', 'A.note', 'A.updated_at')->get()->toArray();

        return view("admin.Department.create" , compact('departid', 'department', 'workforce', 'files', 'notes', 'departmentTask', 'taskState', 'display_property', 'str_departs'));
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

    public function save_task(Request $request)
    {
        $departmentid = Crypt::decryptString($request->departmentid);
        $departmentTaskid = '';
        if(isset($request->departmenttaskid))
        {
            $departmenttaskid = Crypt::decryptString($request->departmenttaskid);
            DepartmentTask::where('id', $departmenttaskid)
            ->update([
                'workerid' => $request->workerid,
                'task' => $request->task,
                'description' => $request->description,
                'date' => $request->date,
                'priority' => $request->priority,
                'state' => $request->state,
            ]);
            return "success";

        }else{
            $departmentTaskid = DepartmentTask::create($request->merge([
                'workerid' => $request->workerid,
                'departmentid' => $departmentid,
                'task' => $request->task,
                'date' => $request->date,
                'priority' => $request->priority,
                'state' => $request->state,
                'description' => $request->description,
            ])->all())->id;
            return Crypt::encryptString($departmentTaskid);
        }

    }

    public function add_note(Request $request)
    {

        $departmenttaskid = Crypt::decryptString($request->departmenttaskid);
        $table = new DepartmentNote;
        $table->departmenttaskid = $departmenttaskid;
        $table->userid = Auth::user()->id;
        $table->note = $request->note;
        $table->save();

        $data = DB::table('department_notes as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $departmenttaskid)->select('A.id', 'B.name', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
    }

    public function get_note(Request $request)
    {
        $data = DB::table('department_notes')->where('id', $request->id)->select('note')->get();
        return $data;
    }

    public function edit_note(Request $request)
    {
        $departmenttaskid = Crypt::decryptString($request->departmenttaskid);

        DepartmentNote::where('id', $request->id)
                ->update([
                    'note' => $request->note, 
                ]);

        $data = DB::table('department_notes as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $departmenttaskid)->select('A.id', 'B.name', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
    }

    public function delete_note(Request $request)
    {
        
        DepartmentNote::where('id', $request->id)->delete();   
        $departmentid = Crypt::decryptString($request->departmenttaskid);

        $data = DB::table('department_notes as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('departmenttaskid', $departmentid)->select('A.id', 'B.name', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
    }

    public function add_file(Request $request){

        $request->departmenttaskid = Crypt::decryptString($request->departmenttaskid);

        $store = new DepartmentFile();

        $store->userid = Auth::user()->id;

        $all = $request->all();

        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            $store->$kk = $this->uploadimage($request, $kk);
        }
        $store->save();

        $data = DB::table('department_files as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $request->departmenttaskid)->select('A.id', 'B.name', 'A.name as fileName', 'A.type', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
    }

    public function edit_file(Request $request){

        $departmenttaskid = Crypt::decryptString($request->departmenttaskid);

        $store = new DepartmentFile();

        if($request->fileEditState == "true")
        {
            foreach ($request->files as $kk => $r) {
                $url = $this->uploadimage($request, $kk);
            }
            DepartmentFile::where('id', $request->id)
                ->update([
                    'type' => $request->type,
                    'name' => $url,
                    'note' => $request->note, 
                ]);
            
        }else{
            DepartmentFile::where('id', $request->id)
            ->update([
                'note' => $request->note, 
            ]);
        }

        $data = DB::table('department_files as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $departmenttaskid)->select('A.id', 'B.name', 'A.name as fileName', 'A.type', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
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

    public function delete_file(Request $request)
    {
        $id = Crypt::decryptString($request->departmenttaskid);

        DepartmentFile::where('id', $request->id)->delete();
        $data = DB::table('department_files as A')->leftjoin('users as B', 'A.userid', '=', 'B.id')->where('A.departmenttaskid', $id)->select('A.id', 'B.name', 'A.name as fileName', 'A.type', 'A.note', 'A.created_at')->get()->toArray();
        return $data;
    }
}
