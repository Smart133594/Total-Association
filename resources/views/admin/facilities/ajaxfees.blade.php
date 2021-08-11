@php $x=1; @endphp
@foreach($data as $d)
    <tr>
        <td>
            {{$x}}
        </td>

        <td>
            {{$d->fes_name}}
        </td>
        <td>
            $ {{ number_format($d->amount,2)}}
        </td>

        <td>
            <div class="onoffswitch">
                <input type="checkbox"  onchange="statuschange('facilities_fees','status',{{$d->id}})"  class="onoffswitch-checkbox" id="myonoffswitch{{$d->id}}" tabindex="0" @if($d->status==1) checked @endif>
                <label class="onoffswitch-label" for="myonoffswitch{{$d->id}}"></label>
            </div>
        </td>

    </tr>
    @php $x++; @endphp
@endforeach
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    function statuschange(table,field,id){
        var path='/statuschange/'+table+'/'+field+'/'+id;
        $.get(path,function(res){

        });
    }

</script>
