@extends('admin.layouts.master')
@section('title', 'Incident')
@section('content')
<style>
    table {
        table-layout: fixed;
        border-collapse: collapse;
        width: 100%;
        max-width: 100px;
    }
    td.text-flow {
        white-space: nowrap; 
        width: 100px; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('facilities/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Details</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Facilities Details</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')

                        <div class="row">
                            <div class="col-md-10">

                                <div id="printableArea">


                                    <div class="group_text">
                                        <h2>Facilities Details</h2>
                                    </div>
                                    <p><b>Occupied:</b></p>
                                    <p><b>Type:</b> {{$data->FacilitiesType->typeName}}</p>
                                    <p><b>Term:</b> {{$data->FacilitiesType->termType}}</p>
                                    <p><b>Rental Periods:</b><br>

                                        @php $price="";
                                                        if($data->FacilitiesType->isHourly==1){ $price.=" Hourly -"; }
                                                        if($data->FacilitiesType->isDaily==1){ $price.=" Daily -"; }
                                                        if($data->FacilitiesType->isWeekly==1){ $price.=" Weekly -"; }
                                                        if($data->FacilitiesType->isMonthly==1){ $price.=" Monthly -"; }
                                                        if($data->FacilitiesType->isYearly==1){ $price.=" Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                        @endphp
                                        </p>
                                    <p><b>Location:</b> {!! $data->location !!}</p>
                                    <p><b>Current Renter:</b></p>
                                    <p><b>Paid Until:</b> @if($data->paidUntil) {{ date("M d, Y", strtotime($data->paidUntil))}}@endif </p>
                                    <p><b>Current Cost:</b>


                                        @php $price="";
                                                        if($data->FacilitiesType->isHourly==1){ $price.=" $".$data->FacilitiesType->HourlyPrice."/Hourly -"; }
                                                        if($data->FacilitiesType->isDaily==1){ $price.=" $".$data->FacilitiesType->DailyPrice."/Daily -"; }
                                                        if($data->FacilitiesType->isWeekly==1){ $price.=" $".$data->FacilitiesType->WeeklyPrice."/Weekly -"; }
                                                        if($data->FacilitiesType->isMonthly==1){ $price.=" $".$data->FacilitiesType->MonthlyPrice."/Monthly -"; }
                                                        if($data->FacilitiesType->isYearly==1){ $price.=" $".$data->FacilitiesType->YearlyPrice."/Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                        @endphp

                                    </p>

                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Rental History</h2>
                                </div>

                                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="min-width: 100px">Renter</th>
                                        <th style="min-width: 100px">From</th>
                                        <th style="min-width: 100px">To</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody1">
                                    @php $x=1; @endphp
                                    @foreach($data->FacilitiesRent as $r)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td class="text-flow">{{$r->RentrsName}}</td>
                                            <td class="text-flow">{{$r->fromDate}}</td>
                                            <td class="text-flow">{{$r->toDate}}</td>
                                            <td>{{$r->amount}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                   <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    </div>-->
                                                </div>
                                            </td>
                                        </tr>
                                        @php $x++; @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Communication History</h2>
                                </div>

                                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="min-width: 100px">Send to</th>
                                        <th style="min-width: 100px">Date</th>
                                        <th style="min-width: 100px">Subject</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody2">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Notes History</h2>
                                </div>
                                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="min-width: 100px">Written By</th>
                                        <th style="min-width: 100px">Date</th>
                                        <th style="min-width: 100px">Subject</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody3">
                                    @php $x=1; @endphp
                                    @foreach($data->FacilitiesRent as $r)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td class="text-flow">{{$r->RentrsName}}</td>
                                            <td class="text-flow">{{$r->updated_at}}</td>
                                            <td class="text-flow">{{$r->noteSubject}}</td>

                                            <td>
                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                  <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    </div>-->
                                                </div>
                                            </td>
                                        </tr>
                                        @php $x++; @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Incident And Fines</h2>
                                </div>

                                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="min-width: 100px">Incedent / Fine</th>
                                        <th style="min-width: 100px">Date</th>
                                        <th style="min-width: 100px">Description</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody4">

                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-10">
                                <div class="group_text">
                                    <h2>Videos of Facilities</h2>
                                </div>

                                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="min-width: 150px">Before Rentring To</th>
                                        <th style="min-width: 100px">Date</th>
                                        <th style="min-width: 100px">File Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody5">
                                    @php $x=1; @endphp
                                    @foreach($data->FacilitiesRent as $r)
                                        <tr>
                                            <td>{{$x}}</td>
                                            <td class="text-flow">{{$r->RentrsName}}</td>
                                            <td class="text-flow">{{$r->created_at}}</td>
                                            <td class="text-flow">{{$r->video}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                   <!--  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    </div>-->
                                                </div>
                                            </td>


                                        </tr>
                                        @php $x++; @endphp
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

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

