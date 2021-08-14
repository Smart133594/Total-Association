<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitiesType extends Model
{
    use HasFactory;
    protected $table="facilities_types";
    public function Facilities(){
        return $this->hasMany('App\Models\Facilities', 'facilitiesTypeId');
    }
}
