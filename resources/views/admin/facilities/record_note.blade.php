@extends('admin.layouts.master')
@section('title', 'Note')
@section('content')

<style>
    @if ($facilitieRent ?? '')
        @if ($facilitieRent->isResident == 0)
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
        @if ($facilitieRent->paymentType == 0)
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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i>
                            Home</a></li>
                    @if (request()->is('record-note/*'))
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                    @else
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page"><a
                            href="{{ route('facilities.index') }}">Facilities</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Note</a></li>
                </ol>
            </nav>
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome">
                    <h6>Note</h6>
                </div>
                <div class="ms-panel-body">
                    @include('admin.includes.msg')
                    <form action="{{ route('rent.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="facilities_id" value="{{ $id }}">
                        @if ($facilitieRent ?? '')
                            <input type="hidden" name="id" value="{{ $facilitieRent->id }}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">

                                <div id="printableArea">

                                    <div class="group_text">
                                        <h2>Facilities Details</h2>
                                    </div>
                                    <p><b>Occupied:</b></p>
                                    <p><b>Type:</b> {{ $facilities->FacilitiesTypetypeName }}</p>
                                    <p><b>Term:</b> {{ $facilities->FacilitiesTypetermType }}</p>
                                    <p><b>Rental Periods:</b><br>
                                        @if ($facilities->FacilitiesType->isHourly == 1) Hourly ,
                                        @endif
                                        @if ($facilities->FacilitiesType->isDaily == 1) Daily ,@endif
                                        @if ($facilities->FacilitiesType->isWeekly == 1) Weekly,
                                        @endif
                                        @if ($facilities->FacilitiesType->isMonthly == 1)Monthly ,
                                        @endif
                                        @if ($facilities->FacilitiesType->isYearly == 1) Yearly @endif
                                    </p>
                                    <p><b>Location:</b> {!! $data->location !!}</p>
                                    <p><b>Current Renter:</b></p>
                                    <p><b>Paid Until:</b>
                                        @if ($data->paidUntil)
                                            {{ date('M d, Y', strtotime($data->paidUntil)) }}
                                    </p>
                                    @endif
                                    <p><b>Current Cost:</b>
                                        @if ($facilities->FacilitiesType->isHourly == 1)
                                            ${{ $facilities->FacilitiesType->HourlyPrice }}/Hourly ,@endif
                                        @if ($facilities->FacilitiesType->isDaily == 1)
                                            ${{ $facilities->FacilitiesType->DailyPrice }}/Daily ,@endif
                                        @if ($facilities->FacilitiesType->isWeekly == 1)
                                            ${{ $facilities->FacilitiesType->WeeklyPrice }}/Weekly, @endif
                                        @if ($facilities->FacilitiesType->isMonthly == 1)
                                            ${{ $facilities->FacilitiesType->MonthlyPrice }}/Monthly ,@endif
                                        @if ($facilities->FacilitiesType->isYearly == 1)
                                            ${{ $facilities->FacilitiesType->YearlyPrice }}/Yearly @endif
                                    </p>

                                </div>
                            </div>

                        </div>
                        <div class="row">

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
                                    <input type="text" class="form-control" id="noteSubject" name="noteSubject" @if ($facilitieRent ?? '') value="{{ $facilitieRent->noteSubject }}" @endif>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleEmail">Note Details</label>
                                    <textarea class="form-control" id="noteDetails"
                                        name="noteDetails"> @if ($facilitieRent ?? ''){{ $facilitieRent->noteDetails }}@endif</textarea>
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
    function rentedto(type) {
        if (type == "1") {
            $(".resident").show();
            $(".notresident").hide();
        } else {
            $(".resident").hide();
            $(".notresident").show();
        }

    }

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
        $.get('/getbuilding/' + association, function(res) {
            $("#buildingId").html(res);
        })
        $.get('/getproperty/' + association, function(res) {
            $("#propertyId").html(res);
        })
    }

    function selectperson(type) {
        var propertyId = $("#propertyId").val();
        $.get('/get-person/' + type + '/' + propertyId, function(res) {
            $("#person").html(res);
        })
    }
</script>
@endsection
