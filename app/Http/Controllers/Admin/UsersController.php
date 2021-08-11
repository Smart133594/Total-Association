<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Hash, Auth, Validator;
use App\Models\Group;
use DB;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $name = "User";

            $path = "manager";



//        if ($request->role == 1 || $request->role == 2) {
//            $path = "profile";
//            $editpath = "profile";
//
//        }
        if (isset($request->id)) {
            $store = User::find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new User();
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);
        }

        $all = $request->all();
        if (empty($request->password) || is_null($request->password)) {
            unset($all['password']);
        } else {
            $request->password = Hash::make($request->password);
        }
        //dont touch below
        //save all field

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
        $store->save();
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " has been Updated");
            return redirect("/manager/". Crypt::encryptString($request->id) . "/edit");
        } else {
            $request->session()->flash("message", $name . " has been added");
            return redirect("/" . $path);
        }
        //dont touch below ends
    }


    public function destroy(User $user)
    {
        $deletedata = User::find($user->id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully");
            return redirect()->back();
        }
    }

    public function profile()
    {
        $id = Auth::id();
        $user = User::where('id', $id)->where('role', 1)->first();
        //dd($user);
        return view('admin.user.profile', ['data' => $user]);
    }

    public function index()
    {
        $cust = User::where('role', '4')->get();
        foreach ($cust as $k => $v) {
            $cust[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        $validate = array('name', 'mobile');
        return view('admin.user.manager', ['alldata' => $cust, 'validate' => $validate]);

    }

    public function create()
    {
        $validate = array('name');
        return view('admin.user.create',['validate' => $validate]);
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $cust = User::where('id', $id)->first();

        $validate = array('name', 'mobile');
        return view('admin.user.create', ['data' => $cust, 'validate' => $validate]);
    }

    public function changepwd(Request $request)
    {

        return view("admin.user.changepwd");
    }

    public function changepwdsave(Request $request)
    {
        $feature = User:: find(Auth::id());
        $feature->password = Hash::make($request->password);
        $request->session()->flash("message", "Password Change Successfully");
        return redirect("change-pwd");
    }

}
