@extends('admin.layouts.master')
@section('title', 'Owner')
@section('content')

    <style>
        @if(isset($data))
            @if($data->isCompany=='0')
                .group_company {
                    display: none;
                }
            @else
                .group_individual, {
                    display: none;
                }
            @endif
        @else
            .notus, .group_company{
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('owner.index')}}">Owner</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('owner.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>@if($data ?? '') Update @else Add @endif Owner</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <form id="admin-form" class="main-form" method="post" action="{{route('owner.store')}}" enctype="multipart/form-data">
                            @csrf
                            @if($data ?? '')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                            @endif
                            <input type="hidden" name="ref" value="{{ $ref }}">
                            <div class="group_text">
                                <h2>Property Information </h2>
                                <p>Selecting which property the owner owns.</p>
                            </div>
                            <div class="row">
                                @if($setting['is_subassociations']=="1")
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Select Sub-Association</label>
                                            <select class="form-control" id="associationId" name="associationId" onchange="getbuilding(this.value)">
                                                <option value="">--Choose--</option>
                                                @foreach($subasso as $s)
                                                    <option value="{{$s->id}}" @if($data ?? '') @if($data->associationId==$s->id)selected @endif @endif>{{$s->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-8">
                                    <div class="form-group" id="building" style="display: none">
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
                                    <div class="form-group">
                                        <label for="examplePassword">Property<span>*</span></label>
                                        <select type="text" class="form-control" id="propertyId" name="propertyId" required onchange="gettype()">
                                            <option value="">--Choose--</option>
                                            @if($setting['is_subassociations']=="0" || isset($data))
                                                @foreach($property as $p)
                                                    <option value="{{$p->id}}" type="{{$p->type}}" @if($data ?? '') @if($data->propertyId==$p->id) selected @endif @endif>{{$p->type}}/{{$p->building}}
                                                        /{{$p->aptNumber}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>



                                </div>
                                <div class="col-md-8">
                                    <div class="group_text">
                                        <h2>Owner Basic Information </h2>
                                    </div>
                                    <div class="form-group" style="padding-top: 35px">
                                        <label>Individual/Company<span>*</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="isCompany" name="isCompany" onclick="iscompany(this.value)" value="0" @if(!isset($data)) checked
                                               @endif  @if($data ?? '') @if($data->isCompany=='0')checked @endif @endif> Individual
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="isCompany" name="isCompany" onclick="iscompany(this.value)" value="1" @if($data ?? '') @if($data->isCompany=='1')checked @endif @endif>
                                        Company &nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 group_individual">
                                    <div class="form-group">
                                        <label for="examplePassword">First Name<span>*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" @if($data ?? '')value="{{$data->firstName}}" @if($data->isCompany==0) required
                                               @endif  @else required @endif>
                                    </div>
                                </div>
                                <div class="col-md-4 group_individual">
                                    <div class="form-group ">
                                        <label for="examplePassword">Middle Name</label>
                                        <input type="text" class="form-control" id="middleName" name="middleName" @if($data ?? '') value="{{$data->middleName}}" @endif >
                                    </div>
                                </div>
                                <div class="col-md-4 group_individual">
                                    <div class="form-group">
                                        <label for="examplePassword">Last Name<span>*</span></label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" @if($data ?? '') value="{{$data->lastName}}" @if($data->isCompany==0) required
                                               @endif @else required @endif>
                                    </div>
                                </div>
                                <div class="col-md-8 group_company">
                                    <div class="form-group">
                                        <label for="examplePassword">Company Legal Name<span>*</span></label>
                                        <input type="text" class="form-control" id="companyLegalName" name="companyLegalName" @if($data ?? '') value="{{$data->companyLegalName}}"
                                               @if($data->isCompany==1) required @endif @endif>
                                    </div>
                                </div>
                                <div class="col-md-8 group_company">
                                    <div class="form-group">
                                        <label for="examplePassword">Incorporation</label>
                                        <select type="text" class="form-control" id="inCorporation" name="inCorporation" @if($data ?? '') @if($data->isCompany==1) required @endif @endif>
                                            <option value="">--Choose--</option>
                                            <option value="State" @if($data ?? '')@if($data->inCorporation=='State') selected @endif @endif>State</option>
                                            <option value="Country" @if($data ?? '')@if($data->inCorporation=='Country') selected @endif @endif>Country</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 group_company">
                                    <div class="form-group">
                                        <label for="examplePassword">EIN Number<span>*</span></label>
                                        <input type="text" class="form-control" id="einNumber" name="einNumber" @if($data ?? '') value="{{$data->einNumber}}"
                                               @if($data->isCompany==1) required @endif @endif>
                                    </div>
                                </div>
                                <div class="col-md-8 group_company">
                                    <div class="form-group">
                                        <label for="examplePassword">Contact Person</label>
                                        <input type="text" class="form-control" id="contactPerson" name="contactPerson" @if($data ?? '')value="{{$data->contactPerson}}"
                                               @if($data->isCompany==1) required @endif @endif>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Phone Number<span>*</span></label>
                                        <input type="text" class="form-control" id="phoneNo" name="phoneNumber" value="@if($data ?? ''){{$data->phoneNumber}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Email Id<span>*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="@if($data ?? ''){{$data->email}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">WhatsApp Number</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="@if($data ?? ''){{$data->whatsapp}}@endif">
                                    </div>
                                </div>


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
                                        <label for="examplePassword">Occupation<span>*</span></label>
                                        <input type="text" class="form-control" id="occupation" name="occupation" value="@if($data ?? ''){{$data->occupation}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePassword">Picture<span>*</span></label><br>
                                        <input type="file" id="ethnicity" name="picture">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @if($data ?? '')
                                        <img src="/upload/{{$data->picture}}" style="width: 100%">
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="padding-top: 35px">

                                        <input type="radio" id="if_us_citizen" name="if_us_citizen" onclick="isus(this.value)" value="1"
                                               @if(!isset($data)) checked @else   @if($data ?? '')   @if($data->if_us_citizen=='1')checked @endif @endif @endif>
                                        USA Citizen &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="if_us_citizen" name="if_us_citizen" onclick="isus(this.value)" value="2"
                                               @if($data ?? '') @if($data->if_us_citizen=='2')checked @endif @endif > USA Resident
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" id="if_us_citizen" name="if_us_citizen" onclick="isus(this.value)" value="3"
                                               @if($data ?? '') @if($data->if_us_citizen=='3')checked @endif @endif > USA Tourist
                                        &nbsp;&nbsp;&nbsp;&nbsp;

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ssn">
                                    <div class="form-group">
                                        <label for="examplePassword">Social Security Number<span>*</span></label>
                                        <input type="text" class="form-control" id="socialSecurityNumber" name="socialSecurityNumber" value="@if($data ?? ''){{$data->socialSecurityNumber}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4 dl">
                                    <div class="form-group">
                                        <label for="examplePassword">Driver License</label><br>
                                        <input type="file" id="driverLicense" name="driverLicense">
                                        <br>
                                        @if($data ?? '')
                                            <img src="/upload/{{$data->driverLicense}}" style="width: 100px">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 notus">
                                    <div class="form-group">
                                        <label for="examplePassword">Country of Origin<span>*</span></label>
                                        <input type="text" class="form-control" id="countryofResidence" name="countryofResidence" value="@if($data ?? ''){{$data->countryofResidence}}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4 notus">
                                    <div class="form-group">
                                        <label for="examplePassword">US Visa</label><br>
                                        <input type="file" id="usVisa" name="usVisa">
                                        <br>
                                        @if($data ?? '')
                                            <img src="/upload/{{$data->usVisa}}" style="width: 100px">
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
                                        <label for="examplePassword">Ownership Start Date<span>*</span></label><br>
                                        <input type="date" class="form-control" id="ownershipStartDate" name="ownershipStartDate" value="@if($data ?? ''){{$data->ownershipStartDate}}@endif">
                                    </div>
                                </div>


                            </div>
                            <div class="group_text">
                                <h2>Legal Address </h2>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Address Line 1<span>*</span></label>
                                        <input type="text" class="form-control" id="mailingAddress1" name="mailingAddress1" value="@if($data ?? ''){{$data->mailingAddress1}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleEmail">Address Line 2 </label>
                                        <input type="text" class="form-control" id="mailingAddress2" name="mailingAddress2" value="@if($data ?? ''){{$data->mailingAddress2}}@endif">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">City<span>*</span></label>
                                        <input type="text" class="form-control" id="city" name="city" value="@if($data ?? ''){{$data->city}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">State<span>*</span></label>
                                        <input type="text" class="form-control" id="state" name="state" value="@if($data ?? ''){{$data->state}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Country<span>*</span></label>
                                        <input type="text" class="form-control" id="country" name="country" value="@if($data ?? ''){{$data->country}}@endif" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePassword">Zip<span>*</span></label>
                                        <input type="text" class="form-control" id="zip" name="zip" value="@if($data ?? ''){{$data->zip}}@endif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="group_text">
                                <h2>Documents Table</h2>
                                <p>Must be uploaded to activate owner – Based on the application process requirements.</p>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="float: right;margin-bottom: 10px">Upload New Document</button>
                                    <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                        <thead>
                                        <tr>
                                            <th>Document</th>
                                            <th>Upload Date</th>
                                            <th>Upload By</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">

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
                            <label for="exampleEmail">Document Name</label>
                            <select class="form-control" id="documentName" name="documentName">
                                <option value="Application">Application</option>
                                <option value="Board of Directors Approval">Board of Directors Approval</option>
                                <option value="Background check">Background check</option>
                                <option value="Property Ownership Proof">Property Ownership Proof</option>
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
                        <div class="form-group">
                            <label for="exampleEmail">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
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
        $(document).ready(function () {
            $('#data-table').DataTable();
            uploaddoc();
        });
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });


        function uploaddoc() {
            $.get('/uploaddoc/{{$ref}}', function (res) {
                $("#tbody").html(res);
            })
        }

        function getbuilding(association) {
            $.get('/getbuilding/' + association, function (res) {
                $("#buildingId").html(res);
            })
            $.get('/getproperty/' + association, function (res) {
                $("#propertyId").html(res);
            })
        }


    </script>
    <style>
        label span {
            color: #FF0000;
        }

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
        function submitform() {
            var description = $("#description").val();
            var uploadedBy = $("#uploadedBy").val();
            var ref = $("#ref").val();
            console.log(ref);
            var documents = $("#documents").val();
            var documentName = $("#documentName").val();


            var formData = new FormData();
            formData.append('documents', $('#documents')[0].files[0]);
            formData.append('description', description);
            formData.append('ref', ref);
            formData.append('uploadedBy', uploadedBy);
            formData.append('documentName', documentName);
            formData.append('_token', "{{csrf_token()}}");

            $.ajax({
                url: '/uploadownerdocument',
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

        function iscompany(type) {
            if (type == 1) {
                $(".group_individual").hide();
                $(".group_company").show();

                $(".group_individual").find('input').prop('required', false);
                $(".group_company").find('input').prop('required', true);
                $(".group_individual").find('select').prop('required', false);
                $(".group_company").find('select').prop('required', true);

            } else {
                $(".group_individual").show();
                $(".group_company").hide();

                $(".group_company").find('input').prop('required', false);
                $(".group_individual").find('select').prop('required', true);
                $(".group_company").find('select').prop('required', false);

            }
            $(".middleName").prop('required', false);
        }

        @if($data ?? '')
        gettype();
        isus({{$data->if_us_citizen}})

        @endif
        function gettype() {
            var type = $("#propertyId  option:selected").attr('type');
            if (type == "Multi Dwelling") {
                $("#building").show();
            } else {
                $("#building").hide();
            }
        }

        function isus(type) {
            console.log(type);
            if (type == 1) {
                $(".ssn").show();
                $(".dl").show();
                $(".notus").hide();
            } else if (type == 2) {
                $(".ssn").show();
                $(".dl").hide();
                $(".notus").show();

            } else {
                $(".ssn").hide();
                $(".dl").hide();
                $(".notus").show();
            }


        }

    </script>



@endsection

