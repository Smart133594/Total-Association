@extends('admin.layouts.master')
@section('title', 'Work Force Detail')
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
            <div style="padding:10px">
                <h6>Association: {{ _OBJVALUE($punchClock, "association") }}</h6>
                <h6>Current State: {{ _OBJVALUE($punchClock, "state") == 0 ? "Clocked In" : "Clocked Out" }}</h6>
                <p>{{ _OBJVALUE($punchClock, "note") }}</p>
            </div>
            <hr> <br/>
            <div class="row">
                <div class="col-6">
                    <h5>Clock In</h5>
                    <hr>
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
                    <p>Date: {{ _OBJVALUE($punchClock, "out_date") }}</p>
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
