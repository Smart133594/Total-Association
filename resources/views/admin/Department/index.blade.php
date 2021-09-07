@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
<style>
    .btn-sm {
        min-width: 0 !important;
    }
</style>

<style>
    table {
        table-layout: fixed;
        border-collapse: collapse;
        width: 100%;
        max-width: 100px;
    }
    td.text-flow {
        white-space: nowrap; 
        width: 100px; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@php
    use Illuminate\Support\Facades\Crypt;
@endphp
    <div class="ms-content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Work Force</a></li>
            </ol>
        </nav>
            @include('admin.includes.msg')
            @foreach ($departments as $index => $department)
            <div class="ms-panel">
                <div class="ms-panel-header">
                    <h2>{{$department->department}}</h2>
                </div>
                <div class="ms-panel-body">
                    <div class="ms-panel-custome mb-2">
                        <div class="col-6" style="margin-left: -15px;">
                            <a href="{{route('department.show', $department->edit_id)}}" class="btn btn-sm btn-primary m-0">SOLO</a>
                            <a href="{{route('department.create', 'department='.$department->edit_id)}}" class="btn btn-sm btn-primary m-0">+</a>
                        </div>
                        <div class="col-6" style="margin-left: 25%;">
                            <select id="filter_emp_{{$department->id}}" onchange="submit_func({{$departments}})" class="form-control" style="width: 52%;">
                                <option value="-1">All Workers</option>
                                @foreach ($workforce as $value)
                                @php
                                    $selected = false;
                                    if(isset($_GET['emp_'.$department->id])) {
                                        $selected = $_GET['emp_'.$department->id] == $value->id;
                                    }
                                @endphp
                                    <option value='{{$value->id}}' {{$selected ? "selected" : ""}}>{{$value->firstname.' '.$value->middlename.' '.$value->lastname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th style="min-width: 100px;">Worker</th>
                                <th style="min-width: 100px;">Due Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Desc</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $priorities = ['High', 'Medium', 'Low'];
                            $colors = ['rgba(255, 0, 0, 0.1)', 'rgba(255, 255, 0, 0.2)', 'rgba(0, 0, 255, 0.1)'];
                            $states = ['Assigned', 'In Progress', 'On Hold', 'Canceled', 'Done'];
                            @endphp
                            @foreach ($department->Tasks as $index => $task)
                                <tr style="background-color: {{$colors[$task->priority]}}">
                                    <td>{{ $index+1 }}</td>
                                    <td class="text-flow">{{ $task->task }}</td>
                                    <td class="text-flow">
                                        @if ($task->Worker)
                                            {{ $task->Worker->firstname }} {{ $task->Worker->middlename }} {{ $task->Worker->lastname }}
                                        @endif
                                    </td>
                                    <td class="text-flow">{{ date("M d, Y", strtotime($task->date)) }}</td>
                                    <td class="text-flow">{{ $priorities[$task->priority] }}</td>
                                    <td class="text-flow">{{ $states[$task->state] }}</td>
                                    <td class="text-flow">{{ $task->description }}</td>
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
                </div>
            </div>
            @endforeach
    </div>
<script>
    const submit_func = (data) => {
        console.log(data);
        var selected_emp = {};
        data.forEach(item => {
            var selected = $(`#filter_emp_${item.id}`).val();
            selected_emp = {...selected_emp, [`emp_${item.id}`]:selected};
            
        });
        const param = $.param(selected_emp);
        var url = location.protocol + "//" + location.host;
        url += "/department?" + param;
        location.href = url;
    }
    $(document).ready(function() {
        $('.data-table').DataTable();
    });
</script>
@endsection