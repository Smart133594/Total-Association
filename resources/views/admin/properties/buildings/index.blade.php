@extends('admin.layouts.master')
@section('title', 'Building')
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Condominium</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('buildings.index')}}">Building</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Buildings List</h6>

                        <a href="{{route('buildings.create')}}" class="ms-text-primary">Add Building </a>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-md-3" style="margin-bottom: 1%;">
                                <form action="" method="get">
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">Both</option>
                                        <option value="1" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==1)selected @endif>Active</option>
                                        <option value="0" @if(isset($_GET['status']) && !empty($_GET['status'])  && $_GET['status']==0)selected @endif>Disabled</option>
                                    </select>
                                </form>
                            </div>

                            <div class="col-md-3">
                                <form action="" method="get">
                                    <select name="association" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">--choose association--</option>
                                        @foreach($filter['association'] as $f)
                                            <option value="{{$f->id}}"
                                                    @if(isset($_GET['association']) && !empty($_GET['association'])  && $_GET['association']==$f->id) selected @endif>{{$f->name}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        @include('admin.includes.msg')
                        <div class="table-responsive">
                            <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th style="min-width: 100px">Building</th>
                                    <th style="min-width: 100px">Address</th>
                                    <th style="min-width: 100px">No of Floors</th>
                                    <th style="min-width: 100px">13th Floor</th>
                                    <th class="no-sort">Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td class="text-flow">{{$val->building}} {{$allassociation[$val->associationId]}}</td>
                                            <td class="text-flow">{!! $val->address !!}</td>
                                            <td class="text-flow">{{$val->noOfFloors}}</td>
                                            <td class="text-flow">@if($val->is13==1) Yes @elseif($val->is13==null) NA @else No @endif</td>
                                            <td>@if($val->status==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                <a href="/buildings/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
                                                {{--<form action="{{ route('master-association.destroy',$val->id) }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="trans-btn" onclick=" return confirm('Are you sure to delete this Building !!')"><i class="far fa-trash-alt ms-text-danger"></i></button>
                                                </form>--}}
                                                {{--<a href="#"><i class=""></i></a>--}}
                                                <div class="dropdown">
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

