<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $table="pet";
    
    public function PetType(){
        return $this->hasOne('App\Models\Pettype', 'id', 'pettypeId');
    }
    public function Owner(){
        return $this->hasOne('App\Models\Owner', 'id', 'ownerId');
    }
}
