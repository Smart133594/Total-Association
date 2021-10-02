@extends('admin.layouts.master')
@section('title', 'Work Add/Edit')
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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{ route('work-force.index') }}">Work Force</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Punch Clock</a></li>
                </ol>
            </nav>
        </div>
        <!-- User Activity By Country Widget -->
        <div class="col-xl-4 col-md-12">
            <div class="ms-panel ms-widget">
                @include('admin.includes.msg')
                {{-- <input type="button" value="Who is clocked in" class="btn btn-primary"> --}}
                {{-- <hr> --}}
                @php
                    $status = 0;
                    $employees = 0;
                    $pay_from = null;
                    $pay_to = null;
                    if(isset($_GET['status'])) $status = $_GET['status'];
                    if(isset($_GET['employees'])) $employees = $_GET['employees'];
                    if(isset($_GET['pay_from'])) $pay_from = $_GET['pay_from'];
                    if(isset($_GET['pay_to'])) $pay_to = $_GET['pay_to'];
                @endphp
                <form id="filter_form">
                <div class="ms-panel-header">
                <h3 style="font-size:35px !important">Active Employee</h3>
                </div>
                <div class="ms-panel-body p-0">
                <div class="col-md-12">
                    <select name="status" id="status" class="col-md-10 form-control m-3 hitomi-horizontal" onchange="changeOption()">
                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Active</option>
                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Archived</option>
                        <option value="2" {{ $status == 2 ? 'selected' : '' }}>Both</option>
                    </select>
                    <select name="employees" id="employees" class="col-md-10 form-control m-3" onchange="userinfo()">
                    </select>
                </div>
                <div class="col-md-12"></div>
                <div class="col-md-12 m-3" id="user_info">
                </div>
                </div>
                </form>
            </div>
        </div>
        <!-- Trade History Widget -->
        <div class="col-xl-8 col-md-12">
            <div class="ms-panel ms-widget ms-panel-fh">
                <div class="ms-panel-header">
                <h3 style="font-size:35px !important">Time Period</h3>
                </div>
                <div class="ms-panel-body p-0">
                <div class="table-responsive">
                    <div class="col-md-12">
                            <form id="filter_form">

                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 2%; margin-bottom: 4%;">
                                        In order to view the work hours of an employee, please select the employee you wish to review.
                                        Once you selected the employee, please select the start date and the end date of the pay period you wish to review.
                                        then just press go.
                                    </div>
                                    <div class="col-md-12">
                                    Start Date
                                    </div>
                                    <div class="col-md-8" style="margin-bottom: 5%;">
                                        <input type="date" name="pay_from" id="pay_from" class="form-control" value="{{ $pay_from }}">
                                    </div>
                                    <div class="col-md-12">
                                        End Date
                                    </div>
                                    <div class="col-md-8" style="margin-bottom: 5%;">
                                        <input type="date" name="pay_to" id="pay_to" class="form-control" value="{{ $pay_to }}">
                                    </div>
                                    <div class="col-md-6" style="margin-bottom: 5%;">
                                        <input type="submit" value="Go" class="btn btn-primary m-0 p-1">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-widget ms-panel-fh">
                <div class="ms-panel-header">
                    <div class="ms-panel-custome mb-3" style="margin-bottom:0px !important">
                    <h5>
                            @php
                                $f = 1;
                                foreach ($workers as $key => $item) {
                                    if($employees == $item['id']) {
                                        echo "$item[firstname] $item[middlename] $item[lastname]'s Hours";
                                        $f = 0;
                                    }
                                }
                                if($f == 1) {
                                    echo 'Punch Clock';
                                }
                                if($pay_from != null) {
                                    $ta = $pay_from;
                                    $ta = str_replace('-', '/', $ta);
                                    echo " From $ta";
                                }
                                if($pay_to != null) {
                                    $tb = $pay_to;
                                    $tb = str_replace('-', '/', $tb);
                                    echo " To $tb";
                                }
                            @endphp
                        </h5>
                        <div class="m-0 p-0">
                            <button class="btn btn-primary btn-sm m-0" onclick="openModal()"  >Add New Time Entry</button>
                            {{-- <button class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#time_sheet">Export Time Sheet</button> --}}
                        </div>
                    </div>
                </div>
                <div class="ms-panel-body">
                    <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 data-table" id="tableId">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th style="min-width: 100px">Image Captured</th>
                            <th style="min-width: 100px">Clock In Date</th>
                            <th style="min-width: 100px">Clock In Time</th>
                            <th style="min-width: 100px">Clock Out Date</th>
                            <th style="min-width: 100px">Clock Out Time</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($punchClock as $index => $item)
                            <?php $detail_uri = '/punch-clock/'.$item->edit_id ?>
                            <tr>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $index+1 }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">
                                    @php
                                        $img = @$item->in_meta->image;
                                        if($img == null) {
                                            echo 'No Image';
                                        } else {
                                            echo "<img src='/upload/$img' class='image-responsive' style='height: 50px; width: 50px; max-width: 50px !important;'/>";
                                        }
                                    @endphp
                                </td>
                                <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ date('d/m/Y', strtotime($item->in_date)) }}</td>
                                <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ date('h:i', strtotime($item->in_date)) }}</td>
                                <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->out_date ? date('d/m/Y', strtotime($item->out_date)) : '-' }}</td>
                                <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->out_date ? date('h:i', strtotime($item->out_date)) : '-' }}</td>
                                <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->duration }}</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="cust-btn dropdown-toggle note-action" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-th"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <button class="dropdown-item" onclick="window.location.href='{{ $detail_uri }}'" >View</button>
                                            <a class="dropdown-item" href="#" onclick="openModal({{ $item }})" >Edit</a>
                                            <form action="{{ route('punch-clock.destroy', $item->id) }}" method="post">
                                                @method("delete")
                                                @csrf
                                                <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to delete this? ')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <h4>Total Time = {{ $times }}</h4>
                </div>
            </div>
        </div>
        
        <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-widget ms-panel-fh">
                <div class="ms-panel-header">
                <h2 style="font-size:35px !important">Single Employee</h2>
                </div>
                <div class="ms-panel-body p-0">
                <div class="table-responsive">
                    <div class="col-md-12" style="margin-bottom:1%">
                        <ul class="ms-list d-flex horizontal_ads">
                            <li class="ms-list-item pl-0">
                                <label class="ms-checkbox-wrap">
                                    <input type="radio" name="worker_type" value="employee" >
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> Employee </span>
                            </li>
                            <li class="ms-list-item">
                                <label class="ms-checkbox-wrap">
                                    <input type="radio" name="worker_type" value="all" checked="">
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> All </span>
                            </li>
                        </ul>
                        
                        <div class="mb-3" style="margin-top:1%">
                            <h6 style="font-size 18px !important;">
                                In order to print a report of the above Employee and time interval. Please select bottom settings and click on "Create PDF"
                            </h6>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-1" id="diva">
                                        <label class="ms-checkbox-wrap">
                                            <input type="checkbox" name="hours_shift" id="hours_shift" checked>
                                            <i class="ms-checkbox-check"></i>
                                        </label>
                                    </div>
                                    <div class="col-1" id="divb">If over</div>
                                    <div class="col-2" id="divc"><input type="number" id="in_a" value="0" class="col-12"/></div>
                                    <div class="col-2" id="divd">Hours shift, Deduct</div>
                                    <div class="col-2" id="dive"><input type="number" id="in_b" value="0" class="col-12"/></div>
                                    <div class="col-2" id="divf">Min for Break</div>

                                    {{-- <div class="col-md-3" style="margin-left: -5%; margin-top: 3px;">If over</div>
                                    <div class="col-md-2" style="margin-left: -20%; margin-top: -5px;"><input type="number" id="in_a" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Hours shift, Deduct</div>
                                    <div class="col-md-2" style="margin-left: -12%; margin-top: -5px;"><input type="number" id="in_b" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Min for Break</div> --}}

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="checkbox" name="decimal_total" id="decimal_total" checked>
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Display Totals In Decimal format </span>
                        </div>
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="checkbox" name="time_24_format" id="time_24_format" checked>
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Display Time in 24 hour format. </span>
                        </div>
                        <br>
                        <div id="all_radio">
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="radio" name="report_radio" value="groupEmployee" checked="">
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Group Time Entires by Employee </span>
                        </div>
                        <div class="mb-3">
                                <label class="ms-checkbox-wrap">
                                    <input type="radio" name="report_radio" value="groupDay">
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> Group Time Entires by Day </span>
                        </div>
                        </div>
                        <input type="button" value="Create PDF" class="btn btn-primary col-md-2" onclick="exprtSheet()">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-widget ms-panel-fh">
                <div class="ms-panel-header">
                <h4 style="font-size:35px !important">Single Employee</h4>
                </div>
                <div class="ms-panel-body p-0">
                <div class="table-responsive">
                    <div class="col-md-12" style="margin-bottom:2%">
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <select name="export_user" id="export_user" onchange="change_export_user()" class="form-control" hidden>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 style="font-size 18px !important;">
                                This section will print a report of all Employees that works at a time interval. Please select the
                                time interval and setting below and click on "Create PDF"
                            </h6>
                        </div>
                        <div class="row" style="margin-bottom:20px !important">
                            <div class="col-md-4">
                                <label for="">Start Date</label>
                                <div class="form-row">
                                        <input type="date" name="pay_period_from" id="pay_period_from1" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">End Date</label>
                                <div class="form-row">
                                        <input type="date" name="pay_period_to" id="pay_period_to1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-1" id="diva">
                                        <label class="ms-checkbox-wrap">
                                            <input type="checkbox" name="hours_shift" id="hours_shift1" value="true"  onclick="change_hour_shift()" checked>
                                            <i class="ms-checkbox-check"></i>
                                        </label>
                                    </div>
                                    <div class="col-1" id="divb">If over</div>
                                    <div class="col-2" id="divc"><input type="number" id="in_a1" value="0" class="col-12"/></div>
                                    <div class="col-2" id="divd">Hours shift, Deduct</div>
                                    <div class="col-2" id="dive"><input type="number" id="in_b1" value="0" class="col-12"/></div>
                                    <div class="col-2" id="divf">Min for Break</div>

                                    {{-- <div class="col-md-3" style="margin-left: -5%; margin-top: 3px;">If over</div>
                                    <div class="col-md-2" style="margin-left: -20%; margin-top: -5px;"><input type="number" id="in_a" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Hours shift, Deduct</div>
                                    <div class="col-md-2" style="margin-left: -12%; margin-top: -5px;"><input type="number" id="in_b" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Min for Break</div> --}}

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="checkbox" name="decimal_total" id="decimal_total1" checked>
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Display Totals In Decimal format </span>
                        </div>
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="checkbox" name="time_24_format" id="time_24_format1" checked>
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Display Time in 24 hour format. </span>
                        </div>
                        <br>
                        <div id="all_radio">
                        <div class="mb-3">
                            <label class="ms-checkbox-wrap">
                                <input type="radio" name="report_radio1" value="groupEmployee" checked="">
                                <i class="ms-checkbox-check"></i>
                            </label>
                            <span> Group Time Entires by Employee </span>
                        </div>
                        <div class="mb-3">
                                <label class="ms-checkbox-wrap">
                                    <input type="radio" name="report_radio1" value="groupDay">
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> Group Time Entires by Day </span>
                        </div>
                        </div>
                        <input type="button" value="Create PDF" class="btn btn-primary col-md-2" onclick="exprtSheet1()">
                    </div>
                    <div id="export_table1" style="display: none"></div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="log_modal" tabindex="-1" role="dialog" aria-labelledby="log_modal_label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" id="log_form" enctype="multipart/form-data" action="{{route('punch-clock.store')}}">
                <div class="modal-header">
                    <h5 class="modal-title" id="log_modal_label">Add Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @csrf
                <input type="hidden" name="employee" id="employee">
                <input type="hidden" name="editid" id="editid">
                <div class="modal-body form-row mt-3">
                    <div class="col-md-6 mb-4">
                        <label for="add_time_from">Pay from</label>
                        <input type="datetime-local" name="add_time_from" id="add_time_from" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="add_time_to">Pay to</label>
                        <input type="datetime-local" name="add_time_to" id="add_time_to" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <textarea name="add_time_note" id="add_time_note" rows="5" class="form-control" placeholder="Note" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Add time entry" id="btnAdd" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @media screen and (max-width: 966px) {
        #divb { min-width: 22% !important; margin-left: -2% !important; }
        #divc { margin-left: -3%; }
        #divd { min-width: 52% !important; }
        #dive { margin-left: 6% !important; }
        #divf { min-width: 40% !important; margin-top: 1%; margin-left: -1%; }
    }
    #divb { margin-left: -5%; }
    #divc { margin-left: -3%; }
    #divd { margin-left: -1%; }
    #dive { margin-left: -2%; }
    #divf { margin-left: -1%; }

