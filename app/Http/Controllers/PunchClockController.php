<?php

namespace App\Http\Controllers;

use App\Models\PunchClock;
use App\Models\WorkForce;
use Illuminate\Http\Request;

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
        $punchClock = new PunchClock;
        if(isset($request->employees)) {
            $punchClock = $punchClock->where('workerid', $request->employees);
        }
        if(isset($request->pay_from)){
            $pay_from = $request->pay_from;
            $punchClock = $punchClock->where('in_date', '>=', $pay_from);
        }
        if(isset($request->pay_to)){
            $pay_to = $request->pay_to;
            $punchClock = $punchClock->where('out_date', '<=', $pay_to);
        }
        $punchClock = $punchClock->get();
        $total_duration = 0;
        $time = '';
        foreach ($punchClock as $key => $value) {
            $duration = strtotime($value->out_date) - strtotime($value->in_date);

            $total_duration += $duration;

            $hours = intval($duration/3600);
            $duration=$duration%3600;
            $mins = intval($duration/60);
            $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

            $punchClock[$key]['duration'] = $times;
        }


        $hours = intval($total_duration/3600);
        $total_duration=$total_duration%3600;
        $mins = intval($total_duration/60);
        $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

        return view('admin.PunchClock.index', compact('workers', 'punchClock', 'times'));
    }
    public function exportTimeSheet(Request $request)
    {
        $userid = $request->userid;
        $pay_period_to = $request->pay_period_to;
        $decimal_total = $request->decimal_total;
        $time_format = $request->time_format;


        $punchClock = PunchClock::where('workerid', $userid);
        if(isset($request->pay_period_from)){
            $punchClock = $punchClock->where('in_date', '>=', $request->pay_period_from);
        }
        if(isset($request->pay_period_to)){
            $punchClock = $punchClock->where('out_date', '<=', $request->pay_period_to);
        }
        $punchClock = $punchClock->get();
        $result = '';
        foreach ($punchClock as $key => $value) {
            $index = $key+1;
           
            
            $clocked_in_dt = date('d/m/Y', strtotime($value->in_date));
            $clocked_in_time = date('h:i', strtotime($value->in_date));
            $clocked_out_dt = date('d/m/Y', strtotime($value->out_date));
            $clocked_out_time = date('h:i', strtotime($value->out_date));

            $duration = strtotime($value->out_date) - strtotime($value->in_date);
            $hours = intval($duration/3600);
            $duration=$duration%3600;
            $mins = intval($duration/60);
            $times = ($hours < 10 ? 0 : '').$hours.':'.($mins < 10 ? 0 : '').$mins;

            $result .= "<tr>
                            <td>$index</td>
                            <td>$clocked_in_dt</td>
                            <td>$clocked_in_time</td>
                            <td>$clocked_out_dt</td>
                            <td>$clocked_out_time</td>
                            <td>$times</td>
                        </tr>";
        }
        $result = " <table>
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Clocked In Date</td>
                                <td>Clocked In Time</td>
                                <td>Clocked Out Date</td>
                                <td>Clocked Out Time</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>$result</tbody>
                    </table>";

                    return $result;
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
    public function show(PunchClock $punchClock)
    {
        //
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
    }
}
