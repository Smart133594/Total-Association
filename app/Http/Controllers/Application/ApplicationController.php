<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Mail\MailSend;
use App\Models\Application;
use App\Models\Masterassociation;
use App\Models\Subassociation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
use View;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $settings = Setting::get();
            foreach ($settings as $k => $v) {
                $setting[$v->slug] = $v->value;
            }

            View::share(['setting' => $setting]);
            return $next($request);
        });

    }

    public function index()
    {
        if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] != 5) {
            $application = Application::orderby('id', 'desc')->where('status', $_GET['status'])->get();
        } else {
            if (isset($_GET['status']) && $_GET['status'] == 5) {
                $application = Application::orderby('id', 'desc')->get();
            } else {
                $application = Application::orderby('id', 'desc')->where('status', 1)->get();
            }


        }

        foreach ($application as $k => $v) {
            $application[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.application.application.index', ['alldata' => $application]);
    }

    public function create()
    {
        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('firstName', 'lastName', 'phoneNo', 'email');
        return view('admin.application.application.create', ['validate' => $validate,'subasso'=>$subasso]);
    }

    public function store(Request $request)
    {
        $name = "Application";
        $path = "application";


        if (isset($request->id)) {
            $store = Application:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {

            $store = new Application();
            $request->validate([
                'firstName' => 'required'
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

        $count = Application::where('email', $request->email)->where('status', 4)->count();
        if ($count == 0) {
            $store->save();

        $id = $store->id;
        $id = Crypt::encryptString($id);

        //send mail

        $url = env('WEBSITE_URL') . "application-form/" . $id;
        $details = '
                            <h2>Hi ' . $request->firstName . '</h2>
                            <p> Please click below link to fill the form and make payments</p>
                            <br>
                            <a href="' . $url . '" class="btn">Click Me</a>
                            <br>
                            <br>
                            ---or---
                            <br>
                            <a href="' . $url . '">' . $url . '</a>
        ';
        Mail::to($request->email)->send(new MailSend($details, 'Application'));
        }

        //send mail

        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " has been Updated.");
            return redirect("/" . $path . "/" . Crypt::encryptString($request->id) . "/edit");
        } else {
            if ($count == 0) {
                $request->session()->flash("message", "Application has been created and email send to applicant");
                return redirect("/" . $path);
            }else{
                $request->session()->flash("error", "Email id already approved.");
                return redirect("/" . $path."/create");
            }
        }
        //dont touch below ends
    }
    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $subasso = Subassociation::where('status', 1)->get();
        $validate = array('firstName', 'lastName', 'phoneNo', 'email');
        $application = Application::where('id', $id)->first();
        return view('admin.application.application.create', ['data' => $application, 'validate' => $validate,'subasso'=>$subasso]);
    }

    public function destroy($id)
    {
        $deletedata = Application::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }

    }

    public function application($id)
    {
        $id = Crypt::decryptString($id);
        $expire = 0;
        Application::where('id', $id)->update(['isEmailVarified' => 1]);
        $data = Application::where('id', $id)->first();
        $duration = Setting::where('slug', 'application_duration')->first();
        $duration = $duration->value;
        $to_time = strtotime(date('Y-m-d H:i:s'));
        $from_time = strtotime($data->created_at);
        $diff = round(($to_time - $from_time) / 60, 2);
        if ($data->paymentStatus == 1) {
            $ids = Crypt::encryptString($data->id);
            return redirect("/application-submitted/" . $ids);
        } else {
            if ($diff > $duration) {
                Application::where('id', $id)->update(['status' => 2]);
                $expire = 1;
            }
        }


        return view('admin.application.application.application-form', ['data' => $data, 'expire' => $expire]);
    }

    public function applicationstore(Request $request)
    {

        $store = Application:: find($request->id);
        foreach ($request->files as $kk => $r) {
            $forimgupdate[$kk] = $store->$kk;
        }

        if (!isset($request->isAgent)) {
            $store->isAgent = 0;
        }
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
        $store->save();
        $id = $store->id;
        return redirect("/pay-application/" . $id);

    }

    public function payapplication($id)
    {


        //$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';  //for real tranction
        $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $path = env('WEBSITE_URL');
        return view('admin.application.application.pay', ['paypal_url' => $paypal_url, 'paymnet_id' => $id, 'path' => $path]);

    }

    public function success(Request $request)
    {
        $order = Application::find($request->item_name);
        $order->paymentStatus = 1;
        $order->transactionId = $request->txn_id;
        $order->paymentType = $request->payment_type;
        $order->amount = $request->mc_gross;
        $order->dateTime = date("Y-m-d h:i:s");
        $order->save();
        $id = Crypt::encryptString($request->item_name);
        return redirect("/application-submitted/" . $id);
    }

    public function cancel(Request $request)
    {
        return view('admin.application.application.cancel');
    }


    public function applicationsubmitted($id)
    {
        $id = Crypt::decryptString($id);
        $data = Application::find($id);
        if(!empty($data->associationId) && $data->associationId > 0){
            $association=Subassociation::where('id',$data->associationId)->first();
        }else{
            $association=Masterassociation::where('id',1)->first();
        }

        return view('admin.application.application.success', ['data' => $data,'association'=>$association]);
    }

    public function details($id)
    {

        $data = Application::where('id', $id)->first();
        echo '<table class="table">';
        echo '<tr><td>Application Type</td><td>' . $data->applicationType . '</td></tr>';
        echo '<tr><td>Name</td><td>' . $data->firstName . ' ' . $data->middleName . ' ' . $data->lastName . '</td></tr>';
        echo '<tr><td>Phone No</td><td>' . $data->phoneNo . '</td></tr>';
        echo '<tr><td>Email</td><td>' . $data->email . '</td></tr>';
        echo '<tr><td>Social Security Number</td><td>' . $data->socialSecurityNo . '</td></tr>';
        echo '<tr><td>Driving License Number</td><td>' . $data->drivingLicenseNo . ' <br><a href="/upload/' . $data->drivingLicenseImage . '" target="_blank"><img src="/thumb/' . $data->drivingLicenseImage . '" style="border-radius:0px;max-width:100px;"></a></td></tr>';
        echo '<tr><td>Tex Return</td><td> <a href="/upload/' . $data->textReturn . '" target="_blank">' . $data->textReturn . '</a></td></tr>';
        echo '<tr><td>Address</td><td>' . $data->address . '</td></tr>';
        echo '<tr><td>Place Of Work</td><td>' . $data->placeOfWork . '</td></tr>';
        echo '<tr><td>Current Income</td><td>' . $data->currentIncome . '</td></tr>';


        if ($data->isAgent == 1) {
            echo '<tr><td colspan="2"> </td></tr>';
            echo '<tr><td>Agent Name</td><td>' . $data->agentFirstName . ' ' . $data->agentMiddleName . ' ' . $data->agentLastName . '</td></tr>';
            echo '<tr><td>Agent Phone </td><td>' . $data->agentPhoneNo . '</td></tr>';
            echo '<tr><td>Agent Email</td><td>' . $data->agentEmailId . '</td></tr>';
        }
        echo '<tr><td colspan="2"> </td></tr>';
        if ($data->paymentStatus == 1) {
            echo '<tr><td>Payment Status</td><td>Success</td></tr>';
        }
        echo '<tr><td>Amount</td><td>' . $data->amount . '</td></tr>';
        echo '<tr><td>Payment Type</td><td>' . $data->paymentType . '</td></tr>';
        echo '<tr><td>Payment Time</td><td>' . $data->dateTime . '</td></tr>';
        echo '</table>';
    }

    public function applicationapproval($id, $status)
    {
        $data = Application::where('id', $id)->first();
        Application::where('id', $id)->update(['status' => $status]);
        if ($status == 3) {

            $details = '
                            <h2>Hi ' . $data->firstName . '</h2>
                            <p> Your Application has been declined</p>

        ';


        }
        if ($status == 4) {

            $details = '
                            <h2>Hi ' . $data->firstName . '</h2>
                             <p> Congratulations! Your Application has been Approved</p>

        ';


        }
        Mail::to($data->email)->send(new MailSend($details, 'Application Status'));
        return redirect()->back();
    }
    public function resent($id)
    {

        $data = Application::where('id', $id)->first();
        Application::where('id', $id)->update(['created_at' => date('Y-m-d H:m:i')]);
        $id = Crypt::encryptString($id);
        $url = env('WEBSITE_URL') . "application-form/" . $id;
        $details = '
                            <h2>Hi ' . $data->firstName . '</h2>
                            <p> Please click below link to fill the form and make payments</p>
                            <br>
                            <a href="' . $url . '" class="btn">Click Me</a>
                            <br>
                            <br>
                            ---or---
                            <br>
                            <a href="' . $url . '">' . $url . '</a>
        ';


        Mail::to($data->email)->send(new MailSend($details, 'Application'));
        session()->flash("message", "Mail Resend");
        return redirect()->back();
    }
    public function assignpayment($id)
    {
        Application::where('id', $id)->update(['paymentStatus' => 1]);
        session()->flash("message", "Payment Status Changed");
        return redirect()->back();
    }


    public function chackemail($email)
    {
        echo $count = Application::where('email', $email)->where('status', 4)->count();
    }

}
