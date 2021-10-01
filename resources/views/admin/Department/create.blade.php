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
                <div style="width: 180px" class="mb-3" style="display: none;">
                    <label for="status" style="display: none;">Worker</label>
                    <select name="workerid" id="workerid" class="form-control" required style="display: none;">
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
                <div class="row">
                    <div class="col-6"><h5>File</h5></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary" style="min-width: 5px !important; margin-top: -3px; margin-left: 90%;" data-toggle="modal" data-target="#fileModal">+</button>
                    </div>
                </div>
                <br>
                <table id="data-table2" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                    <thead>
                    <tr role="row">
                        <th>#</th>
                        <th>Time</th>
                        <th>By</th>
                        <th>File Type</th>
                        <th>Note</th>
                        <th class="no-sort">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($tasks) &&  $tasks->count()>0)
                        @foreach ($tasks as $key => $val)
                        <tr role="row" class="odd">
                            <td class="sorting_1">{{$key+1}}</td>
                            <td class="sorting_1">{{$val->updated_at}}</td>
                            <td class="sorting_1">{{$val->workerid}}</td>
                            <td class="sorting_1">{{substr($val->image, -3)}} File</td>
                            <td class="sorting_1" id="td_file_{{$val->id}}">{{$val->description}}</td>
                            <td class="action">
                                <div class="dropdown show">
                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-th ms-text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#" onclick="editFile({{$val->id}})">Edit</a>
                                        <a class="dropdown-item" href="#" onclick="deleteFile({{$val->id}})">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <hr>
                <div class="row">
                    <div class="col-6"><h5>Note</h5></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary" style="min-width: 5px !important; margin-top: -3px; margin-left: 90%;" data-toggle="modal" data-target="#exampleModal" onclick="init_modal()">+</button>
                    </div>
                </div>
                <br>
                <table id="data-table1" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                    <thead>
                    <tr role="row">
                        <th>#</th>
                        <th>Time</th>
                        <th>By</th>
                        <th>Note</th>
                        <th class="no-sort" style="max-width:100px;align:center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (!empty($notes) &&  $notes->count()>0)
                        @foreach ($notes as $key => $val)
                        <tr role="row" class="odd">
                            <td class="sorting_1">{{$key+1}}</td>
                            <td class="sorting_1">{{$val->updated_at}}</td>
                            <td class="sorting_1">{{$val->userid}}</td>
                            <td class="sorting_1" id="td_note_{{$val->id}}">{{$val->note}}</td>
                            <td class="action">
                                <div class="dropdown show">
                                    <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-th ms-text-primary"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="#" onclick="editNote({{$val->id}})">Edit</a>
                                        <a class="dropdown-item" href="#" onclick="deleteNote({{$val->id}})">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <hr>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New File</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <textarea id="file_text" rows="4" class="form-control" placeholder="Write Details Note" spellcheck="false"></textarea><br>
                    <div style="width: 180px" class="mb-3">
                        <input type="file" class="form-control valid" required name="imageA" text="Upload file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" value="Save Task" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</form>

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
    
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <textarea id="note_text1" rows="4" class="form-control" placeholder="Write New Note" spellcheck="false"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="update_note()">Change</button>
                </div>
            </div>
        </div>
    </div>

<script>
    
    var edit_id = -1;

    $(document).ready(function() {
        $("#depart").val({{ @$departid }});
        $('#data-table1').DataTable();
        $('#data-table2').DataTable();
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

        $.get('add_note/' + content, function(data, status) {
            window.location.reload();
        });
        $("#exampleModal").modal('hide');
    }

    function deleteNote(id) {
        $.get('delete_note/' + id, function(data, status) {
            window.location.reload();
        });
    }

    function deleteFile(id) {
        $.get('delete_file/' + id, function(data, status) {
            window.location.reload();
        });
    }

    function editFile(id) {
        $("#file_text").val($("#td_file_"+id).html());
        edit_id = id;
        $("#fileModal").modal('show');
    }

    function editNote(id) {
        $("#note_text1").val($("#td_note_"+id).html());
        edit_id = id;
        $("#edit_modal").modal('show');
    }

    function update_note() {
        const content = $("#note_text1").val();
        if(content == '') {
            toastr.warning('Input new note.', 'Warning');
            return;
        }
        // var data = {
        //     id: edit_id,
        //     note: content,
        // }
        // $.get('update_note', data, function(data, status) {
        //     window.location.reload();
        // });

        $("#edit_modal").modal('hide');
    }

</script>

@endsection