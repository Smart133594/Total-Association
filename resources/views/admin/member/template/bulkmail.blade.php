@extends('admin.layouts.master')
@section('title', 'Bulk Communication')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('bulk.communication')}}">Bulk Communication</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Bulk Communication</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('send.bulkmail')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="exampleEmail">Template Name <span>*</span></label>
                                        <select class="form-control" id="templateName" name="templateName" onchange="gettemplate(this.value)" required>
                                            <option value="">--choose--</option>
                                            @foreach($template as $t)
                                                <option value="{{$t->id}}">{{$t->templateName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">To</label><br>
                                        <input type="radio" name="to_mail" value="Individual" onclick="getgroup(1)" checked>&nbsp; Individual &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio"
                                                                                                                                                                                   name="to_mail"
                                                                                                                                                                                   value="Group"
                                                                                                                                                                                   onclick="getgroup(0)">&nbsp;
                                        Group
                                    </div>
                                    @if(!isset($_GET['type']) || !isset($_GET['user']))
                                    @if($setting['is_subassociations']=="1")

                                        <div class="form-group Individual">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId" onchange="getbuilding(this.value)">
                                                <option value="">--Choose--</option>
                                                @foreach($subasso as $s)
                                                    <option value="{{$s->id}}" @if($data ?? '') @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @endif
                                    <div class="form-group Individual" id="building" >
                                        <label for="examplePassword">Building</label>
                                        <select type="text" class="form-control" id="buildingId" name="buildingId">
                                            <option value="">--Choose--</option>
                                            @if($setting['is_subassociations']=="0" || isset($data))
                                                @foreach($building as $p)
                                                    <option value="{{$p->id}}" @if($data ?? '') @if($data->buildingId==$p->id) selected @endif @endif>{{$p->building}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group Individual">
                                        <label for="examplePassword">Property<span>*</span></label>
                                        <select type="text" class="form-control" id="propertyId" name="propertyId"  onchange="gettype()">
                                            <option value="">--Choose--</option>
                                            @if($setting['is_subassociations']=="0" || isset($data))
                                                @foreach($property as $p)
                                                    <option value="{{$p->id}}" type="{{$p->type}}" @if($data ?? '') @if($data->propertyId==$p->id) selected @endif @endif>{{$p->type}}/{{$p->building}}
                                                        /{{$p->aptNumber}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @endif
                                    <div class="form-group Individual">
                                        <label for="exampleEmail">Choose Receiver</label>
                                        <select class="form-control" name="whome_type" onchange="selectperson(this.value)">
                                            <option value="">--choose--</option>
                                            <option value="Owners" @if(isset($_GET['type']) && $_GET['type']=="Owners") selected @endif>Owners</option>
                                            <option value="Residents" @if(isset($_GET['type']) && $_GET['type']=="Residents") selected @endif>Residents</option>
                                        </select>
                                    </div>
                                    <div class="form-group Individual">
                                        <label for="exampleEmail"> Select the Person</label>
                                        <select class="form-control" id="person" name="whome">
                                            <option value="">--choose--</option>
                                            @if(isset($_GET['user']) && !empty($person))
                                                @foreach($person as $p)
                                                    <option value="{{$p->id}}" @if(isset($_GET['user']) && $_GET['user']==$p->id) selected @endif>{{$p->firstName}} {{$p->lastName}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group Group" style="display: none">
                                        <label for="exampleEmail">Choose Receiver</label><br>
                                        <input type="checkbox" name="whome_group[]" value="Owners"> Owners<br>
                                        <input type="checkbox" name="whome_group[]" value="Residents"> Residents<br>
                                        <input type="checkbox" name="whome_group[]" value="Guests"> Guests<br>
                                        <input type="checkbox" name="whome_group[]" value="Pet Owners"> Pet Owners
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <lable>Subject</lable>
                                        <input type="text" class="form-control" name="subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Template</label>
                                        <textarea class="form-control editor" id="mytemplate" name="template">@if($data ?? ''){{$data->template}}@endif</textarea>
                                    </div>
                                    @foreach($template_variable as $t)
                                        <button class="btn btn-secondary" type="button" onclick="setto('{{$t->variable}}')">{{$t->variable}}</button>
                                    @endforeach

                                </div>

                            </div>

                            <input type="submit" class="btn btn-primary d-block" value="Send Mail">
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

        function gettemplate(id) {
            $.get("/gettemplate/" + id, function (res) {
                tinyMCE.activeEditor.setContent(res);
            })

        }

        function getgroup(type) {
            if (type == "1") {
                $(".Individual").show();
                $(".Group").hide();
            } else {
                $(".Individual").hide();
                $(".Group").show();
            }
        }

        function getbuilding(association) {
            $.get('/getbuilding/' + association, function (res) {
                $("#buildingId").html(res);
            })
            $.get('/getproperty/' + association, function (res) {
                $("#propertyId").html(res);
            })
        }

        function selectperson(type) {
            var propertyId=$("#propertyId").val();
            $.get('/get-person/' + type +'/'+propertyId, function (res) {
                $("#person").html(res);
            })
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

