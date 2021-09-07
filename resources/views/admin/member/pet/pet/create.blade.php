@extends('admin.layouts.master')
@section('title', 'Pet')
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
        width: 100px; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Pets</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('pet.index')}}">Pets</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('pet.create')}}">@if($data ?? '') Update @else Add @endif</a></li>
                    </ol>
                </nav>
                <form id="admin-form" method="post" action="{{route('pet.store')}}" enctype="multipart/form-data">
                    <div class="ms-panel">
                        <div class="row" style="width: 100%">
                            <div class="col">
                                <div class="ms-panel-header ms-panel-custome">
                                    <div class="group_text">
                                        <h2>Pet Information</h2>
                                        <p>Please enter the information about the pet</p>
                                    </div>
                                </div>
                                <div class="ms-panel-body">
                                    <div class="form-group">
                                        <label for="exampleEmail">Pet Name</label>
                                        <input type="text" class="form-control" id="petName" name="petName" value="@if($data ?? ''){{$data->petName}}@endif" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="examplePassword">Type</label>
                                        <select type="text" class="form-control" id="pettypeId" name="pettypeId" onchange="getvaccin(this.value,'{{$ref}}')" required>
                                            <option value="">--Choose--</option>
    
                                            @foreach($pettype as $p)
                                                <option value="{{$p->id}}" @if($data ?? '') @if($data->pettypeId==$p->id) selected @endif @endif>{{$p->petType}}</option>
                                            @endforeach
    
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="examplePassword">Breed And Description</label>
                                        <input type="text" class="form-control" id="breedAndDesc" name="breedAndDesc" value="@if($data ?? ''){{$data->breedAndDesc}}@endif" required>
                                    </div>
                                    @if($data ?? '')
                                        <div class="col-md-4">
                                            <img src="/upload/{{$data->image}}" style="width: 100%">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleEmail">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="col" >
                            <div class="ms-panel-header ms-panel-custome">
                                <div class="group_text">
                                    <h2>Pet’s Owner</h2>
                                    <p>Please Select the Pet’s Owner from the building’s residents.</p>
                                </div>
                            </div>
                            <div class="ms-panel-body" >
                                @include('admin.includes.msg')
                                @csrf
                                @if($data ?? '')
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                @endif
                                <input type="hidden" value="{{$ref}}" name="pet_ref">
                                <div class="form-group">
                                    <label for="examplePassword">Property</label>
                                    <select type="text" class="form-control" id="propertyId" name="propertyId" onchange="propertycheck(this.value)" required>
                                        <option value="">--Choose--</option>

                                        @foreach($property as $p)
                                            <option value="{{$p->id}}" @if($data ?? '') @if($data->propertyId==$p->id) selected @endif @endif>{{$p->id}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="examplePassword">Owner</label>
                                    <select type="text" class="form-control" id="ownerId" name="ownerId" required>
                                        <option value="">--Choose--</option>
                                        @if($data ?? '')
                                            @foreach($owner as $p)
                                                <option value="{{$p->id}}" @if($data ?? '') @if($data->ownerId==$p->id) selected @endif @endif>{{$p->firstName}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="ms-panel">
                        <div class="ms-panel-header ms-panel-custome">
                            <div class="group_text">
                                <h2>Pet IDocuments</h2>
                                <p>In florida , the following documents must be obtained by law in order to legally own a pet. Make sure you review and upload such documents.</p>
                            </div>
                        </div>
                        <div class="ms-panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @php $docc=json_decode($setting['pet_documents'],true);
                                    $documents_description=json_decode($setting['documents_description'],true);
                                    $documents_required_by_law=json_decode($setting['documents_required_by_law'],true);
                                    $documents_status=json_decode($setting['documents_status'],true);
                                    @endphp
                                    <div class="table-responsive">
                                    <table class="d-block d-md-table table table-striped thead-primary w-100 dataTable no-footer">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Document</th>
                                            <th style="min-width: 100px">Exp. Date</th>
                                            <th style="min-width: 150px">Required By Law</th>
                                            <th style="min-width: 100px">Doc. Info</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($docc) @php $x=1; @endphp
                                        @foreach($docc as $k=>$va)
                                            @php $class=strtolower(str_replace(" ","-",$va));  @endphp
                                            <tr>
                                                <td class="text-flow">{{$x}}</td>
                                                <td class="text-flow">{{$va}}</td>
                                                <td class="text-flow" class="exp_{{ $class }}"> @if(isset($pet_document[$class]->exp_date)) {{ $pet_document[$class]->exp_date }} @endif</td>
                                                <td class="text-flow">@if(isset($documents_required_by_law[$k])) @if($documents_required_by_law[$k]==1) Yes @else No @endif @endif</td>
                                                {{-- <td><img src="/assets/img/info.png" data-toggle="modal" data-target="#details" onclick="showdetails('{{$documents_description[$k]}}','{{$ref}}')"></td> --}}
                                                <td><img src="/assets/img/info.png" onclick="sweetBasic('{{$documents_description[$k]}}','Details');"></td>
                                                
                                                <td class="text-flow" style='@if($documents_status[$k]=="Current") color:#4caf50 @else color:#f44336  @endif'>{{ $documents_status[$k]  }}</td>

                                                <td class="action">

                                                    <div class="dropdown show">
                                                        <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-th"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="uploaddoc('{{$class}}')">Upload
                                                                Documents</a>
                                                            <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#details" onclick="showdocuments('{{$class}}','{{$ref}}')">Show
                                                                Documents</a>


                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            @php $x++; @endphp
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ms-panel">
                        <div class="ms-panel-header ms-panel-custome">
                            <div class="group_text">
                                <h2>Pet Vaccinations</h2>
                                <p>In florida , the following Vaccinations must be administered by law to all pets. Make sure you review and upload The vaccine documents.</p>
                            </div>
                        </div>
                        <div class="ms-panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                        <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Vaccination</th>
                                            <th>Exp. Date</th>
                                            <th>Required By Law</th>
                                            <th>Vaccination. Info</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="vdetails">

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="ms-panel">
                        <div class="ms-panel-header ms-panel-custome">
                            <div class="group_text">
                                <h2>Support / Service Animal</h2>
                                <p>Florida's laws prohibit housing providers from discriminating against tenants with a need for an emotional support animal. ESA owners are allowed to
                                    live with their animal companions as “reasonable accommodation”, even in buildings that generally prohibit pets. in order to be clasified a service
                                    animal, the following documents must be obtained by the owber</p>
                            </div>
                        </div>
                        <div class="ms-panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox" id="supportAnimal" value="1" name="supportAnimal" @if($data ?? '') @if($data->supportAnimal==1) checked
                                                @endif @endif  onclick="toggledocx()">
                                        <label for="examplePassword" for="supportAnimal">Support Animal</label>
                                    </div>
                                </div>
                                <div class="col-md-12 supportAnimal" @if($data ?? '') @if($data->supportAnimal==1) style="display:block" @endif @endif >

                                    @php $docc=json_decode($setting['pet_support_documents'],true); @endphp
                                    @php $support_description=json_decode($setting['support_description'],true); @endphp
                                    @php $support_required_by_law=json_decode($setting['support_required_by_law'],true); @endphp
                                    @php $documents_support_status=json_decode($setting['documents_support_status'],true); @endphp
                                    <div class="table-responsive">
                                    <table class="table table-striped thead-primary w-100 dataTable no-footer">
                                        <thead>
                                        <tr>
                                            <th>S. No</th>
                                            <th>Document</th>
                                            <th>Exp. Date</th>
                                            <th>Required By Law</th>
                                            <th>Doc. Info</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($docc) @php $x=1; @endphp
                                        @foreach($docc as $k=>$va)
                                            @php $class=strtolower(str_replace(" ","-",$va));  @endphp
                                            <tr>
                                                <td>{{$x}}</td>
                                                <td>{{$va}}</td>
                                                <td class="exp_{{ $class }}"> @if(isset($pet_document[$class]->exp_date)) {{ $pet_document[$class]->exp_date }} @endif</td>
                                                <td>@if(isset($support_required_by_law[$k])) @if($support_required_by_law[$k]==1) Yes @else No @endif @endif</td>
                                                {{-- <td><img src="/assets/img/info.png" data-toggle="modal" data-target="#details" onclick="showdetails('{{$support_description[$k]}}','{{$ref}}')"></td> --}}
                                                <td><img src="/assets/img/info.png" onclick="sweetBasic('{{$support_description[$k]}}','Details')"></td>
                                                <td style='@if($documents_support_status[$k]=="Current") color:#4caf50 @else color:#f44336  @endif'>{{ $documents_support_status[$k]  }}</td>

                                                <td class="action">

                                                    <div class="dropdown show">
                                                        <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="fas fa-th"></i>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="uploaddoc('{{$class}}')">Upload
                                                                Documents</a>
                                                            <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#details" onclick="showdocuments('{{$class}}','{{$ref}}')">Show
                                                                Documents</a>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            @php $x++; @endphp
                                        @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary d-block" value="Save">
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Details </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-details">
                    <form action="/uploaddocument" id="petdocuments" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$ref}}" name="pet_ref" id="pet_ref">
                        <input type="hidden" value="" id="tags" name="tags">
                        <div class="form-group">
                            <label for="exampleEmail">Document</label>
                            <input type="file" class="form-control" id="documents" name="documents">
                        </div>
                        <div class="form-group">
                            <label for="exampleEmail">Expiry Date</label>
                            <input type="date" class="form-control" name="exp_date" id="exp_date">
                        </div>


                    </form>
                    <input type="button" value="Upload" class="btn btn-success" onclick="submitform()">
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Details </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-details-pet">

                </div>

            </div>
        </div>
    </div>

    <script>

        function sweetBasic(description, title) {
            Swal.fire(title, description);
        }

        function submitform() {
            var tags = $("#tags").val();
            var pet_ref = $("#pet_ref").val();
            var documents = $("#documents").val();
            var exp_date = $("#exp_date").val();
            var required_by_law = $('input[name=required_by_law]:checked', '#petdocuments').val();

            var formData = new FormData();
            formData.append('documents', $('#documents')[0].files[0]);
            formData.append('tags', tags);
            formData.append('pet_ref',pet_ref);
            formData.append('exp_date', exp_date);
            formData.append('_token', "{{csrf_token()}}");

            $.ajax({
                url : '/uploaddocument',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {
                    console.log(data);
                    $('.exp_'+tags).html(data.exp_date);
                    $('#exampleModal').modal('toggle');

                }
            });


        }

        function toggledocx() {
            $(".supportAnimal").toggle();
        }

        function uploaddoc(tags) {
            $("#tags").val(tags);
        }
        function showdetails(tags,pet_ref){

                $("#modal-details-pet").html(tags);

        }
        function showdocuments(tags,pet_ref){
            $.get("/pet-showdetails/"+tags+"/"+pet_ref,function(res){
                $("#modal-details-pet").html(res);
            })
        }

        function getvaccin(type,pet_ref){
            $.get("/getvaccination/"+type+"/"+pet_ref,function(res){
                $("#vdetails").html(res);
            })
        }
        @if($data ?? '')
        $(document).ready(function () {
            var type=$('#pettypeId').val();
            getvaccin(type,{{$ref}});
        });
        @endif

        $(document).ready(function () {
            $('#data-table').DataTable();
        });
        $(document).ready(function () {
            $('.customdate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>
    <script>
        function propertycheck(propertyId) {
            $.get('/gets-owner/' + propertyId, function (res) {

                $("#ownerId").html(res);
            })
        }
    </script>
    <style>
        .supportAnimal {
            display: none;
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
    @include('admin.includes.validate')
@endsection

