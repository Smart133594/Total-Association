@extends('admin.layouts.master')
@section('title', 'Properties')
@section('content')
    <style>
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('properties.index')}}">Properties</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Properties List</h6>


                    </div>
                    <div class="ms-panel-body">
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-md-3" style="margin: 1%">
                                <form action="" method="get">
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Current</option>
                                        <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Delinquent</option>
                                        <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>Both</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-3" style="margin: 1%">

                                <form action="" method="get">
                                    <select name="association" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--choose association--</option>
                                        @foreach($filter['association'] as $f)
                                            <option value="{{$f->id}}" @if(isset($_GET['association']) && !empty($_GET['association'])  && $_GET['association']==$f->id) selected @endif>{{$f->name}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-3" style="margin: 1%">
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
                            <div class="col-md-3"></div>
                        </div>
                        @include('admin.includes.msg')
                        <div class="table-responsive">
                            <table class="table table-striped thead-primary w-100" id="data-table">
                                <thead>
                                    <tr role="row">
                                        <th style="max-width: 20px !important; width: 20px !important;">S.No.</th>
                                        @if($setting['is_subassociations']=="1")
                                            <th style="width: 80px !important;">Association</th>
                                        @endif
                                        <th style="max-width: 120px !important; width: 60px !important;">Building</th>
                                        <th style="max-width: 50px !important; width: 50px !important;">Apartment</th>
                                        <th style="max-width: 120px !important; width: 120px !important;">Owner</th>
                                        <th style="max-width: 80px !important; width: 80px !important;">Owner Tel</th>
                                        <th style="max-width: 120px !important; width: 80px !important;">Resident</th>
                                        <th style="max-width: 80px !important; width: 80px !important;">Resident Tel</th>
                                        <th class="no-sort" style="max-width: 20px !important; width: 20px !important;">Status</th>
                                        <th class="no-sort" style="max-width: 30px !important; width: 30px !important;">Occupied</th>
                                        <th class="no-sort" style="max-width: 20px !important; width: 20px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" onclick="goto('/showproperties/{{ $val->edit_id }}')">{{$key+1}}</td>
                                            @if($setting['is_subassociations']=="1")
                                                <td onclick="goto('/showproperties/{{ $val->edit_id }}')">{{$val->Subassociation->name}}</td>
                                            @endif
                                            <td class="text-flow" onclick="window.localStorage.urlClass='properties'; goto('/properties/{{ $val->edit_id }}')"> @if($val->buildingId>0){{$val->Building->building}}@endif </td>
                                            <td class="text-flow" onclick="goto('/showproperties/{{ $val->edit_id }}')">{{$val->aptNumber}}</td>
                                            <td class="text-flow" onclick="window.localStorage.urlClass='properties'; goto('/properties/{{ $val->edit_id }}')">
                                                @if(isset($val->Owner) && count($val->Owner) > 0)
                                                    @foreach ($val->Owner as $index=>$item)
                                                        @if($index != 0) 
                                                        /
                                                        @endif
                                                        @if ($item->isCompany == 1)
                                                            {{ $item->companyLegalName }}
                                                        @else
                                                        {{ $item->firstName . ' ' . $item->lastName}}
                                                        @endif
                                                    @endforeach
                                                @else N/A @endif
                                            </td>
                                            <td class="text-flow" onclick="window.localStorage.urlClass='properties'; goto('/properties/{{ $val->edit_id }}')">
                                                @if(isset($val->Owner) && count($val->Owner) > 0)
                                                    @foreach ($val->Owner as $index=>$item)
                                                        @if($index != 0) 
                                                        /
                                                        @endif
                                                        {{ $item->phoneNumber}}
                                                    @endforeach
                                                @else N/A @endif
                                            </td>
                                            <td class="text-flow" onclick="window.localStorage.urlClass='properties'; goto('/properties/{{ $val->edit_id }}')">
                                                @if(isset($val->Resident) && count($val->Resident) > 0)
                                                    @foreach ($val->Resident as $index=>$item)
                                                        @if($index != 0) 
                                                        /
                                                        @endif
                                                        {{ $item->firstName . ' ' . $item->lastName}}
                                                    @endforeach
                                                @else N/A @endif
                                            </td>
                                            <td class="text-flow" onclick="window.localStorage.urlClass='properties'; goto('/properties/{{ $val->edit_id }}')">
                                                @if(isset($val->Resident) && count($val->Resident) > 0)
                                                    @foreach ($val->Resident as $index=>$item)
                                                        @if($index != 0) 
                                                        /
                                                        @endif
                                                        {{ $item->phoneNumber}}
                                                    @endforeach
                                                @else N/A @endif
                                            </td>
                                            <td onclick="goto('/showproperties/{{ $val->edit_id }}')"> @if($val->status=="1")<span style="color: #13ce18">Current</span> @else <span style="color: #ff0000">Deliquent</span></i>@endif</td>
                                            <td onclick="goto('/showproperties/{{ $val->edit_id }}')">
                                                @if(isset($val->Resident) && count($val->Resident) > 0)
                                                    <i class="fas fa-dot-circle dot-green"></i>
                                                @else <i class="fas fa-dot-circle dot-red"></i> @endif
                                            </td>
                                            <td class="action">
                                                {{--<a href="/properties/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>--}}
                                                {{--<form action="{{ route('properties.destroy',$val->id) }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="trans-btn" onclick=" return confirm('Are you sure to delete this Properties !!')"><i class="far fa-trash-alt ms-text-danger"></i></button>
                                                </form>--}}
                                                {{--<a href="#"><i class=""></i></a>--}}
                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="/showproperties/{{ $val->edit_id }}">See Info</a>
                                                        <a class="dropdown-item" href="/incident?filter=property&id={{ $val->edit_id }}">Incidents</a>
                                                        <a class="dropdown-item" href="#" onclick="window.localStorage.urlClass='properties'; window.location.href='/fine-incident/{{ $val->edit_id }}'">Fines</a>
                                                        {{-- <a class="dropdown-item" href="/fines?filter=property&id={{ $val->edit_id }}">Issue Fine</a> --}}
                                                        <a class="dropdown-item" href="#">Record Payment </a>
                                                        <a class="dropdown-item" href="#">Elevator Pass </a>
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
        function goto(url){
            window.location.href=url;
        }
    </script>
@endsection

