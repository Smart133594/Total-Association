@extends('admin.layouts.master')
@section('title', 'Application')
@section('content')


    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('facilities/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.create')}}">New</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>New Facilities</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" class="main-form" method="post" action="{{route('facilities.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">

                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label>Select Facilities Type <span>*</span></label>
                                        <select class="form-control" id="facilitiesTypeId" name="facilitiesTypeId" required>
                                            <option value="">--Choose--</option>
                                            @foreach($facilities_type as $s)
                                                <option value="{{$s->id}}" @if($data ?? '') @if($data->facilitiesTypeId==$s->id)selected @endif @endif>{{$s->typeName}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="examplePassword">Facility</label>
                                        <input type="text" class="form-control" id="Facility" name="Facility" value="@if($data ?? ''){{$data->Facility}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="examplePassword">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" value="@if($data ?? ''){{$data->location}}@endif" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleEmail">Image</label>
                                        <input type="file" id="image" name="image">
                                        @if($data ?? '')
                                            @if(!empty($data->image))
<br>
                                                    <img src="/upload/{{$data->image}}" style="height: 200px">

                                            @endif
                                        @endif

                                    </div>

                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary d-block" id="submit" value="Save">
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
            $.get("/chackemail-application/" + email, function (res) {
                console.log(res);
                if (res == 1) {
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

