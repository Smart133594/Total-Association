@extends('admin.layouts.master')
@section('title', 'Rent')
@section('content')

    <style>
        @if($facilities ?? '')
                @if($facilities->isResident==0)
                 .resident {
            display: none;
        }

        .notresident {
            display: block;
        }

        @else
                 .resident {
            display: block;
        }

        .notresident {
            display: none;
        }

        @endif
                @if($facilities->paymentType==0)
                 .cc {
            display: none;
        }

        .cheque {
            display: block;
        }

        @else
                 .cc {
            display: block;
        }

        .cheque {
            display: none;
        }

        @endif



        @else
            .notresident {
            display: none;
        }

        .cheque {
            display: none;
        }
        @endif


    </style>
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
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Rent The Facilities</a></li>
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
                                <div class="col-md-12">

                                    <div class="group_text">
                                        <h2>Dates</h2>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleEmail">Start Date <span>*</span></label>
                                        <input type="text" class="form-control " id="fromDate" name="fromDate" @if($facilities ?? '') value="{{$facilities->fromDate}}" @else value="{{$_GET['fromDate']}}" @endif required readonly>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleEmail">End Date <span>*</span></label>
                                        <input type="text" class="form-control " id="toDate" name="toDate" @if($facilities ?? '') value="{{$facilities->toDate}}"  @else value="{{$_GET['toDate']}}" @endif required readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <div class="group_text">
                                        <h2>Rented To</h2>
                                        <input type="radio" value="1" name="isResident" @if(!isset($facilities)) checked @else @if($facilities->isResident==1) checked
                                               @endif @endif onclick="rentedto(this.value)"> Resident
                                        <input type="radio" name="isResident" value="0" onclick="rentedto(this.value)" @if($facilities ?? '') @if($facilities->isResident==0) checked @endif @endif> Non
                                        Resident
                                        <br><br>
                                    </div>
                                </div>
                                <div class="col-md-7 resident">
                                    @if($setting['is_subassociations']=="1")

                                        <div class="form-group Individual">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId" onchange="getbuilding(this.value)"  @if(!isset($facilities)) required @endif>
                                                <option value="">--Choose--</option>
                                                @foreach($subasso as $s)
                                                    <option value="{{$s->id}}" @if($facilities ?? '') @if($facilities->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @endif


                                    <div class="form-group Individual" id="building">
                                        <label for="examplePassword">Building</label>
                                        <select type="text" class="form-control" id="buildingId" name="buildingId"   @if(!isset($facilities)) required @endif>
                                            <option value="">--Choose--</option>
                                            @if(isset($facilities))
                                                @foreach($building as $s)
                                                    <option value="{{$s->id}}" @if($facilities ?? '') @if($facilities->buildingId==$s->id)selected @endif @endif>{{$s->building}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group Individual">
                                        <label for="examplePassword">Property<span>*</span></label>
                                        <select type="text" class="form-control" id="propertyId" name="propertyId" onchange="gettype()"   @if(!isset($facilities)) required @endif>
                                            <option value="">--Choose--</option>
                                            @if($setting['is_subassociations']=="0" || isset($facilities))
                                                @foreach($property as $p)
                                                    <option value="{{$p->id}}" type="{{$p->type}}" @if($facilities ?? '') @if($facilities->propertyId==$p->id) selected @endif @endif>{{$p->type}}
                                                        /{{$p->building}}
                                                        /{{$p->aptNumber}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group Individual">
                                        <label for="exampleEmail">Choose Receiver</label>
                                        <select class="form-control" name="whome_type" onchange="selectperson(this.value)"   @if(!isset($facilities)) required @endif>
                                            <option value="">--choose--</option>
                                            <option value="Owners" @if($facilities ?? '') @if($facilities->whome_type=="Owners") selected @endif @endif>Owners</option>
                                            <option value="Residents" @if($facilities ?? '') @if($facilities->whome_type=="Residents") selected @endif @endif>Residents</option>
                                        </select>
                                    </div>
                                    <div class="form-group Individual">
                                        <label for="exampleEmail"> Select the Person</label>
                                        <select class="form-control" id="person" name="whome"  onchange="setperson()"   @if(!isset($facilities)) required @endif>
                                            <option value="">--choose--</option>
                                            @if(isset($facilities) && !empty($person))
                                                @foreach($person as $p)
                                                    <option value="{{$p->id}}" type="{{$p->type}}"
                                                            @if($facilities ?? '') @if($facilities->whome==$p->id) selected @endif @endif>{{$p->firstName}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-7 notresident">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Renters Name</label>
                                                <input type="text" class="form-control" id="RentrsName" name="RentrsName" @if($facilities ?? '') value="{{$facilities->RentrsName}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Renters Phone</label>
                                                <input type="text" class="form-control" id="RentrsPhone" name="RentrsPhone" @if($facilities ?? '') value="{{$facilities->RentrsPhone}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Renters Email</label>
                                                <input type="text" class="form-control" id="RentrsEmail" name="RentrsEmail" @if($facilities ?? '') value="{{$facilities->RentrsEmail}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleEmail">Renters Address</label>
                                                <textarea class="form-control" id="RentrsAddress" name="RentrsAddress"> @if($facilities ?? ''){{$facilities->RentrsAddress}}@endif</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Upload Id</label>
                                                <input type="file" class="form-control" id="RentrsIdproof" name="RentrsIdproof">
                                                @if($facilities ?? '')
                                                    @if(!empty($facilities->RentrsIdproof))
                                                        <img src="/thumb/{{$facilities->RentrsIdproof}}">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                    <div class="group_text">
                                        <h2>Record Payment</h2>
                                        <input type="radio" value="1" name="paymentType" @if(!isset($facilities)) checked @else @if($facilities->paymentType==1) checked
                                               @endif @endif onclick="paymenttype(this.value)"> Credit Card <input type="radio"
                                                                                                                   name="paymentType"
                                                                                                                   value="0"
                                                                                                                   onclick="paymenttype(this.value)">
                                        Cheque
                                        <br><br>
                                    </div>


                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="exampleEmail">Enter Amount<span>*</span></label>
                                        <input type="text" class="form-control" id="amount" name="amount" @if($facilities ?? '') value="{{$facilities->amount}}" @endif required>
                                    </div>
                                </div>
                                <div class="col-md-12 cc">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Name on Card</label>
                                                <input type="text" class="form-control" id="NameOnCard" name="NameOnCard" @if($facilities ?? '') value="{{$facilities->NameOnCard}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Card Type</label>
                                                <input type="text" class="form-control" id="cardType" name="cardType" @if($facilities ?? '') value="{{$facilities->cardType}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Card number</label>
                                                <input type="number" class="form-control" id="cardNumber" name="cardNumber" @if($facilities ?? '') value="{{$facilities->cardNumber}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleEmail">Exp Month</label>
                                                <input type="text" class="form-control" id="expMonth" name="expMonth" @if($facilities ?? '') value="{{$facilities->expMonth}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleEmail">Exp Year</label>
                                                <input type="text" class="form-control" id="expYear" name="expYear" @if($facilities ?? '') value="{{$facilities->expYear}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="exampleEmail">CVV</label>
                                                <input type="number" class="form-control" id="cvv" name="cvv" max="999" @if($facilities ?? '') value="{{$facilities->cvv}}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Card Front</label>
                                                <input type="file" class="form-control" id="ccFront" name="ccFront">
                                                @if($facilities ?? '')
                                                    @if(!empty($facilities->ccFront))
                                                        <img src="/thumb/{{$facilities->ccFront}}">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleEmail">Card Back</label>
                                                <input type="file" class="form-control" id="ccBack" name="ccBack">
                                                @if($facilities ?? '')
                                                    @if(!empty($facilities->ccBack))
                                                        <img src="/thumb/{{$facilities->ccBack}}">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 cheque">

                                    <div class="form-group">
                                        <label for="exampleEmail">Cheque<br></label>
                                        <input type="file" id="cheque" name="cheque">
                                        @if($facilities ?? '')
                                            @if(!empty($facilities->cheque))
                                                <img src="/thumb/{{$facilities->cheque}}">
                                            @endif
                                        @endif
                                    </div>

                                </div>
                                @if($data->videoRequired==1)
                                    <div class="col-md-12">
                                        <hr>
                                        <div class="group_text">
                                            <h2>Upload Video</h2>

                                            <br><br>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" id="video" name="video">
                                        </div>
                                    </div>
                                @endif
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
                                    <hr>
                                    <div class="group_text">
                                        <h2>Add a Note</h2>
                                        <br><br>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Subject</label>
                                        <input type="text" class="form-control" id="noteSubject" name="noteSubject" @if($facilities ?? '') value="{{$facilities->noteSubject}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Note Details</label>
                                        <textarea class="form-control" id="noteDetails" name="noteDetails"> @if($facilities ?? ''){{$facilities->noteDetails}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-success" value="Save And Rent Faclility">
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


