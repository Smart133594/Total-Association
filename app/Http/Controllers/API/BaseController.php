<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\WorkForce;
use App\Models\PunchClock;
use App\Models\PunchClockMeta;
use App\Models\AccessDevice;
use App\Models\PunchClockAuth;
use App\Models\Subassociation;
use Illuminate\Support\Facades\Hash;

class BaseController extends Controller
{
    public function health(Request $request)
    {
        $association_id = $request->association_id;
        $serial_number = $request->serial_number;
        $ip_address = $request->ip_address;
        $user = Auth::user();
        $device_info = AccessDevice::where('serial_number', $serial_number)->first();
        if($device_info == null) {
            $device_info = AccessDevice::create([ 'serial_number' => $serial_number, 'ip_address' => $ip_address, 'active' => 0 ]);
        }

        $association = Subassociation::where('id', $association_id)->first();
       
        $data['user'] =  $user;
        $data['association'] =  $association;
        $data['device_info'] =  $device_info;

        return response()->json(['success'=>true, 'data' => $data], 200);
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $association = $request->association;
        $serial_number = $request->serial_number;
        $ip_address = $request->ip_address;

        $association = Subassociation::where('name', $association)->first();
        if($association == null){
            return response()->json(['success'=>false, 'message'=>'Association not registerd.'], 401);
        }
        $device_info = AccessDevice::where('serial_number', $serial_number)->first();
        if($device_info == null) {
            $device_info = AccessDevice::create([ 'serial_number' => $serial_number, 'ip_address' => $ip_address, 'active' => 0 ]);
        }
        $users = PunchClockAuth::where('username', $email)->get();
        foreach ($users as $key => $user) {
            if(Hash::check($password, $user->password)){
                $data['token'] =  $user->createToken('token-name', ['server:update'])->plainTextToken;
                $data['user'] =  $user;
                $data['association'] =  $association;
                $data['device_info'] =  $device_info;
                return response()->json(['success'=>true, "data" => $data, 'message'=>"Login success"], 200);
            }
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
       try {
        $id = $request->id;
        $state = $request->state;
        $workerid = $request->workerid;
        $association = $request->association;
        $now = $request->date;
        // $now = date("Y-m-d h:i:s", time());
        $type = 0;
        if($id > 0){
            $type = 1;
            PunchClock::where('id', $id)->update(['out_date' => $now, 'state' => 1]);
        }else{
            $id = PunchClock::create(['workerid' => $workerid, 'association' => $association, 'in_date' => $now, 'state' => 0])->id;
        }

        PunchClockMeta::create($request->merge(['punchclockid'=> $id, 'type' => $type])->all());

       } catch (\Throwable $th) {
           error_log($th->getMessage());
       }
        return response()->json(['success'=>true], 200);
    }
    public function upload(Request $request)
    {
        $name = $this->uploadimage($request, "image");
        return response()->json(['success'=>true, 'name' => $name], 200);
    }
}
