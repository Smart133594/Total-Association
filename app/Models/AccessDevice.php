<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessDevice extends Model
{
    use HasFactory;
    protected $fillable = ['serial_number', 'ip_address', 'active'];
}
