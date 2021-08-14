<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $table="properties";
    public function PropertyType(){
        return $this->hasOne('App\Models\Propertytype', 'id', 'typeId');
    }
    public function Building(){
        return $this->hasMany('App\Models\Building', 'id', 'buildingId');
    }
}
