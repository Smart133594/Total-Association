@extends('admin.layouts.master')
@section('title', 'Digital Signage Group')
@section('content')

    <script>
        function previewA(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(`#preview_a`)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewB(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(`#preview_b`)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewC(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(`#preview_c`)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewD(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(`#preview_d`)
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('digital-signage-group.index')}}">Digital Signage Group</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('digital-signage-group.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        {{-- <h6>@if($data ?? '') Update @else Add @endif Group</h6> --}}
                        <h6>Digital Signage</h6>
                    </div>
                    <div class="ms-panel-body">
                       @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('digital-signage-group.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleEmail">Group Name <span>*</span></label>
                                        <input type="text" class="form-control" id="groupName" name="groupName" value="@if($data ?? ''){{$data->groupName}}@endif" required>
                                    </div>
                                </div>
         
                                @if(!isset($data) || Auth::user()->role==1)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleEmail">Manager <span>*</span></label>
                                            <select class="form-control" id="user_id" name="user_id" required>
                                                <option value="">--choose manager--</option>
                                                @foreach($member as $m)
                                                    <option value="{{$m->id}}" @if($data ?? '') @if($m->id==$data->user_id) selected @endif @endif>{{$m->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="idDocument" class="btn btn-primary">Choose File</label><br>
                                            <input type="file" id="idDocument" style="display: none;" name="logo" onchange="previewA(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div style="width: 180px; border: 2px dashed #333; margin-top: 17px;">
                                        @if(isset($data) && !empty($data->image1))
                                                <img src="{{ '/thumb/'.$data->logo }}" id="preview_a" style="height: 180px; width: 180px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/180" id="preview_a" style="height: 180px; width: 180px; object-fit: cover;">
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Scrolling Text</h6>
                    </div>
                    <div class="ms-panel-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleEmail">Set the scrolling text items</label>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 1</label>
                                        <input type="text" class="form-control" name="heading1" value="@if($data ?? ''){{$data->heading1}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 2</label>
                                        <input type="text" class="form-control" name="heading2" value="@if($data ?? ''){{$data->heading2}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 3</label>
                                        <input type="text" class="form-control" name="heading3" value="@if($data ?? ''){{$data->heading3}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 4</label>
                                        <input type="text" class="form-control" name="heading4" value="@if($data ?? ''){{$data->heading4}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 5</label>
                                        <input type="text" class="form-control" name="heading5" value="@if($data ?? ''){{$data->heading5}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 6</label>
                                        <input type="text" class="form-control" name="heading6" value="@if($data ?? ''){{$data->heading6}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 7</label>
                                        <input type="text" class="form-control" name="heading7" value="@if($data ?? ''){{$data->heading7}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 8</label>
                                        <input type="text" class="form-control" name="heading8" value="@if($data ?? ''){{$data->heading8}}@endif">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 9</label>
                                        <input type="text" class="form-control" name="heading9" value="@if($data ?? ''){{$data->heading9}}@endif">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleEmail">Scroll Item 10</label>
                                        <input type="text" class="form-control" name="heading10" value="@if($data ?? ''){{$data->heading10}}@endif">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Scrolling Text</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleEmail">Set the scrolling text items</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <p>Left Image</p>
                                <div class="form-group" style="margin-top: -25px;">
                                    <label for="idDocument1" class="btn btn-primary">Choose File</label><br>
                                    <input type="file" id="idDocument1" style="display: none;" name="image1" onchange="previewB(this)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="width: 180px; border: 2px dashed #333; margin-top: 17px;">
                                    @if(isset($data) && !empty($data->image1))
                                        <img src="{{ '/thumb/'.$data->image1 }}" id="preview_b" style="height: 180px; width: 180px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/180" id="preview_b" style="height: 180px; width: 180px; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <p>Middle Image</p>
                                <div class="form-group" style="margin-top: -25px;">
                                    <label for="idDocument2" class="btn btn-primary">Choose File</label><br>
                                    <input type="file" id="idDocument2" style="display: none;" name="image2" onchange="previewC(this)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="width: 180px; border: 2px dashed #333; margin-top: 17px;">
                                    @if(isset($data) && !empty($data->image2))
                                        <img src="{{ '/thumb/'.$data->image2 }}" id="preview_c" style="height: 180px; width: 180px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/180" id="preview_c" style="height: 180px; width: 180px; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <p>Right Image</p>
                                <div class="form-group" style="margin-top: -25px;">
                                    <label for="idDocument3" class="btn btn-primary">Choose File</label><br>
                                    <input type="file" id="idDocument3" style="display: none;" name="image3" onchange="previewD(this)">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="width: 180px; border: 2px dashed #333; margin-top: 27px;">
                                    @if(isset($data) && !empty($data->image3))
                                        <img src="{{ '/thumb/'.$data->image3 }}" id="preview_d" style="height: 180px; width: 180px; object-fit: cover;">
                                    @else
                                        <img src="https://via.placeholder.com/180" id="preview_d" style="height: 180px; width: 180px; object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-panel">
                    <div class="ms-panel-body">
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

