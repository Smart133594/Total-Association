@extends('admin.layouts.master')
@section('title', 'Fines')
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
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Fines and Violations</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('fines.index')}}">Fines</a></li>
                    </ol>

                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Fines</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-md-3" style="margin: 1%">
                                <form action="" method="get">
                                    <select name="police" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">All</option>
                                        <option value="0" @if(isset($_GET['police']) && $_GET['police'] == '0')selected @endif>Police</option>
                                        <option value="1" @if(isset($_GET['police']) && $_GET['police'] == '1')selected @endif>No Police</option>
                                    </select>
                                    <input type="hidden" name="filter_date" @if (isset($_GET['filter_date'])) value="{{$_GET['filter_date']}}" @endif />
                                </form>
                            </div>
                            <div class="col-md-3" style="margin: 1%">
                                <form action="" method="get">
                                    <input type="date" class="form-control" name="filter_date" onchange="this.form.submit()" @if (isset($_GET['filter_date'])) value="{{$_GET['filter_date']}}" @endif/>
                                    <input type="hidden" name="police" @if (isset($_GET['police'])) value="{{$_GET['police']}}" @endif >
                                </form>
                            </div>
                        </div>
                        @include('admin.includes.msg')
                        <div class="table-responsive">
                            <table id="data-table" class=" table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th style="max-width: 30px; width: 30px;">S.No.</th>
                                    <th style="max-width: 120px; width: 120px;">Date</th>
                                    <th style="max-width: 200px; width: 200px;">Property</th>
                                    <th style="max-width: 100px; width: 150px;">Individual</th>
                                    <th style="max-width: 100px; width: 150px;">Incident</th>
                                    <th style="max-width: 100px; width: 100px;">Fine Amount</th>
                                    <th style="max-width: 30px; width: 30px;">Police</th>
                                    <th style="max-width: 30px; width: 30px;">Fine</th>
                                    <th style="max-width: 30px; width: 30px;" class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td class="text-flow">{{$val->dateTime}}</td>

                                            <td class="text-flow">{{ $property[$val->propertyId]->building}}  {{$allassociation[$property[$val->propertyId]->associationId]}} - @if($property[$val->propertyId]->type=="Multi Dwelling")  {{ $property[$val->propertyId]->aptNumber}} @else {{ $property[$val->propertyId]->address1}}  @endif</td>
                                            <td class="text-flow">{{$val->ind}}</td>
                                            <td class="text-flow">{{$val->incidentTitle}}</td>
                                            <td class="text-flow">
                                                @if($val->new_fine_amount>0)
                                                    ${{$val->new_fine_amount}}
                                                @else
                                                    ${{$val->fine_amount}}
                                                @endif
                                            </td>

                                            <td>@if($val->policeInvolved==1)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td>@if($val->outcome=='Fine')<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                {{--                                                <a href="/incident/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>--}}
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
                                                        <a class="dropdown-item" href="/incident/create">Incident Info</a>
                                                        <a class="dropdown-item" href="/fines/{{$val->edit_id}}/edit">Fine Info</a>
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

