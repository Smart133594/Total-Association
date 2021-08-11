@extends('admin.layouts.master')
@section('title', 'Pet Type')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Pets</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('pettype.index')}}">Pet Type</a></li>

                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('pettype.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Pet Type</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('pettype.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label for="exampleEmail">Pet Type</label>
                                        <input type="text" class="form-control" id="legalName" name="petType" value="@if($data ?? ''){{$data->petType}}@endif" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
@if($data ?? '')
                                    @php
                                        $vacc=json_decode($data->vaccinations_list,true);
                                        $description=json_decode($data->description,true);
                                        $required_by_law=json_decode($data->required_by_law,true);
                                        $doc_status=json_decode($data->doc_status,true);
                                    @endphp
                                    @endif
                                    <div class="group_text">
                                        <h2>List of Vaccinations</h2>
                                        <p>In florida , the following Vaccinations must be administered by law to all pets. Make sure you review and upload The vaccine documents.</p>
                                    </div>

                                    <div class="vaccinations_list">
                                        @if($data ?? '')
                                        @foreach($vacc as $k=>$va)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Document Name</label>
                                                        <input type="text" class="form-control" value="{{$va}}" name="vaccinations_list[]">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <input type="text" class="form-control" value="{{$description[$k]}}" name="description[]">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Required by Law?</label>
                                                        <select  class="form-control" name="required_by_law[]">
                                                            <option value="1" @if($required_by_law[$k]==1) selected @endif>Yes</option>
                                                            <option value="0" @if($required_by_law[$k]==0) selected @endif>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select  class="form-control" name="doc_status[]">
                                                            <option value="Current"  @if($doc_status[$k]=="Current") selected @endif>Current</option>
                                                            <option value="Inactive"  @if($doc_status[$k]=="Inactive") selected @endif>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
@endif
                                    </div>
                                    <button type="button" class="btn btn-success" onclick="addrows()">Add Row</button>
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
        function addrows() {
            var html = '<div class="row"><div class="col-md-3"><div class="form-group"> <label>Document Name</label> <input type="text" class="form-control" name="vaccinations_list[]"></div></div><div class="col-md-5"><div class="form-group"> <label>Description</label> <input type="text" class="form-control" name="description[]"></div></div><div class="col-md-2"><div class="form-group"> <label>Required by Law?</label> <select class="form-control" name="required_by_law[]"><option value="1">Yes</option><option value="0">No</option> </select></div></div><div class="col-md-2"><div class="form-group"> <label>Status</label> <select class="form-control" name="doc_status[]"><option value="Current">Current</option><option value="Inactive">Inactive</option> </select></div></div></div>';
            $('.vaccinations_list').append(html);
        }

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

