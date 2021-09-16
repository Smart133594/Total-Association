@extends('admin.layouts.master')
@section('title', 'Resident Info')
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
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-sm-6">
                        <div class="ms-card card-gradient-success ms-widget ms-infographics-widget">
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
                        <div class="ms-card {{ $fine_num < 3 ? 'card-gradient-success' : 'card-gradient-danger' }} ms-widget ms-infographics-widget">
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
                                <h6>{{$data->firstName}} {{$data->lastName}} IDs</h6>
                            </div>
                            <div class="ms-panel-body" style="min-height: 605px;">
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
                            <div class="ms-panel-body" style="min-height: 605px;">
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
                            <div class="ms-panel-body" style="min-height: 605px;">
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
                            <div class="ms-panel-body" style="min-height: 605px;">
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
        function goto(url) {
            window.location.href = url;
        }
    </script>
@endsection

