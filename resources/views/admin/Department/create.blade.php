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
                <input type="hidden" name="departmentid" id="departmentid" value="{{ _OBJVALUE($department, 'edit_id') }}">
                <input type="hidden" name="departmentTaskid" id="departmentTaskid" value="{{ _OBJVALUE($departmentTask, 'edit_id') }}">

                <h5>Add/Edit Task</h5>
                <div class="mb-3">
                    <input type="text" name="task" id="task" placeholder="Task" class="form-control" required value="{{ _OBJVALUE($departmentTask, 'task') }}">
                </div>
                <div class="mb-3">
                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Description">{{ _OBJVALUE($departmentTask, 'description') }}</textarea>
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
                <div class="col-md-8" style="margin-top: 2%;">
                    <input type="button" value="Save Task" onclick="saveTask()" class="btn btn-primary m-0 p-1">
                </div>
                <hr>
                <div class="row">
                    <div class="col-6"><h5>Note</h5></div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary" style="min-width: 5px !important; margin-top: -3px; margin-left: 90%;" onclick="init_modal()">+</button>
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
                    <tbody id="noteBody">
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
                                        <a class="dropdown-item" href="#" onclick="editFile({{$val->id}}, {{$val->note}})">Edit</a>
                                        <a class="dropdown-item" href="#" onclick="deleteFile({{$val->id}})">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add File</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <textarea id="file_note" rows="4" class="form-control" placeholder="Write Details Note" spellcheck="false"></textarea><br>
                    <div class="form-group">
                        <input type="file" id="file" style="display: none;" name="logo" onchange="previewA(this)">
                        <div class="row" style="margin-left:20px">
                            <label for="file" class="col-md-3 btn btn-primary">Upload File</label><br>
                            <label class="col-md-3" id="fileName" style="margin-top: 25px;"></label><br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="button" value="Save File" onclick="addFile()" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>
</form>

    <div class="modal fade" id="note_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Note</h5>
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
    
    <div class="modal fade" id="note_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <input type="text" id="noteid" hidden>
                    <textarea id="note_edit_text" rows="4" class="form-control" placeholder="Write New Note" spellcheck="false"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="update_note()">Change</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="note_delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Note</h5>
                </div>
                <div class="modal-body" id="modal-details">
                    <h4>Do you want to delete this note?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="delete_note()">Delete</button>
                </div>
            </div>
        </div>
    </div>

<script>

    function previewA(input) {
        $("#fileName").append(input.files[0]['name']);
    }
    
    var edit_id = -1;

    $(document).ready(function() {
        $("#depart").val({{ @$departid }});
        $('#data-table1').DataTable();
        $('#data-table2').DataTable();
    });
    
    const init_modal = () => {
        $("#departmentTaskid").val("36");
        if($("#departmentTaskid").val() == "")
        {
            toastr.warning('First, register task.', 'Warning');
            return;
        }
        $("#note_modal").modal('show');
        $("#note_text").val("");
    }

    function saveTask()
    {
        var departmentid = $("#departmentid").val();
        var workderId = $("#workerid").val();
        var task = $('#task').val();
        var description = $('#description').val();
        var date = $("#date").val();
        var priority = $("#priority").val();
        var state = $("#status").val();
        if(task == '' || description == '' || date == ''){
            toastr.warning('Input above values.(task, description or date)', 'Warning');
            return;
        }
        var formData = new FormData();
        formData.append('departmentid', departmentid);
        formData.append('workerid', workderId);
        formData.append('task', task);
        formData.append('description', description);
        formData.append('date', date);
        formData.append('priority', priority);
        formData.append('state', state);
        formData.append('_token', "{{csrf_token()}}");
        console.log(formData);
        $.ajax({
            url: '/department/add_task_note',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#departmentTaskid").val(data);
                toastr.success('Task register success', 'Success');
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
    }

    function addNote(){
        $("#departmentTaskid").val('36');
        const content = $("#note_text").val();
        if(content == '') {
            toastr.warning('Input new note.', 'Warning');
            return;
        }
        
        var formData = new FormData();
        formData.append('departmenttaskid', $("#departmentTaskid").val());
        formData.append('note', content);
        formData.append('_token', "{{csrf_token()}}");
        console.log(formData);
        $.ajax({
            url: '/department/add_note',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data.length);
                drawTable(data);
                toastr.success('Note added', 'Success');
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
        $("#note_modal").modal('hide');
    }

    function editNote(id) {
        $("#noteid").val(id);
        var formData = new FormData();
        formData.append('id', id);
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
            url: '/department/get_note',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data[0]['note']);
                $("#note_edit_text").val(data[0]['note']);
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
        $("#note_edit_modal").modal('show');

    }

    function update_note() {
        var formData = new FormData();
        formData.append('id', $("#noteid").val());
        formData.append('note', $("#note_edit_text").val());
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
            url: '/department/edit_note',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data);
                drawTable(data);
                toastr.success('Note updated', 'Success');
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
        $("#note_edit_modal").modal('hide');
    }

    function deleteNote(id) {
        $("#noteid").val(id);
        $("#note_delete_modal").modal('show');
    }

    function delete_note(){
        var formData = new FormData();
        formData.append('id', $("#noteid").val());
        formData.append('_token', "{{csrf_token()}}");
        $.ajax({
            url: '/department/delete_note',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                drawTable(data);
                toastr.success('Note deleted', 'Success');
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
        $("#note_delete_modal").modal('hide');
    }

    function addFile(){
        $("#departmentTaskid").val('36');
        const content = $("#file_note").val();
        var file = $("#file").val();

        if(content == '') {
            toastr.warning('Input new note.', 'Warning');
            return;
        }
        if(file == "" ){
            toastr.warning('Input new file.', 'Warning');
            return;
        }

        console.log(content);
        console.log(file);
        
        var formData = new FormData();
        formData.append('departmenttaskid', $("#departmentTaskid").val());
        formData.append('note', content);
        formData.append('file', file);
        formData.append('_token', "{{csrf_token()}}");
        console.log(formData);
        $.ajax({
            url: '/department/add_file',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                console.log(data.length);
                drawTable(data);
                toastr.success('File added', 'Success');
                return;
            },
            error: function(err) {
                console.log({err});
            }
        });
        $("#note_modal").modal('hide');
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

    function drawTable(data)
    {
        $('#noteBody').empty();
        var html = ' ';
        var k = 1;
        for(i = 0; i < data.length; i ++)
        {
            html +=     '<tr role="row" class="odd">';
            html +=        '<td class="sorting_1">' + k + '</td>';
            html +=        '<td class="sorting_1">' + data[i]['created_at'] + '</td>';
            html +=        '<td class="sorting_1">' + data[i]['name'] + '</td>';
            html +=        '<td class="sorting_1">' + data[i]['note'] + '</td>';
            html +=        '<td class="action">';
            html +=            '<div class="dropdown show">';
            html +=                '<a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            html +=                    '<i class="fas fa-th ms-text-primary"></i>';
            html +=                '</a>';
            html +=                '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            html +=                    '<a class="dropdown-item" onclick="editNote(' + data[i]['id'] + ')">Edit</a>';
            html +=                    '<a class="dropdown-item" onclick="deleteNote(' + data[i]['id'] + ')">Delete</a>';
            html +=                '</div>';
            html +=            '</div>';
            html +=        '</td>';
            html +=    '</tr>';
            k ++;
        }
        $('#noteBody').append(html);
    }

</script>

@endsection