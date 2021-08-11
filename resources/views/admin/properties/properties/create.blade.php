@extends('admin.layouts.master')
@section('title', 'Properties')
@section('content')
<div class="ms-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('properties.index')}}">Properties</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{route('properties.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                </ol>
            </nav>
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome">
                    <h6>@if($data ?? '') Update @else Add @endif Properties</h6>
                </div>
                @include('admin.includes.msg')
                <form id="admin-form" method="post" action="{{route('properties.store')}}" enctype="multipart/form-data">
                    @csrf
                    @if($data ?? '')
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    @endif
                    <div class="ms-panel-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group" style="display:none">
                                    <label>Select Master-Association</label>
                                    <select class="form-control" id="masterassociationId" name="masterassociationId">
                                        @foreach($masasso as $s)
                                        <option value="{{$s->id}}" selected>{{$s->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($setting['is_subassociations']=="1")
                                <div class="form-group">
                                    <label>Select Sub-Association</label>
                                    <select class="form-control" id="associationId" name="associationId" onchange="getbuilding(this.value)">
                                        <option value="">--Choose--</option>
                                        @foreach($subasso as $s)
                                        <option value="{{$s->id}}" @if($data ?? '' ) @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>Select Type</label>
                                    <select class="form-control" id="selecttype" name="typeId" onchange="gettype()">
                                        <option value="">--Choose--</option>
                                        @foreach($ptype as $p)
                                        <option value="{{$p->id}}" @if($data ?? '' ) @if($data->typeId==$p->id)selected @endif @endif type="{{$p->type}}">{{$p->propertyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group apartment_related">
                                    <label>Choose Building</label>
                                    <select class="form-control" id="buildingId" name="buildingId" onchange="getfloor(this.value)">
                                        <option value="">Choose Building</option>
                                        @if($setting['is_subassociations']=="0" || isset($data))
                                        @foreach($building as $b)
                                        <option value="{{$b->id}}" @if($data ?? '' ) @if($b->id==$data->buildingId) selected @endif @endif>{{$b->building}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group apartment_related ">
                                    <label>Apartment Number</label>
                                    <input type="text" class="form-control" id="aptNumber" name="aptNumber" value="@if($data ?? ''){{$data->aptNumber}}@endif">
                                </div>
                                <div class="form-group apartment_related ">
                                    <label>Floor Number</label>
                                    <select class="form-control" id="floorNumber" name="floorNumber">
                                        <option value="">Choose Floor</option>
                                        @if($data ?? '')
                                        @if(count($floor)>0)
                                        @foreach($floor as $f)
                                        <option value="{{$f}}" @if($data ?? '' ) @if($f==$data->floorNumber) selected @endif @endif>{{$f}}</option>
                                        @endforeach
                                        @endif
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group apartment_related">
                                    <label>Payment Bracket</label>
                                    <select class="form-control" id="paymentBracket" name="paymentBracket">
                                        <option value="">--choose--</option>
                                        @foreach($payment_bracket as $b)
                                        <option value="{{$b->id}}" @if($data ?? '' ) @if($b->id==$data->paymentBracket) selected @endif @endif>{{$b->payBracketName}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ms-panel-header ms-panel-custome house_related">
                        <h6>Address</h6>
                    </div>
                    <div class="ms-panel-body">
                        {{-- <div class="row">--}}

                        {{-- <div class="col-md-12">--}}

                        {{-- <div class="form-group row">--}}
                        {{-- <label class="col-sm-2 col-form-label">Occupied By</label>--}}
                        {{-- <div class="col-sm-10" style="padding-top: 7px">--}}
                        {{-- <input type="radio" name="occupied" value="Owner"  @if($data ?? '') @if($data->occupied=='Owner')checked @endif @endif> Owner &nbsp;&nbsp;&nbsp;&nbsp;--}}
                        {{-- <input type="radio" name="occupied" value="Rental"   @if($data ?? '') @if($data->occupied=='Rental')checked @endif @endif> Rental &nbsp;&nbsp;&nbsp;&nbsp;--}}
                        {{-- <input type="radio" name="occupied" value="Vacant"  @if($data ?? '') @if($data->occupied=='Vacant')checked @endif @endif> Vacant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                        {{-- </div>--}}
                        {{-- </div>--}}
                        {{-- </div>--}}

                        {{-- </div>--}}
                        <div class="row">
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>Address Line 1</label>
                                    <input type="text" class="form-control" id="address2" name="address1" value="@if($data ?? ''){{$data->address1}}@endif">
                                </div>
                            </div>
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" value="@if($data ?? ''){{$data->address2}}@endif">
                                </div>
                            </div>
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" id="city" name="city" value="@if($data ?? ''){{$data->city}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" id="state" name="state" value="@if($data ?? ''){{$data->state}}@endif">
                                </div>
                            </div>
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" id="country" name="country" value="@if($data ?? ''){{$data->country}}@endif">
                                </div>
                            </div>
                            <div class="col-md-4 house_related">
                                <div class="form-group">
                                    <label>Zip</label>
                                    <input type="text" class="form-control" id="pincode" name="pincode" value="@if($data ?? ''){{$data->pincode}}@endif">
                                </div>
                            </div>
                        </div>


                        {{-- <div class="row">--}}
                        {{-- <div class="col-md-12">--}}

                        {{-- <div class="form-group">--}}
                        {{-- <label>Status</label>--}}
                        {{-- <select class="form-control" id="status" name="status">--}}
                        {{-- <option value="">--Choose Status--</option>--}}
                        {{-- <option value="Current" @if($data ?? '') @if($data->status=='Current')selected @endif @endif>Current</option>--}}
                        {{-- <option value="Deliquent" @if($data ?? '') @if($data->status=='Deliquent')selected @endif @endif>Deliquent</option>--}}
                        {{-- </select>--}}
                        {{-- </div>--}}
                        {{-- </div>--}}
                        {{-- </div>--}}
                        <input type="submit" class="btn btn-primary d-block" value="Save">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".house_related").hide();
        $(".apartment_related").hide();
        gettype();
    });

    function getfloor(building) {
        $.get('/getfloor/' + building, function(res) {
            $("#floorNumber").html(res);
        })
    }

    function getbuilding(association) {
        $.get('/getbuilding/' + association, function(res) {
            $("#buildingId").html(res);
        })
        $.get('/paymentbracket/' + association, function(res) {
            $("#paymentBracket").html(res);
        })
    }
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

    .hide {
        display: none;
    }
</style>


<script>
    function gettype() {
        var datatype = $('#selecttype').find(":selected").attr('type');

        if (datatype == "Multi Dwelling") {
            $(".house_related").hide();
            $(".apartment_related").show();

            $(".house_related").find('input').prop('required', false);
            $(".apartment_related").find('input').prop('required', true);
            $(".house_related").find('select').prop('required', false);
            $(".apartment_related").find('select').prop('required', true);
        } else {
            $(".house_related").show();
            $(".apartment_related").hide();

            $(".apartment_related").find('input').prop('required', false);
            $(".house_related").find('input').prop('required', true);
            $(".apartment_related").find('select').prop('required', false);
            $(".house_related").find('select').prop('required', true);
        }
    }
</script>
@include('admin.includes.validate')
@endsection