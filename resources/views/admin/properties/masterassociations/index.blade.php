@extends('admin.layouts.master')
@section('title', 'Master Association')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Master Association</a></li>

                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Master Associations</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('master-association.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Legal Name</label>
                                        <input type="text" class="form-control" id="legalName" name="legalName" value="@if($data ?? ''){{$data->legalName}}@endif" required>
                                    </div>


                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="examplePassword">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="@if($data ?? ''){{$data->name}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Address Line 1</label>
                                        <input type="text" class="form-control" id="address1" name="address1" value="@if($data ?? ''){{$data->address1}}@endif" required >
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Address Line 2</label>
                                        <input type="text" class="form-control" id="address2" name="address2" value="@if($data ?? ''){{$data->address2}}@endif" required >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="examplePassword">City</label>
                                        <input type="text" class="form-control" id="city" name="city" value="@if($data ?? ''){{$data->city}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="examplePassword">State</label>
                                        <input type="text" class="form-control" id="state" name="state" value="@if($data ?? ''){{$data->state}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="examplePassword">Country</label>
                                        <input type="text" class="form-control" id="country" name="country"value=" @if($data ?? ''){{$data->country}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="examplePassword">Zip</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode" value="@if($data ?? ''){{$data->pincode}}@endif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Phone Number</label>
                                        <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="@if($data ?? ''){{$data->phoneNo}}@endif"value="@if($data ?? ''){{$data->country}}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="examplePassword">Email Id</label>
                                        <input type="email" class="form-control" id="email" name="email" value="@if($data ?? ''){{$data->email}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Fax Number</label>
                                        <input type="text" class="form-control" id="fax" name="fax" value="@if($data ?? ''){{$data->fax}}@endif"value="@if($data ?? ''){{$data->country}}@endif" >
                                    </div>
                                    <div class="form-group">
                                        <label for="examplePassword">WhatsApp Number</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsappNo" value="@if($data ?? ''){{$data->whatsappNo}}@endif"value="@if($data ?? ''){{$data->country}}@endif" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Website</label>
                                        <input type="text" class="form-control" id="website" name="website" value="@if($data ?? ''){{$data->website}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" name="facebook" value="@if($data ?? ''){{$data->facebook}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Twitter</label>
                                        <input type="text" class="form-control" id="twitter" name="twitter" value="@if($data ?? ''){{$data->twitter}}@endif">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="examplePassword">EIN number</label>
                                    <input type="text" class="form-control" id="einNumber" name="einNumber" value="@if($data ?? ''){{$data->einNumber}}@endif">
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

