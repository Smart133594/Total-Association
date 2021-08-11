@extends('admin.layouts.master')
@section('title', 'Digital Signage Group')
@section('content')

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
                        <h6>@if($data ?? '') Update @else Add @endif Group</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('digital-signage-group.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                @if(!isset($data) || Auth::user()->role==1)
                                    <div class="col-md-8">
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
                                @endif

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Group Name <span>*</span></label>
                                        <input type="text" class="form-control" id="groupName" name="groupName" value="@if($data ?? ''){{$data->groupName}}@endif" required>
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
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="examplePassword">Logo </label>
                                                <input type="file" class="form-control" id="idDocument" name="logo">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if(isset($data) && !empty($data->logo))
                                                <div class="logo"><img src="{{ '/thumb/'.$data->logo }}" class="preview">
                                                </div> @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="examplePassword">Left Image </label>
                                                <input type="file" class="form-control" id="idDocument" name="image1">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if(isset($data) && !empty($data->image1))
                                                <div class="image1"><img src="{{ '/thumb/'.$data->image1 }}" class="preview">
                                                </div> @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="examplePassword">Middle Image </label>
                                                <input type="file" class="form-control" id="idDocument" name="image2">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if(isset($data) && !empty($data->image2))
                                                <div class="image2"><img src="{{ '/thumb/'.$data->image2 }}" class="preview">
                                                </div> @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="examplePassword">Right Image </label>
                                                <input type="file" class="form-control" id="idDocument" name="image3">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if(isset($data) && !empty($data->image3))
                                                <div class="image3"><img src="{{ '/thumb/'.$data->image3 }}" class="preview">
                                                </div> @endif
                                        </div>
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

