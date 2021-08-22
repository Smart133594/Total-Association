<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;
    protected $fillable = ['workerid', 'date', 'from_time', 'to_time', 'comment'];
    public function Worker(){
        return $this->hasOne('App\Models\User', 'id', 'workerid');
    }
}
