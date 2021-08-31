<?php

namespace App\Http\Controllers;
use App\Models\PunchClockAuth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class PunchClockAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = new PunchClockAuth;
        if(count($items->get()) < 1) {
            $items->username = 'admin';
            $items->password = Hash::make('root');
            $items->save();
        }

        return view('admin.settings.punchclockauth', ['item' => $items->get()]);
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
        $current = PunchClockAuth::get()[0]->password;
        if(!Hash::check($request->oldpassword, $current)) {
            return "error";
        }

        $updateDetails = [
            'username' => $request->username,
            'password' => Hash::make($request->newpassword)
        ];
        PunchClockAuth::where('id', $request->id)->update($updateDetails);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
