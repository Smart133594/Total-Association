<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Facilities;
use App\Models\FacilitiesType;
use App\Models\FacilityRent;
use App\Models\Guest;
use App\Models\Masterassociation;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Property;
use App\Models\Resident;
use App\Models\Subassociation;
use App\Models\TemplateVariable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;

class facilitiesController extends Controller
{
    public function index()
    {
        $facilities_type = FacilitiesType::get();

        $facilities = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId');
        //filter
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            if ($_GET['status'] == 1) {
                $facilities = $facilities->where('facilities.status', 1);
            } elseif ($_GET['status'] == 2) {
                $facilities = $facilities->where('facilities.status', 0);
            }

        }
        if (isset($_GET['type']) && !empty($_GET['type'])) {
            $facilities = $facilities->where('facilities.facilitiesTypeId', $_GET['type']);
        }
        //filter
        $facilities = $facilities->get(['facilities_types.typeName','facilities_types.contractRequired', 'facilities.*']);


        foreach ($facilities as $k => $v) {
            $rent = FacilityRent::where('facilities_id', $v->id)->orderBy('id', 'desc')->first();
            if ($rent) {
                $facilities[$k]['vacency'] = "1";
                $facilities[$k]['isResident'] = $rent->isResident;
                if ($rent->isResident == 1) {
                    $facilities[$k]['current_occupaier'] = $rent->whome;
                    $facilities[$k]['current_occupaier_id'] = Crypt::encryptString($rent->whome);
                    $facilities[$k]['whome_type'] = $rent->whome_type;
                } else {
                    $facilities[$k]['current_occupaier'] = 0;
                }
                $facilities[$k]['current_occupaier_rent_id'] = Crypt::encryptString($rent->id);

                $facilities[$k]['toDate'] = $rent->toDate;
            }
            $facilities[$k]['edit_id'] = Crypt::encryptString($v->id);


        }


