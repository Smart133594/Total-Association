<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PunchClock extends Model
{
    use HasFactory;
    protected $fillable = ['workerid', 'in_date', 'out_date', 'note', 'state', 'association', 'lat', 'lng'];
    public function Worker()
    {
        return $this->hasOne('App\Models\WorkForce', 'id', 'workerid');
    }
    public function PunchClockMeta(){
        return $this->hasMany('App\Models\PunchClockMeta', 'punchclockid');
        // $res = [];
        // $in_meta = null;
        // $out_meta = null;
        // foreach ($data as $key => $value) {
        //     if($value->type == 0){
        //         $in_meta = $value;
        //     }else if($value->type == 1){
        //         $out_meta = $value;
        //     }
        // };
        // return ['in_meta' => $in_meta, 'out_meta' => $out_meta];
    }

    public function Association() {
        return $this->hasOne('App\Models\Subassociation', 'id', 'association');
    }
}
