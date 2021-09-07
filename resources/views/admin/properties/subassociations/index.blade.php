@extends('admin.layouts.master')
@section('title', 'Sub Association')
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
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('sub-association.index')}}">Sub Association</a></li>
                    </ol>

                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Sub Association List</h6>
                        <form action="" method="get" style="position: absolute;left: 215px;top: 20px">
                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Active</option>
                                <option value="2" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==2)selected @endif>Disabled</option>
                                <option value="3" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==3)selected @endif>Both</option>
                            </select>
                        </form>
                        <a href="{{route('sub-association.create')}}" class="ms-text-primary">Add Sub Association </a>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                            <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th style="min-width: 150px">Association Name</th>
                                    <th style="min-width: 150px">Phone Number</th>
                                    <th>Email</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td class="text-flow">{{$val->name}}</td>
                                            <td class="text-flow">{{$val->phoneNo}}</td>
                                            <td>{{$val->email}}</td>
                                            <td>@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                <a href="/sub-association/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
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
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
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

