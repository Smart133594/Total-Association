@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
<style>
    .btn-sm {
        min-width: 0 !important;
    }
</style>
    <div class="ms-content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Task List</a></li>
            </ol>
        </nav>
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h2>To Do List</h2>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                <h4>Administration</h4>
                <div style="width: 150px" class="mb-3">
                    <select name="employees" id="employees" class="form-control">
                        <option value="">Active</option>
                        <option value="">Archived</option>
                        <option value="">Both</option>
                    </select>
                </div>
                <table class="table table-striped thead-primary w-100 data-table">
                    <div class="ms-panel-custome mb-2">
                        <h6>{{ $department->department }}</h6>
                        <a href="{{route('department.create', 'department='.$department->edit_id)}}" class="btn btn-sm btn-primary m-0">+</a>
                    </div>
                    <table class="table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Worker</th>
                                <th>Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Desc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                             $priorities = ['High', 'Medium', 'Low'];
                             $states = ['Assigned', 'In Progress', 'On Hold', 'Canceled', 'Done'];
                            @endphp
                            @foreach ($department->Tasks as $index => $task)
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $task->task }}</td>
                                    <td>
                                        @if ($task->Worker)
                                            {{ $task->Worker->firstname }} {{ $task->Worker->middlename }} {{ $task->Worker->lastname }}
                                        @endif
                                    </td>
                                    <td>{{ date("M d, Y", strtotime($task->date)) }}</td>
                                    <td>{{ $priorities[$task->priority] }}</td>
                                    <td>{{ $states[$task->state] }}</td>
                                    <td>{{ $task->description }}</td>
                                    <td class="action">
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <button class="dropdown-item" onclick="window.location.href='/department/{{ Crypt::encryptString($task->id) }}/edit'">Edit</button>
                                                <form action="{{ route('department.destroy',Crypt::encryptString($task->id)) }}" method="post">
                                                    @method("delete")
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to delete this task? ')">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                </table>
                <hr>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function() {
        $('.data-table').DataTable();
    });
</script>
@endsection