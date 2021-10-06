<?php

namespace App\Http\Controllers;

use App\Models\PunchClock;
use App\Models\Department;
use App\Models\PunchClockMeta;
use App\Models\Subassociation;
use App\Models\WorkForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use PDF;
use Storage;

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
        print_r(count($punchClock));exit();
        if($request->pay_period_from == "")
            return "noData";

        $totalArray = [];

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

            $lunch = "";
            if($value->out_date){
                $duration = strtotime($value->out_date) - strtotime($value->in_date);

                if($request->hours_shift) {
                    if($duration > $request->hours_shift)
                    {
                        $duration -= $request->per_minutes * 60;
                        $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
                    }
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
                }
            }else{
                $times = "Clocked In";
            }
            
            $meta = $value->PunchClockMeta;
            $worker = $value->Worker;
            if($worker == null ) {
                $worker = ['firstname' => '', 'lastname' => '', 'middlename' => '', 'birthday' => ''];
            }

            $totalArray[$key]['login'] = $clocked_in_dt." ".$clocked_in_time;
            $totalArray[$key]['logout'] = $clocked_out_dt." ".$clocked_out_time;
            $totalArray[$key]['lunch'] = $lunch;
            $totalArray[$key]['time'] = $times;

        }

        $data = array(
            'legalname' => $association->legalName, 
            'address1' => $association->address1, 
            'address2' => $association->address2, 
            'city' => $association->city.", ".$association->state.", ".$association->pincode, 
            'telphonenumber' => $association->phoneNo,
            'emailaddress' => $association->email,
            'employeename' => $worker->firstname." ".$worker->middlename." ".$worker->lastname,
            'from' => $request->pay_period_from,
            'to' => $request->pay_period_to,
            'totalTime' => $times,
            'totalArray' => $totalArray,
        );

        view()->share('employee', compact('data'));
        $pdf_doc = PDF::loadView('admin.PunchClock.export_pdf',  compact('data'));

        Storage::put('public/pdf/PunchClock.pdf', $pdf_doc->output());

        return "success";
    }

    public function download()
    {
        $myFile = storage_path("app/public/pdf/PunchClock.pdf");
        $headers = ['Content-Type: application/pdf'];

        return response()->download($myFile, "PunchClock.pdf", $headers);
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

        // if($request->groupEmployee == "true")
        // {
            $workforce = WorkForce::get();
            $totalData = [];
            foreach ($workforce as $count => $worker) {

                $punchClock = PunchClock::where('workerid', $worker->id);

                if(isset($request->pay_period_from)){
                    $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
                }
                if(isset($request->pay_period_to)){
                    $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
                }
                $punchClock = $punchClock->get();
                $result_duration = 0;

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

                    $lunch = "";

                    if($value->out_date){
                        $duration = strtotime($value->out_date) - strtotime($value->in_date);

                        if($request->hours_shift) {
                            if($duration > $request->hours_shift){
                                $duration -= $request->per_minutes * 60;
                                $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
                            }
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
                    
                    $totalArray[$key]['name'] = $worker->firstname.", ".$worker->middlename.", ".$worker->lastname;
                    $totalArray[$key]['login'] = $clocked_in_dt." ".$clocked_in_time;
                    $totalArray[$key]['logout'] = $clocked_out_dt." ".$clocked_out_time;
                    $totalArray[$key]['lunch'] = $lunch;
                    $totalArray[$key]['time'] = $times;
                }


                $hours = intval($result_duration/3600);
                $result_duration=$result_duration%3600;
                $mins = intval($result_duration/60);
                $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

                $data = array();
                if(count($punchClock) != 0){
                    $data = array(
                        'legalname' => $association->legalName, 
                        'address1' => $association->address1, 
                        'address2' => $association->address2, 
                        'city' => $association->city.", ".$association->state.", ".$association->pincode, 
                        'telphonenumber' => $association->phoneNo,
                        'emailaddress' => $association->email,
                        'employeename' => $worker->firstname." ".$worker->middlename." ".$worker->lastname,
                        'from' => $request->pay_period_from,
                        'to' => $request->pay_period_to,
                        'totalTime' => $times,
                        'totalArray' => $totalArray,
                    );
                    $totalData[$count] = $data;
                }

            }

            if($request->groupEmployee == "false")
            {
                view()->share('totalData', compact('totalData'));
                $pdf_doc = PDF::loadView('admin.PunchClock.export_all_employee',  compact('totalData'));
            }else{
                view()->share('totalData', compact('totalData'));
                $pdf_doc = PDF::loadView('admin.PunchClock.export_all_day',  compact('totalData'));
            }

            if(!Storage::disk('public')->put("PunchClock.pdf", $pdf_doc->output())) {
                return false;
            }
            return true;
        // }else{

        //     $workforce = WorkForce::get();
        //     foreach ($workforce as $key => $worker) {

        //         $punchClock = PunchClock::where('workerid', $worker->id);

        //         if(isset($request->pay_period_from)){
        //             $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
        //         }
        //         if(isset($request->pay_period_to)){
        //             $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
        //         }
        //         $punchClock = $punchClock->get();
        //         $res1 = ''; $res2 = ''; $result_duration = 0;
        //         $association = null;

        //         foreach ($punchClock as $key => $value) {
        //             if($key==0) {
        //                 $association = Subassociation::where('id', $value->association)->first();
        //             }
        //             $index = $key+1;
                    
        //             $string_format = "g:i A";
        //             if($time_24_format == "true") {
        //                 $string_format = "H:i";
        //             }

        //             $clocked_in_dt = date('d/m/Y', strtotime($value->in_date));
        //             $clocked_in_time = date($string_format, strtotime($value->in_date));
        //             $clocked_out_dt = $value->out_date ? date('d/m/Y', strtotime($value->out_date)) : '-';
        //             $clocked_out_time = $value->out_date ? date($string_format, strtotime($value->out_date)) : '-';

        //             $lunch = "";

        //             if($value->out_date){
        //                 $duration = strtotime($value->out_date) - strtotime($value->in_date);

        //                 if($request->hours_shift) {
        //                     if($duration > $request->hours_shift){
        //                         $duration -= $request->per_minutes * 60;
        //                         $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
        //                     }
        //                 }

        //                 $result_duration += $duration;

        //                 $hours = intval($duration/3600);
        //                 $duration=$duration%3600;
        //                 $mins = intval($duration/60);

        //                 if($decimal_total == "false"){
        //                     $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
        //                 }else{
        //                     $time = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;
        //                     $hms = explode(":", $time);
        //                     $times = $hms[0] + ($hms[1]/60);
        //                     $times = number_format((float)$times, 2, '.', '');
        //                     // $times = "$hours hour".($hours>1 ? "s" :"")." $mins minute".($mins > 1) ? "s" : "";
        //                 }
        //             }else{
        //                 $times = "Clocked In";
        //             }
                    
        //             $meta = $value->PunchClockMeta;
        //             $worker = $value->Worker;
        //             if($worker == null ) {
        //                 $worker = ['firstname' => '', 'lastname' => '', 'middlename' => '', 'birthday' => ''];
        //             }

        //             $in_meta = null;
        //             $out_meta = null;

        //             // $lunch = intdiv($request->per_minutes, 60).':'. ($request->per_minutes % 60);
        //             // $lunch = explode(" ", $value->in_date)[1];
        //             // $lunch = substr($lunch, 0, 5);
        //             $res2.="<tr><td>$index</td>
        //             <td>"."$worker->firstname $worker->middlename $worker->lastname"."</td>
        //             <td>$clocked_in_dt $clocked_in_time</td>
        //             <td>$clocked_out_dt $clocked_out_time</td>
        //             <td>$lunch</td>
        //             <td>$times</td>
        //             </tr>";

        //             foreach ($meta as $key => $value) {
        //                 if(@$value->AccessDevice->type == 0) $in_meta = $value;
        //                 else $out_meta = $value;
        //             }
        //         }
        //         // $hours = intval($result_duration/3600);
        //         // $result_duration=$result_duration%3600;
        //         // $mins = intval($result_duration/60);
        //         // $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

        //         // $res3='
        //         //     <tr>
        //         //         <td style="text-align: right;" colspan="4">Total:</td>
        //         //         <td>'.$times.'</td>
        //         //     </tr>';
        //         $totalResult .= "$res2";
        //     }
        // }

        // return "$totalResult";
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
