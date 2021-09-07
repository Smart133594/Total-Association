@extends('admin.layouts.master')
@section('title', 'Application')
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
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Department</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('application_setting')}}">Depart Manage Setting</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Depart Manage Setting</h6>
                        <a class="ms-text-primary" href="#" data-toggle="modal" data-target="#input_modal">Add New</a>
                    </div>
                    <div class="ms-panel-body">
                        <table class="d-block d-md-table table-responsive table table-striped thead-primary w-100 data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width: 100px;">Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departs as $index => $item)
                                    <tr>
                                        <td class="text-flow">{{ $index+1 }}</td>
                                        <td class="text-flow">{{ $item->department }}</td>
                                        <td class="action">
                                            <div class="dropdown show">
                                                <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    @if ($index != 0)
                                                    <form action="{{ route('departmanage.show', Crypt::encryptString($item->id)) }}" method="get">
                                                        <button type="submit" class="dropdown-item">Move to Up</button>
                                                    </form>                                                        
                                                    @endif
                                                    @if ($index != count($departs) - 1)
                                                    <form action="{{ route('departmanage.edit', Crypt::encryptString($item->id)) }}" method="get">
                                                        <button type="submit" class="dropdown-item">Move to Down</button>
                                                    </form>                                                        
                                                    @endif
                                                    <form action="{{ route('departmanage.destroy', Crypt::encryptString($item->id)) }}" method="post">
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="input_modal" tabindex="-1" role="dialog" aria-labelledby="modal-7">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <div class="modal-header bg-primary">
              <h3 class="modal-title has-icon text-white"><i class="flaticon-share"></i> Add New</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('departmanage.store') }}" method="post">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="ms-form-group has-icon">
                  <label>Department</label>
                  <input type="text" required placeholder="Department" class="form-control" name="department" value="">
                </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary shadow-none">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
        });
    </script>
@endsection

