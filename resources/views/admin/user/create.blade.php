@extends('admin.layouts.master')
@section('title', 'User')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('manager.index')}}">Manager</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('manager.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Manager</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('manager.store')}}" enctype="multipart/form-data">
                            <input type="hidden" name="role" value="4">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="@if($data ?? ''){{$data->name}}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Email</label>
                                        <input type="text" class="form-control" id="email" name="email" value="@if($data ?? ''){{$data->email}}@endif" required>
                                    </div>
                                    @if(!isset($data))
                                        <div class="form-group">
                                            <label for="exampleEmail">Password</label>
                                            <input type="text" class="form-control" id="email" name="password">
                                        </div>
                                    @endif
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

