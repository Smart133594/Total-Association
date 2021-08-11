<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Mail\MailSend;
use Illuminate\Support\Facades\Mail;
class IndexController extends Controller
{

    public function index()
    {
        return view('index');
    }


    public function send_mail(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required |email'
        ]);

// call curl to POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => "6LezG-oZAAAAAOcxt6wur7SLm3LCYprjabNdQLcm", 'response' => $request['g-recaptcha-response'])));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);
// verify the response
        if ($arrResponse["success"] == '1') {


            $details = [
                'name' => $request['name'],
                'email' => $request['email'],
                'company' => $request['company'],
                'mobile' => $request['mobile'],
                'message' => $request['message']
            ];
            Mail::to('ambarish@rocknik.com')->send(new MailSend($details));
            $request->session()->flash("message", "Your mail has been Send");
        }else{
            $request->session()->flash("message", "Security Error | Mail Send fail");
        }
         return redirect("contact");

    }
}
