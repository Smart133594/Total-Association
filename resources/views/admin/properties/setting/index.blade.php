@extends('admin.layouts.master')
@section('title', 'Property type')
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('property_setting')}}">Property Setting</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('save-setting')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Are there sub-Associations? &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="radio" id="is_subassociations" name="is_subassociations" value="1" @if($data ?? '')@if ($data['is_subassociations']==1) checked @endif @endif required> Yes &nbsp;&nbsp;
                                        <input type="radio" id="is_subassociations" name="is_subassociations" value="0" @if($data ?? '')@if ($data['is_subassociations']==0) checked @endif @endif required> No &nbsp;&nbsp;
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

