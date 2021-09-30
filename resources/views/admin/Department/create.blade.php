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
                <h2>To Do List</h2>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                @csrf
                <input type="hidden" name="departmentid" value="{{ _OBJVALUE($department, 'edit_id') }}">
                <input type="hidden" name="departmentTaskid" value="{{ _OBJVALUE($departmentTask, 'edit_id') }}">

                <h5>Add/Edit Task</h5>
                <div class="mb-3">
                    <input type="text" name="task" id="task" placeholder="Task" class="form-control" required value="{{ _OBJVALUE($departmentTask, 'task') }}">
                </div>
                <div class="mb-3">
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
                <div style="width: 180px" class="mb-3">
                    <label for="date">Image</label>
                    <input type="file" class="form-control valid" required name="imageA">
                </div>
                @php
                    if(@$departmentTask->image != '' && @$departmentTask->image != null) {
                        echo "<img src='/upload/$departmentTask->image' style='width: 200px; height: 100px;' />";
                    }
                @endphp
                <div class="row">
                    <div class="col-6">
                        <h5 style="{{$display_property}} margin-top: 5%;">Notes</h5>
                    </div>
                    <div class="col-6">
                        <input data-toggle="modal" data-target="#exampleModal" style="{{$display_property}} float: right" type="button" value="Add New Note" class="btn btn-primary btn-sm" onclick="init_modal()">
                    </div>
                </div>
                @if (_OBJVALUE($departmentTask, 'note'))
                    @foreach (_OBJVALUE($departmentTask, 'note') as $item)
                        <div style="{{$display_property}}">
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
                <div id="note_area" style="{{$display_property}}">
                </div>
                <hr>
                <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 data-table"> 
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="min-width: 100px">Time</th>
                                <th style="min-width: 100px">by</th>
                                <th style="min-width: 100px">Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deparemntNote as $index => $item)
                                <?php $detail_uri = '/punch-clock/'.$item->edit_id ?>
                                <tr>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->time }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->user }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $item->Note }}</td>
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
                <input type="submit" value="Save Task" class="btn btn-primary">
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Note</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <textarea id="note_text" rows="4" class="form-control" placeholder="Write New Note" spellcheck="false"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="addNote()" >Add</button>
                </div>
            </div>
        </div>
    </div>
    
<script>
    $(document).ready(function() {
        $("#depart").val({{ @$departid }});
        $('.data-table').DataTable();
    });
    
    const init_modal = () => {
        $("#note_text").val("");
    }

    function addNote(){
        const content = $("#note_text").val();
        if(content == '') {
            toastr.warning('Input new note.', 'Warning');
            return;
        }
        const element = `<div class="mb-3"><textarea name="note[]" rows="4" class="form-control" placeholder="Write New Note">${content}</textarea> </div>`;
        $("#note_area").append(element);
        $("#exampleModal").modal('hide');
    }
</script>
@endsection