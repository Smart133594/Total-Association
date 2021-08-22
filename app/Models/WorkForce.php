<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkForce extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'middlename', 'lastname', 'birthday', 'address1', 'address2', 'city', 'state', 'zipcode', 'phone', 'email', 'whatsapp', 'ssn', 'worker_type', 'department', 'start_date', 'end_date', 'salary_structure', 'salary', 'avatar', 'idcard_image', 'contracts_image', 'access_control_device', 'punch_clock_code', 'employee_pwd', 'manage_pwd', 'active_state', 'departmentid'];
    public function Department(){
        return $this->hasOne('App\Models\Department', 'id', 'departmentid');
    }
    public function DepartmentTasks(){
        return $this->hasMany('App\Models\DepartmentTask', 'workerid');
    }
    public function Payroll(){
        $data = $this->hasMany('App\Models\Payroll', 'workerid')->get();
        $res = [];
        foreach ($data as $key => $value) $res[$value->key] = $value->value;
        return $res;
    }
    public function PunchClock(){
        return $this->hasMany('App\Models\PunchClock', 'workerid');
    }
}
