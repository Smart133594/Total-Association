<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentNote extends Model
{
    use HasFactory;
    protected $fillable = ['departmenttaskid', 'userid', 'note'];
    public function DepartmentTask(){
        return $this->hasOne('App\Models\DepartmentTask', 'id', 'departmenttaskid');
    }
    public function Writter(){
        return $this->hasOne('App\Models\User', 'id', 'userid');
    }
}
