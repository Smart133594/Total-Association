<?php

namespace App\Http\Controllers;

use App\Models\Digitalsignage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Auth;

class DigitalsignageController extends Controller
{
    public function index()
    {
        $digitalsignage = Digitalsignage::orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status']==1) {
                $digitalsignage = $digitalsignage->where('status', 1);
            }elseif ($_GET['status']==2) {
                $digitalsignage = $digitalsignage->where('status', 0);
            }
        } else {
            $digitalsignage=$digitalsignage->where('status', 1);
        }
        //filter
        if(Auth::user()->role!=1){
            $digitalsignage=$digitalsignage->where('user_id', Auth::user()->id);
        }

        $digitalsignage=$digitalsignage->get();

        foreach ($digitalsignage as $k => $v) {
            $digitalsignage[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.member.digital_signage.index', ['alldata' => $digitalsignage]);
    }

    public function create()
    {
        $member=User::where('role',4)->get();
        $validate = array('petType');
        return view('admin.member.digital_signage.create', ['validate' => $validate,'member'=>$member]);
    }

    public function store(Request $request)
    {
        $name = "Group";
        $path = "digital-signage-group";

        if (isset($request->id)) {
            $store = Digitalsignage:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Digitalsignage();
            $request->validate([
                'groupName' => 'required'
            ]);
        }

        //dont touch below
        //save all field
        $all = $request->all();
        unset($all['_token']);
        foreach ($all as $k => $v) {
            $store->$k = $request->$k;
        }
        foreach ($request->files as $kk => $r) {
            if (isset($request->id)) {
                $store->$kk = $this->replaceimage($request, $kk, $forimgupdate[$kk]);
            } else {
                $store->$kk = $this->uploadimage($request, $kk);
            }
        }
        $store->is_changed=1;
        $store->save();
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " has been Updated.");
            return redirect("/" . $path . "/" . Crypt::encryptString($request->id) . "/edit");
        } else {
            $request->session()->flash("message", $name . " has been added.");
            return redirect("/" . $path);
        }
        //dont touch below ends
    }

    public function tv($id)
    {
        $digitalsignage = Digitalsignage::where('id', $id)->first();
        Digitalsignage::where('id',$id)->update(['is_changed'=>0]);
        return view('admin.member.digital_signage.tv', ['data' => $digitalsignage]);
    }
    public function tvchange($id)
    {
        echo $digitalsignage = Digitalsignage::where('id', $id)->where('is_changed',1)->count();
    }

    public function edit($id)
    {
        $member=User::where('role',4)->get();
        $id = Crypt::decryptString($id);
        $validate = array('petType');
        $digitalsignage = Digitalsignage::where('id', $id)->first();
        return view('admin.member.digital_signage.create', ['data' => $digitalsignage, 'validate' => $validate,'member'=>$member]);
    }

    public function destroy($id)
    {
        $deletedata = Digitalsignage::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

}
