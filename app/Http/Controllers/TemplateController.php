<?php

namespace App\Http\Controllers;

use App\Mail\MailSend;
use App\Models\Building;
use App\Models\Guest;
use App\Models\EmailManage;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Property;
use App\Models\Resident;
use App\Models\Subassociation;
use App\Models\Template;
use App\Models\TemplateVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;


class TemplateController extends Controller
{

    public function index()
    {
        $template = Template::orderby('id', 'desc');

        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $template = $template->where('status', 1);
            } elseif ($_GET['status'] == 2) {
                $template = $template->where('status', 0);
            }
        } else {
            $template = $template->where('status', 1);
        }
        //filter

        $template = $template->get();

        foreach ($template as $k => $v) {
            $template[$k]['edit_id'] = Crypt::encryptString($v->id);
        }
        return view('admin.member.template.index', ['alldata' => $template]);
    }

    public function create()
    {
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();
        $validate = array('petType');
        return view('admin.member.template.create', ['validate' => $validate,'template_variable'=>$template_variable]);
    }

    public function store(Request $request)
    {
        $name = "Template";
        $path = "template";

        if (isset($request->id)) {
            $store = Template:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Template();
            $request->validate([
                'templateName' => 'required'
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

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();
        $validate = array('petType');
        $template = Template::where('id', $id)->first();
        return view('admin.member.template.create', ['data' => $template, 'validate' => $validate,'template_variable'=>$template_variable]);
    }

    public function destroy($id)
    {
        $deletedata = Template::find($id)->delete();
        if ($deletedata) {
            session()->flash('error', "Deleted Successfully.");
            return redirect()->back();
        }
    }

    public function bulkcommunication()
    {
        $userid = null;
        if(@$_GET['user']){
            $userid = Crypt::decryptString($_GET['user']);
        }
        $template = Template::get();
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();
        $validate = array();
        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }

        $person="";
        if(isset($_GET['type'])) {
            if ($_GET['type'] == "Owners") {
                $person = Owner::where('id', $userid)->get();
            }
            if ($_GET['type'] == "Residents") {
                $person = Resident::where('id', $userid)->get();
            }
            if ($_GET['type'] == "Guests") {
                $person = Guest::where('id', $userid)->get();
            }
        }
        // return view('admin.member.template.email', ['alldata' => EmailManage::get(), 'template' => $template, 'template_variable' => $template_variable]);

        return view('admin.member.template.bulkmail', ['template' => $template,"person"=>$person ,'validate' => $validate, 'template_variable' => $template_variable,'subasso'=>$subasso,'property'=>$property, 'userid' => $userid]);
    }

    public function sendbulkmail(Request $request)
    {
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();

        // foreach($data as $u) {
            // $message = $request->template;
            // foreach ($template_variable as $tv) {
                // $col = $tv->columnName;
                // if($u->$col=="" && $tv->columnName=="first_name"){ $col="companyLegalName";}
                // if($u->$col=="" && $tv->columnName=="address1"){ $col="mailingAddress1";}
                // if($u->$col=="" && $tv->columnName=="address2"){ $col="mailingAddress2";}

                // $message = str_replace($tv->variable, $u->$col, $message);
            // }

            Mail::to("topfreelancer085@gmail.com")->send(new MailSend($request->template, $request->subject));
            return;
        // }


        if ($request->to_mail == "Group") {

            foreach ($request->whome_group as $receiver) {
                if ($receiver == "Owners") {
                    $data = Owner::get();
                }
                if ($receiver == "Residents") {
                    $data = Resident::get();
                }
                if ($receiver == "Guests") {
                    $data = Guest::get();
                }
                if ($receiver == "Pet Owners") {
                    $data = Pet::leftjoin('owners', 'owners.id', '=', 'pet.ownerId')->get(['pet.petName', 'owners.*']);
                }
                //mail send
                foreach($data as $u) {
                    $message = $request->template;
                    foreach ($template_variable as $tv) {
                        $col = $tv->columnName;
                        if($u->$col=="" && $tv->columnName=="first_name"){ $col="companyLegalName";}
                        if($u->$col=="" && $tv->columnName=="address1"){ $col="mailingAddress1";}
                        if($u->$col=="" && $tv->columnName=="address2"){ $col="mailingAddress2";}

                        $message = str_replace($tv->variable, $u->$col, $message);
                    }

                    Mail::to($u->email)->send(new MailSend($message, $request->subject));
                }
                //mail send

            }



        } else {

            if ($request->whome_type == "Owners") {
                $data = Owner::where('id',$request->whome)->get();
            }
            if ($request->whome_type == "Residents") {
                $data = Resident::where('id',$request->whome)->get();
            }

            //mail send
            foreach($data as $u) {
                $message = $request->template;
                foreach ($template_variable as $tv) {
                    $col = $tv->columnName;
                    if($u->$col=="" && $tv->columnName=="first_name"){ $col="companyLegalName";}
                    if($u->$col=="" && $tv->columnName=="address1"){ $col="mailingAddress1";}
                    if($u->$col=="" && $tv->columnName=="address2"){ $col="mailingAddress2";}

                    $message = str_replace($tv->variable, $u->$col, $message);
                }

                Mail::to($u->email)->send(new MailSend($message, $request->subject));
            }
            //mail send

        }


        $request->session()->flash("message", "Mail Send Succefully");
        return redirect()->back();

    }


    public function gettemplate($id)
    {
        $template = Template::where('id', $id)->first();
        echo $template->template;
    }
    public function lettergenerator(){
        $userid = null;
        if(@$_GET['user']){
            $userid = Crypt::decryptString($_GET['user']);
        }
        $template = Template::get();
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();
        $validate = array();
        $subasso = Subassociation::where('status', 1)->get();

        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $person="";
        if(isset($_GET['type'])) {
            if ($_GET['type'] == "Owners") {
                $person = Owner::where('id', $userid)->get();
            }
            if ($_GET['type'] == "Residents") {
                $person = Resident::where('id', $userid)->get();
            }
            if ($_GET['type'] == "Guests") {
                $person = Guest::where('id', $userid)->get();
            }
        }

        return view('admin.member.template.letter', ['template' => $template,'person'=>$person, 'validate' => $validate, 'template_variable' => $template_variable,'property'=>$property,'subasso'=>$subasso, 'userid' => $userid]);
    }
    public function  downloadletter(Request $request){

            $alldata="<style>.page_break { page-break-before: always; }</style>";
        $template_variable = TemplateVariable::where('onlyfacility',0)->get();

        if ($request->to_mail == "Group") {

            foreach ($request->whome_group as $receiver) {
                if ($receiver == "Owners") {
                    $data = Owner::get();
                }
                if ($receiver == "Residents") {
                    $data = Resident::get();
                }
                if ($receiver == "Guests") {
                    $data = Guest::get();
                }
                if ($receiver == "Pet Owners") {
                    $data = Pet::leftjoin('owners', 'owners.id', '=', 'pet.ownerId')->get(['pet.petName', 'owners.*']);
                }


                //mail send
                foreach($data as $u) {
                    $message = $request->template;
                    foreach ($template_variable as $tv) {
                        $col = $tv->columnName;
                        if($u->$col=="" && $tv->columnName=="first_name"){ $col="companyLegalName";}
                        if($u->$col=="" && $tv->columnName=="address1"){ $col="mailingAddress1";}
                        if($u->$col=="" && $tv->columnName=="address2"){ $col="mailingAddress2";}
                        $message = str_replace($tv->variable, $u->$col, $message);
                    }
                    $alldata.=$message.'<div class="page_break"></div>';
                }
                //mail send



            }



        } else {

            if ($request->whome_type == "Owners") {
                $data = Owner::where('id',$request->whome)->get();
            }
            if ($request->whome_type == "Residents") {
                $data = Resident::where('id',$request->whome)->get();
            }

            //mail send
            foreach($data as $u) {
                $message = $request->template;
                foreach ($template_variable as $tv) {
                    $col = $tv->columnName;
                    if($u->$col=="" && $tv->columnName=="first_name"){ $col="companyLegalName";}
                    if($u->$col=="" && $tv->columnName=="address1"){ $col="mailingAddress1";}
                    if($u->$col=="" && $tv->columnName=="address2"){ $col="mailingAddress2";}
                    $message = str_replace($tv->variable, $u->$col, $message);
                }
                $alldata.=$message.'<div class="page_break"></div>';
            }
            //mail send


        }






        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($alldata);
        return $pdf->stream();






    }
    public function getperson($type,$property)
    {
        if($type=="Owners"){
            $data=Owner::where('propertyId',$property)->get();
        }else{
            $data=Resident::where('propertyId',$property)->get();
        }
        echo '<option value="">--choose--</option>';
        foreach ($data as $d){
            echo '<option value="'.$d->id.'">'.$d->firstName.' '.$d->lastName.'</option>';
        }

    }

}
