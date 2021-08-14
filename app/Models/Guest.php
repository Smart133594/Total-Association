<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    public function BlackList(){
        return $this->hasOne('App\Models\GuestsBlacklist', 'guestid');
    }
    public function Properties(){
        return $this->hasOne('App\Models\GuestsBlacklist', 'guestid');
    }
}
