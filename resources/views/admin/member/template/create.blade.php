@extends('admin.layouts.master')
@section('title', 'Template')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('template.index')}}">Template</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('template.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Template</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('template.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="exampleEmail">Template Name</label>
                                        <input type="text" class="form-control" id="templateName" name="templateName" value="@if($data ?? ''){{$data->templateName}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleEmail">Template</label>
                                        <textarea class="form-control editor" id="mytemplate" name="template">@if($data ?? ''){{$data->template}}@endif</textarea>
                                    </div>
                                    @foreach($template_variable as $t)
                                        <button class="btn btn-secondary" type="button" onclick="setto('{{$t->variable}}')">{{$t->variable}}</button>
                                    @endforeach
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
        function setto(mark) {
            tinymce.activeEditor.execCommand('mceInsertContent', false, mark);
        }
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

