@extends('admin.layouts.master')
@section('title', 'Properties Details')
@section('content')



    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                          @if(request()->is('resident/*'))
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                         @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('resident.index')}}">Resident</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Resident Details</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Resident Details</h6>
                    </div>

                    <div class="ms-panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                    <thead>
                                    <th colspan="2">Property Information</th>
                                    </thead>
                                    <tbody>
                                    @if($setting['is_subassociations']=="1")
                                        <tr>
                                            <td>Association</td>
                                            <td>{{$property->association}}</td>
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
                                    </tbody>
                                    <thead>
                                    <th colspan="2">Owner Basic Information</th>
                                    </thead>
                                    <tbody>
                                    @if($data->isCompany==1)
                                        <tr>
                                            <td>Business Legal Name</td>
                                            <td>{{$data->companyLegalName}}</td>
                                        </tr>
                                        <tr>
                                            <td>Business EIN Number</td>
                                            <td>{{$data->einNumber}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$data->firstName}} {{$data->middleName}} {{$data->lastName}}</td>
                                        </tr>
                                        <tr>
                                            <td>Sex</td>
                                            <td>{{$data->sex}}</td>
                                        </tr>
                                        <tr>
                                            <td>Ethnicity</td>
                                            <td>{{$data->ethnicity}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth</td>
                                            <td>{{$data->dateOfBirth}}</td>
                                        </tr>
                                        <tr>
                                            <td>Occupation</td>
                                            <td>{{$data->occupation}}</td>
                                        </tr>
                                        <tr>
                                            <td>Picture</td>
                                            <td><img src="/upload/{{$data->picture}}" style="max-width: 120px;"></td>
                                        </tr>
                                        @if($data->if_us_citizen==1)
                                            <tr>
                                                <td>Social Security Number</td>
                                                <td>{{$data->socialSecurityNumber}}</td>
                                            </tr>
                                            <tr>
                                                <td>Driver License</td>
                                                <td><img src="/upload/{{$data->driverLicense}}" style="max-width: 120px;"></td>
                                            </tr>
                                            <tr>
                                                <td>Green Card/Visa </td>
                                                <td><img src="/upload/{{$data->greenCard}}" style="max-width: 120px;"></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Country of Residence</td>
                                                <td>{{$data->countryofResidence}}</td>
                                            </tr>
                                            <tr>
                                                <td>US Visa</td>
                                                <td><img src="/upload/{{$data->usVisa}}" style="max-width: 120px;"></td>
                                            </tr>
                                            <tr>
                                                <td>Passport</td>
                                                <td><img src="/upload/{{$data->passport}}" style="max-width: 120px;"></td>
                                            </tr>
                                        @endif
                                    @endif
                                    <tr>
                                        <td>Legal Address</td>
                                        <td>{{$data->mailingAddress1}} {{$data->mailingAddress2}},{{$data->city}}, {{$data->state}}, {{$data->country}}, {{$data->zip}}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number</td>
                                        <td>{{$data->phoneNumber}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td>{{$data->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>WhatsApp Number</td>
                                        <td>{{$data->whatsapp}}</td>
                                    </tr>
                                    <tr>
                                        <td>Ownership Start Date</td>
                                        <td>{{$data->ownershipStartDate}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>@if($data->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


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
@endsection

