@extends('admin.layouts.master')
@section('title', 'Guest')
@section('content')
    <style>
        @if($data ?? '')
    @if($data->if_us_citizen=='1')
          .us {
            display: block;
        }

        .notus {
            display: none;
        }

        @else
         .notus {
            display: block;
        }

        .us {
            display: none;
        }
        @endif
        @else
             .notus {
            display: none;
        }

        @endif

                @if(isset($data))

        @if($data->typeId=='4')
    .apartment_related {
            display: none;
        }

        @else
     .house_related {
            display: none;
        }
        @endif
@else
         .apartment_related, .house_related {

            display: none;
        }
        @endif
    </style>

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('guest.index')}}">Guest</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('guest.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <form id="admin-form" class="main-form" method="post" action="{{route('guest.store')}}" enctype="multipart/form-data">
                    <div class="ms-panel">
                        <div class="ms-panel-header ms-panel-custome">
                            <h6>@if($data ?? '') Update @else Add @endif Guest</h6>
                        </div>
                        <div class="ms-panel-body">
                            @include('admin.includes.msg')
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <div class="group_text">
                                <h2>Property Information</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    @if($setting['is_subassociations']=="1")
                                        <div class="form-group">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId">
                                                <option value="">--Choose--</option>
                                                @foreach($subasso as $s)
                                                    <option value="{{$s->id}}" @if($data ?? '') @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                        <div class="form-group">
                                            <label>Select Property</label>
                                            <select class="form-control" id="selecttype" name="propertyId"  >
                                                <option value="">--Choose--</option>
                                                @foreach($property as $p)
                                                    <option value="{{$p->id}}" @if($data ?? '') @if($data->propertyId==$p->id)selected @endif @endif>{{$p->id}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                        <label>Select Type</label>
                                        <select class="form-control" id="selecttype" name="typeId" onchange="gettype()">
                                            <option value="">--Choose--</option>
                                            @foreach($ptype as $p)
                                                <option value="{{$p->id}}" @if($data ?? '') @if($data->typeId==$p->id)selected @endif @endif>{{$p->type}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                        <div class="form-group apartment_related ">
                                            <label>Choose Building</label>
                                            <select class="form-control" id="selecttype" name="buildingId" onchange="getfloor(this.value)">
                                                <option value="">Choose Building</option>

                                                @foreach($building as $b)
                                                    <option value="{{$b->id}}" @if($data ?? '') @if($b->id==$data->buildingId) selected @endif @endif>{{$b->building}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group apartment_related ">
                                            <label>Apartment Number</label>
                                            <input type="text" class="form-control" id="aptNumber" name="aptNumber" value="@if($data ?? ''){{$data->aptNumber}}@endif">
                                        </div>
                                        <div class="form-group apartment_related ">
                                            <label>Floor Number</label>
                                            <select class="form-control" id="floorNumber" name="floorNumber">
                                                <option value="">Choose Floor</option>
                                                @if($data ?? '')
                                                    @if(count($floor)>0)
                                                        @foreach($floor as $f)
                                                            <option value="{{$f}}"  @if($data ?? '') @if($f==$data->floorNumber) selected @endif @endif>{{$f}}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ms-panel">
                        <div class="ms-panel-header ms-panel-custome">
                            <h6>@if($data ?? '') Update @else Add @endif Guest</h6>
                        </div>
                        <div class="ms-panel-body">
                            <div class="group_text">
                                <h2>Guests Basic Information</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-4 group_individual">
                                    <div class="form-group">
                                        <label for="examplePassword">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="@if($data ?? ''){{$data->firstName}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4 group_individual">
                                    <div class="form-group ">
                                        <label for="examplePassword">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName" value="@if($data ?? ''){{$data->middleName}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4 group_individual">
                                    <div class="form-group">
                                        <label for="examplePassword">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="@if($data ?? ''){{$data->lastName}}@endif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ethnicity</label>
                                        <input type="text" class="form-control" name="ethnicity" value="@if($data ?? ''){{$data->ethnicity}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Date Of Birth<span>*</span></label>
                                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" value="@if($data ?? ''){{$data->dateOfBirth}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Sex<span>*</span></label><br>
                                        <input type="radio" name="sex" value="Male" @if(!isset($data)) checked @endif  @if($data ?? '') @if($data->sex=='Male')checked @endif @endif> Male
                                        <input type="radio" name="sex" value="Female" @if($data ?? '') @if($data->sex=='Female')checked @endif @endif> Female
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Picture<span>*</span></label><br>
                                        <input type="file" id="ethnicity" name="picture">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    @if($data ?? '')
                                        <img src="/upload/{{$data->picture}}" style="width: 100px">
                                    @endif
                                </div>

                                <div class="col-md-4 us">
                                    <div class="form-group">
                                        <label for="examplePassword">ID</label><br>
                                        <input type="file" id="driverLicense" name="driverLicense">
                                        <br>
                                        @if($data ?? '')
                                            <img src="/upload/{{$data->driverLicense}}" style="width: 100px">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 notus">
                                    <div class="form-group">
                                        <label for="examplePassword">Passport</label><br>
                                        <input type="file" id="passport" name="passport">
                                        <br>
                                        @if($data ?? '')
                                            <img src="/upload/{{$data->passport}}" style="width: 100px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Phone Number</label>
                                        <input type="text" class="form-control" id="phoneNo" name="phoneNumber" value="@if($data ?? ''){{$data->phoneNumber}}@endif" required>
                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Guest Start Date</label>
                                        <input type="text" class="form-control customdate" id="startingDate" name="startingDate" value="@if($data ?? ''){{$data->startingDate}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Duration</label>
                                        <input type="text" class="form-control" id="duration" name="duration" value="@if($data ?? ''){{$data->duration}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="checkbox" id="documentList" name="documentList" value="1" @if($data ?? '')@if($data->documentList==1) checked @endif @endif > &nbsp;&nbsp;&nbsp;Show
                                        and allow to read related documents.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="checkbox" id="history" name="history" value="1" @if($data ?? '')@if($data->history==1) checked @endif @endif > &nbsp;&nbsp;&nbsp;Show and allow to
                                        read the history of this owner and any incident
                                        and other actions.
                                    </div>
                                </div>
                            </div>

                            <input type="submit" class="btn btn-primary d-block" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.customdate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

        function getresident(id) {
            $.get("/get-residents/" + id, function (res) {
                $("#residentId").html(res);
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


    <script>
        function iscompany(type) {
            if (type == 1) {
                $(".group_individual").hide();
                $(".group_company").show();
            } else {
                $(".group_individual").show();
                $(".group_company").hide();
            }
        }
        function getfloor(building) {
            $.get('/getfloor/' + building, function (res) {
                $("#floorNumber").html(res);
            })
        }
    </script>
    <script>


        function gettype() {
            var datatype = $('#selecttype').find(":selected").text();

            if (datatype == "Multi Dwelling") {
                $(".house_related").hide();
                $(".apartment_related").show();

                $(".house_related").find('input').prop('required',false);
                $(".apartment_related").find('input').prop('required',true);
                $(".house_related").find('select').prop('required',false);
                $(".apartment_related").find('select').prop('required',true);
            } else {
                $(".house_related").show();
                $(".apartment_related").hide();

                $(".apartment_related").find('input').prop('required',false);
                $(".house_related").find('input').prop('required',true);
                $(".apartment_related").find('select').prop('required',false);
                $(".house_related").find('select').prop('required',true);
            }
        }
    </script>
    @include('admin.includes.validate');

@endsection