</style>

<script>
    const workers = JSON.parse(`<?php echo json_encode($workers)?>`);
    const departs = JSON.parse(`<?php echo json_encode($departs)?>`);
    const employees = `{{ $employees }}`;
    const depart_map = [];

    departs.forEach(ele => {
        depart_map[ele['id']] = ele['department'];
    });

    var change_hour_shift = function(){
        var bFlag = $("#hours_shift1").val();
        var hour = document.getElementById('in_a1');
        var min = document.getElementById('in_b1');

        if(bFlag == "true"){
            $("#hours_shift1").val("false");
            hour.disabled = true;
            min.disabled = true;
        }else{
            $("#hours_shift1").val("true");
            hour.disabled = false;
            min.disabled = false;
        }
    }

    var isAll = true;
    $("#log_form").submit(e => {
        var add_time_from = $("#add_time_from").val();
        var add_time_to = $("#add_time_to").val();
        const from_date = new Date(add_time_from);
        const to_date = new Date(add_time_to);
        if(!to_date || !from_date || to_date.getTime() < from_date.getTime()){
            toastr.warning('Input the valid from time and to time.', 'Warning');
            e.preventDefault();
        }
        const employees = $("#employees").val();
        $("#employee").val(employees);
    });
    $('input[type=radio][name=worker_type]').change(function() {
        isAll = this.value == 'all';
        changeExprtType();
    });
    $(document).ready(function() {
        $('.data-table').DataTable();
        changeOption();

        $("#user_info").empty();
        const employees = $("#employees").val();
        const worker = workers.find(item => item.id == employees);
        if(worker){
            var html = `
            <div>
                <div>Name: ${worker.firstname} ${worker.middlename} ${worker.lastname}</div><br>
                <div>Department: ${depart_map[worker.departmentid]}</div><br>
                <div>Phone Number: ${worker.phone}</div><br>
                <div>Email Address: ${worker.email}</div><br>
            </div>
            <img src="/upload/${worker.avatar}" alt="Photo" class="mr-3" style="max-width: 150px; max-height:150px; object-fit:contain">`;
            $("#user_info").append(html);
        }
        isAll = 'all';
        changeExprtType();
    });
    // ---------------
    function changeExprtType(){
        const tmp = isAll ? workers : workers.filter(item => item.worker_type == 0) || [];
        var html = `<option value="">ALL</option>`;
        tmp.forEach(ele => {
            html += `<option value="${ele.id}">${ele.firstname} ${ele.middlename} ${ele.lastname}</option>`;
        });
        $("#export_user").html(html);
    }
    function exprtSheet () { 
        var userid = $("#employees").val();
        if(userid == '') {
            userid = $("#employees").prop('selectedIndex', 1);
            userid = $("#employees").val();
            console.log(userid);
        }
        var pay_period_from = $("#pay_from").val();
        var pay_period_to = $("#pay_from").val();
        var unit_hours = $("#in_a").val();
        var per_minutes = $("#in_b").val();
        var decimal_total = $('#decimal_total').is(":checked");
        var time_format = $('#time_format').is(":checked");
        var hours_shift = $('#hours_shift').is(":checked");

        const from_date = new Date(pay_period_from);
        const to_date = new Date(pay_period_to);

        if(!userid){
            toastr.warning('Please choose employeer.', 'Warning');
        }
        if(pay_period_from && pay_period_to && to_date.getTime() < from_date.getTime()){
            toastr.warning('Input the valid from time and to time.', 'Warning');
            return;
        }
        $("#time_sheet").modal('hide');
        $('#preloader-wrap').removeClass('loaded');

        var formData = new FormData();
        formData.append('userid', userid);
        formData.append('pay_period_from', pay_period_from);
        formData.append('pay_period_to', pay_period_to);
        formData.append('decimal_total', decimal_total);
        formData.append('time_format', time_format);
        formData.append('hours_shift', hours_shift);
        formData.append('unit_hours', time_format);
        formData.append('per_minutes', per_minutes);
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
                url: '/exportPunchClock',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    table2pdf1(data);
                    $('#preloader-wrap').addClass('loaded');
                },
                error: function(err) {
                    console.log({err});
                    $('#preloader-wrap').addClass('loaded');
                }
            });
    }

    function exprtSheet1 () {
        // var userid = $("#export_user").val();
        // console.log(userid);
        // if(userid == '') {
        //     userid = $("#export_user").prop('selectedIndex', 1);
        //     userid = $("#export_user").val();
        //     console.log(userid);
        // }
        var pay_period_from = $("#pay_period_from1").val();
        var pay_period_to = $("#pay_period_to1").val();
        var unit_hours = $("#in_a1").val();
        var per_minutes = $("#in_b1").val();
        var decimal_total = $('#decimal_total1').is(":checked");
        var time_format = $('#time_format1').is(":checked");
        var hours_shift = $('#hours_shift1').is(":checked");

        if(pay_period_from == "" || pay_period_to == ""){
            toastr.warning('Input the valid from time and to time.', 'Warning');
            return;
        }

        const from_date = new Date(pay_period_from);
        const to_date = new Date(pay_period_to);

        if(pay_period_from && pay_period_to && to_date.getTime() < from_date.getTime()){
            toastr.warning('Input the valid from time and to time.', 'Warning');
            return;
        }
        $("#time_sheet").modal('hide');
        $('#preloader-wrap').removeClass('loaded');

        var formData = new FormData();
        formData.append('pay_period_from', pay_period_from);
        formData.append('pay_period_to', pay_period_to);
        formData.append('decimal_total', decimal_total);
        formData.append('time_format', time_format);
        formData.append('hours_shift', hours_shift);
        formData.append('unit_hours', time_format);
        formData.append('per_minutes', per_minutes);
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
                url: '/exportPunchClock1',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    table2pdf1(data);
                    $('#preloader-wrap').addClass('loaded');
                },
                error: function(err) {
                    console.log({err});
                    $('#preloader-wrap').addClass('loaded');
                }
            });
    }
    function table2pdf1(data) {
        console.log(data);
        $("#export_table1").append(data);
        // var elt = document.getElementById('export_table1');
        // var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        // XLSX.writeFile(wb, ('Punch Clock.xlsx'));
        // $("#export_table1").empty();

        alert($("#export_table1").val());

        var pdf = new jsPDF('p', 'pt', 'letter');

        pdf.cellInitialize();
        pdf.setFontSize(10);
        $.each( $('#customers tr'), function (i, row){
            $.each( $(row).find("td, th"), function(j, cell){
                var txt = $(cell).text().trim() || " ";
                var width = (j==4) ? 40 : 70; //make 4th column smaller
                pdf.cell(10, 50, width, 30, txt, i);
            });
        });

        pdf.save('sample-file.pdf');
        $("#export_table1").empty();

    }

    function table2pdf(data) {
        $("#export_table").append(data);
        var elt = document.getElementById('export_table');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        XLSX.writeFile(wb, ('Punch Clock.xlsx'));
        $("#export_table").empty();
    }  

    // ---------------
    function userinfo() {
        $("#filter_form").submit();
    }
    function changeOption(){
        const status = $("#status").val();
        const tmp = status == 2 ? workers : workers.filter(item => item.active_state == status) || [];
        var html = ``;
        tmp.forEach(ele => {
            html += `<option value="${ele.id}" ${employees == ele.id ? 'selected' : ''}>${ele.firstname} ${ele.middlename} ${ele.lastname}</option>`;
        });
        $("#employees").html(html);
    }
    function change_export_user() {
        var id = $("#export_user").val();
        if(id == '') {
            $("#all_radio").attr('style', 'display: inline');

        } else {
            $("#all_radio").attr('style', 'display: none');
        }
    }
    function openModal(data) {
        if(data != null){
            $("#btnAdd").val("Save time entry");
        }
        var add_time_from = new Date();
        var add_time_to = new Date();
        var add_time_note = null;
        var editid = 0;

        if(data){
            editid = data.id;
            add_time_from = new Date(data.in_date);
            add_time_to = new Date(data.out_date);
            add_time_note = data.note;
        }
        add_time_from = new Date(add_time_from.getTime()-add_time_from.getTimezoneOffset()*60000).toISOString().substring(0,16);
        add_time_to = new Date(add_time_to.getTime()-add_time_to.getTimezoneOffset()*60000).toISOString().substring(0,16);

        $("#add_time_from").val(add_time_from);
        $("#add_time_to").val(add_time_to);
        $("#add_time_note").val(add_time_note);
        $("#editid").val(editid);
        $("#log_modal").modal('show');
    }
    // -----------
    function goto(url) {
        window.location.href = url;
    }
</script>
@endsection
