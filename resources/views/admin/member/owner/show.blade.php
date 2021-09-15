@extends('admin.layouts.master')
@section('title', 'Owner’s Info')
@section('content')
    <style>
        .tooltip {
            /* hide and position tooltip */
            width: 250px;
            right: 20px;
            top: -150px;
            background-color: white;
            border-radius: 5px;
            opacity: 0;
            position: absolute;
            padding: 10px;
            -webkit-transition: opacity 0.5s;
            -moz-transition: opacity 0.5s;
            -ms-transition: opacity 0.5s;
            -o-transition: opacity 0.5s;
            transition: opacity 0.5s;
        }

        .hover:hover .tooltip {
            opacity: 1;
        },

    </style>

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i>
                                Home</a></li>
                        @if (request()->is('owner/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('owner.index') }}">Owner</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Owner Details</a></li>
                    </ol>
                </nav>


                <div class="row">
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card card-gradient-primary ms-widget ms-infographics-widget">
                            <div class="ms-card-body media">
                               <div class="media-body">
                                  <h6>Owned/rented For:</h6>
                                  <p style="font-size: 15px"> Owned: 3.5 Years <br /> Rented: 2.1 Years</p>
                               </div>
                            </div>
                            <i class="flaticon-statistics"></i>
                         </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card card-gradient-warning ms-widget ms-infographics-widget">
                            <div class="ms-card-body media">
                               <div class="media-body">
                                   <h6>Violations: </h6>
                                   <p> {{ $violation_num }} Violation{{ $violation_num > 1 ? "s" : '' }}</p>
                                   <p>&nbsp;</p>
                               </div>
                            </div>
                            <i class="flaticon-alert"></i>
                         </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card card-gradient-danger ms-widget ms-infographics-widget">
                            <div class="ms-card-body media">
                               <div class="media-body">
                                    <h6>Fines:</h6>
                                    <div> {{ $fine_num }} Fine{{ $fine_num > 1 ? "s" : '' }}</div>
                                    <p>&nbsp;</p>
                               </div>
                            </div>
                            <i class="flaticon-share-1"></i>
                         </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card {{ $property->status == 1 ? 'card-gradient-success' : 'card-gradient-danger' }} ms-widget ms-infographics-widget">
                            <div class="ms-card-body media">
                               <div class="media-body">
                                    <h6>Status: </h6>
                                    @if ($property->status == 1)
                                        <div>Current</div>
                                    @else
                                        <div>Deliquent</div>
                                    @endif
                                    <p>&nbsp;</p>
                               </div>
                            </div>
                            <i class="flaticon-dashboard"></i>
                         </div>
                    </div>

                    <div class="col-xl-5 col-md-5 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>{{ $data->firstName }} {{ $data->lastName }} IDs</h6>
                            </div>
                            <div class="ms-panel-body" style="min-height: 605px;">
                                <p>
                                    <img src="/upload/{{ $data->picture }}"
                                        style="width:80%; max-height:200px; object-fit:contain;">
                                </p>
                                @if ($data->driverLicense)
                                    <img src="/upload/{{ $data->driverLicense }}" style="width: 80%; object-fit:contain;">
                                @elseif($data->greenCard)
                                    <img src="/upload/{{ $data->greenCard }}" style="width: 80%; object-fit:contain;">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-md-7 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>{{ $data->firstName }} {{ $data->lastName }} Info</h6>
                            </div>
                            <div class="ms-panel-body" style="min-height: 605px;">
                                <p>Name: {{ $data->firstName }} {{ $data->middleName }} {{ $data->lastName }}</p>
                                <p>Sex: {{ $data->sex }}</p>
                                <p>Ethnicity: {{ $data->ethnicity }}</p>
                                <p>Date of birth: {{ date('M d, Y', strtotime($data->dateOfBirth)) }}</p>
                                <p>Occupation: {{ $data->occupation }}</p>
                                <p>Citizenship: {{ $data->country }}</p>
                                <p>USA Resident: {{ $data->if_us_citizen == 1 ? 'YES' : 'No' }}</p>
                                <p>Social Security Number: {{ $data->socialSecurityNumber }}</p>
                                <p>Legal Address: {{ $data->mailingAddress1 }}
                                    {{ $data->mailingAddress2 }},{{ $data->city }}, {{ $data->state }},
                                    {{ $data->country }}, {{ $data->zip }}</p>
                                <p>Phone Number: {{ $data->phoneNumber }}</p>
                                <p>Email Address: {{ $data->email }}</p>
                                <p>Whatsapp: {{ $data->whatsapp }}</p>
                                <p>Ownership Start Date: {{ date('M d Y', strtotime($data->ownershipStartDate)) }}</p>
                                {{-- <p>Access Control: {{ $data->board_of_directors_approval }} |
                                    {{ $data->property_ownership_proof }}</p> --}}
                                <p>Status: &nbsp; &nbsp; @if ($data->status == 1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Property Info</h6>
                                <button class="btn btn-primary btn-sm"
                                    onclick="window.localStorage.urlClass='owner'; window.location.href='/properties/{{ $property->edit_id }}'">Go To</button>
                            </div>
                            <div class="ms-panel-body">
                                @if ($setting['is_subassociations'] == '1')
                                    <p> {{ $property->association }}</p>
                                @endif
                                <p>Type: {{ @$property->Type->type }}</p>
                                @if ($property->Type && $property->type == 'Multi Dwelling')
                                    <p>Building: {{$property->Building->building}}</p>
                                    {{-- {{<p>Building: Building {{ @$property->Type->whichBuilding }}</p>}} --}}
                                    <p>Apartment: {{ $property->aptNumber }}</p>
                                    <p>Floor Number: {{ $property->floorNumber }}</p>
                                @endif
                                <p>Address: {{ $property->address1 }} {{ $property->address2 }} {{ $property->city }},
                                    {{ $property->state }}, {{ $property->pincode }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12" style="display: none;">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Owner Info</h6>
                                <button class="btn btn-primary btn-sm"
                                    onclick="window.localStorage.urlClass='owner'; window.location.href='/member-owner/{{ Crypt::encryptString($data->id) }}'">Go To</button>
                            </div>
                            <div class="ms-panel-body" style="min-height: 605px;">
                                <p>Name: {{ $data->firstName }} {{ $data->middleName }} {{ $data->lastName }}</p>
                                <p>Sex: {{ $data->sex }}</p>
                                <p>Ethnicity: {{ $data->ethnicity }}</p>
                                <p>Date of birth: {{ date('M d, Y', strtotime($data->dateOfBirth)) }}</p>
                                <p>Occupation: {{ $data->occupation }}</p>
                                <p>Citizenship: {{ $data->country }}</p>
                                <p>USA Resident: {{ $data->if_us_citizen == 1 ? 'YES' : 'No' }}</p>
                                <p>Social Security Number: {{ $data->socialSecurityNumber }}</p>
                                <p>Legal Address: {{ $data->mailingAddress1 }}
                                    {{ $data->mailingAddress2 }},{{ $data->city }}, {{ $data->state }},
                                    {{ $data->country }}, {{ $data->zip }}</p>
                                <p>Phone Number: {{ $data->phoneNumber }}</p>
                                <p>Email Address: {{ $data->email }}</p>
                                <p>Whatsapp: {{ $data->whatsapp }}</p>
                                <p>Ownership Start Date: {{ date('M d Y', strtotime($data->ownershipStartDate)) }}</p>
                                <p>Access Control: {{ $data->board_of_directors_approval }} |
                                    {{ $data->property_ownership_proof }}</p>
                                <p>Status: &nbsp; &nbsp; @if ($data->status == 1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Incidents</h6>
                    </div>
                    <div class="ms-panel-body">
                        <table id="data-table"
                            class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
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
                            <tbody>
                                @foreach ($property->Incident as $index => $item)
                                    @if ($item->outcome != 'Fine')
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $item->dateTime }}</td>
                                            <td>{{ $property->Type->type }}</td>
                                            <td>{{ $item->ind }}</td>
                                            <td>{{ $item->incidentTitle }}</td>
                                            <td>{{ $item->outcome }}</td>
                                            <td>
                                                @if ($item->policeInvolved == 1)
                                                    <i class="fas fa-dot-circle dot-green"></i>
                                                @else
                                                    <i class="fas fa-dot-circle dot-red"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fas fa-dot-circle dot-green"></i>
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Fines</h6>

                        <div class="hover"><i class="material-icons" style="font-size: 35px">help_outline</i>
                            <div class="tooltip">
                                <p style="font-size: 17px"><i class="fas fa-dot-circle dot-black"></i> &nbsp; Waiting for dispute </p>
                                <p style="font-size: 17px"><i class="fas fa-dot-circle dot-primary"></i> &nbsp; Not Disputed On time </p>
                                <p style="font-size: 17px"><i class="fas fa-dot-circle dot-yellow"></i> &nbsp; Disputed on time </p>
                                <p style="font-size: 17px"><i class="fas fa-dot-circle dot-red"></i> &nbsp; Rejected by Committee </p>
                                <p style="font-size: 17px"><i class="fas fa-dot-circle dot-green"></i> &nbsp; Approved by Committee </p>
                            </div>
                        </div>
                    </div>

                    <div class="ms-panel-body">
                        <table id="data-table"
                            class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Property</th>
                                    <th>Individual</th>
                                    <th>Incident</th>
                                    <th>Amount</th>
                                    <th>Com</th>
                                    <th>Paid</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($property->Incident as $index => $item)
                                    @if ($item->outcome == 'Fine')
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $item->dateTime }}</td>
                                            <td>{{ $property->Type->type }}</td>
                                            <td>{{ $item->ind }}</td>
                                            <td>{{ $item->incidentTitle }}</td>
                                            <td>{{ $item->fine_amount }}</td>
                                            <td>
                                                @if ($item->fine_status == 2)
                                                    @if ($item->dispute_form)
                                                        <i class="fas fa-dot-circle dot-black"></i>
                                                    @else
                                                        <i class="fas fa-dot-circle dot-primary"></i>
                                                    @endif
                                                @elseif($item->fine_status == 3)
                                                    @if ($item->committee_decision)
                                                        <i class="fas fa-dot-circle dot-green"></i>
                                                    @else
                                                        <i class="fas fa-dot-circle dot-red"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-dot-circle dot-primary"></i>
                                                @endif
                                                {{-- <i class="fas fa-dot-circle dot-yellow"></i> --}}
                                            </td>
                                            <td>
                                                @if ($item->fine_status == 0)
                                                    Not paied
                                                @elseif($item->fine_status == 1)
                                                    Paied
                                                @elseif($item->fine_status == 2)
                                                    Dispute
                                                @elseif($item->fine_status == 3)
                                                    committee deside
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
