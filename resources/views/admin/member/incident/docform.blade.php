@php $x=1; @endphp
@foreach($data as $d)
    <tr>
        <td class="text-flow">
            {{$x}}
        </td>
        <td class="text-flow">
            <a href="{{$d->documents}}" target="_blank">{{$d->documents}}</a>
        </td>
        <td class="text-flow">
            {{$d->type}}
        </td>
        <td class="text-flow">
            {{$d->uploadOn}}
        </td>
        <td class="text-flow">
            {{$d->uploadedBy}}
        </td>

        <td class="action">

            <div class="dropdown show">
                <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-th"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/upload/{{$d->documents}}" target="_blank">View Documents</a>
                </div>
            </div>
        </td>
    </tr>
    @php $x++; @endphp
@endforeach
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
