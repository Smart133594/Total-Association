@extends('admin.layouts.master')
@section('title', 'Facilities')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('facilities'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Facilities List</h6>

                        @if(request()->is('facilities'))
                            <a href="{{route('facilities.create')}}" class="ms-text-primary">Add Facilities</a>
                            @php $path="facilities"; @endphp
                        @else
                            @php $path="facilities-rental"; @endphp
                        @endif

                    </div>
                    <div class="ms-panel-body">
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-md-3">
                                <form action="" method="get">
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Active</option>
                                        <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Suspended</option>
                                        <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>Both</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-3">

                                <form action="" method="get">
                                    <select name="type" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--Facilities Type--</option>
                                        @foreach($facilities_type as $f)
                                            <option value="{{$f->id}}" @if(isset($_GET['type']) && $_GET['type']==$f->id) selected @endif>{{$f->typeName}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>


                        </div>


                        @include('admin.includes.msg')
                        <div class="table-responsive" style="min-height: 300px">
                            <table id="data-table" class="table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th>Facility</th>
                                    <th>Type</th>
                                    <th>Vacancy</th>
                                    <th>Due Date</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" onclick="goto('/owner/{{ $val->edit_id }}')">{{$key+1}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')"> {{$val->Facility}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">{{$val->typeName}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">@if($val->vacency==0 && $val->isYearly!=1)<i class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">{{ $val->toDate }}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                @if(request()->is('facilities'))
                                                    <a href="/facilities/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
                                                @endif
                                                {{--<form action="{{ route('master-association.destroy',$val->id) }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="trans-btn" onclick=" return confirm('Are you sure to delete this Master Association !!')"><i class="far fa-trash-alt ms-text-danger"></i></button>
                                                </form>--}}
                                                {{--<a href="#"><i class=""></i></a>--}}
                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @if(request()->is('facilities'))
                                                            <a class="dropdown-item" href="#" onclick="goto('/{{$path}}/{{ $val->edit_id }}')">Info</a>
                                                            <a class="dropdown-item" href="/facilities-event/{{ $val->edit_id }}">Rental Events List</a>
                                                            @if($val->vacency==1)
                                                                <a class="dropdown-item" href="/record-note/{{ $val->current_occupaier_rent_id }}">Record a Note</a>
                                                                <a class="dropdown-item" href="/payment-info/{{ $val->current_occupaier_rent_id }}">payment Info</a>
                                                                @if($val->contractRequired==1)
                                                                    <a class="dropdown-item" href="/contract/{{ $val->current_occupaier_rent_id }}">Contract</a>
                                                                @endif
                                                            @endif
                                                            @if($val->isResident==1)
                                                                <a class="dropdown-item" href="/bulk-communication?user={{ $val->current_occupaier }}&type={{$val->whome_type}}">Email Current
                                                                    Occupier</a>
                                                                <a class="dropdown-item" href="/letter-generator?user={{ $val->current_occupaier }}&type={{$val->whome_type}}">Send Letter to Current
                                                                    Occupier</a>
                                                            @else
                                                                <a class="dropdown-item" href="/bulk-communication">Email Current Occupier</a>
                                                                <a class="dropdown-item" href="/letter-generator">Send Letter to Current Occupier</a>
                                                            @endif
                                                            @if($val->status==1)
                                                                <a class="dropdown-item" href="/facilities-suspend/{{ $val->edit_id }}">Suspend Facility </a>
                                                                {{--                                                                <a class="dropdown-item" href="/rent-facilities/{{ $val->edit_id }}">Rent the Facility </a>--}}
                                                            @else
                                                                <a class="dropdown-item" href="/facilities-suspend/{{ $val->edit_id }}">Activate Facility </a>
                                                            @endif


                                                        @else
                                                            <a class="dropdown-item" href="#" onclick="goto('/{{$path}}/{{ $val->edit_id }}')">Info</a>
                                                            <a class="dropdown-item" href="/facilities-rental-event/{{ $val->edit_id }}">Rental Events List</a>
                                                            @if($val->vacency==1)
                                                                <a class="dropdown-item" href="/record-a-note/{{ $val->current_occupaier_rent_id }}">Record a Note</a>
                                                                <a class="dropdown-item" href="/paymentinfo/{{ $val->current_occupaier_rent_id }}">payment Info</a>
                                                                @if($val->contractRequired==1)
                                                                    <a class="dropdown-item" href="/upload-contract/{{ $val->current_occupaier_rent_id }}">Contract</a>
                                                                @endif
                                                            @endif
                                                            @if($val->isResident==1)
                                                                <a class="dropdown-item" href="/bulk-communication?user={{ $val->current_occupaier }}&type={{$val->whome_type}}">Email Current
                                                                    Occupier</a>
                                                                <a class="dropdown-item" href="/letter-generator?user={{ $val->current_occupaier }}&type={{$val->whome_type}}">Send Letter to Current
                                                                    Occupier</a>
                                                            @else
                                                                <a class="dropdown-item" href="/bulk-communication">Email Current Occupier</a>
                                                                <a class="dropdown-item" href="/letter-generator">Send Letter to Current Occupier</a>
                                                            @endif
                                                            @if($val->status==1)
                                                                <a class="dropdown-item" href="/facilities-status/{{ $val->edit_id }}">Suspend Facility </a>
                                                                {{--                                                                <a class="dropdown-item" href="/rent-the-facilities/{{ $val->edit_id }}">Rent the Facility </a>--}}
                                                            @else
                                                                <a class="dropdown-item" href="/facilities-status/{{ $val->edit_id }}">Activate Facility </a>
                                                            @endif

                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable({
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
    </script>
@endsection

