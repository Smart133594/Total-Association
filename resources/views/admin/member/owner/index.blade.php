@extends('admin.layouts.master')
@section('title', 'Owner')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('owner'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('owner.index')}}">Owner</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Owner List</h6>

                        @if(request()->is('owner'))
                            <a href="{{route('owner.create')}}" class="ms-text-primary">Add Owner</a>
                            @php $path="owner"; @endphp
                        @else
                            @php $path="member-owner"; @endphp
                        @endif

                    </div>
                    <div class="ms-panel-body">
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-md-3">
                                <form action="" method="get">
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Current</option>
                                        <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Delinquent</option>
                                        <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>Both</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-3">

                                <form action="" method="get">
                                    <select name="association" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--choose association--</option>
                                        @foreach($filter['association'] as $f)
                                            <option value="{{$f->id}}"
                                                    @if(isset($_GET['association']) && !empty($_GET['association'])  && $_GET['association']==$f->id) selected @endif>{{$f->name}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="" method="get">
                                    <select name="building" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--choose building--</option>
                                        @foreach($filter['building'] as $f)
                                            <option value="{{$f->id}}" @if(isset($_GET['building']) && !empty($_GET['building'])  && $_GET['building']==$f->id)selected @endif>{{$f->building}}</option>
                                        @endforeach
                                    </select>
                                    @if (isset($_GET['association']) && !empty($_GET['association']))
                                        <input type="hidden" name="association" value="{{ $_GET['association'] }}">
                                    @endif
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="" method="get">
                                    <select name="property" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--choose property--</option>
                                        @foreach($filter['property'] as $f)
                                            <option value="{{$f->id}}" @if(isset($_GET['property']) && !empty($_GET['property'])  && $_GET['property']==$f->id)selected @endif>
                                                {{$f->building}} {{$allassociation[$f->associationId]}} - @if($f->type=="Multi Dwelling") {{$f->aptNumber}} @else {{$f->address1}} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (isset($_GET['association']) && !empty($_GET['association']))
                                        <input type="hidden" name="association" value="{{ $_GET['association'] }}">
                                    @endif
                                    @if (isset($_GET['building']) && !empty($_GET['building']))
                                        <input type="hidden" name="building" value="{{ $_GET['building'] }}">
                                    @endif
                                </form>
                            </div>
                        </div>


                        @include('admin.includes.msg')
                        <div class="table-responsive">
                            <table id="data-table" class="table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th>Property</th>
                                    <th>Owner Name</th>
                                    <th>Phone Number</th>
                                    <th>Company Name</th>
                                    <th>Incorporation</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" onclick="goto('/owner/{{ $val->edit_id }}')">{{$key+1}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">   {{ $property[$val->property_id]->building}} {{$allassociation[$val->associationId]}}
                                                - @if($property[$val->property_id]->type=="Multi Dwelling")  {{ $property[$val->property_id]->aptNumber}} @else {{ $property[$val->property_id]->address1}}  @endif</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">@if(!empty($val->firstName)){{$val->firstName}} {{$val->middleName}} {{$val->lastName}} @else {{$val->companyLegalName}} {{$val->contactPerson}} @endif</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">{{$val->phoneNumber}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">{{$val->companyLegalName}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">{{$val->inCorporation}}</td>
                                            <td onclick="goto('/{{$path}}/{{ $val->edit_id }}')">@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                @if(request()->is('owner'))
                                                    <a href="/owner/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
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
                                                        <a class="dropdown-item" href="/{{$path}}/{{ $val->edit_id }}/">See Info</a>
                                                        <a class="dropdown-item" href="/bulk-communication">Send Email</a>
                                                        <a class="dropdown-item" href="/letter-generator">Send Letter</a>


                                                        <a class="dropdown-item" href="/incident?filter=owner&id={{ $val->edit_id }}">Incidents</a>
                                                        <a class="dropdown-item" href="/fines?filter=owner&id={{ $val->edit_id }}">Issue Fine</a>
                                                        <a class="dropdown-item" href="#">Create Appointment</a>
                                                        <a class="dropdown-item" href="#">Access Control</a>

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

