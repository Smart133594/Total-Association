@extends('admin.layouts.master')
@section('title', 'Work Force Detail')
@section('content')
<style>
    .avatar-preview {
        width: 70%;
        height: 70%;
        margin: auto;
        margin-top: 15%;
        border: 2px dashed #333;
        text-align: center;
        position: relative;
    }
    .vertical-center {
        margin: 0;
        position: absolute;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        width: 100%;
        text-align: center;
    }

</style>
<div class="ms-content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
            </li>
            <li class="breadcrumb-item " aria-current="page"><a href="#">Work Force</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('work-force.index') }}">Work Force</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Worker Info</a></li>
        </ol>
    </nav>
    <div class="ms-panel">
        <div class="ms-panel-header ms-panel-custome">
            <h2>Worker Info</h2>
        </div>
        <div class="ms-panel-body">
            @include('admin.includes.msg')
            <div class="form-row">
                <div class="col-md-3">
                    <div class="avatar-preview">
                        @if ($worker->avatar)
                            <img src="/upload/{{ $worker->avatar }}" alt="Photo" style="width: 100%; height:100%; object-fit:cover">
                        @else
                            <h5 class="vertical-center">Photo</h5>
                        @endif
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <h5>Basic Information</h5> <br>
                    <p>Name: &nbsp;{{ $worker->firstname }} {{ $worker->middlename }} {{ $worker->lastname }}</p>
                    <p>Date of birth: &nbsp;{{ date("M d, Y", strtotime($worker->birthday)) }}</p>
                    <div style="display: flex">
                        <div>Address:</div>
                        <div style="margin-left: 20px">
                            @if($worker->address1){{ $worker->address1 }}<br/>@endif
                            @if($worker->address2){{ $worker->address2 }}<br/>@endif
                            {{ $worker->city }}, {{ $worker->state }} {{ $worker->zipcode }}
                        </div>
                    </div>
                    <p></p>
                    <p>Phone Number: &nbsp;{{ $worker->format_phone }}</p>
                    <p>email: &nbsp;{{ $worker->email }}</p>
                    <p>Whatsapp: &nbsp;{{ $worker->format_whatsapp }}</p>
                </div>
                <hr  class="col-md-12"/>
                <div class="col-md-5">
                    <h5>Employment Information</h5> <br>
                    <p>Type: &nbsp;{{ $worker->worker_type == 0 ? "Employee" : "Sub Contractor" }}</p>
                    @if ($worker->Department)
                    <p>Department: &nbsp;{{ $worker->Department->department }}</p>
                    @endif
                    <p>Start Date: &nbsp;{{ date("M d, Y", strtotime($worker->start_date)) }}</p>
                    <p>End Date: &nbsp; {{ date("M d, Y", strtotime($worker->end_date)) }}</p>
                    <p>Salary Structure: &nbsp;${{ $worker->salary }}/{{ $worker->salary_structor == 0 ? "Year" : "Hour" }}</p>
                    <p>Status: &nbsp;{{ $worker->active_state == "0" ? "Active" : "Archived" }}</p>
                </div>
                <div class="col-md-7">
                    <div class="avatar-preview" style="height: 90%; margin-top:5%">
                        @if ($worker->idcard_image)
                            <img src="/upload/{{ $worker->idcard_image }}" alt="Photo" style="width: 100%; height:100%; object-fit:cover">
                        @else
                            <h5 class="vertical-center">Driver License / ID</h5>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5>Last Work Days</h5>
                    <table class="table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Total</th>
                                <th>Map</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5>Payment History</h5>
                    <table class="table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paid for</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Bank</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5>Last to do</h5>
                    <table class="table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5>Last Work Log</h5>
                    <table class="table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Log</th>
                                <th>Date</th>
                                <th>Task</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changeDate() {
        const year = $("#year").val();
        const month = $("#month").val();
        const cur_date = $("#date").val();
        if (!year || !month) return;
        const date = (new Date(year, month, 0)).getDate();
        let ele = ``;
        for (let i = 1; i < date + 1; i++) {
            ele += `<option value="${i}" ${cur_date == i && "selected"}>${i}</option>`;
        }
        $("#date").empty();
        $("#date").append(ele);
    }
    $(document).ready(function() {
        changeDate();
        $('.data-table').DataTable();
    });

    $("#choose-avatar").on("change", function(e) {
        const files = e.target.files[0];
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function() {
                $("#avatar-preview").html(`<img src="${this.result}" />`);
            });
        }
    });
    $("#choose-idcard").on("change", function(e) {
        const files = e.target.files[0];
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function() {
                $("#idcard-preview").html(`<img src="${this.result}" />`);
            });
        }
    });
    $("#choose-contracts").on("change", function(e) {
        const files = e.target.files[0];
        if (files) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(files);
            fileReader.addEventListener("load", function() {
                $("#contracts-preview").html(`<img src="${this.result}" />`);
            });
        }
    });
</script>
@endsection
