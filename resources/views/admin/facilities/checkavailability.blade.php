@extends('admin.layouts.master')
@section('title', 'Rent a Facilities')
@section('content')

    <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css">
    <script src="/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Rent a Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">{{$facilitiestype->typeName}}</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Rent {{$facilitiestype->typeName}}</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        @foreach($facilities as $f)
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="ms-card-img">
                                            <img src="{{"/upload/".$f->facilities_img}}" alt="card_img" style="width: 100%">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="group_text">
                                            <h2>{{$f->Facility}}</h2>
                                        </div>
                                        <p><b>Status: @if($f->paidUntil < date('Y-m-d') || $f->isWeekly==1 || $f->isDaily==1 || $f->isHourly==1) <span style="color:#4caf50">Available</span>   @else
                                                    <span style="color:#e91e63"> Not Available</span> @endif</b></p>
                                        <p><b>Type:</b> {{$f->typeName}}</p>
                                        <p><b>Term:</b> @php $price="";
                                                        if($f->isHourly==1){ $price.=" $".$f->HourlyPrice."/Hourly -"; }
                                                        if($f->isDaily==1){ $price.=" $".$f->DailyPrice."/Daily -"; }
                                                        if($f->isWeekly==1){ $price.=" $".$f->WeeklyPrice."/Weekly -"; }
                                                        if($f->isMonthly==1){ $price.=" $".$f->MonthlyPrice."/Monthly -"; }
                                                        if($f->isYearly==1){ $price.=" $".$f->YearlyPrice."/Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                            @endphp</p>
                                        <p><b>Rental Periods:</b> @php $price="";
                                                        if($f->isHourly==1){ $price.=" Hourly -"; }
                                                        if($f->isDaily==1){ $price.=" Daily -"; }
                                                        if($f->isWeekly==1){ $price.=" Weekly -"; }
                                                        if($f->isMonthly==1){ $price.=" Monthly -"; }
                                                        if($f->isYearly==1){ $price.=" Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                            @endphp</p>
                                        <p><b>Location:</b> {{$f->location}}</p>
                                        <p><b>Renewal Date:</b>@if($f->paidUntil) {{ date("M d, Y", strtotime($f->paidUntil))}}@endif </p>

                                    </div>
                                    <div class="col-md-12">
                                        @if($f->isYearly!=1)
                                            <div id="scheduler{{$f->facilities_id}}">

                                            </div>


                                            <script>
                                                $(document).ready(function () {
                                                    var appointments = new Array();
                                                        @php $x=1; @endphp
                                                        @foreach($f->rent as $r)
                                                    var appointment{{$r->id}} = {
                                                            id: "id{{$x}}",
                                                            description: "George brings projector for presentations.",
                                                            location: "",
                                                            subject: "Rent by {{$r->RentrsName}}",
                                                            calendar: "{{$f->Facility}}",
                                                            start: new Date({{ date("Y", strtotime($r->fromDate))}}, {{ date("m", strtotime($r->fromDate))}}, {{ date("d", strtotime($r->fromDate))}}, {{ date("h", strtotime($r->fromDate))}}, 00, 00),
                                                            end: new Date({{ date("Y", strtotime($r->toDate))}}, {{ date("m", strtotime($r->toDate))}}, {{ date("d", strtotime($r->toDate))}}, {{ date("h", strtotime($r->toDate))}}, 00, 00)
                                                        }
                                                    appointments.push(appointment{{$r->id}});
                                                    @php $x++; @endphp
                                                    @endforeach

                                                    // prepare the data
                                                    var source =
                                                        {
                                                            dataType: "array",
                                                            dataFields: [
                                                                {name: 'id', type: 'string'},
                                                                {name: 'description', type: 'string'},
                                                                {name: 'location', type: 'string'},
                                                                {name: 'subject', type: 'string'},
                                                                {name: 'calendar', type: 'string'},
                                                                {name: 'start', type: 'date'},
                                                                {name: 'end', type: 'date'}
                                                            ],
                                                            id: 'id',
                                                            localData: appointments
                                                        };
                                                    var adapter = new $.jqx.dataAdapter(source);
                                                    $("#scheduler{{$f->facilities_id}}").jqxScheduler({
                                                        date: new $.jqx.date({{ date('Y') }}, {{ date('m') }}, {{ date('d') }}),
                                                        width: 850,
                                                        height: 500,
                                                        editDialog: false,
                                                        source: adapter,
                                                        @if($f->calenderType=="Days")
                                                        view: 'weekView',
                                                        @else
                                                        view: 'monthView',
                                                        @endif
                                                        showLegend: true,
                                                        ready: function () {

                                                            $("#scheduler{{$f->facilities_id}}").jqxScheduler('ensureAppointmentVisible', 'id1');
                                                        },
                                                        resources:
                                                            {
                                                                colorScheme: "scheme05",
                                                                dataField: "calendar",
                                                                source: new $.jqx.dataAdapter(source)
                                                            },
                                                        appointmentDataFields:
                                                            {
                                                                from: "start",
                                                                to: "end",
                                                                id: "id",
                                                                description: "description",
                                                                location: "place",
                                                                subject: "subject",
                                                                resourceId: "calendar"
                                                            },
                                                        views:
                                                            [
                                                                'dayView',
                                                                'weekView',
                                                                'monthView'
                                                            ]
                                                    });
                                                });
                                            </script>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            @if($f->paidUntil < date('Y-m-d') || $f->isWeekly==1 || $f->isDaily==1 || $f->isHourly==1)
                                <div class="ms-panel-body">
                                    <form class="needs-validation clearfix" novalidate="" action="/rent-facilities/{{$f->facilities_edit_id}}" method="get">
                                        <div class="form-row">
                                            <div class="col-xl-3 col-md-3 mb-3">
                                                <label for="validationCustom100">Form</label>
                                                <div class="input-group">
                                                    <input type="text" name="fromDate" class="form-control fromdate{{$f->facilities_id}} datetimepicker{{$f->facilities_id}}" onclick="resetform({{$f->facilities_id}})" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-3">
                                                <label for="validationCustom101">To</label>
                                                <div class="input-group">
                                                    <input type="text" name="toDate" class="form-control todate{{$f->facilities_id}} datetimepicker{{$f->facilities_id}}" placeholder="" onclick="resetform({{$f->facilities_id}})"  required>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-3">
                                                <button class="btn btn-primary chk{{$f->facilities_id}}" type="button" style="margin-top: 25px;" onclick="checkavailability({{$f->facilities_id}})">Check Availability</button>
                                                <button class="btn btn-success sub{{$f->facilities_id}}" type="submit" style="margin-top: 25px;display: none">Rent the Facility</button>
                                            </div>
                                            <div class="col-xl-3 col-md-3">

                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                                <script>



                                    var datePickerTime = function (currentDateTime) {

                                        var today = new Date();
                                        var istoday = today.toDateString();
                                        var day = currentDateTime.toDateString();

                                        if (day === istoday) {
                                            this.setOptions({
                                                {{--allowTimes: [{!! $todayallow !!}]--}}
                                            });
                                        } else {
                                            this.setOptions({
                                                {{--allowTimes: [{!! $alldayallow !!}]--}}
                                            });
                                        }
                                    };



                                    jQuery('.datetimepicker{{$f->facilities_id}}').datetimepicker({
                                        minDate: '{{date('Y-m-d', strtotime("+1 day"))}}',
                                        @if($f->isHourly!=1)
                                        disabledDates: [{!! $f->disabledDates !!}],
                                        formatDate: 'Y-m-d',
                                        format: 'Y-m-d',
                                        @else
                                        format: 'Y-m-d H:i',
                                        onChangeDateTime: datePickerTime,
                                        @endif
                                        mask: false,
                                        @if($f->isHourly!=1)
                                        timepicker: false,
                                        @endif
                                    });

                                </script>
                            @endif
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="/calander/jqx.base.css" type="text/css"/>
    <link rel="stylesheet" href="/calander/jqx.energyblue.css" type="text/css"/>
    <script type="text/javascript" src="/calander/jqx-all.js"></script>
    <script type="text/javascript" src="/calander/globalize.js"></script>

    <link rel="stylesheet" href="/calander/app.css" type="text/css"/>
<script>

    function resetform(facilities_id){
        $(".chk"+facilities_id).show();
        $(".sub"+facilities_id).hide();
    }

    function checkavailability(facilities_id){
        var from=$(".fromdate"+facilities_id).val();
        var to=$(".todate"+facilities_id).val();
        $.get("/checkavail/"+from+"/"+to+"/"+facilities_id,function (res) {
            if(res==0){
                $(".chk"+facilities_id).hide();
                $(".sub"+facilities_id).show();
            }else{
                alert("not available");
            }
        })
    }
    </script>
@endsection


