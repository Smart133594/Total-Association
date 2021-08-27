<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\WorkForce;
use App\Models\PunchClock;
use App\Models\PunchClockMeta;

class BaseController extends Controller
{
    public function heart(Request $request)
    {
        return response()->json(['success'=>true, 'userid' => Auth::user()->id], 200);
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            $data['token'] =  $user->createToken('token-name', ['server:update'])->plainTextToken;
            $data['user'] =  $user;
            return response()->json(['success'=>true, "data" => $data, 'message'=>"Login success"], 200);
        }
        return response()->json(['success'=>false, 'message'=>'Login failed'], 401);
    }
    public function clockState(Request $request)
    {
        $clock_code = $request->clock_code;
        $association = $request->association;

        $worker = WorkForce::where('punch_clock_code', $clock_code)->first();
        if($worker != null){
            $workerid = $worker->id;
            $punch_clock = PunchClock::where([
                'workerid' => $workerid,
                'association' => $association,
                'state' => 0
            ])->first();
            return response()->json(['success'=>true, 'punch_clock' => $punch_clock, 'worker' => $worker], 200);
        }else {
            return response()->json(['success'=>false, 'message'=>'Wrong Code. No employee found'], 200);
        }
    }
    public function clockUpdate(Request $request)
    {
        $id = $request->id;
        $state = $request->state;
        $workerid = $request->workerid;
        $association = $request->association;
        $now = $request->date;
        // $now = date("Y-m-d h:i:s", time());
        $type = 0;
        if($state == 0){
            $type = 1;
            PunchClock::where('id', $id)->update(['out_date' => $now, 'state' => 1]);
        }else{
            $id = PunchClock::create(['workerid' => $workerid, 'association' => $association, 'in_date' => $now, 'state' => 0])->id;
        }

        PunchClockMeta::create($request->merge(['punchclockid'=> $id, 'type' => $type])->all());

        return response()->json(['success'=>true], 200);
    }
    public function upload(Request $request)
    {
        $name = $this->uploadimage($request, "image");
        return response()->json(['success'=>true, 'name' => $name], 200);
    }
}