        return view('admin.facilities.facilities', ['alldata' => $facilities, 'facilities_type' => $facilities_type]);
    }

    public function create()
    {
        $facilities_type = FacilitiesType::get();
        $validate = array();
        return view('admin.facilities.facilities_create', ['facilities_type' => $facilities_type, 'validate' => $validate]);
    }

    public function store(Request $request)
    {
        $name = "Facilities";
        $path = "facilities";
        if (isset($request->id)) {
            $store = Facilities:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new Facilities();
            $request->validate([
                'Facility' => 'required'
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
        $data = Facilities::where('id', $id)->first();
        $facilities_type = FacilitiesType::get();
        $validate = array();
        return view('admin.facilities.facilities_create', ['facilities_type' => $facilities_type, 'validate' => $validate, 'data' => $data]);
    }

    public function show($id)
    {
        $id = Crypt::decryptString($id);
        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);


        //extraTable
        $rental_history = FacilityRent::where('facilities_id', $data->id)->get();

        //extraTable

        return view('admin.facilities.facilities_details', ['data' => $data, 'rental_history' => $rental_history]);
    }

    public function rent($id)
    {
        $id = Crypt::decryptString($id);

        //calculate block dates
        $disabledDates = "";
        $allfacilities = FacilityRent::where('facilities_id', $id)->get();
        foreach ($allfacilities as $a) {
            $start = substr($a->fromDate, 0, 10);
            $end = substr($a->toDate, 0, 10);
            $dates = $start;
            $disabledDates = "'" . $start . "',";
            while ($dates < $end) {
                $dates = date('Y-m-d', strtotime($dates . ' +1 day'));
                $disabledDates .= "'" . $dates . "',";
            }
        }
        $disabledDates = substr($disabledDates, 0, -1);
//calculate block dates


        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);

        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $rent = FacilityRent::where('facilities_id', $id)->get();
        return view('admin.facilities.rent', ['data' => $data, 'id' => $id, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'rent' => $rent, 'disabledDates' => $disabledDates]);
    }


    public function edit_rent($id)
    {
        $id = Crypt::decryptString($id);

        $facilities = FacilityRent::where('id', $id)->first();

        //calculate block dates
        $disabledDates = "";
        $allfacilities = FacilityRent::where('facilities_id', $facilities->facilities_id)->get();
        foreach ($allfacilities as $a) {
            $start = substr($a->fromDate, 0, 10);
            $end = substr($a->toDate, 0, 10);
            $dates = $start;
            $disabledDates = "'" . $start . "',";
            while ($dates < $end) {
                $dates = date('Y-m-d', strtotime($dates . ' +1 day'));
                $disabledDates .= "'" . $dates . "',";
            }
        }
        $disabledDates = substr($disabledDates, 0, -1);
//calculate block dates

        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $facilities->facilities_id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);


        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }

        $person = "";
        $building = Building::where('associationId', $facilities->associationId)->get();
        if ($facilities->whome_type == "Owners") {
            $person = Owner::where('id', $facilities->whome)->get();
        }
        if ($facilities->whome_type == "Residents") {
            $person = Resident::where('id', $facilities->whome)->get();
        }


        $rent = FacilityRent::where('facilities_id', $id)->get();
        return view('admin.facilities.rent', ['data' => $data, 'building' => $building, 'person' => $person, 'id' => $facilities->facilities_id, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'facilities' => $facilities, 'rent' => $rent, 'disabledDates' => $disabledDates]);
    }


    public function rentstore(Request $request)
    {
        $name = "Facilities";
        $path = "facilities-rental-event";
        if (isset($request->id)) {
            $store = FacilityRent:: find($request->id);
            foreach ($request->files as $kk => $r) {
                $forimgupdate[$kk] = $store->$kk;
            }
        } else {
            $store = new FacilityRent();
            $request->validate([
                'facilities_id' => 'required'
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

        Facilities::where('id', $request->facilities_id)->update(['paidUntil' => $request->toDate]);
        //save all field
        if (isset($request->id)) {
            $request->session()->flash("message", $name . " rent details has been updated.");
            return redirect()->back();
        } else {
            $request->session()->flash("message", $name . " has been rented.");
            return redirect("/" . $path . "/" . Crypt::encryptString($request->facilities_id));
        }
        //dont touch below ends

    }

    public function events($id)
    {
        $id = Crypt::decryptString($id);
        $facilities = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);

        $data = FacilityRent::where('facilities_id', $id)->get();
        foreach ($data as $k => $v) {
            $data[$k]['edit_id'] = Crypt::encryptString($v->id);
        }

        return view('admin.facilities.events', ['facilities' => $facilities, 'data' => $data]);
    }

    public function recordanote($id)
    {
        $id = Crypt::decryptString($id);
        $facilities = FacilityRent::where('id', $id)->first();


        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $facilities->facilities_id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);

        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $rent = FacilityRent::where('facilities_id', $id)->get();
        return view('admin.facilities.record_note', ['data' => $data, 'id' => $id, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'facilities' => $facilities, 'rent' => $rent]);
    }

    public function paymentinfo($id)
    {
        $id = Crypt::decryptString($id);
        $facilities = FacilityRent::where('id', $id)->first();


        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $facilities->facilities_id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);


        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $rent = FacilityRent::where('facilities_id', $id)->get();
        return view('admin.facilities.paymentinfo', ['data' => $data, 'id' => $id, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'facilities' => $facilities, 'rent' => $rent]);
    }


    public function status($id)
    {
        $id = Crypt::decryptString($id);
        $data = Facilities::where('id', $id)->first();
        if ($data->status == 1) {
            $facilities_type = FacilitiesType::get();
            $validate = array();
            return view('admin.facilities.status', ['facilities_type' => $facilities_type, 'validate' => $validate, 'data' => $data]);
        } else {
            $data = Facilities::where('id', $id)->update(['status' => 1]);
            return redirect()->back();
        }
    }

    public function approvepayment($id)
    {
        $id = Crypt::decryptString($id);
        $data = FacilityRent::where('id', $id)->update(['paymentStatus' => 1]);
        return redirect()->back();
    }


    public function downloadcontract($id)
    {

        $facilities = FacilityRent::where('id', $id)->first();
        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $facilities->facilities_id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);


        $data->RentrsName = $facilities->RentrsName;
        $data->RentrsAddress = $facilities->RentrsAddress;
