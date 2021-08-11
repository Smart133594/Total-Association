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
                                        <label for="exampleEmail">Pat Allowed</label>
                                        <select type="text" class="form-control" id="is_pat_allowd" name="is_pat_allowd" required>
                                            <option value="1" @if($data['is_pat_allowd']==1) selected @endif>Yes</option>
                                            <option value="0" @if($data['is_pat_allowd']==0) selected @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmail">Pet size limit</label>
                                        <input class="form-control" id="pet_size_limit" name="pet_size_limit" @if($data ?? '')value="{{$data['pet_size_limit']}}" @endif required>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleEmail">Pet Required Documents</label>
                                        @php $docc=json_decode($data['pet_documents'],true); @endphp
                                        @php $description=json_decode($data['documents_description'],true); @endphp
                                        @php $required_by_law=json_decode($data['documents_required_by_law'],true);  @endphp
                                        @php $doc_status=json_decode($data['documents_status'],true); @endphp
                                        <div class="pet_documents">
                                            @if($docc)
                                                @foreach($docc as $k=>$va)
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Document Name</label>
                                                                <input type="text" class="form-control"  @if($va) value="{{$va}}" @endif name="pet_documents[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <input type="text" class="form-control" @if($description[$k]) value="{{$description[$k]}}" @endif name="documents_description[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Required by Law? {{$required_by_law[$k]}}</label>
                                                                <select  class="form-control" name="documents_required_by_law[]">
                                                                    <option value="1"   @if($required_by_law[$k]==1) selected @endif >Yes</option>
                                                                    <option value="0"  @if($required_by_law[$k]==0) selected @endif >No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select  class="form-control" name="documents_status[]">
                                                                    <option value="Current"    @if($doc_status[$k]=="Current") selected @endif   >Current</option>
                                                                    <option value="Inactive"   @if($doc_status[$k]=="Inactive") selected @endif  >Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success" onclick="addrows()">Add Row</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleEmail">Pet Support Documents</label>
                                        @php $docc=json_decode($data['pet_support_documents'],true); @endphp
                                        @php $description=json_decode($data['support_description'],true); @endphp
                                        @php $required_by_law=json_decode($data['support_required_by_law'],true); @endphp
                                        @php $doc_status=json_decode($data['documents_support_status'],true); @endphp
                                        <div class="pet_support_documents">
                                            @if($docc)
                                                    @foreach($docc as $k=>$va)

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Document Name</label>
                                                                <input type="text" class="form-control" @if($va)  value="{{$va}}" @endif name="pet_support_documents[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <input type="text" class="form-control"  @if($description[$k]) value="{{$description[$k]}}" @endif name="support_description[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Required by Law?</label>
                                                                <select  class="form-control" name="support_required_by_law[]">
                                                                    <option value="1"   @if($required_by_law[$k]==1) selected @endif  >Yes</option>
                                                                    <option value="0"  @if($required_by_law[$k]==0) selected @endif >No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select  class="form-control" name="documents_support_status[]">
                                                                    <option value="Current"   @if($doc_status[$k]=="Current") selected @endif  >Current</option>
                                                                    <option value="Inactive"    @if($doc_status[$k]=="Inactive") selected @endif  >Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success" onclick="addrows2()">Add Row</button>

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

