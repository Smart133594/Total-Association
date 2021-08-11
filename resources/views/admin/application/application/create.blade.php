@extends('admin.layouts.master')
@section('title', 'Application')
@section('content')


    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Application</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application.index')}}">Background Checks</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application.create')}}">New</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>New Application</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" class="main-form" method="post" action="{{route('application.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">

                                <div class="col-md-10 ">

                                @if($setting['is_subassociations']=="1")
                                    <div class="form-group">
                                        <label>Select Sub-Association <span>*</span></label>
                                        <select class="form-control" id="associationId" name="associationId" required>
                                            <option value="">--Choose--</option>
                                            @foreach($subasso as $s)
                                                <option value="{{$s->id}}" @if($data ?? '') @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label for="examplePassword">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="@if($data ?? ''){{$data->firstName}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group ">
                                        <label for="examplePassword">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName" value="@if($data ?? ''){{$data->middleName}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label for="examplePassword">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="@if($data ?? ''){{$data->lastName}}@endif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Phone Number</label>
                                        <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="@if($data ?? ''){{$data->phoneNo}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Email Id</label>
                                        <input type="email" class="form-control" id="email" name="email" @if($data ?? '')value="{{$data->email}}" @endif required onblur="chackemail(this.value)">
                                    </div>
                                </div>
                            </div>
                            <input type="submit"  class="btn btn-primary d-block" id="submit" value="Save">
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
        function chackemail(email) {
            $.get("/chackemail-application/"+email,function(res){
                console.log(res);
                if(res==1){
                    html = '<label for="website" generated="true" class="email-error error">Email id already approved.</label>';
                    $("#email").after(html);
                }

            })
        }
        $("#email").focus(function () {
            $(".email-error").remove();
            $("#email").removeClass('error');
        })
    </script>
    <script>
        $(document).ready(function () {
            $('.customdate').datepicker({
                dateFormat: 'yy-mm-dd'
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
    @include('admin.includes.validate');

@endsection

