@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
<style>
    .btn-sm {
        min-width: 0 !important;
    },
    .note-container{
        position: relative;
    }
    .note-action{
        position: absolute;
        bottom: 0;
        right: 0;
    }
    .note-container p{
        padding-right: 40px;
    }
</style>
    <div class="ms-content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Work Log</a></li>
            </ol>
        </nav>
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h2>Work Log</h2>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                <h4 style="margin-left:15px">Administration</h4><br>
                <form class="form   " method="GET" accept="/">
                    @php
                        $status = 0;
                        $employees = 0;
                        $start_date = null;
                        $end_date = null;
                        if(isset($_GET['status'])) $status = $_GET['status'];
                        if(isset($_GET['employees'])) $employees = $_GET['employees'];
                        if(isset($_GET['start_date'])) $start_date = $_GET['start_date'];
                        if(isset($_GET['end_date'])) $end_date = $_GET['end_date'];
                    @endphp
                    <div class="form-group col-md-3 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" onchange="changeOption()">
                            <option value="0" {{ $status == 0 ? 'selected' : '' }}>Active</option>
                            <option value="1" {{ $status == 1 ? 'selected' : '' }}>Archived</option>
                            <option value="2" {{ $status == 2 ? 'selected' : '' }}>Both</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="employees">Employees</label>
                        <select name="employees" id="employees" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start_date }}">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"value="{{ $end_date }}">
                    </div>
                    <div class="form-group col-md-12"></div>
                    <div class="col-md-3 mb-3">
                        <input type="submit" value="Get Work Log" class="btn btn-primary">
                    </div>
                    <!-- <div class="form-group col-md-3 mb-3">
                        <input type="button" value="Add Log" class="btn btn-primary" onclick="openModal()">
                    </div> -->
                </form>
                <div class="col-xl-12 col-md-12">
                    <div class="ms-panel ms-widget ms-panel-fh">
                        <div class="ms-panel-header">
                            <div class="ms-panel-custome mb-3" style="margin-bottom:0px !important">
                                <h5>Logs</h5>
                                <div class="m-0 p-0">
                                    <button class="btn btn-primary btn-sm m-0" onclick="openModal()"  >+</button>
                                    {{-- <button class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#time_sheet">Export Time Sheet</button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="ms-panel-body">
                            <table class="table table-striped thead-primary w-100 data-table">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>By</th>
                                    <th style="min-width: 100px">Log</th>
                                    <th style="max-width: 100px">Action</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @foreach ($worklogs as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->date)) }} {{ date('h:i', strtotime($item->from_time)) }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->date)) }} {{ date('h:i', strtotime($item->to_time)) }}</td>
                                            <td>{{$item->Worker->name}}</td>
                                            <td>{{$item->comment}}</td>
                                            <td class="action">
                                                <div class="dropdown show">
                                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <button class="dropdown-item" onclick="openModal({{ $item }})">Edit</button>
                                                        <form action="{{ route('work-log.destroy', $item->id) }}" method="post">
                                                            @method("delete")
                                                            @csrf
                                                            <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to delete this log? ')">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        <tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="log_modal" tabindex="-1" role="dialog" aria-labelledby="log_modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="log_modal_label"> Work Log </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="log_form" enctype="multipart/form-data" action="{{route('work-log.store')}}">
                    @csrf
                    <input type="hidden" name="editid" id="editid">
                    <div class="modal-body row" id="modal-details">
                        <div class="form-group col-md-4">
                            <label for="exampleEmail">Date</label>
                            <select name="date" id="date" class="form-control" required>
                                <option>{{ date('m/d/Y', strtotime('-3 days')) }}</option>
                                <option>{{ date('m/d/Y', strtotime('-2 days')) }}</option>
                                <option>{{ date('m/d/Y', strtotime('-1 days')) }}</option>
                                <option>{{ date('m/d/Y') }}</option>
                            </select>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="form-group col-md-4">
                            <label for="from_time">From Time</label>
                            <input type="time" name="from_time" id="from_time" class="form-control" required>
                            {{-- <select name="from_time" id="from_time" class="form-control">
                                <option value="1">08/19/2021</option>
                            </select> --}}
                        </div>
                        <div class="form-group col-md-4">
                            <label for="to_time">To Time</label>
                            <input type="time" name="to_time" id="to_time" class="form-control" required>
                            {{-- <select name="to_time" id="to_time" class="form-control">
                                <option value="1">1</option>
                                <option value="1">2</option>
                            </select> --}}
                        </div>
                        <div class="col-md-12">
                            <textarea name="comment" id="comment" cols="30" class="form-control" placeholder="Work Performed" style="height:100px" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Save Log" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    const workers = JSON.parse(`<?php echo json_encode($workers)?>`);
    const employees = `{{ $employees }}`;
    $(document).ready(function() {
        changeOption();
        $('.data-table').DataTable();

    });
    $("#log_form").submit(e => {
        var from_time = $("#from_time").val();
        var to_time = $("#to_time").val();
        const from_date = new Date('1/1/1991' + ' ' + from_time);
        const to_date = new Date('1/1/1991' + ' ' + to_time);
        if(to_date.getTime() < from_date.getTime()){
            toastr.warning('Input the valid from time and to time.', 'Warning');
            e.preventDefault();
        }
    });
    function changeOption(){
        const status = $("#status").val();
        const tmp = status == 2 ? workers : workers.filter(item => item.active_state == status) || [];
        var html = ` <option value="0">All</option>`;
        tmp.forEach(ele => {
            html += `<option value="${ele.id}" ${employees == ele.id ? 'selected' : ''}>${ele.firstname} ${ele.middlename} ${ele.lastname}</option>`;
        });
        $("#employees").empty();
        $("#employees").append(html);
    }
    function openModal(data) {
        console.log(data);
        var date = "{{ date('m/d/Y') }}";
        var from_time = null;
        var to_time = null;
        var comment = null;
        var editid = 0;

        if(data){
            var formattedDate = new Date(data.date);
            var d = formattedDate.getDate();
            var m =  formattedDate.getMonth();
            m += 1;
            var y = formattedDate.getFullYear();
            date = `${m < 10 ? '0' : ''}${m}/${d < 10 ? "0" : ''}${d}/${y}`;
            from_time = data.from_time;
            to_time = data.to_time;
            comment = data.comment;
            editid = data.id;
        }

        $("#date").val(date);
        $("#from_time").val(from_time);
        $("#to_time").val(to_time);
        $("#comment").val(comment);
        $("#editid").val(editid);
        $("#log_modal").modal('show');
    }
</script>
@endsection