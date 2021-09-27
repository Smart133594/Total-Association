@extends('admin.layouts.master')
@section('title', 'Work Add/Edit')
@section('content')
<?php 
    function _OBJVALUE($object, $key) {
        try {
            if($object && isset($object[$key])) {
                return $object[$key];
            }
        } catch (\Throwable $th) {
        }
        return null;
    }
?>
<style>
    #avatar-preview {
        width: 180px;
        border: 2px dashed #333;
    }
    #idcard-preview {
        width: 300px;
        border: 2px dashed #333;
    }
    #contracts-preview {
        width: 250px;
        border: 2px dashed #333;
    }
    #avatar-preview img, #idcard-preview img, #contracts-preview img {
        width: 100%;
        height: auto;
    }
    #avatar-preview div, #idcard-preview div, #contracts-preview div {
        margin-top: 100px;
        margin-bottom: 100px;
        width: 100%;
        text-align: center;
        font-size: 24px;
    }
    [type="file"] {
        height: 0;
        width: 0;
        overflow: hidden;
    }
</style>
<div class="ms-content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
            </li>
            <li class="breadcrumb-item " aria-current="page"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('work-force.index') }}">Work Force</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Add-Edit Worker</a></li>
        </ol>
    </nav>

    <form class="ms-panel main-form" id="work_force_form" method="post" action="{{route('work-force.store')}}" enctype="multipart/form-data">
        <div class="ms-panel-header ms-panel-custome">
            <h4>Worker Add/Edit</h4>
        </div>
        <div class="ms-panel-body">
            @include('admin.includes.msg')
            @csrf
            <input type="hidden" name="edit_id" value="{{ $edit_id }}">
            <h5>Basic Information</h5>
            <label for="userName">User Name</label>
            <div class="form-row" id="userName">
                <div class="col-md-4 mb-3">
                    <input type="text" class="form-control" name="firstname" placeholder="First Name" value="{{ _OBJVALUE($worker, 'firstname') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <input type="text" class="form-control" name="middlename" placeholder="Middle Name"value="{{ _OBJVALUE($worker, 'middlename') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <input type="text" class="form-control" name="lastname" placeholder="Last Name" value="{{ _OBJVALUE($worker, 'lastname') }}" required>
                </div>
            </div>

            <label for="birthday">Date Of Birth</label>
            <div class="" id="birthday">
                <div class="row">
                    <div class="col-md-6 mb-6">
                        <select name="year" id="year" class="form-control" onchange="changeDate()" required>
                            <option value="">Select Year</option>
                            @for ($i = 1900; $i < date('Y'); $i++)
                                <option value="{{ $i }}" {{ _OBJVALUE($worker, 'year') == $i ? "selected" : "" }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6 mb-6"></div>
                </div>
                <div class="row" style="margin-top: 25px;">
                    <div class="col-md-4 mb-4">
                        <select name="month" id="month" class="form-control" onchange="changeDate()" required>
                            <option value="">Select Month</option>
                            @for ($i = 1; $i < 13; $i++)
                                <option value="{{ $i }}" {{ _OBJVALUE($worker, 'month') == $i ? "selected" : "" }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-8 mb-8">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4" style="">
                        <select name="date" id="date" class="form-control" required>
                            <option value="">Select Date</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-8" style="">
                    </div>
                </div>
            </div>
            <label for="address">Address</label>
            <div class="form-row" id="address">
                <div class="col-md-5 mb-3">
                    <input type="text" name="address1" id="address1" class="form-control mb-3" placeholder="address 1" value="{{ _OBJVALUE($worker, 'address1') }}" required>
                    <input type="text" name="address2" id="address2" class="form-control"  value="{{ _OBJVALUE($worker, 'address2') }}" placeholder="address 2(Opitional)">
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="city" id="city" class="form-control" placeholder="City"  value="{{ _OBJVALUE($worker, 'city') }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ _OBJVALUE($worker, 'state') }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zip" value="{{ _OBJVALUE($worker, 'zipcode') }}" required>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="phoneNo" id="phoneNo" class="form-control"
                        placeholder="Phone number"  value="{{ _OBJVALUE($worker, 'phone') }}"required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="email" id="email" class="form-control"  value="{{ _OBJVALUE($worker, 'email') }}" placeholder="Email" required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" placeholder="Whatsapp" value="{{ _OBJVALUE($worker, 'whatsapp') }}"
                        required>
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="ssn" id="ssn" class="form-control"
                        placeholder="Social Security Number"  value="{{ _OBJVALUE($worker, 'ssn') }}"required>
                </div>
            </div>
            <hr />
        </div>
        <div class="ms-panel-body">
            <h5>Employment Information</h5>
            <ul class="ms-list d-flex">
                <li class="ms-list-item pl-0">
                    <label class="ms-checkbox-wrap">
                        <input type="radio" name="worker_type" value="0" {{ _OBJVALUE($worker, 'worker_type') == 0 ? "checked" : "" }}>
                        <i class="ms-checkbox-check"></i>
                    </label>
                    <span> Employee </span>
                </li>
                <li class="ms-list-item">
                    <label class="ms-checkbox-wrap">
                        <input type="radio" name="worker_type" value="1" {{ _OBJVALUE($worker, 'worker_type') == 1 ? "checked" : "" }}>
                        <i class="ms-checkbox-check"></i>
                    </label>
                    <span> Sub Contractor </span>
                </li>
            </ul>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="departmentid">Department</label>
                    <select name="departmentid" id="departmentid" class="form-control">
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ _OBJVALUE($worker, 'departmentid')==$department->id ? "selected" : '' }}>{{ $department->department }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="start_date">Starting Date</label>
                    <input type="date" name="start_date" id="start_date" placeholder="starting Date" class="form-control" value="{{ _OBJVALUE($worker, 'start_date') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" placeholder="End Date" class="form-control" value="{{ _OBJVALUE($worker, 'end_date') }}">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="salary_structure">Salary Structure</label>
                    <select name="salary_structure" id="salary_structure" class="form-control">
                        <option value="0" {{ _OBJVALUE($worker, 'salary_structure') == 0 ? "selected" : '' }}>Global</option>
                        <option value="1"{{ _OBJVALUE($worker, 'salary_structure') == 1 ? "selected" : '' }}>Per Hour</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="salary">Salary</label>
                    <input type="number" name="salary" id="salary" placeholder="Salary" class="form-control" value="{{ _OBJVALUE($worker, 'salary') }}" required>
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="active_state">Status</label>
                    <select name="active_state" id="active_state" class="form-control">
                        <option value="0" {{ _OBJVALUE($worker, 'active_state') == 0 ? "selected" : '' }}>Active</option>
                        <option value="1" {{ _OBJVALUE($worker, 'active_state') == 1 ? "selected" : '' }}>Archive</option>
                    </select>
                </div>
            </div>
            <hr />
        </div>
        <div class="ms-panel-body">
            <h5>Upload Employee Photo</h5>
            <div>
                <label for="choose-avatar" class="btn btn-primary mb-4">Upload photo</label>
                <div id="avatar-preview">
                    @if (_OBJVALUE($worker, "avatar"))
                    <img src="/upload/{{ _OBJVALUE($worker, 'avatar') }}" alt="Photo" style="width: 100%; height:100%; object-fit:cover">
                    @else
                        <div class="vertical-center">avatar</div>
                    @endif
                </div>
                <input type="file" id="choose-avatar" name="choose-avatar" accept="image/*" />
            </div>
            <hr />
        </div>
        <div class="ms-panel-body">
            <h5>Upload Driver License or Identification Card</h5>
            <div>
                <label for="choose-idcard" class="btn btn-primary mb-4">Upload Identification Card</label>
                <div id="idcard-preview">
                    @if (_OBJVALUE($worker, 'idcard_image'))
                        <img src="/upload/{{ _OBJVALUE($worker, 'idcard_image') }}" alt="Driver License / ID" style="width: 100%; height:100%; object-fit:cover">
                    @else
                        <div class="vertical-center">Driver License / ID</div>
                    @endif
                </div>
                <input type="file" id="choose-idcard" name="choose-idcard" accept="image/*" />
            </div>
            <hr />
        </div>
        <div class="ms-panel-body">
            <h5>Print Contract and have its Signed</h5>
            <input type="button" value="Print Contract for this Employee" class="btn btn-primary" id="print-contract" style="display: none;">
            <div>
                <label for="choose-contracts" class="btn btn-primary mb-4">Upload Signed Contract</label>
                <div id="contracts-preview">
                    @if (_OBJVALUE($worker, 'contract_image'))
                        <img src="/upload/{{ _OBJVALUE($worker, 'contract_image') }}" alt="Contract Image" style="width: 100%; height:100%; object-fit:cover">
                    @else
                        <div class="vertical-center">Contract Image</div>
                    @endif
                </div>
                <input type="file" id="choose-contracts" name="choose-contracts" accept="image/*" />
            </div>
            <input type="button" value="Send Contract by Email" class="btn btn-primary" id="send-contract">
            <hr />
        </div>
        <div class="ms-panel-body">
            <h5>Password and Access Control</h5>
            <div class="form-row">
                <div class="col-md-3">
                    <label for="access_control_device">Access Control Device</label>
                    <input type="text" name="access_control_device" id="access_control_device" value="{{ _OBJVALUE($worker, 'access_control_device') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="punch_clock_code">Punch Clock Code</label>
                    <input type="number" name="punch_clock_code" id="punch_clock_code" class="form-control" value="{{ _OBJVALUE($worker, 'punch_clock_code') }}">
                </div>
                <div class="col-md-3">
                    <label for="employee_pwd">Employee App Password</label>
                    <input type="password" name="employee_pwd" id="employee_pwd" class="form-control" value="{{ _OBJVALUE($worker, 'employee_pwd') }}" >
                </div>
                <div class="col-md-3">
                    <label for="manage_pwd">Management Software Password</label>
                    <input type="password" name="manage_pwd" id="manage_pwd" class="form-control" value="{{ _OBJVALUE($worker, 'manage_pwd') }}" >
                </div>
            </div>
            <hr />
        </div>
        <div class="ms-panel-body" style="display: none;">
            <h5>Payroll</h5>
            <div class="form-row mb-3">
                <div class="col-md-3">
                    <label for="bank">Bank</label>
                    <input type="text" name="bank" id="bank" class="form-control" value="{{ _OBJVALUE(_OBJVALUE($worker, 'Payroll'), 'bank') }}">
                </div>
                <div class="col-md-3">
                    <label for="routing_number">Routing Number</label>
                    <input type="text" name="routing_number" id="routing_number" class="form-control" value="{{ _OBJVALUE(_OBJVALUE($worker, 'Payroll'), 'routing_number') }}">
                </div>
                <div class="col-md-3">
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" id="account_number" class="form-control" value="{{ _OBJVALUE(_OBJVALUE($worker, 'Payroll'), 'account_number') }}">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <label for="Federal Filing Status"></label>
                    <select name="filing_status" id="filing_status" class="form-control">
                        <option value="0">Single or Married filing separately</option>
                        <option value="1">Married Filing Jointly</option>
                        <option value="2">Head Of Household</option>
                    </select>
                </div>
            </div>
            <hr />
        </div>
        <div class="ms-panel-body">
            <input type="submit" value="Save" class="btn btn-primary">
        </div>
    </form>
</div>
<script>
    const init_date = '{{ _OBJVALUE($worker, 'date') }}';

    $("#work_force_form").submit(e => {
        const code = $("#punch_clock_code").val();
        if(`${code}`.length != 6){
            toastr.warning('Punch clock code must be 6 letters digital.', 'Warning');
            e.preventDefault();
        }
    });

    function changeDate(init_val = 0) {
        const year = $("#year").val();
        const month = $("#month").val();
        const cur_date = init_val > 0 ? init_val : $("#date").val();
        if (!year || !month) return;
        const date = (new Date(year, month, 0)).getDate();
        let ele = `<option value="">Select Date</option>`;
        for (let i = 1; i < date + 1; i++) {
            ele += `<option value="${i}" ${cur_date == i && "selected"}>${i}</option>`;
        }
        $("#date").empty();
        $("#date").append(ele);
    }
    $(document).ready(function() {
        changeDate(init_date);
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
