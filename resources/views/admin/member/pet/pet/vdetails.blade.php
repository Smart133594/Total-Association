@php $vacc=json_decode($pettype->vaccinations_list,true); @endphp
@php $vdescription=json_decode($pettype->description,true); @endphp
@php $vrequired_by_law=json_decode($pettype->required_by_law,true); @endphp
@php $vdoc_status=json_decode($pettype->doc_status,true); @endphp




@if($vacc) @php $x=1; @endphp
@foreach($vacc as $k=>$va)
    @php $class=strtolower(str_replace(" ","-",$va));  @endphp
    <tr>
        <td>{{$x}}</td>
        <td>{{$va}}</td>
        <td class="exp_{{ $class }}"> @if(isset($pet_document[$class]->exp_date)) {{ $pet_document[$class]->exp_date }} @endif</td>
        <td>@if(isset($vrequired_by_law[$k])) @if($vrequired_by_law[$k]==1) Yes @else No @endif @endif</td>
        <td><img src="/assets/img/info.png" onclick="sweetBasic('{{$vdescription[$k]}}','Details')"></td>
        <td style='@if($vdoc_status[$k]=="Current") color:#4caf50 @else color:#f44336  @endif'>{{ $vdoc_status[$k]  }}</td>

        <td class="action">

            <div class="dropdown show">
                <a class="cust-btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    <i class="fas fa-th"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#exampleModal" onclick="uploaddoc('{{$class}}')">Upload
                        Documents</a>
                    <a class="dropdown-item" href="javascript:" data-toggle="modal" data-target="#details" onclick="showdocuments('{{$class}}','{{$ref}}')">Show
                        Documents</a>
                </div>
            </div>
        </td>

    </tr>
    @php $x++; @endphp
@endforeach
@endif
