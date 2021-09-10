@extends('admin.layouts.master')
@section('title', 'Owner’s Info')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('owner/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('owner.index')}}">Owner</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Owner Details</a></li>
                    </ol>
                </nav>

                
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card ms-card-body card-primary properties-card">
                            <h6>Owned/rented For:</h6>
                            <div style="font-size: 16px"> Owned: 3.5 Years <br /> Rented: 2.1 Years</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card ms-card-body card-warning properties-card">
                            <h6>Violations: </h6>
                            <div> {{ $violation_num }} Violation{{ $violation_num > 1 ? "s" : '' }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card ms-card-body card-danger properties-card">
                            <h6>Fines:</h6>
                            <div> {{ $fine_num }} Fine{{ $fine_num > 1 ? "s" : '' }}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card ms-card-body {{ $property->status == 1 ? 'card-success' : 'card-danger' }} properties-card">
                            <h6>Status: </h6>
                            @if ($property->status == 1)
                                <div>Current</div>
                            @else
                                <div>Deliquent</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-5 col-md-5 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>{{$data->firstName}} {{$data->lastName}} IDs</h6>
                            </div>
                            <div class="ms-panel-body">
                                <p>
                                    <img src="/upload/{{$data->picture}}" style="width:80%; max-height:200px; object-fit:contain;">
                                </p>
                                @if ($data->driverLicense)
                                    <img src="/upload/{{$data->driverLicense}}" style="width: 80%;">
                                @elseif($data->greenCard)
                                    <img src="/upload/{{$data->greenCard}}" style="width: 80%;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-md-7 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>{{$data->firstName}} {{$data->lastName}} Info</h6>
                            </div>
                            <div class="ms-panel-body">
                                <p>Name: {{$data->firstName}} {{$data->middleName}} {{$data->lastName}}</p>
                                <p>Sex: {{ $data->sex }}</p>
                                <p>Ethnicity: {{ $data->ethnicity }}</p>
                                <p>Date of birth: {{ date("M d, Y", strtotime($data->dateOfBirth)) }}</p>
                                <p>Occupation: {{ $data->occupation }}</p>
                                <p>Citizenship: {{ $data->country }}</p>
                                <p>USA Resident: {{ $data->if_us_citizen==1 ? "YES" : "No" }}</p>
                                <p>Social Security Number: {{ $data->socialSecurityNumber }}</p>
                                <p>Legal Address: {{$data->mailingAddress1}} {{$data->mailingAddress2}},{{$data->city}}, {{$data->state}}, {{$data->country}}, {{$data->zip}}</p>
                                <p>Phone Number: {{ $data->phoneNumber }}</p>
                                <p>Email Address: {{ $data->email }}</p>
                                <p>Whatsapp: {{ $data->whatsapp }}</p>
                                <p>Ownership Start Date: {{ date('M d Y', strtotime($data->ownershipStartDate)) }}</p>
                                <p>Access Control: {{ $data->board_of_directors_approval }} | {{ $data->property_ownership_proof }}</p>
                                <p>Status: &nbsp; &nbsp; @if($data->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Property Info</h6>
                                <button class="btn btn-primary btn-sm" onclick="goto('/properties/{{ $property->edit_id }}')">Go To</button>
                            </div>
                            <div class="ms-panel-body">
                                @if($setting['is_subassociations']=="1")
                                    <p> {{$property->association}}</p>
                                @endif
                                <p>Type: {{ @$property->Type->type }}</p>
                                @if ($property->Type && $property->type == "Multi Dwelling")
                                    <p>Building: Building {{ @$property->Type->whichBuilding }}</p>
                                    <p>Apartment: {{ $property->aptNumber }}</p>
                                    <p>Floor Number: {{ $property->floorNumber }}</p>
                                @endif
                                <p>Address: {{$property->address1}} {{$property->address2}}  {{$property->city}}, {{$property->state}}, {{$property->pincode}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Owner Info</h6>
                                <button class="btn btn-primary btn-sm" onclick="goto('/member-owner/{{ $data->edit_id }}')">Go To</button>
                            </div>
                            <div class="ms-panel-body">
                                <p>Name: {{$data->firstName}} {{$data->middleName}} {{$data->lastName}}</p>
                                <p>Sex: {{ $data->sex }}</p>
                                <p>Ethnicity: {{ $data->ethnicity }}</p>
                                <p>Date of birth: {{ date("M d, Y", strtotime($data->dateOfBirth)) }}</p>
                                <p>Occupation: {{ $data->occupation }}</p>
                                <p>Citizenship: {{ $data->country }}</p>
                                <p>USA Resident: {{ $data->if_us_citizen==1 ? "YES" : "No" }}</p>
                                <p>Social Security Number: {{ $data->socialSecurityNumber }}</p>
                                <p>Legal Address: {{$data->mailingAddress1}} {{$data->mailingAddress2}},{{$data->city}}, {{$data->state}}, {{$data->country}}, {{$data->zip}}</p>
                                <p>Phone Number: {{ $data->phoneNumber }}</p>
                                <p>Email Address: {{ $data->email }}</p>
                                <p>Whatsapp: {{ $data->whatsapp }}</p>
                                <p>Ownership Start Date: {{ date('M d Y', strtotime($data->ownershipStartDate)) }}</p>
                                <p>Access Control: {{ $data->board_of_directors_approval }} | {{ $data->property_ownership_proof }}</p>
                                <p>Status: &nbsp; &nbsp; @if($data->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Incidents</h6>
                    </div>
                    <div class="ms-panel-body">
                        <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Property</th>
                                    <th>Individual</th>
                                    <th>Incident</th>
                                    <th>Outcome</th>
                                    <th>Police</th>
                                    <th>Fine</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Fines</h6>
                    </div>
                    <div class="ms-panel-body">
                        <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Property</th>
                                    <th>Individual</th>
                                    <th>Incident</th>
                                    <th>Outcome</th>
                                    <th>Police</th>
                                    <th>Fine</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
@endsection

