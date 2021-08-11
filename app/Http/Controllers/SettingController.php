<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function property_setting()
    {
        $validate = array();
        $setting = Setting::where('setting_location', 'property')->get();
        foreach ($setting as $k => $v) {
            $data[$v->slug] = $v->value;
        }

        return view('admin.properties.setting.index', ['data' => $data, 'validate' => $validate]);
    }

    public function application_setting()
    {
        $validate = array();
        $setting = Setting::where('setting_location', 'application')->get();
        foreach ($setting as $k => $v) {
            $data[$v->slug] = $v->value;
        }

        return view('admin.application.setting.index', ['data' => $data, 'validate' => $validate]);
    }
    public function petsetting()
    {
        $validate = array();
        $setting = Setting::where('setting_location', 'pet')->get();
        foreach ($setting as $k => $v) {
            $data[$v->slug] = $v->value;
        }
        return view('admin.member.pet.pet.setting', ['data' => $data, 'validate' => $validate]);
    }
    public function finesetting()
    {
        $validate = array();
        $setting = Setting::where('setting_location', 'fine')->get();
        foreach ($setting as $k => $v) {
            $data[$v->slug] = $v->value;
        }
        return view('admin.fines.setting', ['data' => $data, 'validate' => $validate]);
    }




    public function store(Request $request)
    {
        if(isset($request->pet_documents)){
            $request->pet_documents=json_encode($request->pet_documents);
            $request->documents_description=json_encode($request->documents_description);
            $request->documents_required_by_law=json_encode($request->documents_required_by_law);
            $request->documents_status=json_encode($request->documents_status);
        }
        if(isset($request->pet_support_documents)){
            $request->pet_support_documents=json_encode($request->pet_support_documents);
            $request->support_description=json_encode($request->support_description);
            $request->support_required_by_law=json_encode($request->support_required_by_law);
            $request->documents_support_status=json_encode($request->documents_support_status);
        }

        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            Setting::where('slug', $k)->update(['value' => $v]);
        }
        return redirect()->back();
    }

}
