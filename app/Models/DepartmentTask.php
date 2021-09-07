<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentTask extends Model
{
    use HasFactory;
    protected $fillable = ['departmentid', 'workerid', 'task', 'date', 'priority', 'state', 'description', "image"];
    public function Worker(){
        return $this->hasOne('App\Models\WorkForce', 'id', 'workerid');
    }
    public function Department(){
        return $this->hasOne('App\Models\Department', 'id', 'departmentid');
    }
    public function Note(){
        return $this->hasMany('App\Models\DepartmentNote', 'departmenttaskid');
    }
}
