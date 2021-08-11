@extends('admin.layouts.master')
@section('title', 'Payment Bracket')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('payment-bracket.index')}}">Payment Bracket</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('payment-bracket.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Payment Bracket</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('payment-bracket.store')}}" enctype="multipart/form-data">
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
                                        <label for="exampleEmail">Name</label>
                                        <input type="text" class="form-control" id="payBracketName" name="payBracketName" value="@if($data ?? ''){{$data->payBracketName}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Description</label>
                                        <textarea type="text" class="form-control" id="description" name="description">@if($data ?? ''){{$data->description}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Fees Paid every_____Months</label>
                                        <input type="text" class="form-control" id="feePaidPerMonth" name="feePaidPerMonth" value="@if($data ?? ''){{$data->feePaidPerMonth}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Fees Value</label>
                                        <input type="text" class="form-control" id="feesValue" name="feesValue" value="@if($data ?? ''){{$data->feesValue}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Percentage of Budget</label>
                                        <input type="text" class="form-control" id="budget" name="budget" value="@if($data ?? ''){{$data->budget}}@endif" required>
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

