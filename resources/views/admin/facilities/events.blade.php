@extends('admin.layouts.master')
@section('title', 'Rental Events List')
@section('content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        @if(request()->is('facilities-event/*'))
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                        @else
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities</a></li>
                            <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Rental Events List</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Rental Events List</h6>

                        @if(request()->is('facilities'))
                            <a href="{{route('facilities.create')}}" class="ms-text-primary">Add Facilities</a>
                            @php $path="facilities"; @endphp
                        @else
                            @php $path="facilities-rental"; @endphp
                        @endif


                    </div>
                    <div class="ms-panel-body">


                        @include('admin.includes.msg')
                        <div class="table-responsive" style="min-height: 300px">
                            <table id="data-table" class="table table-striped thead-primary w-100">
                                <thead>
                                <tr role="row">
                                    <th>S. No</th>
                                    <th>Renter</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($data) &&  $data->count()>0)
                                    @foreach($data as $key=>$val)
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" onclick="goto('/owner/{{ $val->edit_id }}')">{{$key+1}}</td>
                                            <td> {{$val->RentrsName}}</td>
                                            <td>{{$val->fromDate}}</td>
                                            <td>{{$val->toDate}}</td>

                                            <td>@if($val->paymentStatus==1)<i class="fas fa-dot-circle dot-green"></i>@else<i
                                                    class="fas fa-dot-circle dot-red"></i>@endif </td>
                                            <td class="action">
                                                @if(request()->is('facilities'))
                                                    <a href="/facilities/{{ $val->edit_id }}/edit"><i class="fas fa-pencil-alt ms-text-primary"></i></a>
                                                @endif
                                                {{--<form action="{{ route('master-association.destroy',$val->id) }}" method="post">
                                                    {{ method_field('delete') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="trans-btn" onclick=" return confirm('Are you sure to delete this Master Association !!')"><i class="far fa-trash-alt ms-text-danger"></i></button>
                                                </form>--}}
                                                {{--<a href="#"><i class=""></i></a>--}}
                                                <div class="dropdown">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @if(request()->is('facilities-event'))
                                                            <a class="dropdown-item" href="#" onclick="goto('/edit_rent/{{ $val->edit_id }}')">Edit</a>
                                                        @else
                                                            <a class="dropdown-item" href="#" onclick="goto('/edit_the_rent/{{ $val->edit_id }}')">Edit</a>
                                                        @endif
                                                        @if($val->paymentStatus==0)
                                                            <a class="dropdown-item" href="/approve-facility-payments/{{ $val->edit_id }}">Approve Payment </a>
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
    <script>
        function goto(url) {
            window.location.href = url;
        }
    </script>
@endsection

