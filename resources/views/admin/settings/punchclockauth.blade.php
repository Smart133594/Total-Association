@extends('admin.layouts.master')
@section('title', 'Access Device')
@section('content')
<div class="ms-content-wrapper">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb pl-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('punch-clock.index') }}">Punch Clock</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Punch Clock Detail</a></li>
        </ol>
    </nav>
    <div class="ms-panel">
        <div class="ms-panel-header ms-panel-custome">
            <h2>Punch Clock Authuntication</h2>
        </div>
        <div class="ms-panel-body">
            @include('admin.includes.msg')
            <div class="form-row">
                
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    Input Username:
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="username" value="{{$item[0]->username}}">
                </div>
                <div class="col-md-1">
                </div>
                
                <div class="col-md-12">
                    <br>
                </div>

                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    Input Old Password:
                </div>
                <div class="col-md-7">
                    <input type="password" class="form-control" id="oldpassword" value="">
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-12">
                    <br>
                </div>

                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    Input New Password:
                </div>
                <div class="col-md-7">
                    <input type="password" class="form-control" id="newpassword" value="">
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-12">
                    <br>
                </div>

                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    Input New Password Confirm:
                </div>
                <div class="col-md-7">
                    <input type="password" class="form-control" id="newcpassword" value="">
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-12">
                    <br>
                </div>

                <div class="col-md-4"></div>
                <div class="col-md-2">
                    <input type="button" onclick="save({{$item[0]->id}})" class="btn btn-primary d-block" value="Save">
                </div>
                <div class="col-md-6"></div>
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

    const save = (id) => {
        const username = $("#username").val();
        const oldpassword = $("#oldpassword").val();
        const newpassword = $("#newpassword").val();
        const newrpassword = $("#newcpassword").val();

        if(username == '' || oldpassword == '' || newpassword == '' || newrpassword == '') {
            toastr.warning('Input is not valid.', 'Warning');
            return;
        }

        if(newrpassword != newpassword) {
            toastr.error('New Password and New Password Confirm are incorrect.', 'Error');
            return;
        }

        var formData = new FormData();
        formData.append('id', id);
        formData.append('username', username);
        formData.append('oldpassword', oldpassword);
        formData.append('newpassword', newpassword);
        formData.append('_token', "{{csrf_token()}}");

        $.ajax({url: 'punchclock-auth',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result) {
                if(result == 'error') {
                    toastr.error("Old Password is incorrect.", "Error");
                } else {
                    toastr.success("Username and Password are changed successfully.", "Success");
                }
        }});
    }
</script>
@endsection
