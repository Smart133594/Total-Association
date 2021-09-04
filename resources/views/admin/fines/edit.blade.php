@extends('admin.layouts.master')
@section('title', 'Incident')
@section('content')
    <style>
        .steps {
            padding: 0;
            list-style-type: none;
            border: 1px solid #ccc;
        }

        .steps:before, .steps:after {
            content: "";
            display: table;
        }

        .steps:after {
            clear: both;
        }

        .steps li {
            display: inline-block;
            width: 25%;
            float: left;
            text-align: center;
            font-size: 10px;
            font-family: sans-serif;
        }

        .steps li.step_active {
            background: #009efb;;
            color: #fff;
        }

        .steps li a {
            padding: 0 12px;
            height: 40px;
            line-height: 40px;
            position: relative;
            display: block;
        }

        .steps li.step_active a:before, ul li.step_active a:after {
            content: "";
            position: absolute;
            border-style: solid;
            border-color: transparent transparent transparent white;
            border-width: 20px;
            left: 0px;
        }

        .steps li.step_active a:after {
            content: "";
            right: -40px;
            left: auto;
            border-color: transparent transparent transparent #009efb;;
        }

        .steps li.active a {
            padding-left: 30px;
        }

        .group_text {
            padding-top: 15px;
        }

    </style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Fines and Violations</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('fines.index')}}">Fine</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Details</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Fine Details</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')

                        <div class="row">
                            <div class="col-md-10">
                                <ul class="steps">
                                    <li><a>Step 1 - Incident Report</a></li>
                                    @if($data->fine_status==0)
                                        <li class="step_active"><a>Step 2 - Waiting For Response</a></li>
                                    @elseif($data->fine_status==2)
                                        <li><a>Step 2 - Waiting For Response</a></li>
                                        <li class="step_active"><a>Step 3 - To Fining Committee</a></li>
                                    @elseif($data->fine_status==3)
                                        @if($data->committee_decision=="Appeal Rejected")
                                            <li><a>Step 2 - Waiting For Response</a></li>
                                            <li class="step_active"><a>Final Step - Fine In Effect</a></li>
                                        @else
                                            <li><a>Step 2 - Waiting For Response</a></li>
                                            <li><a>Step 3 - To Fining Committee</a></li>
                                            <li class="step_active"><a>Final Step - Fining Committee Decision</a></li>
                                        @endif
                                    @endif


                                </ul>
                                <div id="printableArea">
                                    @if($data->fine_status==0)
                                        <p>An incident report has been created and the management or Board of Directors decided to issue a tine for the violation. Florida law requires to allow X days
                                            for
                                            the offender to dispute the fine. This step can proceed in 3 ways:</p>
                                        <ol>
                                            <li>The offender will dispute the fine by filling the online form or delivering it to the office</li>
                                            <li>The offender will not dispute the fine or will not dispute it in a timely manner</li>
                                            <li>The Offender will pay the fine immidiately</li>
                                        </ol>
                                        <p>If the offender disputes the fine, a package will be created for the fining committee to discuss the matter and make a decision on the matter. If the fine
                                            was
                                            not disputed in a timely manner, the fine will be issued to the property account immediately. If the offender pays the fine immediately, the case will be
                                            closed</p>
                                    @endif
                                    @if($data->fine_status==2)

                                            <p>So the offender disputed the fine. He has the right to appear in front of the fining committee and plead his case. The Committee will decide this matter. You will need to create a package for the committee members to look over as they make their decision. this item will need to be scheduled in the next Fining Committee meeting.</p>
                                            <p> Once the committee made a decision. Make sure to record that decision and scan the Committee Decision form into the system.</p>
                                    @endif
                                    @if($data->fine_status==3)
                                            <p>So the offender did not dispute the fine in a timely manner, or the committee decided to keep the fine. Either way, the fine is now finalized and on the property balance sheet. It must be paid or the property will become delinquent. The property can pay for the fine online on the website or give a check to be entered below. Once the payment is received, this issue will be closed.</p>
                                        @endif

                                    <div class="group_text">
                                        <h2>Incident Details</h2>
                                    </div>
                                    <p><b>Time of Incident:</b> {{ date("M d, Y", strtotime($data->dateTime))}} </p>
                                    <p><b>Property:</b> {{ $property[$data->propertyId]->type}}/{{ $property[$data->propertyId]->building}}/{{ $property[$data->propertyId]->aptNumber}} </p>
                                    <p><b>Offender:</b> {{$data->ind}}</p>
                                    <p><b>Incident Title:</b> {{$data->incidentTitle}}</p>
                                    <p><b>Incident Description:</b><br>
                                        {!! $data->incidentDescription !!}</p>
                                    <p><b>Police Report Details:</b><br>
                                        Police report# {!! $data->policeReport !!}</p>
                                    <p><b>Fine Amount</b> $ @if($data->new_fine_amount==0) {{$data->fine_amount}} @else {{$data->new_fine_amount}} @endif</p>
                                    <p><b>Time of Notification Sent:</b> {{ date("M d, Y", strtotime($data->report_send_time))}}</p>

                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Incident Files</h2>
                                </div>

                                <table class="table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Document</th>
                                        <th>Type</th>
                                        <th>Upload Date</th>
                                        <th>Upload By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">

                                    </tbody>
                                </table>
                                @if($data->fine_status!=1)
                                    <div class="group_text">
                                        <h2>Resend Notification</h2>
                                        <a href="/fine-resendemail/{{$data->id}}"><button type="button" class="btn btn-light">Resend email to the offender and owner</button></a>
                                        <button type="button" class="btn btn-light" onclick="printDiv('printableArea')">Print letter send to the offender and owner</button>
                                    </div>
                                @endif
                                @if($data->fine_status==2)
                                    <form action="{{ route('fine-update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$data->id}}" name="id">
                                        <input type="hidden" value="3" name="fine_status">
                                        <div class="group_text">
                                            <h2>Create package for fining committee</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Generate Finning Committee Packege</label>
                                                    <input type="text" class="form-control" name="committee_packege">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="group_text">
                                            <h2>Enter Committee Decision</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Committee Decision <span>*</span></label>
                                                    <select class="form-control" name="committee_decision" onchange="setfineamount(this.value)" required>
                                                        <option value="">--choose--</option>
                                                        <option value="Appeal Rejected">Appeal Rejected</option>
                                                        <option value="Fine Reduce">Fine Reduce</option>
                                                        <option value="Appeal Accepted">Appeal Accepted</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function setfineamount(d){
                                                if(d=="Fine Reduce"){
                                                    $(".fine").show();
                                                }else{
                                                    $(".fine").hide();
                                                }

                                            }
                                        </script>
                                        <div class="row fine" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>New Fine Amount</label>
                                                    <input type="text" class="form-control" name="new_fine_amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Signed committee decision form <span>*</span></label>
                                                    <input type="file" class="form-control" name="decision_form" required>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary d-block" value="Save">
                                    </form>
                                @endif
                                @if($data->fine_status==0)
                                    <form action="{{ route('fine-update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$data->id}}" name="id">
                                        <input type="hidden" value="2" name="fine_status">
                                        <div class="group_text">
                                            <h2>Enter Dispute form filled by Offender</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Dispute Form <span>*</span></label>
                                                    <input type="file" class="form-control" name="dispute_form" required>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary" value="Save">
                                    </form>
                                @endif

                                @if($data->fine_status==3)
                                    <div class="group_text">
                                        <h2>Notification And Timing</h2>
                                        <p><b>Date of Notification:</b> {{ date("M d, Y", strtotime($data->report_send_time))}}</p>
                                        <p><b>Date waited for Response:</b> {{ $setting['wait-days-for-fine'] }}</p>
                                        <p><b>date fine become effective:</b> {{ date("M d, Y", strtotime($data->report_send_time .'+'.$setting["wait-days-for-fine"].' day'))}}</p>
                                        <h2>Committee Outcome</h2>
                                        <p><b>Committee Decision:</b> {{$data->committee_decision}}</p>
                                        <p><b>Final Fine Amount:</b> $ @if($data->new_fine_amount==0) {{$data->fine_amount}} @else {{$data->new_fine_amount}} @endif</p>
                                    </div>

                                @endif
                                @if($data->fine_status!=1)
                                    <form action="{{ route('fine-update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$data->id}}" name="id">
                                        <input type="hidden" value="1" name="fine_status">
                                        <div class="group_text">
                                            <h2>Receive Payment For the Fine</h2>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Enter Amount <span>*</span></label>
                                                    <input type="text" class="form-control" name="paid_amount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Check <span>*</span></label>
                                                    <input type="file" class="form-control imgInp" name="check_image" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <img id="check_image" class="preview" src="" style="display: none"/>
                                            </div>
                                        </div>
                                        <input type="submit" class="btn btn-primary d-block" value="Save">
                                    </form>
                                @endif
                                @if($data->fine_status==1)
                                    <img src="/upload/{{$data->check_image}}">
                                @endif

                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function isindividual(type) {
            if (type == 1) {
                $(".individual_group").show();
                $("#individualType").prop('required', true);
            } else {
                $(".individual_group").hide();
                $("#individualType").prop('required', false);
            }
        }

        function ispolice(type) {
            if (type == 1) {
                $(".police").show();
            } else {
                $(".police").hide();
            }
        }

        $(document).ready(function () {
            $('#data-table').DataTable();
            uploaddoc();
        });

        function uploaddoc() {
            $.get('/uploadincidentdoc/{{$ref}}', function (res) {
                $("#tbody").html(res);
            })
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var id = $(input).attr('name');
                $(".preview").show();
                reader.onload = function (e) {
                    $('#' + id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(".imgInp").change(function () {
            console.log("hi");
            readURL(this);
        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
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

@endsection
