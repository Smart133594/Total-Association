@extends('admin.layouts.master')
@section('title', 'Work Add/Edit')
@section('content')

<div class="ms-content-wrapper">
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
    <div class="ms-panel">
        <div class="ms-panel-header ms-panel-custome">
            <h2>Punch Clock</h2>
        </div>
        <div class="ms-panel-body">
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
            <form class="row" id="filter_form">
            <div class="row">
                <div class="col-md-4">
                    <h5>Active Employee</h5>
                        <div class="col-md-12">
                            <select name="status" id="status" class="col-md-3 form-control m-3 hitomi-horizontal" onchange="changeOption()">
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

                <div class="col-md-8">
                    <h5>Time Period</h5>
                    <div class="form-row mb-3">
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 2%; margin-bottom: 15%;">
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
                    </div>
                </div>
            </div>
            </form>

            <div>
                <hr>
                <div class="ms-panel-custome mb-3">
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
                        <button class="btn btn-primary btn-sm m-0" data-toggle="modal" data-target="#time_sheet">Export Time Sheet</button>
                    </div>
                </div>
                <table class="table table-striped thead-primary w-100 data-table"> 
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image Captured</th>
                            <th>Clock In Date</th>
                            <th>Clock In Time</th>
                            <th>Clock Out Date</th>
                            <th>Clock Out Time</th>
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
                                        $img = @$item->meta['image'];
                                        if($img == null) {
                                            echo 'No Image';
                                        } else {
                                            echo "<img src='/upload/$img' class='image-responsive' style='height: 50px; width: 50px; max-width: 50px !important;'/>";
                                        }
                                    @endphp
                                </td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ date('d/m/Y', strtotime($item->in_date)) }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ date('h:i', strtotime($item->in_date)) }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $item->out_date ? date('d/m/Y', strtotime($item->out_date)) : '-' }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $item->out_date ? date('h:i', strtotime($item->out_date)) : '-' }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $item->duration }}</td>
                                <td>
                                    <div class="dropdown show">
                                        <a class="cust-btn dropdown-toggle note-action" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-th"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ $detail_uri }}" >Detail</a>
                                            {{-- <a class="dropdown-item" href="#" onclick="openModal({{ $item }})" >Edit</a> --}}
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
                <p>Total Time = {{ $times }}</p>
            </div>
            <div>
                <hr>
                <h5>Report</h5>
                <div class="ms-panel-custome mb-3 row">
                        <div class="modal-body mt-3 ">
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
                            <label for="">Select an Employee</label>
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <select name="export_user" id="export_user" onchange="change_export_user()" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <label for="">Start Date</label>
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <input type="date" name="pay_period_from" id="pay_period_from" class="form-control">
                                </div>
                            </div>
                            <label for="">End Date</label>
                            <div class="form-row mb-3">
                                <div class="col-md-6">
                                    <input type="date" name="pay_period_to" id="pay_period_to" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="ms-checkbox-wrap">
                                            <input type="checkbox" name="hours_shift" id="hours_shift" checked>
                                            <i class="ms-checkbox-check"></i>
                                        </label>
                                    </div>
                                    <div class="col-md-3" style="margin-left: -5%; margin-top: 3px;">If over</div>
                                    <div class="col-md-2" style="margin-left: -20%; margin-top: -5px;"><input type="number" id="in_a" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Hours shift, Deduct</div>
                                    <div class="col-md-2" style="margin-left: -12%; margin-top: -5px;"><input type="number" id="in_b" value="0" class="form-control col-md-6"/></div>
                                    <div class="col-md-3" style="margin-left: -9%; margin-top: 3px;">Min for Break</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="ms-checkbox-wrap">
                                    <input type="checkbox" name="decimal_total" id="decimal_total" checked>
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> Total In Decimal format </span>
                            </div>
                            <div class="mb-3">
                                <label class="ms-checkbox-wrap">
                                    <input type="checkbox" name="time_24_format" id="time_24_format" checked>
                                    <i class="ms-checkbox-check"></i>
                                </label>
                                <span> Time in 24 hour format. </span>
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
                        <div id="export_table" style="display: none"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
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
                    <input type="submit" value="Save Log" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    const workers = JSON.parse(`<?php echo json_encode($workers)?>`);
    const departs = JSON.parse(`<?php echo json_encode($departs)?>`);
    const employees = `{{ $employees }}`;
    const depart_map = [];

    departs.forEach(ele => {
        depart_map[ele['id']] = ele['department'];
    });

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
            <img src="/upload/${worker.avatar}" alt="Photo" class="mr-3" style="width: 150px; height:150px">`;
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
        var userid = $("#export_user").val();
        if(userid == '') {
            userid = $("#export_user").prop('selectedIndex', 1);
            userid = $("#export_user").val();
            console.log(userid);
        }
        var pay_period_from = $("#pay_period_from").val();
        var pay_period_to = $("#pay_period_to").val();
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
                    table2pdf(data);
                    $('#preloader-wrap').addClass('loaded');
                },
                error: function(err) {
                    console.log({err});
                    $('#preloader-wrap').addClass('loaded');
                }
            });
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
        var add_time_from = new Date();
        var add_time_to = new Date();
        var add_time_note = null;
        var editid = 0;

        if(data){
            editid = data.id;
            add_time_from = new Date(data.in_date);
            add_time_to = new Date(data.out_date);
            add_time_note = data.total;
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
