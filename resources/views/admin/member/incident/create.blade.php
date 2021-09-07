@extends('admin.layouts.master')
@section('title', 'Incident')
@section('content')
<style>
    table {
        table-layout: fixed;
        border-collapse: collapse;
        width: 100%;
        max-width: 100px;
    }
    td.text-flow {
        white-space: nowrap; 
        width: 10px; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
    <style>
        @if($data ?? '')
            @if($data->individual==1)
                .individual_group {
                    display: block
                }
            @endif
            @if($data->individualType=="Unregistered")
                .individual_group1 {
                    display: block
                }
                .individual_group2 {
                    display: none
                }
            @else
                .individual_group2 {
                    display: none
                }
                .individual_group1 {
                    display: block
                }
            @endif
        @else
            .individual_group, .police, .individual_group2 {
                display: none
            }
        @endif
    </style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Incidents</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('incident.index')}}">Incident</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('incident.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Incident</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" method="post" action="{{route('incident.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="group_text">
                                        <h2>Incident Details</h2>
                                        <p>Please put the incident details</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Date and Time </label>
                                        <input type="datetime-local" class="form-control" id="dateTime" name="dateTime" value="@if($data ?? ''){{$data->dateTime}}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Property</label>
                                        <select class="form-control" id="propertyId" name="propertyId" required>
                                            @foreach($property as $p)
                                                <option value="{{ $p->id }}" 
                                                    @if($data ?? '') @if($p->id==$data->propertyId) selected @endif @endif
                                                    @if($p->id==@$propertyid) selected @endif
                                                    >
                                                    {{$p->PropertyType->building}} {{$allassociation[$p->associationId]}} - @if($p->PropertyType->type=="Multi Dwelling") {{$p->aptNumber}} @else {{$p->address1}} @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <lable>Individual</lable>
                                        <br>
                                        <input type="radio" name="individual" value="0" @if($data ?? '') @if($data->individual==0) checked @endif @else checked
                                               @endif onclick="isindividual(this.value)"> &nbsp;No &nbsp;&nbsp;&nbsp; <input type="radio" name="individual" value="1"
                                                                                                                             @if($data ?? '')  @if($data->individual==1) checked
                                                                                                                             @endif @endif onclick="isindividual(this.value)"> &nbsp;Yes
                                    </div>
                                    <div class="form-group individual_group">
                                        <label for="exampleEmail">Individual Type</label>
                                        <select class="form-control" id="individualType" name="individualType" onchange="getresponsible(this.value)">
                                            <option value=""> --choose--</option>
                                            <option value="Owner" @if($data ?? '') @if($data->individualType=="Owner") selected @endif @endif> Owner</option>
                                            <option value="Residents" @if($data ?? '') @if($data->individualType=="Residents") selected @endif @endif> Residents</option>
                                            <option value="Guests" @if($data ?? '') @if($data->individualType=="Guests") selected @endif @endif> Guests</option>
                                            <option value="Unregistered" @if($data ?? '') @if($data->individualType=="Unregistered") selected @endif @endif> Unregistered</option>
                                        </select>
                                    </div>
                                    <script>
                                        function getresponsible(type) {
                                            if (type == "Unregistered") {
                                                $(".individual_group2").show();
                                                $(".individual_group1").hide();
                                            } else {
                                                $(".individual_group2").hide();
                                                $(".individual_group1").show();
                                                $.get("/getresponsible/" + type, function (res) {
                                                    $("#responsiblePersonId").html(res);
                                                })
                                            }

                                        }
                                    </script>

                                    <div class="form-group individual_group individual_group1">
                                        <label for="exampleEmail">Responsible Person</label>
                                        <select class="form-control" id="responsiblePersonId" name="responsiblePersonId" required>
                                            <option value="">--choose--</option>
                                            @if($data ?? '')
                                                @foreach($user as $u)
                                                    <option value="{{$u->id}}" @if($u->id==$data->responsiblePersonId) selected @endif>{{$u->firstName}} {{$u->lastName}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group individual_group2">
                                        <label for="exampleEmail">Name of Description</label>
                                        <input type="text" class="form-control" id="name_of_description" name="name_of_description" value="@if($data ?? ''){{$data->name_of_description}}@endif">
                                    </div>


                                    <div class="form-group">
                                        <label for="exampleEmail">Incident Title </label>
                                        <input type="text" class="form-control" id="incidentTitle" name="incidentTitle" value="@if($data ?? ''){{$data->incidentTitle}}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Incident Description</label>
                                        <textarea type="text" class="form-control editor" id="incidentDescription" name="incidentDescription"
                                                  required>@if($data ?? ''){{$data->incidentDescription}}@endif</textarea>

                                    </div>
                                    <div class="group_text">
                                        <h2>Police Information</h2>
                                        <p>Police Information details</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleEmail">Police Involved </label>
                                        <input type="radio" name="policeInvolved" value="0" onclick="ispolice(this.value)" @if($data ?? '') @if($data->policeInvolved==0) checked
                                               @endif @else checked @endif > &nbsp;No &nbsp;&nbsp;&nbsp; <input type="radio" name="policeInvolved" value="1"
                                                                                                                @if($data ?? '')  @if($data->policeInvolved==1) checked
                                                                                                                @endif @endif  onclick="ispolice(this.value)"> &nbsp;Yes
                                    </div>
                                    <div class="form-group police">
                                        <label for="exampleEmail">Police Report </label>
                                        <textarea type="text" class="form-control" id="policeReport" name="policeReport">@if($data ?? ''){{$data->policeReport}}@endif</textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleEmail">Outcome</label>
                                        <select class="form-control" id="outcome" name="outcome" onchange="setfine(this.value)" required>
                                            <option value=""> --choose--</option>
                                            <option value="Warning" @if($data ?? '') @if($data->outcome=="Warning") selected @endif @endif> Warning</option>
                                            <option value="Fine" @if($data ?? '') @if($data->outcome=="Fine") selected @endif @endif> Fine</option>
                                            <option value="Litigation" @if($data ?? '') @if($data->outcome=="Litigation") selected @endif @endif> Litigation</option>
                                        </select>
                                    </div>

                                    <div class="form-group fine_amount" @if($data ?? '') @if($data->outcome!="Fine") style="display: none" @endif  @else style="display: none" @endif>
                                        <label for="exampleEmail">Fine Amount</label>
                                        <input type="number" class="form-control" id="fine_amount" name="fine_amount" value="@if($data ?? ''){{$data->fine_amount}}@endif">
                                    </div>

                                    <script>
                                        function setfine(outcome) {
                                            if (outcome == "Fine") {
                                                $(".fine_amount").show();
                                            } else {
                                                $(".fine_amount").hide();
                                            }

                                        }
                                    </script>

                                </div>
                                <div class="col-md-12">
                                    <div class="group_text">
                                        <h2>Incident Documents</h2>
                                        <p>Please Upload all Incident Documents</p>
                                    </div>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;margin-bottom: 10px">Upload New Document</button>
                                    <table class="table d-block d-md-table table-responsive table-striped thead-primary w-100 dataTable no-footer">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 80px">S.No</th>
                                            <th>Document</th>
                                            <th>Type</th>
                                            <th style="min-width: 80px">Upload Date</th>
                                            <th style="min-width: 80px">Upload By</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="tbody">

                                        </tbody>
                                    </table>


                                </div>

                            </div>

                            <input type="submit" class="btn btn-primary d-block" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Upload Documents </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-details">
                    <form action="/uploaddocument" id="ownerdocuments" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$ref}}" name="ref" id="ref">
                        <div class="form-group">
                            <label for="exampleEmail">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                                <option value="document">Document</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleEmail">Document</label>
                            <input type="file" class="form-control" id="documents" name="documents">
                        </div>
                        <div class="form-group">
                            <label for="exampleEmail">Uploaded By</label>
                            <input type="Text" class="form-control" id="uploadedBy" name="uploadedBy">
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <input type="button" value="Upload" class="btn btn-success" onclick="submitform()">
                </div>
            </div>
        </div>
    </div>

    <script>
        function isindividual(type) {
            if (type == 1) {
                $(".individual_group").show();
                $("#individualType").prop('required', true);
            } else {
                $(".individual_group").hide();
                $("#individualType").prop('required', false);
            }
        }

        function ispolice(type) {
            if (type == 1) {
                $(".police").show();
            } else {
                $(".police").hide();
            }
        }

        $(document).ready(function () {
            $('#data-table').DataTable();
            uploaddoc();
        });
        function uploaddoc() {
            $.get('/uploadincidentdoc/{{$ref}}', function (res) {
                $("#tbody").html(res);
            })
        }

        function submitform() {
            var type = $("#type").val();
            var uploadedBy = $("#uploadedBy").val();
            var ref = $("#ref").val();
            var documents = $("#documents").val();

            var formData = new FormData();
            formData.append('documents', $('#documents')[0].files[0]);
            formData.append('ref', ref);
            formData.append('uploadedBy', uploadedBy);
            formData.append('type', type);
            formData.append('_token', "{{csrf_token()}}");

            $.ajax({
                url: '/uploadincidentdocument',
                type: 'POST',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (data) {
                    $('#exampleModal').modal('toggle');
                    uploaddoc();
                }
            });


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

