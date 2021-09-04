@extends('admin.layouts.master')
@section('title', 'Fines')
@section('content')

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
                        @include('admin.includes.msg')
                            <table id="data-table" class="table-responsive table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S.No.</th>
                                    <th>Date</th>
                                    <th>Property</th>
                                    <th>Individual</th>
                                    <th>Incident</th>
                                    <th>Fine Amount</th>
                                    <th>Police</th>
                                    <th>Fine</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($alldata) &&  $alldata->count()>0)
                                    @foreach($alldata as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1">{{$key+1}}</td>
                                            <td>{{$val->dateTime}}</td>

                                            <td>{{ $property[$val->propertyId]->building}}  {{$allassociation[$property[$val->propertyId]->associationId]}} - @if($property[$val->propertyId]->type=="Multi Dwelling")  {{ $property[$val->propertyId]->aptNumber}} @else {{ $property[$val->propertyId]->address1}}  @endif</td>
                                            <td>{{$val->ind}}</td>
                                            <td>{{$val->incidentTitle}}</td>
                                            <td>
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
                                                        <a class="dropdown-item" href="/fines/{{$val->edit_id}}/edit">Incident Report</a>
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

