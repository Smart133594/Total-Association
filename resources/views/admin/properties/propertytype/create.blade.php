@extends('admin.layouts.master')
@section('title', 'Property type')
@section('content')
    <style>
        .building {
            display: none;
        }
    </style>

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('property-type.index')}}">Property Type</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('property-type.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Property type</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('property-type.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">

                                @if($setting['is_subassociations']=="1")
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId" onchange="getfees(this.value)">
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
                                        <label for="exampleEmail">Property Type</label>
                                        <input type="text" class="form-control" id="propertyName" name="propertyName" value="@if($data ?? ''){{$data->propertyName}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Select Property Type</label>
                                        <select class="form-control" id="type" name="type" onchange="showbuilding(this.value)" required>
                                            <option value="">--Choose--</option>
                                            <option value="Multi Dwelling" @if($data ?? '') @if($data->type=='Multi Dwelling')selected @endif @endif>Multi Dwelling</option>
                                            <option value="Single Dwelling" @if($data ?? '') @if($data->type=='Single Dwelling')selected @endif @endif>Single Dwelling</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-8 building" @if(isset($data)) @if($data->type=="Apartment") style="display:block" @endif @endif>
                                    <div class="form-group">
                                        <label for="exampleEmail">Building</label>
                                        <select class="form-control" id="whichBuilding" name="whichBuilding" @if(isset($data)) @if($data->type=="Apartment") required @endif @endif>
                                            <option value="">--Choose--</option>
                                            @foreach($building as $b)
                                                <option value="{{$b->id}}" @if($data ?? '') @if($data->whichBuilding==$b->id)selected @endif @endif>{{$b->building}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Maintenance Fee Bracket </label>
                                        <select class="form-control" id="maintainenceFeeBracketId" name="maintainenceFeeBracketId" required>
                                            <option value="">--Choose--</option>
                                            @if($setting['is_subassociations']=="0" || isset($data))
                                                @foreach($payment_bracket as $p)
                                                    <option value="{{$p->id}}" @if($data ?? '') @if($data->maintainenceFeeBracketId==$p->id)selected @endif @endif>{{$p->payBracketName}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Description</label>
                                        <textarea type="text" class="form-control" id="propertyDescription" name="propertyDescription">@if($data ?? ''){{$data->propertyDescription}}@endif</textarea>
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
        function getfees(association) {
            $.get('/paymentbracket/' + association, function (res) {
                $("#maintainenceFeeBracketId").html(res);
            })
        }
    </script>
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
    <script>
        function showbuilding(type) {
            if (type == "Apartment") {
                $(".building").show();
                $("#whichBuilding").prop('required', true);
            } else {
                $(".building").hide();
                $("#whichBuilding").prop('required', false);
            }

        }
    </script>
    @include('admin.includes.validate')
@endsection

