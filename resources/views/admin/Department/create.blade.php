@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
<style>
    .btn-sm {
        min-width: 0 !important;
    }
</style>
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
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Task List</a></li>
            </ol>
        </nav>
        <form class="ms-panel main-form" method="post" action="{{route('department.store')}}" enctype="multipart/form-data">
            <div class="ms-panel-header">
                <h2>Task List</h2>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                @csrf
                <input type="hidden" name="departmentid" value="{{ _OBJVALUE($department, 'edit_id') }}">
                <input type="hidden" name="departmentTaskid" value="{{ _OBJVALUE($departmentTask, 'edit_id') }}">
                <h5>Add/Edut Task</h5>
                <div class="mb-3">
                    <label for="task">Task</label>
                    <input type="text" name="task" id="task" placeholder="Task" class="form-control" required value="{{ _OBJVALUE($departmentTask, 'task') }}">
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Description">{{ _OBJVALUE($departmentTask, 'description') }}</textarea>
                </div>
                <div style="width: 180px" class="mb-3">
                    <label for="date">Due Date</label>
                    <input type="date" name="date" id="date" class="form-control" required value="{{ _OBJVALUE($departmentTask, 'date') }}">
                </div>
                <div style="width: 180px" class="mb-3">
                    <label for="status">Worker</label>
                    <select name="workerid" id="workerid" class="form-control" required>
                        @if (_OBJVALUE($department, "Workers"))
                            @foreach (_OBJVALUE($department, "Workers") as $worker)
                            <option value="{{ $worker->id }}"  {{ _OBJVALUE($departmentTask, 'workerid') == $worker->id ? 'selected' : '' }}>{{     $worker->firstname }} {{ $worker->middlename }} {{ $worker->lastname }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div style="width: 180px" class="mb-3">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority" class="form-control">
                        <option value="0"  {{ _OBJVALUE($departmentTask, 'priority') == 0 ? 'selected' : '' }}>High</option>
                        <option value="1"  {{ _OBJVALUE($departmentTask, 'priority') == 1 ? 'selected' : '' }}>Medium</option>
                        <option value="2"  {{ _OBJVALUE($departmentTask, 'priority') == 2 ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div style="width: 180px" class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="0"  {{ _OBJVALUE($departmentTask, 'state') == 0 ? 'selected' : '' }}>Assigned</option>
                        <option value="1"  {{ _OBJVALUE($departmentTask, 'state') == 1 ? 'selected' : '' }}>In Progress</option>
                        <option value="2"  {{ _OBJVALUE($departmentTask, 'state') == 2 ? 'selected' : '' }}>On Hold</option>
                        <option value="3"  {{ _OBJVALUE($departmentTask, 'state') == 3 ? 'selected' : '' }}>Canceled</option>
                        <option value="4"  {{ _OBJVALUE($departmentTask, 'state') == 4 ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <h5>Notes</h5>
                @if (_OBJVALUE($departmentTask, 'note'))
                    @foreach (_OBJVALUE($departmentTask, 'note') as $item)
                        <div>
                            <hr>
                            <div class="ms-panel-custome">
                                <span>{{ date("m/d/Y h:i", strtotime($item->created_at)) }}</span>
                                <span>{{ _OBJVALUE($item->Writter, 'name') }}</span>
                            </div>
                            <p>{{ $item->note }}</p>
                        </div>
                    @endforeach
                @endif
                <br>
                <div id="note_area">
                    <h5>Add New Note</h5>
                    <div class="mb-3">
                        <textarea name="note[]" rows="4" class="form-control" placeholder="Write New Note"></textarea>
                    </div>
                </div>
                <input type="button" onclick="addNote()" value="Add New Note" class="btn btn-primary btn-sm">
                <hr>
                <input type="submit" value="Save Task" class="btn btn-primary">
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('.data-table').DataTable();
    });
    function addNote(){
        const element = `<div class="mb-3"><textarea name="note[]" rows="4" class="form-control" placeholder="Write New Note"></textarea> </div>`;
        $("#note_area").append(element);
    }
</script>
@endsection