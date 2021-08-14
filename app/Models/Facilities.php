<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    use HasFactory;
    protected $table="facilities";
    public function FacilitiesType(){
        return $this->hasOne('App\Models\FacilitiesType', 'id', 'facilitiesTypeId');
    }
    public function FacilitiesRent(){
        return $this->hasMany('App\Models\FacilityRent', 'facilities_id');
    }
}
