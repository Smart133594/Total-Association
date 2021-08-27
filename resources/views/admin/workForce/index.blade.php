@extends('admin.layouts.master')
@section('title', 'Work Force')
@section('content')
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
                <h2>All Worker</h2>
                <a href="{{route('work-force.create')}}" class="ms-text-primary">Add Worker</a>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                <table class="table table-striped thead-primary w-100 data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date of birth</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Whatsapp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workers as $index => $worker)
                            <?php $detail_uri = '/work-force/'.$worker->edit_id ?>
                            <tr>
                                <td>{{ $index }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $worker->firstname }} {{ $worker->middlename }} {{ $worker->lastname }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $worker->birthday }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $worker->email }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $worker->phone }}</td>
                                <td onclick="goto('{{ $detail_uri }}')">{{ $worker->whatsapp }}</td>
                                <td class="action">
                                    <div class="dropdown show">
                                        <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-th"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            <a class="dropdown-item" href="{{ $detail_uri }}">Show Info</a>
                                            <a class="dropdown-item" href="/work-force/{{ $worker->edit_id }}/edit">Edit</a>
                                            <form action="{{ route('work-force.destroy',$worker->edit_id) }}" method="post">
                                                @method("delete")
                                                @csrf
                                                <button type="submit" class="dropdown-item" onclick=" return confirm('Are you sure to delete this Worker? ')">Delete</button>
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
    </div>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
        });
        function goto(url) {
            window.location.href = url;
        }
    </script>
@endsection