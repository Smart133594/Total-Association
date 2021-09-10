@extends('admin.layouts.master')
@section('title', 'Access Device')
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
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('punch-clock.index') }}">Punch Clock</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Punch Clock Detail</a></li>
            </ol>
        </nav>
        <div class="ms-panel">
            <div class="ms-panel-header ms-panel-custome">
                <h2>Access Devices</h2>
            </div>
            <div class="ms-panel-body">
                @include('admin.includes.msg')
                <table id="data-table" class="d-block d-md-table table-responsive table table-striped thead-primary w-100">
                    <thead>
                        <tr role="row">
                            <th style="width: 40px">No.</th>
                            <th style="min-width: 100px">Name</th>
                            <th style="min-width: 100px">&nbsp; &nbsp; Serial Number</th>
                            <th style="min-width: 100px">IP Address</th>
                            <th class="no-sort">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $key => $item)
                            <tr role="row" class="odd">
                                <td>{{ $key + 1 }}</td>
                                <td class="row" id="td_name_{{ $item->id }}">
                                    {{ $item->name }} &nbsp;&nbsp;<span class="material-icons dot-primary" style="font-size: 20px"
                                        onclick="onEdit('{{ $item->name }}', {{ $item->id }})">edit</span>
                                </td>
                                <td class="text-flow">&nbsp; &nbsp; {{ $item->serial_number }}</td>
                                <td class="text-flow">{{ $item->ip_address }}</td>
                                <td>
                                    @if ($item->active == 1)
                                        <label class="ms-switch">
                                            <input type="checkbox" id="check_{{ $item->id }}" checked
                                                onclick="setStatus({{ $item->id }})">
                                            <span class="ms-switch-slider ms-switch-success round"></span>
                                        </label>
                                    @else
                                        <label class="ms-switch">
                                            <input type="checkbox" id="check_{{ $item->id }}"
                                                onclick="setStatus({{ $item->id }})">
                                            <span class="ms-switch-slider ms-switch-success round"></span>
                                        </label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        var current_edit = {
            id: 0,
            name: null
        }
        $(document).ready(function() {
            $('#data-table').DataTable({
                targets: 'no-sort',
                orderable: false
            });
        });
        const onEdit = (name, id) => {
            current_edit = { name, id };
            const html = `
            <input type='text' id='input_name_${id}' class='form-control col-md-8' value='${name}'>
            <span class="material-icons col-md-2 dot-primary" style="font-size: 20px" onclick="onSave(${id})">check_circle</span>
            <span class="material-icons col-md-2 dot-red" style="font-size: 20px; " onclick="onShow('${current_edit.name}', ${id})">cancel</span>
        `;
            $(`#td_name_${id}`).empty();
            $(`#td_name_${id}`).append(html);
        }
        const onSave = (id) => {
            const text = $(`#input_name_${id}`).val();
            if(!text) {
                toastr.warning('Please input the name.', 'Warning');
                return;
            }
            onShow(text, id);
          
            var formData = new FormData();
            formData.append('id', id);
            formData.append('type', "name");
            formData.append('name', text);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: `access-settings`,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                }
            });
        }
        const onShow = (text, id) => {
            current_edit = { name:null, id:0 };
            const html =
                ` ${text} &nbsp;&nbsp; <span class="material-icons dot-primary"style="font-size: 20px" onclick="onEdit('${text}', ${id})">edit</span>`;
            $(`#td_name_${id}`).empty();
            $(`#td_name_${id}`).append(html);
        }
        const setStatus = (id) => {
            const status = document.getElementById("check_" + id).checked;
            var formData = new FormData();
            formData.append('id', id);
            formData.append('status', status);
            formData.append('type', "status");
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: 'access-settings',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                }
            });
        }
    </script>
@endsection