//        dd($data);
        $alldata = "<style>.page_break { page-break-before: always; }</style>";
        $template_variable = TemplateVariable::where('onlyfacility', 1)->get();


        //mail send

        $message = $data->contract;
        foreach ($template_variable as $tv) {
            $replace_data = "";
            $col = $tv->columnName;
            if (!empty($col)) {
                $message = str_replace($tv->variable, $data->$col, $message);
            }
            if ($tv->variable == "{{Month}}") {
                $replace_data = date('M');
            }
            if ($tv->variable == "{{Day}}") {
                $replace_data = date('d');
            }
            if ($tv->variable == "{{Year}}") {
                $replace_data = date('Y');
            }
            if ($tv->variable == "{{Renter Address}}") {

                if ($facilities->isResident == 0) {
                    $replace_data = date('Y');
                } else {
                    if ($facilities->whome_type == "Owner") {
                        $x = Owner::where('id', $facilities->whome)->first();
                    } else {
                        $x = Resident::where('id', $facilities->whome)->first();
                    }

                    $replace_data = $x->mailingAddress1 . " " . $x->city . ", " . $x->state . " " . $x->country . ", " . $x->zip;
                }
            }

            if ($facilities->isResident == 0) {
                $association = Masterassociation::first();
            } else {
                $association = Subassociation::where('id', $facilities->associationId)->first();
            }

            if ($tv->variable == "{{Association Legal Address}}") {
                $replace_data = $association->address1 . " " . $association->address2 . " " . $association->city . ", " . $association->state . " " . $association->country . ", " . $association->pincode;
            }
            if ($tv->variable == "{{Association Legal Name}}") {
                $replace_data = $association->legalName;
            }
            if ($tv->variable == "{{Rental Type}}" || $tv->variable == "{{Rental Time Term}}") {
                $price = "";
                if ($data->isHourly == 1) {
                    $price .= " Hourly -";
                }
                if ($data->isDaily == 1) {
                    $price .= " Daily -";
                }
                if ($data->isWeekly == 1) {
                    $price .= " Weekly -";
                }
                if ($data->isMonthly == 1) {
                    $price .= " Monthly -";
                }
                if ($data->isYearly == 1) {
                    $price .= " Yearly -";
                }
                $replace_data = substr($price, 0, -2);

            }

            if ($tv->variable == "{{rental pay period}}") {

                $date1 = $facilities->fromDate;
                $date2 = $facilities->toDate;

                $diff = abs(strtotime($date2) - strtotime($date1));

                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                if ($years > 0) {
                    $replace_data = $years . " Years";
                }
                if ($months > 0) {
                    $replace_data .= $months . " Months";
                }
                if ($days > 0) {
                    $replace_data .= $days . " Days";
                }


            }
            if ($tv->variable == "{{Rental Use}}") {
                $replace_data = "Rental Use";
            }


            if ($tv->variable == "{{Current Time and Date}}") {
                $replace_data = date('Y-M-d H:m A');
            }
            


            if (!empty($replace_data)) {
                $message = str_replace($tv->variable, $replace_data, $message);
            }

        }
         $alldata .= $message . '<div class="page_break"></div>';


         $pdf = App::make('dompdf.wrapper');
         $pdf->loadHTML($alldata);
        return $pdf->stream();

    }


    public function rentfacilities()
    {

        $facilitiestype = FacilitiesType::where('status', 1)->get();
        foreach ($facilitiestype as $k => $f) {
            $facilitiestype[$k]['edit_id'] = Crypt::encryptString($f->id);
        }
        return view('admin.facilities.rentfacilities', ['facilitiestype' => $facilitiestype]);
    }

    public function checkavailability($id)
    {
        $id = Crypt::decryptString($id);
        $facilitiestype = FacilitiesType::where('id', $id)->first();

        $facilities = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.facilitiesTypeId', $id)
            ->get(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location', 'facilities.image as facilities_img', 'facilities.id as facilities_id']);


        foreach ($facilities as $k => $v) {
            $r = FacilityRent::where('facilities_id', $v->facilities_id)->get();
//calculate block dates
            $disabledDates = "";
            $blockTime = "";
            foreach ($r as $a) {
                $start = substr($a->fromDate, 0, 10);
                $end = substr($a->toDate, 0, 10);
                $dates = $start;
                $disabledDates = "'" . $start . "',";
                while ($dates < $end) {
                    $dates = date('Y-m-d', strtotime($dates . ' +1 day'));
                    $disabledDates .= "'" . $dates . "',";
                }
            }
            $disabledDates = substr($disabledDates, 0, -1);
//calculate block dates

            $facilities[$k]['disabledDates'] = $disabledDates;
            $facilities[$k]['blockTime'] = $blockTime;
            $facilities[$k]['rent'] = $r;
            $facilities[$k]['facilities_edit_id'] = Crypt::encryptString($v->facilities_id);
        }
        //    $allowTimes=array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00');


        return view('admin.facilities.checkavailability', ['facilities' => $facilities, 'facilitiestype' => $facilitiestype]);
    }

    public function checkavail($from, $to, $id)
    {

        echo $a = FacilityRent::where('facilities_id', $id)->where('fromDate', '<=', $from)->where('toDate', '>=', $to)->count();

    }


    public function contract($id)
    {
        $id = Crypt::decryptString($id);
        $facilities = FacilityRent::where('id', $id)->first();

        $disabledDates="";
        $data = Facilities::leftjoin('facilities_types', 'facilities_types.id', '=', 'facilities.facilitiesTypeId')
            ->where('facilities.id', $facilities->facilities_id)
            ->first(['facilities_types.*', 'facilities.Facility', 'facilities.paidUntil', 'facilities.location']);

        $subasso = Subassociation::where('status', 1)->get();
        $property = Property::leftjoin('property_types', 'property_types.id', '=', 'properties.typeId')
            ->get(['properties.*', 'property_types.type']);
        foreach ($property as $k => $v) {
            $building = Building::where('id', $v->buildingId)->first();
            $property[$k]['building'] = $building['building'];
        }
        $rent = FacilityRent::where('facilities_id', $id)->get();
        return view('admin.facilities.contract', ['data' => $data, 'id' => $id, 'subasso' => $subasso, 'property' => $property, 'building' => $building, 'facilities' => $facilities, 'rent' => $rent,'disabledDates'=>$disabledDates]);
    }
}
