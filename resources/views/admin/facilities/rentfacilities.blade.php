@extends('admin.layouts.master')
@section('title', 'Rent a Facilities')
@section('content')
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item " aria-current="page"><a href="#">Facilities Rental</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('facilities.index')}}">Facilities</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Rent a Facilities</a></li>
                    </ol>
                </nav>
                <div class="ms-panel">
                    <div class="ms-panel-header ms-panel-custome">
                        <h6>Rent a Facilities</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('admin.includes.msg')

                        <div class="row">
                            @foreach($facilitiestype as $f)
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <a href="/checkavailability/{{$f->edit_id}}">
                                        <div class="ms-card">
                                            <div class="ms-card-img">
                                                <img src="{{"/upload/".$f->image}}" alt="card_img" style="height: 200px;width:100%">
                                            </div>
                                            <div class="ms-card-body">
                                                <h6>{{$f->typeName}}</h6>
                                                <p>{{$f->typeDescription}}</p>
                                                <p><b>Rental Period :</b>
                                                    @php $price="";
                                                        if($f->isHourly==1){ $price.=" Hourly -"; }
                                                        if($f->isDaily==1){ $price.=" Daily -"; }
                                                        if($f->isWeekly==1){ $price.=" Weekly -"; }
                                                        if($f->isMonthly==1){ $price.="  Monthly -"; }
                                                        if($f->isYearly==1){ $price.="  Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                                    @endphp
                                                    <br>
                                                    <b>Price:</b>
                                                    @php $price="";
                                                        if($f->isHourly==1){ $price.=" $".$f->HourlyPrice."/Hourly -"; }
                                                        if($f->isDaily==1){ $price.=" $".$f->DailyPrice."/Daily -"; }
                                                        if($f->isWeekly==1){ $price.=" $".$f->WeeklyPrice."/Weekly -"; }
                                                        if($f->isMonthly==1){ $price.=" $".$f->MonthlyPrice."/Monthly -"; }
                                                        if($f->isYearly==1){ $price.=" $".$f->YearlyPrice."/Yearly -"; }
                                                        echo $price=substr($price,0,-2);
                                                    @endphp
                                                    <br>
                                                    <b>Rented To :</b> @if($f->residentOnly==1) Residents Only @else All @endif</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection


