<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunchClock extends Model
{
    use HasFactory;
    protected $fillable = ['workerid', 'in_date', 'out_date', 'note'];
}
