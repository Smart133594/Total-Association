<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestsBlacklist extends Model
{
    use HasFactory;
    protected $fillable = ['guestid', 'isblock', 'blockuserid', 'description'];
    public function Guest(){
        return $this->hasOne('App\Models\Guest', 'id', 'guestid');
    }
    public function BlockUser(){
        return $this->hasOne('App\Models\User', 'id', 'blockuserid');
    }
}
