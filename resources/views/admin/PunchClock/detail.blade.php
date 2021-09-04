@extends('admin.layouts.master')
@section('title', 'Work Force Detail')
@section('content')
<?php 
    function _OBJVALUE($object, $key) {
        try {
            if(@$object && isset($object[$key])) {
                return @$object[$key];
            }
        } catch (\Throwable $th) {
        }
        return null;
    }
?>
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
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ route('punch-clock.index') }}">Punch Clock</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#">Punch Clock Detail</a></li>
        </ol>
    </nav>
    <div class="ms-panel">
        <div class="ms-panel-header ms-panel-custome">
            <h2>Punch Clock Detail</h2>
        </div>
        <div class="ms-panel-body">
            @include('admin.includes.msg')
            <div class="form-row">
                <div class="col-md-3">
                    <div class="avatar-preview">
                        <img src="/upload/{{$punchClock->worker_info['avatar']}}" alt="Photo" style="width: 100%; height:100%; object-fit:cover">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <h5>Basic Information</h5> <br>
                    <p>Name: &nbsp;{{ $punchClock->worker_info['firstname'] }}&nbsp;{{ $punchClock->worker_info['middlename'] }}&nbsp;{{ $punchClock->worker_info['lastname'] }}</p>
                    <p>Date of birth: &nbsp;{{$punchClock->worker_info['birthday']}}</p>
                    <div style="display: flex">
                        <div>Address:</div>
                        <div style="margin-left: 20px">
                            @if($punchClock->worker_info['address1']){{ $punchClock->worker_info['address1'] }}<br/>@endif
                            @if($punchClock->worker_info['address2']){{ $punchClock->worker_info['address2'] }}<br/>@endif
                            {{ $punchClock->worker_info['city'] }}, {{ $punchClock->worker_info['state'] }} {{ $punchClock->worker_info['zipcode'] }}
                        </div>
                    </div>
                    <p></p>
                    <p>Phone Number: &nbsp;{{$punchClock->worker_info['phone']}}</p>
                    <p>email: &nbsp;{{$punchClock->worker_info['email']}}</p>
                    <p>Whatsapp: &nbsp;{{$punchClock->worker_info['whatsapp']}}</p>
                </div>
            </div>
            <div style="padding:10px">
                <h6>Association: {{ @$association[0]->legalName }}</h6>
                <h6>Current State: {{ _OBJVALUE($punchClock, "state") == 0 ? "Clocked In" : "Clocked Out" }}</h6>
                <p>{{ _OBJVALUE($punchClock, "note") }}</p>
            </div>
            <hr> <br/>
            <div class="row">
                <div class="col-6">
                    <h5>Clock In</h5>
                    <hr>
                    <p>Serial Number: {{ @_OBJVALUE($punchClock->in_meta->AccessDevice, "serial_number") }}</p>
                    <p>IP Address: {{ @_OBJVALUE($punchClock->in_meta->AccessDevice, "ip_address") }}</p>
                    <p>Status: {{ @_OBJVALUE($punchClock->in_meta->AccessDevice, "state") == 0 ? "Disactive" : "Active" }}</p>
                    <p>Date: {{ _OBJVALUE($punchClock, "in_date") }}</p>
                    @if (_OBJVALUE($punchClock, "in_meta"))
                        <p>Location: {{ _OBJVALUE($punchClock->in_meta, "city") }}, {{ _OBJVALUE($punchClock->in_meta, "area") }}, {{ _OBJVALUE($punchClock->in_meta, "country") }}</p>
                        <p>Postal code: {{ _OBJVALUE($punchClock->in_meta, "postal_code") }}</p>
                    @endif
                    @if (_OBJVALUE(_OBJVALUE($punchClock, "in_meta"), "image"))
                        <img src="/upload/{{ $punchClock->in_meta->image }}" alt="Photo" style="width: 80%;">
                    @endif
                </div>
                <div class="col-6" style="border-left:1px solid rgba(0, 0, 0, 0.1);">
                    <h5>Clock Out</h5>
                    <hr>
                    <p>Serial Number: {{ @_OBJVALUE($punchClock->out_meta->AccessDevice, "serial_number") }}</p>
                    <p>IP Address: {{ @_OBJVALUE($punchClock->out_meta->AccessDevice, "ip_address") }}</p>
                    <p>Status: {{ @_OBJVALUE($punchClock->out_meta->AccessDevice, "state") == 0 ? "Disactive" : "Active" }}</p>
                    <p>Date: {{ @_OBJVALUE($punchClock, "out_date") }}</p>
                    @if (_OBJVALUE($punchClock, "out_meta"))
                        <p>Location: {{ _OBJVALUE($punchClock->out_meta, "city") }}, {{ _OBJVALUE($punchClock->out_meta, "area") }}, {{ _OBJVALUE($punchClock->out_meta, "country") }}</p>
                        <p>Postal code: {{ _OBJVALUE($punchClock->out_meta, "postal_code") }}</p>
                    @endif
                    @if (_OBJVALUE(_OBJVALUE($punchClock, "out_meta"), "image"))
                        <img src="/upload/{{ $punchClock->out_meta->image }}" alt="Photo" style="width: 80%;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
