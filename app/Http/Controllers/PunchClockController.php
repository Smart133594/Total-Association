<?php

namespace App\Http\Controllers;

use App\Models\PunchClock;
use App\Models\Department;
use App\Models\PunchClockMeta;
use App\Models\Subassociation;
use App\Models\WorkForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PunchClockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $workers = WorkForce::get();
        $departs = Department::get();
        $punchClock = new PunchClock;
        if(isset($request->employees)) {
            $punchClock = $punchClock->where('workerid', $request->employees);
        }
        if(isset($request->pay_from)){
            $pay_from = $request->pay_from;
            $punchClock = $punchClock->where(function ($query)  use ($pay_from){
                $query->where('in_date', '>=', $pay_from)->orWhere('in_date', null);
            });
        }
        if(isset($request->pay_to)){
            $pay_to = $request->pay_to;
            $punchClock = $punchClock->where(function ($query) use ($pay_to) {
                $query->where('out_date', '<=', $pay_to)->orWhere('out_date', null);
            });
            // $punchClock = $punchClock->where('out_date', '<=', $pay_to);
        }
        $punchClock = $punchClock->get();
        $total_duration = 0;
        $time = '';
        foreach ($punchClock as $key => $value) {
            if($value->out_date) {
                $duration = strtotime($value->out_date) - strtotime($value->in_date);

                $total_duration += $duration;
    
                $hours = intval($duration/3600);
                $duration=$duration%3600;
                $mins = intval($duration/60);
                $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
    
                $punchClock[$key]['duration'] = $times;
            }else{
                $punchClock[$key]['duration'] = "Current Clocked In";
            }

            // $punchClock->in_meta->AccessDevice->serial_number;
            $meta = $value->PunchClockMeta;
            foreach ($meta as $meta_key => $ele) {
                if($ele->type == 0) {
                    $punchClock[$key]->in_meta = $ele;
                }else{
                    $punchClock[$key]->out_meta = $ele;
                }
            }
        }
        $hours = intval($total_duration/3600);
        $total_duration=$total_duration%3600;
        $mins = intval($total_duration/60);
        $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
       
        foreach ($punchClock as $key => $value) {
            $punchClock[$key]['edit_id'] = Crypt::encryptString($value->id);
        }
        if(!isset($request->pay_from))
            $punchClock = null;

        return view('admin.PunchClock.index', compact('workers', 'punchClock', 'times', 'departs'));
    }
    public function exportTimeSheet(Request $request)
    {
        $userid = $request->userid;
        $pay_period_to = $request->pay_period_to;
        $pay_period_from = $request->pay_period_from;
        $decimal_total = $request->decimal_total;
        $time_24_format = $request->time_24_format;

        $punchClock = PunchClock::where('workerid', $userid);
        if(isset($request->pay_period_from)){
            $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
        }
        if(isset($request->pay_period_to)){
            $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
        }
        $punchClock = $punchClock->get();
        $result = ''; $res2 = ''; $result_duration = 0;
        $association = null;
        if(count($punchClock) == 0)
            return "noData";
        foreach ($punchClock as $key => $value) {
            if($key==0) {
                $association = Subassociation::where('id', $value->association)->first();
            }
            $index = $key+1;
           
            $string_format = "g:i A";
            if($time_24_format == "true") {
                $string_format = "H:i";
            }
            $clocked_in_dt = date('d/m/Y', strtotime($value->in_date));
            $clocked_in_time = date($string_format, strtotime($value->in_date));
            $clocked_out_dt = $value->out_date ? date('d/m/Y', strtotime($value->out_date)) : '-';
            $clocked_out_time = $value->out_date ? date($string_format, strtotime($value->out_date)) : '-';

            if($value->out_date){
                $duration = strtotime($value->out_date) - strtotime($value->in_date);

                if($request->hours_shift) {
                    if($duration > $request->hours_shift)
                        $duration -= $request->per_minutes * 60;
                }

                $result_duration += $duration;

                $hours = intval($duration/3600);
                $duration=$duration%3600;
                $mins = intval($duration/60);

                if($decimal_total == "false"){
                    $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                }else{
                    $time = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                    $hms = explode(":", $time);
                    $times = $hms[0] + ($hms[1]/60);
                    $times = number_format((float)$times, 2, '.', '');
                    // $times = "$hours hour".($hours>1 ? "s" :"")." $mins minute".($mins > 1) ? "s" : "";
                }
            }else{
                $times = "Clocked In";
            }
            
            $meta = $value->PunchClockMeta;
            $worker = $value->Worker;
            if($worker == null ) {
                $worker = ['firstname' => '', 'lastname' => '', 'middlename' => '', 'birthday' => ''];
            }

            $in_meta = null;
            $out_meta = null;

            // $lunch = explode(" ", $value->in_date)[1];
            // $lunch = substr($lunch, 0, 5);
            $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
            $res2.="<tr><td>$index</td>
            
            <td>$clocked_in_dt $clocked_in_time</td>
            <td>$clocked_out_dt $clocked_out_time</td>
            <td>$lunch</td>
            <td>$times</td>
        </tr>";

            foreach ($meta as $key => $value) {
                if(@$value->AccessDevice->type == 0) $in_meta = $value;
                else $out_meta = $value;
            }

            $result .= "<tr>
                            <td>$index</td>
                            <td>$worker->firstname $worker->middlename $worker->lastname</td>
                            <td>$worker->birthday</td>
                            <td>$clocked_in_dt</td>
                            <td>$clocked_in_time</td>
                        ". ($in_meta == null ? "<td/><td/><td/>" : 
                        "
                            <td>($in_meta->latitude, $in_meta->longitude)</td>
                            <td>$in_meta->country $in_meta->area $in_meta->city</td>
                            <td>$in_meta->postal_code</td>
                        ")."
                            <td>$clocked_out_dt</td>
                            <td>$clocked_out_time</td>
                            <td>$times</td>
                        ". ($out_meta == null ? "<td/><td/><td/>" : 
                        "
                            <td>($out_meta->latitude, $out_meta->longitude)</td>
                            <td>$out_meta->country $out_meta->area $out_meta->city</td>
                            <td>$out_meta->postal_code</td>
                        ")."
                        </tr>";
        }
        $result = " <table id='customers'>
                        <thead>
                            <tr>
                                <td rowspan='2'>No</td>
                                <td rowspan='2'>Worker Name</td>
                                <td rowspan='2'>Worker birthday</td>
                                <td colspan='5'>Clocked In</td>
                                <td colspan='5'>Clocked Out</td>
                                <td rowspan='2'>Total</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>Time</td>
                                <td>latitude, longitude</td>
                                <td>country area city </td>
                                <td>postal code</td>
                                <td>Date</td>
                                <td>Time</td>
                                <td>latitude, longitude</td>
                                <td>country area city </td>
                                <td>postal code</td>
                            </tr>
                        </thead>
                        <tbody>$result</tbody>
                    </table>";
                    $res1 = '
<table id="customers">
    <tr>
        <th colspan="5" style="text-align: center; width:300px">Employee Time Sheet</th>
    </tr>

    <tr>
        <td colspan="5">'."$association->legalName".'</td>
    </tr>
    <tr>
        <td colspan="2">'."$association->address1".'</td>
        <td>Employee Name:</td>
        <td colspan="2">'."$worker->firstname $worker->middlename $worker->lastname".'</td>
    </tr>
    <tr>
        <td colspan="2">'."$association->address2".'</td>
        <td>From Date</td>
        <td colspan="2">'."$request->pay_period_from".'</td>
    </tr>
    <tr>
        <td colspan="2">'."$association->city, $association->state, $association->pincode".'</td>
        <td>To Date:</td>
        <td colspan="2">'."$request->pay_period_to".'</td>
    </tr>
    <tr>
        <td colspan="2">'."$association->phoneNo".'</td>
        <td></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2">'.$association->email.'</td>
        <td></td>
        <td colspan="2"></td>
    </tr>

    <tr><td colspan="5"></td></tr>

    <tr>
        <td>#</td>
        <td>Login</td>
        <td>Logout</td>
        <td>Lunch</td>
        <td>Total Time</td>
    </tr>';

    $hours = intval($result_duration/3600);
    $result_duration=$result_duration%3600;
    $mins = intval($result_duration/60);
    $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

    $res3='
    <tr>
        <td style="text-align: right;" colspan="4">Total:</td>
        <td>'.$times.'</td>
    </tr>
</table>';
                 
        return "$res1"."$res2"."$res3";
        return $result;
    }

    public function exportTimeSheet1(Request $request)
    {
        $decimal_total = $request->decimal_total;
        $time_24_format = $request->time_24_format;
        $time_24_format = $request->time_24_format;
        $time_24_format = $request->time_24_format;
        $groupEmployee = $request->groupEmployee;

        $punchClock = PunchClock::select()->first();
        $association = Subassociation::where('id', $punchClock['association'])->first();

        if($request->groupEmployee == "true")
        {
            
            $totalResult = '
            <table id="customers">
            <tr>
                <th colspan="5" style="text-align: center;">Employee Time Sheet</th>
            </tr>

            <tr><td colspan="5"></td></tr>

            <tr>
                <td colspan="5">'."$association->legalName".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->address1".'</td>
                <td>Employee Name:</td>
                <td colspan="2">All</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->address2".'</td>
                <td>From Date</td>
                <td colspan="2">'."$request->pay_period_from".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->city, $association->state, $association->pincode".'</td>
                <td>To Date:</td>
                <td colspan="2">'."$request->pay_period_to".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->phoneNo".'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">'.$association->email.'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>';

            $workforce = WorkForce::get();
            foreach ($workforce as $key => $worker) {

                $punchClock = PunchClock::where('workerid', $worker->id);

                if(isset($request->pay_period_from)){
                    $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
                }
                if(isset($request->pay_period_to)){
                    $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
                }
                $punchClock = $punchClock->get();
                $res1 = ''; $res2 = ''; $result_duration = 0;
                $association = null;
                // if(count($punchClock) == 0)
                //     return "noData";
                $res1 .= '<tr><td colspan="5">'."$worker->firstname $worker->middlename $worker->lastname".'</td></tr>
                <tr>
                    <td>#</td>
                    <td>Login</td>
                    <td>Logout</td>
                    <td>Lunch</td>
                    <td>Total Time</td>
                </tr>';

                foreach ($punchClock as $key => $value) {
                    if($key==0) {
                        $association = Subassociation::where('id', $value->association)->first();
                    }
                    $index = $key+1;
                    
                    $string_format = "g:i A";
                    if($time_24_format == "true") {
                        $string_format = "H:i";
                    }


                    $clocked_in_dt = date('d/m/Y', strtotime($value->in_date));
                    $clocked_in_time = date($string_format, strtotime($value->in_date));
                    $clocked_out_dt = $value->out_date ? date('d/m/Y', strtotime($value->out_date)) : '-';
                    $clocked_out_time = $value->out_date ? date($string_format, strtotime($value->out_date)) : '-';


                    if($value->out_date){
                        $duration = strtotime($value->out_date) - strtotime($value->in_date);

                        if($request->hours_shift) {
                            if($duration > $request->hours_shift)
                                $duration -= $request->per_minutes * 60;
                        }

                        $result_duration += $duration;

                        $hours = intval($duration/3600);
                        $duration=$duration%3600;
                        $mins = intval($duration/60);

                        if($decimal_total == "false"){
                            $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                        }else{
                            $time = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                            $hms = explode(":", $time);
                            $times = $hms[0] + ($hms[1]/60);
                            $times = number_format((float)$times, 2, '.', '');
                            // $times = "$hours hour".($hours>1 ? "s" :"")." $mins minute".($mins > 1) ? "s" : "";
                        }
                    }else{
                        $times = "Clocked In";
                    }
                    
                    $meta = $value->PunchClockMeta;
                    $worker = $value->Worker;
                    if($worker == null ) {
                        $worker = ['firstname' => '', 'lastname' => '', 'middlename' => '', 'birthday' => ''];
                    }

                    $in_meta = null;
                    $out_meta = null;

                    $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
                    // $lunch = explode(" ", $value->in_date)[1];
                    // $lunch = substr($lunch, 0, 5);
                    $res2.="<tr><td>$index</td>
                    <td>$clocked_in_dt $clocked_in_time</td>
                    <td>$clocked_out_dt $clocked_out_time</td>
                    <td>$lunch</td>
                    <td>$times</td>
                    </tr>";

                    foreach ($meta as $key => $value) {
                        if(@$value->AccessDevice->type == 0) $in_meta = $value;
                        else $out_meta = $value;
                    }
                }
                $hours = intval($result_duration/3600);
                $result_duration=$result_duration%3600;
                $mins = intval($result_duration/60);
                $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

                $res3='
                    <tr>
                        <td style="text-align: right;" colspan="4">Total:</td>
                        <td>'.$times.'</td>
                    </tr>';
                $totalResult .= "$res1"."$res2"."$res3";
            }
        }else{
            $totalResult = '
            <table id="customers">
            <tr>
                <th colspan="5" style="text-align: center;">Employee Time Sheet</th>
            </tr>

            <tr><td colspan="5"></td></tr>

            <tr>
                <td colspan="5">'."$association->legalName".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->address1".'</td>
                <td>Employee Name:</td>
                <td colspan="2">All</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->address2".'</td>
                <td>From Date</td>
                <td colspan="2">'."$request->pay_period_from".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->city, $association->state, $association->pincode".'</td>
                <td>To Date:</td>
                <td colspan="2">'."$request->pay_period_to".'</td>
            </tr>
            <tr>
                <td colspan="2">'."$association->phoneNo".'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">'.$association->email.'</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr><td colspan="5">Group by days</td></tr>
            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Login</td>
                <td>Logout</td>
                <td>Lunch</td>
                <td>Total Time</td>
            </tr>';

            $workforce = WorkForce::get();
            foreach ($workforce as $key => $worker) {

                $punchClock = PunchClock::where('workerid', $worker->id);

                if(isset($request->pay_period_from)){
                    $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
                }
                if(isset($request->pay_period_to)){
                    $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
                }
                $punchClock = $punchClock->get();
                $res1 = ''; $res2 = ''; $result_duration = 0;
                $association = null;
                // if(count($punchClock) == 0)
                //     return "noData";

                foreach ($punchClock as $key => $value) {
                    if($key==0) {
                        $association = Subassociation::where('id', $value->association)->first();
                    }
                    $index = $key+1;
                    
                    $string_format = "g:i A";
                    if($time_24_format == "true") {
                        $string_format = "H:i";
                    }


                    $clocked_in_dt = date('d/m/Y', strtotime($value->in_date));
                    $clocked_in_time = date($string_format, strtotime($value->in_date));
                    $clocked_out_dt = $value->out_date ? date('d/m/Y', strtotime($value->out_date)) : '-';
                    $clocked_out_time = $value->out_date ? date($string_format, strtotime($value->out_date)) : '-';


                    if($value->out_date){
                        $duration = strtotime($value->out_date) - strtotime($value->in_date);

                        if($request->hours_shift) {
                            if($duration > $request->hours_shift)
                                $duration -= $request->per_minutes * 60;
                        }

                        $result_duration += $duration;

                        $hours = intval($duration/3600);
                        $duration=$duration%3600;
                        $mins = intval($duration/60);

                        if($decimal_total == "false"){
                            $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                        }else{
                            $time = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
                            $hms = explode(":", $time);
                            $times = $hms[0] + ($hms[1]/60);
                            $times = number_format((float)$times, 2, '.', '');
                            // $times = "$hours hour".($hours>1 ? "s" :"")." $mins minute".($mins > 1) ? "s" : "";
                        }
                    }else{
                        $times = "Clocked In";
                    }
                    
                    $meta = $value->PunchClockMeta;
                    $worker = $value->Worker;
                    if($worker == null ) {
                        $worker = ['firstname' => '', 'lastname' => '', 'middlename' => '', 'birthday' => ''];
                    }

                    $in_meta = null;
                    $out_meta = null;

                    $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
                    // $lunch = explode(" ", $value->in_date)[1];
                    // $lunch = substr($lunch, 0, 5);
                    $res2.="<tr><td>$index</td>
                    <td>"."$worker->firstname $worker->middlename $worker->lastname"."</td>
                    <td>$clocked_in_dt $clocked_in_time</td>
                    <td>$clocked_out_dt $clocked_out_time</td>
                    <td>$lunch</td>
                    <td>$times</td>
                    </tr>";

                    foreach ($meta as $key => $value) {
                        if(@$value->AccessDevice->type == 0) $in_meta = $value;
                        else $out_meta = $value;
                    }
                }
                // $hours = intval($result_duration/3600);
                // $result_duration=$result_duration%3600;
                // $mins = intval($result_duration/60);
                // $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

                // $res3='
                //     <tr>
                //         <td style="text-align: right;" colspan="4">Total:</td>
                //         <td>'.$times.'</td>
                //     </tr>';
                $totalResult .= "$res2";
            }
        }

        return "$totalResult</table>";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $editid = intval($request->editid);
        if($editid > 0){
            PunchClock::where('id', $editid)->update([
                'workerid' => $request->employee,
                'in_date' => $request->add_time_from,
                'out_date' => $request->add_time_to,
                'note' => $request->add_time_note,
            ]);    
            session()->flash('success', "Successfully updated.");
        }else{
            PunchClock::create([
                'workerid' => $request->employee,
                'association' => 1,
                'in_date' => $request->add_time_from,
                'out_date' => $request->add_time_to,
                'note' => $request->add_time_note,
            ]);
            session()->flash('success', "Successfully created.");
        }
        return redirect()->route("punch-clock.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PunchClock  $punchClock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $id = Crypt::decryptString($id);
        //
        $punchClock = PunchClock::where('id', $id)->first();
        $association = Subassociation::where('id', $punchClock->association)->get();

        if($punchClock->out_date) {
            $duration = strtotime($punchClock->out_date) - strtotime($punchClock->in_date);

            $hours = intval($duration/3600);
            $duration=$duration%3600;
            $mins = intval($duration/60);
            $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

            $punchClock['duration'] = $times;
        }else{
            $punchClock['duration'] = "Current Clocked In";
        }

        $meta = $punchClock->PunchClockMeta;
        foreach ($meta as $key => $value) {
            if($value->type == 0) {
                $punchClock->in_meta = $value;
            }else{
                $punchClock->out_meta = $value;
            }
        }
        // dd($punchClock->in_meta->AccessDevice->serial_number);
        $punchClock->worker_info = $punchClock->Worker;

        
        return view('admin.PunchClock.detail', compact('punchClock', 'association'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PunchClock  $punchClock
     * @return \Illuminate\Http\Response
     */
    public function edit(PunchClock $punchClock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PunchClock  $punchClock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PunchClock $punchClock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PunchClock  $punchClock
     * @return \Illuminate\Http\Response
     */
    public function destroy(PunchClock $punchClock)
    {
        //
        $delete = $punchClock->delete();
        if($delete){
            session()->flash('error', "Deleted Successfully.");
        }else{
            session()->flash('error', "Something went wrong.");
        }
        return redirect()->back();
    }
}
