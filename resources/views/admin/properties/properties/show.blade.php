@extends('admin.layouts.master')
@section('title', 'Property Details')
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
            width: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        ,

    </style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                    class="material-icons">home</i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="{{ route('properties.index') }}">Properties</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Property Details</a></li>
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
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Current Owner(s)</h6>
                                <div class="ms-slider-arrow">
                                    <a href="#" class="owner-prev-item">
                                        <i class="far fa-caret-square-left"></i>
                                    </a>
                                    <a href="#" class="owner-next-item">
                                        <i class="far fa-caret-square-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ms-panel-body ms-owners-slider">
                                @foreach ($property->Owner as $val)
                                    <div class="ms-crypto-overview">
                                        <a href="#" class="ms-profile">
                                            @if ($val->picture)
                                                <img src="/upload/{{ $val->picture }}" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                                            @endif
                                            <div class="ms-card-body">
                                                <h5>{{ $val->firstName }}</h5>
                                                <span>{{ $val->lastName }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header d-flex justify-content-between">
                                <h6>Current Owner(s)</h6>
                                <div class="ms-slider-arrow">
                                    <a href="#" class="resident-prev-item">
                                        <i class="far fa-caret-square-left"></i>
                                    </a>
                                    <a href="#" class="resident-next-item">
                                        <i class="far fa-caret-square-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ms-panel-body ms-residents-slider">
                                @foreach ($property->Resident as $val)
                                    <div class="ms-crypto-overview">
                                        <a href="#" class="ms-profile">
                                            @if ($val->picture)
                                                <img src="/upload/{{ $val->picture }}" class="ms-img-large ms-img-round ms-user-img mx-auto d-block" alt="people">
                                            @endif
                                            <div class="ms-card-body">
                                                <h5>{{ $val->firstName }}</h5>
                                                <span>{{ $val->lastName }}</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>Property Info</h6>
                            </div>
                            <div class="ms-panel-body row">
                                @if ($setting['is_subassociations'] == '1')
                                    <p class="col-md-6">Association:</p>
                                    <p class="col-md-6">{{ $property->sub_association }}</p>
                                @endif

                                <p class="col-md-6">Type:</p>
                                <p class="col-md-6">{{ @$property->Type->type }}</p>
                                @if ($property->Type && $property->type == "Multi Dwelling")
                                    <p class="col-md-6">Building:</p>
                                    <p class="col-md-6">Building {{ @$property->Type->whichBuilding }}</p>

                                    <p class="col-md-6">Apartment:</p>
                                    <p class="col-md-6">{{ @$property->aptNumber }}</p>

                                    <p class="col-md-6">Floor Number:</p>
                                    <p class="col-md-6">{{ @$property->floorNumber }}</p>
                                @endif

                                <p class="col-md-6">Address:</p>
                                <p class="col-md-6">
                                    {{ $property->address1 }} <br/>
                                    {{ $property->address2 }} <br/>
                                    {{ $property->city }}, {{ $property->state }} {{ $property->pincode }}
                                </p>

                                <p class="col-md-6">Payment Bracket: </p>
                                <p class="col-md-6">0.03%</p>

                                <p class="col-md-6">Current Payment Term: </p>
                                <p class="col-md-6">Quarterly</p>
                                
                                <p class="col-md-6">Current Payment Amount: </p>
                                <p class="col-md-6">$1, 798.54</p>
                                
                                <p class="col-md-6">Last Payment Due Date: </p>
                                <p class="col-md-6">{{ now() }}</p>
                                
                                <p class="col-md-6">Next Payment Due Date: </p>
                                <p class="col-md-6">{{ now() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="ms-panel">
                            <div class="ms-panel-header">
                                <h6>Last Transactions</h6>
                            </div>
                            <div class="ms-panel-body p-2">
                                <table class="table thead-primary dataTable">
                                    <thead>
                                        <tr>
                                            <th>DATE</th>
                                            <th>TYPE</th>
                                            <th>DESC</th>
                                            <th>CHARGE</th>
                                            <th>PAYMENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>asdf</td>
                                            <td>asdf</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <!--Owners Table-->
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <div class="group_text">
                            <h2>Owners Table</h2>
                            <p>This will show a table of current and past Owners</p>
                        </div>
                    </div>
                    <div class="ms-panel-body table-responsive">
                        <table
                            class="table-responsive d-block d-md-table data-table table table-striped thead-primary w-100 dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="min-width: 100px">Owner Name</th>
                                    <th style="min-width: 100px">Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th style="min-width: 100px">Company Name</th>
                                    <th style="min-width: 100px">Incorporation</th>
                                    <th style="min-width: 100px">EIN Number</th>
                                    <th style="min-width: 100px">Contact Person</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($property->Owner as $val)
                                    <tr>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            <div>
                                                {{ $val->firstName }}
                                                {{ $val->middleName }} {{ $val->lastName }}</div>
                                        </td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->phoneNumber }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->email }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {!! $val->mailingAddress1 !!}<br>{!! $val->mailingAddress2 !!} </td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->companyLegalName }}
                                        </td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->inCorporation }}
                                        </td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->einNumber }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->contactPerson }}
                                        </td>
                                        <td onclick="goto('/owner/{{ $val->owner_id }}')">
                                            @if ($val->status == 1)<i
                                                class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif
                                        </td>
                                        <td class="action">

                                            <div class="dropdown show">
                                                <a class="cust-btn dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="/owner/{{ $val->owner_id }}">
                                                        OwnerInfo </a>
                                                    <a class="dropdown-item"
                                                        href="/letter-generator?type=Owners&user={{ $val->edit_id }}">
                                                        Send Letter </a>
                                                    <a class="dropdown-item"
                                                        href="/bulk-communication?type=Owners&user={{ $val->edit_id }}">
                                                        Send Email </a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Owners Table-->

                <!--Residents  Table-->
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <div class="group_text">
                            <h2>Residents Table</h2>
                            <p>This will show a table of current and past Residents</p>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <table
                            class="table-responsive data-table table table-striped thead-primary w-100 d-block d-md-table dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="min-width: 100px">Phone Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($property->Resident as $val)
                                    <tr>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->firstName }}
                                            {{ $val->middleName }} {{ $val->lastName }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->phoneNumber }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->email }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {!! $val->mailingAddress1 !!}<br>{!! $val->mailingAddress2 !!} </td>
                                        <td onclick="goto('/owner/{{ $val->owner_id }}')">
                                            @if ($val->status == 1)<i
                                                class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif
                                        </td>

                                        <td class="action">

                                            <div class="dropdown show">
                                                <a class="cust-btn dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner
                                                        Info </a>
                                                    <a class="dropdown-item"
                                                        href="/letter-generator?type=Residents&user={{ $val->edit_id }}">
                                                        Send Letter </a>
                                                    <a class="dropdown-item"
                                                        href="/bulk-communication?type=Residents&user={{ $val->edit_id }}">
                                                        Send Email </a>

                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Residents  Table-->

                <!--Guest Table-->
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <div class="group_text">
                            <h2>Guest Table</h2>
                            <p>This will show a table of current and past Guest</p>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <table
                            class="table-responsive d-block d-md-table data-table table table-striped thead-primary w-100 dataTable no-footer">
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
                                @foreach ($property->Guest as $val)
                                    <tr>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->property_id }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->rfname }}
                                            {{ $val->rlname }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->firstName }}
                                            {{ $val->middleName }} {{ $val->lastName }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->phoneNumber }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->email }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ date('d M', strtotime($val->startingDate)) }} -
                                            {{ date('d M Y', strtotime($val->endDate)) }} </td>
                                        <td onclick="goto('/owner/{{ $val->owner_id }}')">
                                            @if ($val->status == 1)<i
                                                class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif
                                        </td>
                                        <td class="action">

                                            <div class="dropdown show">
                                                <a class="cust-btn dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner
                                                        Info
                                                    </a>

                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Guest Table-->

                <!--Pets  Table-->
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <div class="group_text">
                            <h2>Pets Table</h2>
                            <p>This will show a table of current and past pets</p>
                        </div>
                    </div>
                    <div class="ms-panel-body table-responsive">
                        <table
                            class="table-responsive d-block d-md-table data-table table table-striped thead-primary w-100 dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th style="min-width: 100px">Pet Name</th>
                                    <th style="min-width: 100px">Pet Type</th>
                                    <th>Owner</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($property->Pet as $val)
                                    <tr>
                                        <td><img src="/thumb/{{ $val->image }}"
                                                style="border-radius:0;height:50px;width:auto;max-width:100px"></td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->petName }}</td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            {{ $val->PetType->petType }}
                                        </td>
                                        <td class="text-flow" onclick="goto('/owner/{{ $val->owner_id }}')">
                                            @if (isset($val->Owner))
                                                {{ $val->Owner->firstName }} {{ $val->Owner->lastName }}
                                            @endif
                                        </td>
                                        <td onclick="goto('/owner/{{ $val->owner_id }}')">
                                            @if ($val->status == 1)<i
                                                class="fas fa-dot-circle dot-green"></i>@elseif($val->status==0) <i
                                                class="fas fa-dot-circle dot-yellow"></i>@else <i
                                                    class="fas fa-dot-circle dot-red"></i>@endif
                                        </td>
                                        <td class="action">

                                            <div class="dropdown show">
                                                <a class="cust-btn dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="/owner/{{ $val->owner_id }}"> Owner
                                                        Info
                                                    </a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Pets  Table-->
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
    <script>
        function goto(url) {
            window.location.href = url;
        }
        $(document).ready(function() {
            const options = {
                dots: false,
                arrows: false,
                infinite: false,
                slidesToShow: 4,
                arrows: true,
                responsive: [{
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 420,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            };
            $('.ms-owners-slider').slick({
                ...options,
                prevArrow: $('.owner-prev-item'),
                nextArrow: $('.owner-next-item'),
            });
            $('.ms-residents-slider').slick({
                ...options,
                prevArrow: $('.resident-prev-item'),
                nextArrow: $('.resident-next-item'),
            });
        })
    </script>
@endsection
