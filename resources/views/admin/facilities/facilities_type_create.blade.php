@extends('admin.layouts.master')
@section('title', 'Application')
@section('content')

    <style>
        .contract_field {
            display: none;
        }
    </style>

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('facilities-type.index')}}">Facilities Type</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities-type.create')}}">New</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>New Facilities Type</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" class="main-form" method="post" action="{{route('facilities-type.store')}}" enctype="multipart/form-data">
                            <input type="hidden" value="{{$ref}}" name="ref" id="ref">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">

                                <div class="col-md-10 ">
                                    <div class="group_text">
                                        <h2>Type Name and Description</h2>
                                    </div>
                                    <div class="form-group">
                                        <label for="examplePassword">Type Name</label>
                                        <input type="text" class="form-control" id="typeName" name="typeName" value="@if($data ?? ''){{$data->typeName}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-10 ">
                                    <div class="form-group ">
                                        <label for="examplePassword">Type Description</label>
                                        <textarea class="form-control" id="typeDescription" name="typeDescription">@if($data ?? ''){{$data->typeDescription}}@endif</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleEmail">Image</label>
                                        <input type="file" id="image" name="image">
                                        @if($data ?? '')
                                            @if(!empty($data->image))
                                                <br>
                                                <img src="/upload/{{$data->image}}" style="height: 200px">
                                            @endif
                                        @endif

                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="group_text">
                                        <hr>
                                        <h2>Limitation</h2>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="residentOnly" id="residentOnly" value="1" @if($data ?? '') @if($data->residentOnly==1) checked @endif @endif> <label
                                            for="residentOnly">Residents
                                            Only</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        Limited to <input type="text" name="limitedToRentalPerYear" value="@if($data ?? ''){{$data->limitedToRentalPerYear}}@endif"> Rentals Events per Year
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        Limited to <input type="text" name="limitedToRentalperEvent" value="@if($data ?? ''){{$data->limitedToRentalperEvent}}@endif"><select name="limitedType">
                                            <option value="Hours">Hours</option>
                                            <option value="Days">Days</option>
                                            <option value="Months">Months</option>
                                            <option value="Years">Years</option>
                                        </select> per rental Events
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="residentOnly" id="videoRequired" value="1" @if($data ?? '')@if($data->videoRequired==1) checked @endif @endif> <label
                                            for="videoRequired">Video
                                            showing the condition of the Facility at the time of the rental event is required</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        A
                                        <select name="calenderType">
                                            <option value="Days">Days</option>
                                            <option value="Months">Months</option>
                                        </select> calender is required
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="residentOnly" id="rentedOnline" value="1" @if($data ?? '') @if($data->rentedOnline==1) checked @endif @endif> <label
                                            for="rentedOnline">This
                                            rental type can be rented online</label>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="autoRenew" id="autoRenew" value="1" @if($data ?? '') @if($data->autoRenew==1) checked @endif @endif> <label for="autoRenew">This
                                            rental type
                                            is automatically renewing </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group limitation">
                                        A
                                        <select name="paymentType">
                                            <option value="Check">Check</option>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Both">Both</option>
                                        </select> payment is acceptable
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group_text">
                                        <hr>
                                        <h2>Rented By</h2>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="isHourly" value="1" @if($data ?? '') @if($data->isHourly==1) checked @endif @endif> <label>Hourly at <input type="text"
                                                                                                                                                                                 name="HourlyPrice"
                                                                                                                                                                                 value="@if($data ?? ''){{$data->HourlyPrice}}@endif">
                                            dollar for <input type="text" name="HourlyTime" value="@if($data ?? ''){{$data->HourlyTime}}@endif"> Hour/s</label>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="isDaily" value="1" @if($data ?? '') @if($data->isDaily==1) checked @endif @endif> <label>Daily at <input type="text"
                                                                                                                                                                              name="DailyPrice"
                                                                                                                                                                              value="@if($data ?? ''){{$data->DailyPrice}}@endif">
                                            dollar for <input type="text" name="DailyTime" value="@if($data ?? ''){{$data->DailyTime}}@endif"> Day/s</label>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="isWeekly" value="1" @if($data ?? '') @if($data->isWeekly==1) checked @endif @endif> <label>Weekly at <input type="text"
                                                                                                                                                                                 name="WeeklyPrice"
                                                                                                                                                                                 value="@if($data ?? ''){{$data->WeeklyPrice}}@endif">
                                            dollar for <input type="text" name="WeeklyTime" value="@if($data ?? ''){{$data->WeeklyTime}}@endif"> Week/s</label>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="isMonthly" value="1" @if($data ?? '') @if($data->isMonthly==1) checked @endif @endif> <label>Monthly at <input type="text"
                                                                                                                                                                                    name="MonthlyPrice"
                                                                                                                                                                                    value="@if($data ?? ''){{$data->MonthlyPrice}}@endif">
                                            dollar for <input type="text" name="MonthlyTime" value="@if($data ?? ''){{$data->MonthlyTime}}@endif"> Month/s</label>
                                    </div>
                                    <div class="form-group limitation">
                                        <input type="checkbox" name="isYearly" value="1" @if($data ?? '') @if($data->isYearly==1) checked @endif @endif> <label>Yearly at <input type="text"
                                                                                                                                                                                 name="YearlyPrice"
                                                                                                                                                                                 value="@if($data ?? ''){{$data->YearlyPrice}}@endif">
                                            dollar for <input type="text" name="YearlyTime" value="@if($data ?? ''){{$data->YearlyTime}}@endif"> Year/s</label>
                                    </div>

                                </div>
                                <script>
                                    function togglecontract() {
                                        if ($('#contractRequired').is(":checked")) {
                                            $(".contract_field").show()
                                        } else {
                                            $(".contract_field").hide()
                                        }
                                    }
                                </script>
                                <div class="col-md-12">
                                    <div class="group_text">
                                        <hr>
                                        <h2>Contract</h2>
                                        <div class="form-group limitation">
                                            <input type="checkbox" name="contractRequired" id="contractRequired" onclick="togglecontract()" value="1"
                                                   @if($data ?? '')@if($data->contractRequired==1) checked @endif @endif> <label
                                                for="contractRequired"> Contract must be signed for each rental event</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="contract_field">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="examplePassword">Cancellation Notice Time</label>
                                            <input type="text" class="form-control" id="cancellationNoticeTime" name="cancellationNoticeTime"
                                                   value="@if($data ?? ''){{$data->cancellationNoticeTime}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quite Time (Start)</label>
                                            <input type="time" class="form-control" name="quiteTiemHour"
                                                   value="@if($data ?? ''){{$data->quiteTiemHour}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Quite Time (End)</label>
                                            <input type="time" class="form-control" name="quiteTiemMiniuts"
                                                   value="@if($data ?? ''){{$data->quiteTiemMiniuts}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="examplePassword">Max Occupants</label>
                                            <input type="text" class="form-control" id="maxOccupants" name="maxOccupants"
                                                   value="@if($data ?? ''){{$data->maxOccupants}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group limitation">
                                            Security Deposite of $<input type="text" name="secirityDeposite" value="@if($data ?? ''){{$data->secirityDeposite}}@endif"> is Required
                                        </div>
                                        <div class="form-group limitation">
                                            Total of $<input type="text" name="noOfPetAllowed" value="@if($data ?? ''){{$data->noOfPetAllowed}}@endif"> Pets are allowed. with max weight of <input
                                                type="text" name="maxWightPet" value="@if($data ?? ''){{$data->maxWightPet}}@endif"> lbs
                                        </div>
                                        <div class="form-group limitation">
                                            Pet Deposite of $<input type="text" name="petDeposit" value="@if($data ?? ''){{$data->petDeposit}}@endif"> is Required
                                        </div>

                                        <div class="form-group limitation">
                                            <input type="checkbox" name="isPetDepositeRefundable" id="isPetDepositeRefundable" value="1"
                                                   @if($data ?? '') @if($data->isPetDepositeRefundable==1) checked @endif @endif> <label
                                                for="isPetDepositeRefundable"> Is Pet Deposite Refundable? </label>
                                        </div>

                                        <div class="form-group limitation">
                                            <input type="radio" name="parkingAvailable" value="1" @if($data ?? '' && $data->parkingAvailable==1) checked @endif> <input type="text"
                                                                                                                                                                        name="freeParkingSpace"
                                                                                                                                                                        value="@if($data ?? ''){{$data->freeParkingSpace}}@endif">
                                            Parking spaces are provided free of charges
                                        </div>
                                        <div class="form-group limitation">
                                            <input type="radio" name="parkingAvailable" value="2" @if($data ?? '') @if($data->parkingAvailable==1) checked @endif @endif> Parking available for a
                                            charges of <input
                                                type="text" name="ParkingFees" value="@if($data ?? ''){{$data->ParkingFees}}@endif">
                                        </div>
                                        <div class="form-group limitation">
                                            <input type="radio" name="parkingAvailable" value="0" @if($data ?? '') @if($data->parkingAvailable==1) checked @endif @endif> No parking Provided
                                        </div>
                                        <div class="form-group limitation">
                                            Party cleanup fees of $<input type="text" name="partyCleanupFees" value="@if($data ?? ''){{$data->partyCleanupFees}}@endif"> is Required
                                        </div>
                                        <div class="form-group limitation">
                                            smoking is permitted at the <input type="text" name="smokingArea" value="@if($data ?? ''){{$data->smokingArea}}@endif"> Areas
                                        </div>
                                        <div class="form-group limitation">
                                            <input type="checkbox" name="moveinInspectionRequired" id="moveinInspectionRequired" value="1"
                                                   @if($data ?? '') @if($data->moveinInspectionRequired==1) checked @endif @endif> <label
                                                for="moveinInspectionRequired"> Move-in Inspection Required </label>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <b>24 Hours a Day Emergency Contact</b>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>First name</label>
                                            <input type="text" class="form-control" name="emergencyContactFname"
                                                   value="@if($data ?? ''){{$data->emergencyContactFname}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Last name</label>
                                            <input type="text" class="form-control" name="emergencyContactLname"
                                                   value="@if($data ?? ''){{$data->emergencyContactLname}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" name="emergencyContactPhone"
                                                   value="@if($data ?? ''){{$data->emergencyContactPhone}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="emergencyContactEmail"
                                                   value="@if($data ?? ''){{$data->emergencyContactEmail}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="group_text">
                                            <h2>Extra Fees</h2>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;margin-bottom: 10px">New Fees
                                            </button>
                                        </div>


                                        <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                            <thead>
                                            <tr>
                                                <th>S. No</th>
                                                <th>Fees</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody">

                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="col-md-12">
                                        <textarea class="form-control editor" id="mytemplate" name="contract">@if($data ?? ''){{$data->contract}}@endif</textarea>
                                        @foreach($template_variable as $t)
                                            <button class="btn btn-secondary" type="button" onclick="setto('{{$t->variable}}')">{{$t->variable}}</button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary d-block" id="submit" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Upload Documents </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-details">
                    <form action="/uploaddocument" id="ownerdocuments" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$ref}}" name="ref" id="ref">

                        <div class="form-group">
                            <label for="exampleEmail">Fees</label>
                            <input type="text" class="form-control" id="fes_name" name="fes_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleEmail">Amount</label>
                            <input type="Text" class="form-control" id="amount" name="amount">
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <input type="button" value="Insert" class="btn btn-success" onclick="submitform()">
                </div>
            </div>
        </div>
    </div>

    <script>
        function uploaddoc() {
            $.get('/facilitiestable/{{$ref}}', function (res) {
                $("#tbody").html(res);
            })
        }

        function setto(mark) {
            tinymce.activeEditor.execCommand('mceInsertContent', false, mark);
        }

        $(document).ready(function () {
            $('#data-table').DataTable();
            uploaddoc();
        });

        function chackemail(email) {
            $.get("/chackemail-application/" + email, function (res) {
                console.log(res);
                if (res == 1) {
                    html = '<label for="website" generated="true" class="email-error error">Email id already approved.</label>';
                    $("#email").after(html);
                }

            })
        }

        $("#email").focus(function () {
            $(".email-error").remove();
            $("#email").removeClass('error');
        })

        function submitform() {
            var fes_name = $("#fes_name").val();
            var amount = $("#amount").val();
            var ref = $("#ref").val();


            var formData = new FormData();
            formData.append('ref', ref);
            formData.append('fes_name', fes_name);
            formData.append('amount', amount);
            formData.append('_token', "{{csrf_token()}}");
            $.ajax({
                url: '/insertfacilitiesfees',
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (data) {
                    $('#exampleModal').modal('toggle');
                    uploaddoc();
                }
            });


        }

    </script>
    <script>
        $(document).ready(function () {
            $('.customdate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

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

        .limitation input[type=text], .limitation select {
            height: 30px;
            width: 100px;
            margin: 0px 5px;
        }

        .onoffswitch {
            position: relative;
            width: 45px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .onoffswitch-checkbox {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .onoffswitch-label {
            display: block;
            overflow: hidden;
            cursor: pointer;
            height: 19px;
            padding: 0;
            line-height: 19px;
            border: 2px solid #E3E3E3;
            border-radius: 19px;
            background-color: #FFFFFF;
            transition: background-color 0.3s ease-in;
        }

        .onoffswitch-label:before {
            content: "";
            display: block;
            width: 19px;
            margin: 0px;
            background: #FFFFFF;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 24px;
            border: 2px solid #E3E3E3;
            border-radius: 19px;
            transition: all 0.3s ease-in 0s;
        }

        .onoffswitch-checkbox:checked + .onoffswitch-label {
            background-color: #009EFB;
        }

        .onoffswitch-checkbox:checked + .onoffswitch-label, .onoffswitch-checkbox:checked + .onoffswitch-label:before {
            border-color: #009EFB;
        }

        .onoffswitch-checkbox:checked + .onoffswitch-label:before {
            right: 0px;
        }
    </style>
    @include('admin.includes.validate');
    @if($data ?? '')
        <script>
            togglecontract();
        </script>
    @endif
@endsection

