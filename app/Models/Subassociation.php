<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subassociation extends Model
{
    use HasFactory;
    protected $table="sub_associations";
    public function Properties(){
        return $this->hasMany('App\Models\Property', 'associationId');
    }
}
