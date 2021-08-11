@extends('admin.layouts.master')
@section('title', 'Rent')
@section('content')


    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('rent-facilities/*') ||  request()->is('edit_the_rent/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Contract</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Rent The Facilities</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form action="{{route('rent.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="facilities_id" value="{{$id}}">
                            @if($facilities ?? '')
                                <input type="hidden" name="id" value="{{$facilities->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="printableArea">
                                        <div class="group_text">
                                            <h2>Facilities Details</h2>
                                        </div>
                                        <p><b>Occupied:</b></p>
                                        <p><b>Type:</b> {{$data->typeName}}</p>
                                        <p><b>Term:</b> {{$data->termType}}</p>
                                        <p><b>Rental Periods:</b><br>
                                            @if($data->isHourly==1) Hourly @endif
                                            @if($data->isDaily==1)  Daily @endif
                                            @if($data->isWeekly==1) Weekly  @endif
                                            @if($data->isMonthly==1)Monthly  @endif
                                            @if($data->isYearly==1) Yearly @endif </p>
                                        <p><b>Location:</b> {!! $data->location !!}</p>
                                        <p><b>Current Renter:</b></p>
                                        <p><b>Paid Until:</b> @if($data->paidUntil) {{ date("M d, Y", strtotime($data->paidUntil))}}</p>@endif
                                        <p><b>Current Cost:</b>
                                            @if($data->isHourly==1) ${{$data->HourlyPrice}}/Hourly  @endif
                                            @if($data->isDaily==1)  ${{$data->DailyPrice}}/Daily @endif
                                            @if($data->isWeekly==1) ${{$data->WeeklyPrice}}/Weekly @endif
                                            @if($data->isMonthly==1) ${{$data->MonthlyPrice}}/Monthly @endif
                                            @if($data->isYearly==1) ${{$data->YearlyPrice}}/Yearly @endif </p>
                                    </div>
                                </div>
{{--                                <div class="col-md-6">--}}
{{--                                    <div id='calendar'></div>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row">

                                @if($data->contractRequired==1)
                                    @if($facilities ?? '')
                                        <div class="col-md-12">
                                            <hr>
                                            <div class="group_text">
                                                <h2>Contract</h2>
                                                <a href="/downloadcontract/{{$id}}" class="btn btn-success" target="_blank">Download Contract</a><br><br>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleEmail">Upload Signed Contract</label><br>
                                                <input type="file" id="signedContract" name="signedContract">
                                                @if($facilities ?? '')
                                                    @if(!empty($facilities->signedContract))
                                                        <img src="/thumb/{{$facilities->signedContract}}">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                    @endif

                                @endif

                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function rentedto(type) { console.log(type)
               if (type == "1") {
                $(".resident").show();
                $(".notresident").hide();

                $(".Individual").find('input').prop('required', true);
                $(".Individual").find('select').prop('required', true);
                $(".notresident").find('input').prop('required', false);
            } else {
                $(".resident").hide();
                $(".notresident").show();

                $(".notresident").find('input').prop('required', true);
                $(".Individual").find('input').prop('required', false);
                $(".Individual").find('select').prop('required', false);
            }

        }
        @if($facilities ?? '')
        rentedto({{$facilities->isResident}});

@endif

        function paymenttype(type) {
            if (type == "1") {
                $(".cc").show();
                $(".cheque").hide();
            } else {
                $(".cc").hide();
                $(".cheque").show();
            }

        }
    </script>

    <style>
        .action {
            display: flex;
        }

        .dropdown-toggle::after {
            vertical-align: 0.155em;
            left: 0px;
            position: absolute;
            color: #fff;
            left: 20px;
            display: none;
            margin-right: 0px !important;
            top: 7px;
        }

        .cust-btn {
            padding: 4px 4px 3px 4px;
            border-radius: 2px;
            color: #009efb;
        }

        .cust-btn .fas {

            margin-right: 0px !important;
        }
    </style>
    <script>
        function getbuilding(association) {
            $.get('/getbuilding/' + association, function (res) {
                $("#buildingId").html(res);
            })
            $.get('/getproperty/' + association, function (res) {
                $("#propertyId").html(res);
            })
        }

        function selectperson(type) {
            var propertyId = $("#propertyId").val();
            $.get('/get-person/' + type + '/' + propertyId, function (res) {
                $("#person").html(res);
            })
        }
    </script>


    <link rel="stylesheet" type="text/css" href="/datetimepicker/jquery.datetimepicker.css"/ >
    <script src="/datetimepicker/jquery.datetimepicker.full.min.js"></script>
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


        jQuery('.datetimepicker').datetimepicker({

            minDate: '{{date('Y-m-d', strtotime("+1 day"))}}',
            disabledDates: [{!! $disabledDates !!}],
            formatDate: 'Y-m-d',
            @if($data->isHourly!=1)
            format: 'Y-m-d',
            @else
            format: 'Y-m-d H:i',
            @endif
            mask: false,
            @if($data->isHourly!=1)
            timepicker: false,
            @endif
            onChangeDateTime: datePickerTime,

        });


    </script>

    <script src='/fullcalendar/packages/core/main.js'></script>
    <script src='/fullcalendar/packages/interaction/main.js'></script>
    <script src='/fullcalendar/packages/daygrid/main.js'></script>
    <script src='/fullcalendar/packages/timegrid/main.js'></script>
    <script src='/fullcalendar/packages/list/main.js'></script>
    <link href='/fullcalendar/packages/core/main.css' rel='stylesheet'/>
    <link href='/fullcalendar/packages/daygrid/main.css' rel='stylesheet'/>

    @php
        $list="";
        foreach($rent as $r){
        $list.="{
                            title: '".$r->RentrsName."',
                            start: '".$r->fromDate."',
                            end: '".$r->toDate  ."'
                        },";
        }
        $list=substr($list,0,-1);
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                height: 'parent',
                header: {
                    left: 'prev,next ',
                    center: 'title',
                    right: 'today'
                    // right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                @if($data->calenderType=="Days")

                defaultView: 'timeGridWeek',
                @else
                defaultView: 'dayGridMonth',
                @endif
                defaultDate: '{{ date('Y-m-d') }}',
                navLinks: true, // can click day/week names to navigate views
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    {!!  $list!!}
                ]
            });

            calendar.render();
        });

    </script>
    <script>


        function setperson(){
            var name=$("#person").find('option:selected').text();
            $("#RentrsName").val(name);
        }
    </script>

@endsection


