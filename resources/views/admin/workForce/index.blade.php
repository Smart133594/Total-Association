@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
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
    <div class="ms-content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="material-icons">home</i> Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Work Force</a></li>
            </ol>
        </nav>
        <div class="ms-panel">
            <div class="ms-panel-header ms-panel-custome">
                <h2>Work Force</h2>
                <a href="{{route('work-force.create')}}" class="ms-text-primary">Add Worker</a>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                    <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 data-table">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th style="min-width: 120px;">Name</th>
                                <th style="width: 80px;">Date of birth</th>
                                <th style="min-width: 120px;">Email</th>
                                <th>Phone</th>
                                <th>Whatsapp</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workers as $index => $worker)
                                <?php $detail_uri = '/work-force/'.$worker->edit_id ?>
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->firstname }} {{ $worker->middlename }} {{ $worker->lastname }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->birthday }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->email }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->phone }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->whatsapp }}</td>
                                    <td class="text-flow" onclick="goto('{{ $detail_uri }}')">{{ $worker->departname }}</td>
                                    <td>@if($worker->active_state==0)<i class="fas fa-dot-circle dot-green"></i>@else<i class="fas fa-dot-circle dot-red"></i>@endif </td>
                                    <td class="action">
                                        <div class="dropdown show">
                                            <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-th"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <button class="dropdown-item" onclick="window.location.href='{{ $detail_uri }}'">Show Info</button>
                                                <button class="dropdown-item" onclick="window.location.href='/work-force/{{ $worker->edit_id }}/edit'">Edit</button>
                                                @if($worker->active_state==0)
                                                <form action="{{ route('work-force.destroy',$worker->edit_id) }}" method="post">
                                                    @method("delete")
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to archive this? ')">Archive</button>
                                                </form>
                                                @else
                                                <form  action="/work-force/set-active/{{$worker->edit_id}}" method="get">
                                                    @method("delete")
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to active this? ')">Active</button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
        });
        function goto(url) {
            window.location.href = url;
        }
        function deleteEmployee(){
            toastr.warning('Employee cannot be deleted.', 'Warning');
            return;
        }
    </script>
@endsection