@extends('admin.layouts.master')
@section('title', 'Application')
@section('content')
    <style>
        .building{
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

                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application_setting')}}">Application Setting</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Application Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('save-setting')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Application Amount (USD)</label>
                                        <input type="text" class="form-control" id="application_amount" name="application_amount" @if($data ?? '')value="{{$data['application_amount']}}" @endif required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Application Duration (Minutes)</label>
                                        <input type="text" class="form-control" id="application_duration" name="application_amount" @if($data ?? '')value="{{$data['application_amount']}}" @endif required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Minimum Credit Score</label>
                                        <input type="text" class="form-control" id="minimum_credit_score" name="minimum_credit_score" @if($data ?? '')value="{{$data['minimum_credit_score']}}" @endif required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Paypal Id</label>
                                        <input type="text" class="form-control" id="paypal_id" name="paypal_id" @if($data ?? '')value="{{$data['paypal_id']}}" @endif required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Incident Email</label>
                                        <input type="email" class="form-control" id="incidentEmail" name="incidentEmail" @if($data ?? '')value="{{$data['incidentEmail']}}" @endif required>
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
    @include('admin.includes.validate')
@endsection

