<?php

namespace App\Http\Controllers;

use App\Models\FacilitiesType;
use App\Models\TemplateVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class FacilitiestypeController extends Controller
{
    public function index()
    {
        $master = FacilitiesType::get();
        foreach ($master as $k => $v) {
            $master[$k]['edit_id'] = Crypt::encryptString($v->id);
        }

        return view('admin.facilities.facilities_type', ['alldata' => $master]);
    }

    public function create()
    {
        $ref = FacilitiesType::first();
        if ($ref) {
            $ref = $ref->id + 1;
        } else {
            $ref = 1;
        }
        $template_variable = TemplateVariable::where('onlyfacility',1)->get();
        $validate = array();
        return view('admin.facilities.facilities_type_create', ['validate' => $validate, 'template_variable' => $template_variable, 'ref' => $ref]);
    }

    public function store(Request $request)
    {
        $name = "Facilities Type";
        $path = "facilities-type";


        if (isset($request->id)) {
            $store = FacilitiesType:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new FacilitiesType();
            $request->validate([
                'typeName' => 'required'
            ]);
        }


        //dont touch below
        //save all field
        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }

        if ((isset($all['isHourly']) && $all['isHourly'] == 1) || (isset($all['isDaily']) && $all['isDaily'] == 1) || (isset($all['isWeekly']) && $all['isWeekly'] == 1)) {
            $store->termType = "Short Term";
        } else {
            $store->termType = "Long Term";
        }


        if (!isset($all['isHourly']) && empty($all['isHourly'])) {
            $store->isHourly = "0";
        }
        if (!isset($all['isDaily']) && empty($all['isDaily'])) {
            $store->isDaily = "0";
        }
        if (!isset($all['isWeekly']) && empty($all['isWeekly'])) {
            $store->isWeekly = "0";
        }
        if (!isset($all['isMonthly']) && empty($all['isDaily'])) {
            $store->isMonthly = "0";
        }
        if (!isset($all['isYearly']) && empty($all['isDaily'])) {
            $store->isYearly = "0";
        }
        if (!isset($all['residentOnly']) && empty($all['residentOnly'])) {
            $store->residentOnly = "0";
        }
        if (!isset($all['videoRequired']) && empty($all['videoRequired'])) {
            $store->videoRequired = "0";
        }
        if (!isset($all['rentedOnline']) && empty($all['rentedOnline'])) {
            $store->rentedOnline = "0";
        }
        if (!isset($all['contractRequired']) && empty($all['contractRequired'])) {
            $store->contractRequired = "0";
        }
        if (!isset($all['isPetDepositeRefundable']) && empty($all['isPetDepositeRefundable'])) {
            $store->isPetDepositeRefundable = "0";
        }
        if (!isset($all['moveinInspectionRequired']) && empty($all['moveinInspectionRequired'])) {
            $store->moveinInspectionRequired = "0";
        }


        foreach ($request->files as $kk => $r) {
            if (isset($request->id)) {
                $store->$kk = $this->replaceimage($request, $kk, $forimgupdate[$kk]);
            } else {
                $store->$kk = $this->uploadimage($request, $kk);
            }
        }

        $store->save();
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " has been Updated.");
            return redirect("/" . $path);
        } else {
            $request->session()->flash("message", $name . " has been added.");
            return redirect("/" . $path);
        }
        //dont touch below ends

    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $data = FacilitiesType::where('id', $id)->first();
        $ref = $data->ref;
        $template_variable =  TemplateVariable::where('onlyfacility',1)->get();
        $validate = array();
        return view('admin.facilities.facilities_type_create', ['validate' => $validate, 'template_variable' => $template_variable, 'ref' => $ref, 'data' => $data]);
    }

    public function status($id)
    {
        $id = Crypt::decryptString($id);
        $data = FacilitiesType::where('id', $id)->first();
        if ($data->status == 1) {
            $data = FacilitiesType::where('id', $id)->update(['status' => 0]);
        } else {
            $data = FacilitiesType::where('id', $id)->update(['status' => 1]);
        }
        return redirect()->back();
    }
}
