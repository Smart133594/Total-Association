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
        return $this->hasOne('App\Models\Building', 'id', 'buildingId');
    }
    public function Subassociation(){
        return $this->hasOne('App\Models\Subassociation', 'id', 'associationId');
    }
    public function Owner(){
        return $this->hasMany('App\Models\Owner', 'propertyId');
    }
    public function Resident(){
        return $this->hasMany('App\Models\Resident', 'propertyId');
    }
    public function Guest(){
        return $this->hasMany('App\Models\Guest', 'propertyId');
    }
    public function Pet(){
        return $this->hasMany('App\Models\Pet', 'propertyId');
    }
}
