@extends('admin.layouts.master')
@section('title', 'Application')
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Fines and Violations</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application_setting')}}">Fine & Violations Setting</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Fine & Violations Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('save-setting')}}" enctype="multipart/form-data">
                            @csrf


                            <div class="row">



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Fine Days limit</label>
                                        <input class="form-control" id="wait-days-for-fine" name="wait-days-for-fine" @if($data ?? '')value="{{$data['wait-days-for-fine']}}" @endif required>
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
        function addrows() {
            var html = '<div class="row"><div class="col-md-3"><div class="form-group"> <label>Document Name</label> <input type="text" class="form-control" name="pet_documents[]"></div></div><div class="col-md-5"><div class="form-group"> <label>Description</label> <input type="text" class="form-control" name="documents_description[]"></div></div><div class="col-md-2"><div class="form-group"> <label>Required by Law?</label> <select class="form-control" name="documents_required_by_law[]"><option value="1">Yes</option><option value="0">No</option> </select></div></div><div class="col-md-2"><div class="form-group"> <label>Status</label> <select class="form-control" name="documents_status[]"><option value="Current">Current</option><option value="Inactive">Inactive</option> </select></div></div></div>';
            $('.pet_documents').append(html);
        }
        function addrows2() {
            var html = '<div class="row"><div class="col-md-3"><div class="form-group"> <label>Document Name</label> <input type="text" class="form-control" name="pet_support_documents[]"></div></div><div class="col-md-5"><div class="form-group"> <label>Description</label> <input type="text" class="form-control" name="support_description[]"></div></div><div class="col-md-2"><div class="form-group"> <label>Required by Law?</label> <select class="form-control" name="support_required_by_law[]"><option value="1">Yes</option><option value="0">No</option> </select></div></div><div class="col-md-2"><div class="form-group"> <label>Status</label> <select class="form-control" name="documents_support_status[]"><option value="Current">Current</option><option value="Inactive">Inactive</option> </select></div></div></div>';
            $('.pet_support_documents').append(html);
        }
        $(document).ready(function () {
            $('#data-table').DataTable();
        });
    </script>
    @include('admin.includes.validate')
@endsection

