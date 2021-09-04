@extends('admin.layouts.master')
@section('title', 'Facilities Type')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Setting</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="{{route('facilities-type.index')}}">Facilities Type</a></li>
                    </ol>

                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Facilities Type</h6>
                        <a href="{{route('facilities-type.create')}}" class="ms-text-primary">New Facilities Type</a>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')
                            <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th>Facility Type</th>
                                    <th>Term</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td>{{$val->typeName}}</td>
                                            <td>{{$val->termType}}</td>
                                            <td>
                                                @if($val->isHourly==1) ${{$val->HourlyPrice}}/Hourly  @endif
                                                @if($val->isDaily==1)  ${{$val->DailyPrice}}/Daily @endif
                                                @if($val->isWeekly==1) ${{$val->WeeklyPrice}}/Weekly  @endif
                                                @if($val->isMonthly==1) ${{$val->MonthlyPrice}}/Monthly  @endif
                                                @if($val->isYearly==1) ${{$val->YearlyPrice}}/Yearly @endif </p>

                                            </td>

                                            <td>@if($val->status=='1')<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
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
                                                        <a class="dropdown-item" href="/facilities-type/{{$val->edit_id}}/edit">Edit</a>
                                                        @if($val->status==0)
                                                            <a class="dropdown-item" href="/facilitiestype-status/{{$val->edit_id}}">Enabled</a>
                                                        @else
                                                            <a class="dropdown-item" href="/facilitiestype-status/{{$val->edit_id}}">Disabled</a>
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

