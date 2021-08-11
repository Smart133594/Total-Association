@foreach($data as $d)
    <tr>
        <td>
            {{$d->documentName}}
        </td>
        <td>
            {{$d->uploadOn}}
        </td>
        <td>
            {{$d->uploadedBy}}
        </td>
        <td>
            <a href=":javascript" data-toggle="tooltip" data-placement="top" title="{{$d->description}}">Documents</a>
        </td>

        <td class="action">

            <div class="dropdown show">
                <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-th"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/upload/{{$d->documents}}" target="_blank">View Documents</a>
                    <a class="dropdown-item" href="javascript:"  data-toggle="modal" data-target="#exampleModal">Replace Documents</a>
                </div>
            </div>
        </td>

    </tr>
@endforeach
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
