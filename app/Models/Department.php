<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public function Workers(){
        return $this->hasMany('App\Models\WorkForce', 'departmentid');
    }
    public function Tasks(){
        return $this->hasMany('App\Models\DepartmentTask', 'departmentid');
    }
}
