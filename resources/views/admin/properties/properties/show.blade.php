@extends('admin.layouts.master')
@section('title', 'Properties Details')
@section('content')



    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('properties.index')}}">Properties</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Properties Details</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Properties Details</h6>
                    </div>

                    <div class="ms-panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                    <tbody>
                                    @if($setting['is_subassociations']=="1")
                                        <tr>
                                            <td>Association</td>
                                            <td>{{$property->sub_association}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Dwelling</td>
                                        <td>{{$property->type}}</td>
                                    </tr>
                                    @if($property->type=="Multi Dwelling")
                                        <tr>
                                            <td>Building</td>
                                            <td>{{$property->building}}</td>
                                        </tr>
                                        <tr>
                                            <td>Apartment Number</td>
                                            <td>{{$property->aptNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td>Floor Number</td>
                                            <td>{{$property->floorNumber}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Address</td>
                                        <td>{{$property->address1}}<br> {{$property->address2}}<br> {{$property->city}}, {{$property->state}}, {{$property->pincode}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>@if($property->status==1)<span style="color: #13ce18">Current</span> @else <span style="color: #ff0000">Deliquent</span></i>@endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!--Owners Table-->
                            <div class="col-md-12 pt-3">
                                <div class="group_text">
                                    <h2>Owners Table</h2>
                                    <p>This will show a table of current and past Owners</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class=" data-table table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Owner Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Company Name</th>
                                        <th>Incorporation</th>
                                        <th>EIN Number</th>
                                        <th>Contact Person</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($owners as $val)
                                        <tr>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->firstName}} {{$val->middleName}} {{$val->lastName}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->phoneNumber}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->email}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{!! $val->mailingAddress1 !!}<br>{!! $val->mailingAddress2 !!} </td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->companyLegalName}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->inCorporation}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->einNumber}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->contactPerson}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">

                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner Info </a>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--Owners Table-->

                            <!--Residents  Table-->
                            <div class="col-md-12 pt-3">
                                <div class="group_text">
                                    <h2>Residents Table</h2>
                                    <p>This will show a table of current and past Residents</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class=" data-table table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th class="no-sort">Status</th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($residents as $val)
                                        <tr>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->firstName}} {{$val->middleName}} {{$val->lastName}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->phoneNumber}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->email}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{!! $val->mailingAddress1 !!}<br>{!! $val->mailingAddress2 !!} </td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>

                                            <td class="action">

                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner Info </a>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--Owners Table-->
                            <!--Guest   Table-->
                            <div class="col-md-12 pt-3">
                                <div class="group_text">
                                    <h2>Guest Table</h2>
                                    <p>This will show a table of current and past Guest</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class=" data-table table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Resident</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Duration</th>
                                        <th class="no-sort">Status</th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($guest as $val)
                                        <tr>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->property_id}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->rfname}} {{$val->rlname}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->firstName}} {{$val->middleName}} {{$val->lastName}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->phoneNumber}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->email}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{ date("d M", strtotime($val->startingDate))}} - {{ date("d M Y", strtotime($val->endDate))}} </td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">

                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner Info </a>

                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--Guest  Table-->
                            <!--Pets  Table-->
                            <div class="col-md-12 pt-3">
                                <div class="group_text">
                                    <h2>Pets Table</h2>
                                    <p>This will show a table of current and past pets</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class=" data-table table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Pet Name</th>
                                        <th>Pet Type</th>
                                        <th>Owner</th>
                                        <th class="no-sort">Status</th>
                                        <th class="no-sort">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pet as $val)
                                        <tr>
                                            <td><img src="/thumb/{{$val->image}}" style="border-radius:0;height:50px;width:auto;max-width:100px"></td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$val->petName}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">{{$pettype[$val->pettypeId]}}</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">@if(isset($owner[$val->ownerId])){{$owner[$val->ownerId]}}@endif</td>
                                            <td onclick="goto('/owner/{{ $val->owner_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@elseif($val->status==0) <i class="fas fa-dot-circle dot-yellow"></i>@else <i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">

                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner Info </a>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--Guest  Table-->




                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.data-table').DataTable({
                targets: 'no-sort',
                orderable: false
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
    </style>
    <script>
        function goto(url){
            window.location.href=url;
        }
    </script>
@endsection

