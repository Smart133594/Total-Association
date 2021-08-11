@extends('admin.layouts.master')
@section('title', 'Building')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('buildings.index')}}">Building</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('buildings.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Building</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('buildings.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">


                                @if($setting['is_subassociations']=="1")
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId">
                                                <option value="">--Choose--</option>
                                                @foreach($subasso as $s)
                                                    <option value="{{$s->id}}" @if($data ?? '') @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Building Name</label>
                                        <input type="text" class="form-control" id="building" name="building" value="@if($data ?? ''){{$data->building}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Address 1</label>
                                        <input type="text" class="form-control" id="address1" name="address1" value="@if($data ?? ''){{$data->address1}}@endif" required>
                                    </div>
                                </div>
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="exampleEmail">Address 2</label>--}}
{{--                                        <input type="text" class="form-control" id="address2" name="address2" value="@if($data ?? ''){{$data->address2}}@endif">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Numbers of Floors</label>
                                        <input type="text" class="form-control" id="noOfFloors" name="noOfFloors" value="@if($data ?? ''){{$data->noOfFloors}}@endif"
                                               onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group" style="padding-top: 35px">
                                        <label>13th Floor</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="is13" name="is13" value="1" @if($data ?? '') @if($data->is13=='1')checked @endif @endif > Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="is13" name="is13" value="0" @if(!isset($data)) checked @endif @if($data ?? '') @if($data->is13=='0')checked @endif @endif > No &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary d-block" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable();
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
    @include('admin.includes.validate')
@endsection

