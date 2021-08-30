<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunchClockMeta extends Model
{
    use HasFactory;
    protected $fillable = ['punchclockid', 'latitude', 'longitude', 'country', 'area', 'postal_code', 'city', 'image', 'type', 'deviceid'];
}
