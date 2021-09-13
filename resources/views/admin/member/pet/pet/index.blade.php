@extends('admin.layouts.master')
@section('title', 'Pets')
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
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('pet.index')}}">Pets</a></li>
                    </ol>

                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <div class="col-2"><h6>Pets</h6></div>
                        <div class="col-6" style="margin-top: -2px !important;">
                            <form action="" method="get">
                                <select name="status" style="width: 100%" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="0" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==0)selected @endif>In Process</option>
                                    <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Approved</option>
                                    <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Disabled</option>
                                    <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>All</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-4">
                            <a style="float: right" href="{{route('pet.create')}}" class="ms-text-primary">Add Pet </a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                        <div class="table-responsive">
                            <table class="table table-striped thead-primary w-100" id="data-table">
                                <thead>
                                    <tr role="row">
                                        <th style="width: 20px !important; max-width: 20px !important;">S.No.</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Images</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Pet Name</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Pet Type</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Pet Breed</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Property</th>
                                        <th style="min-width: 220px !important; width: 100px !important;">Owner</th>
                                        <th class="no-sort" style="width: 20px !important; max-width: 20px !important;">Status</th>
                                        <th class="no-sort" style="width: 50px !important; max-width: 50px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td class="text-flow"><img src="/thumb/{{$val->image}}" style="border-radius:0; height:100px; width:100px; object-fit: cover; max-width:200px"></td>
                                            <td class="text-flow">{{$val->petName}}</td>
                                            <td class="text-flow">{{$pettype[$val->pettypeId]}}</td>
                                            <td class="text-flow">{{$val->breedAndDesc}}</td>
                                            <td class="text-flow">{{$property[$val->propertyId]}}</td>
                                            <td class="text-flow">{{$owner[$val->ownerId]}}</td>
                                            <td>@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@elseif($val->status==0) <i class="fas fa-dot-circle dot-yellow"></i>@else <i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                <a href="/pet/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
                                                {{--<form action="{{ route('sub-association.destroy',$val->id) }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="trans-btn" onclick=" return confirm('Are you sure to delete this Sub Association !!')"><i class="far fa-trash-alt ms-text-danger"></i></button>
                                                </form>--}}
                                                {{--<a href="#"><i class=""></i></a>--}}
                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @if($val->status==0 || $val->status==2)
                                                        <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="getapprove({{$val->id}})">Approve</a>
                                                        @endif

                                                            @if($val->status==0 || $val->status==1)
                                                        <a class="dropdown-item" href="/pet-declined/{{$val->id}}" >Denied</a>
                                                        @endif
                                                        <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="getdetails({{$val->id}})">Details</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable({
                targets: 'no-sort',
                orderable: false
            });
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pet Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-details">

                </div>

            </div>
        </div>
    </div>
    <script>
        function getdetails(id) {
            $.get("/pet/" + id, function (res) {
                $("#modal-details").html(res);
            })
        }
        function getapprove(id) {
            $.get("/approve-pet-entry/" + id, function (res) {
                $("#modal-details").html(res);
            })
        }
    </script>
@endsection

