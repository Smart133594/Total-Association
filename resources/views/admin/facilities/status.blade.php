@extends('admin.layouts.master')
@section('title', 'Facilities Suspend')
@section('content')


    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('facilities-suspend/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.create')}}">Suspend</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Facilities Suspend</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" class="main-form" method="post" action="{{route('facilities.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Suspend From</label>
                                        <input type="date" class="form-control" id="suspendFrom" name="suspendFrom" value="@if($data ?? ''){{$data->suspendFrom}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Suspend To</label>
                                        <input type="date" class="form-control" id="suspendTo" name="suspendTo" value="@if($data ?? ''){{$data->suspendTo}}@endif" required>
                                    </div>
                                </div>


                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="examplePassword">Title</label>
                                        <input type="text" class="form-control" id="suspendTitle" name="suspendTitle" value="@if($data ?? ''){{$data->suspendTitle}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="examplePassword">suspendDescription</label>
                                        <textarea class="form-control" id="suspendDescription" name="suspendDescription" required>@if($data ?? ''){{$data->suspendDescription}}@endif</textarea>
                                    </div>
                                </div>

                            </div>
<input type="hidden" name="status" value="0">
                            <input type="submit"  class="btn btn-primary d-block" id="submit" value="Suspand">
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

