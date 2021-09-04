@extends('admin.layouts.master')
@section('title', 'Application')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Properties and Residents</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Application</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application.index')}}">Background Checks</a></li>

                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Application List</h6>
                        <form action="" method="get" style="position: absolute;left: 175px;top: 20px">
                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>In Process</option>
                                <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Expired</option>
                                <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>Denied</option>
                                <option value="4" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==4)selected @endif>Approved</option>
                                <option value="5" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==5)selected @endif>All</option>
                            </select>
                        </form>

                        <a href="{{route('application.create')}}" class="ms-text-primary">New Application</a>

                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                            <table id="data-table" class="table-responsive table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th>Type</th>

                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Paid</th>
                                    <th>BG</th>
                                    <th class="no-sort">Approval</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td>{{$val->applicationType}}</td>

                                            <td>{{$val->firstName}} {{$val->middleName}} {{$val->lastName}}</td>
                                            <td>{{$val->phoneNo}}</td>
                                            <td>{{$val->email}}</td>
                                            <td>@if($val->paymentStatus==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td>@if($val->background_check==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>

                                            <td>@if($val->status==4)
                                                    <i class="fas fa-dot-circle dot-green"></i>
                                                @elseif($val->status==2)
                                                    <i class="fas fa-dot-circle dot-red"></i>
                                                @elseif($val->status==3)
                                                    <i class="fas fa-dot-circle dot-red"></i>
                                                @else
                                                    <i class="fas fa-dot-circle dot-yellow"></i>
                                                @endif
                                            </td>

                                            <td class="action">

                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="getdetails({{$val->id}})">View Details</a>
                                                        @if($val->status==1)
                                                            <a class="dropdown-item" href="/applicationapproval/{{$val->id}}/4"
                                                               onclick="return confirm('Are you sure to Approved this Application !!')">Approved</a>
                                                            <a class="dropdown-item" href="/applicationapproval/{{$val->id}}/3" onclick="return confirm('Are you sure to Denied this Application !!')">Denied</a>
                                                        @endif
                                                        @if($val->status==3 || $val->status==2)
                                                            <a class="dropdown-item" href="/applicationapproval/{{$val->id}}/1"
                                                               onclick="return confirm('Are you sure to Reactivate this Application !!')">Reactivate</a>
                                                        @endif
                                                        <a class="dropdown-item" href="/application-resent/{{$val->id}}" onclick="return confirm('Are you want to Resend Email !!')">Resend Email</a>
                                                        @if($val->paymentStatus==0)
                                                            <a class="dropdown-item" href="/application-assignpayment/{{$val->id}}" onclick="return confirm('Are you want to Assign Payment !!')">Assign
                                                                Payment</a>
                                                        @endif
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
    <script>
        $(document).ready(function () {
            $('#data-table').DataTable({
                targets: 'no-sort',
                orderable: false
            });
        });

        function getdetails(id) {
            $.get("/getapplication-details/" + id, function (res) {
                $("#modal-details").html(res);
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
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Application Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-details">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
