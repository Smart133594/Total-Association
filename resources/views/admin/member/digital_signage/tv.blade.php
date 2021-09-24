<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$data->groupName}} | Digital Signage </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/css/digital_signage.css">
</head>
<body>

<div class="header">
    <div class="logo_section">
        <img src="{{'/upload/'.$data->logo}}" alt="Logo" style="height: 48px">
    </div>
    <div class="header_heading">
        <h1>Welcome to {{$data->groupName}}</h1>
    </div>
</div>


<div class="body_section">
    <div class="body_section_left">
        <div class="left_side_img" style="height: 100%;">
            <a class="weatherwidget-io" href="https://forecast7.com/en/26d12n80d14/fort-lauderdale/" data-label_1="FORT LAUDERDALE" data-label_2="WEATHER" data-days="5" data-theme="original" >FORT LAUDERDALE WEATHER</a>
            <script>
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
            </script>
            <img src="/assets/img/side_img.jpg" alt="image" style="height: 50%; background-size: cover;">
        </div>
    </div>

    <div class="body_section_right">
        <div class="big_img">
            <img src="{{'/upload/'.$data->image1}}" alt="image" style="height: 100%; background-size: cover;">
        </div>
        <div class="big_img">
            <img src="{{'/upload/'.$data->image2}}" alt="image" style="height: 100%; background-size: cover;">
        </div>
        <div class="big_img">
            <img src="{{'/upload/'.$data->image3}}" alt="image" style="height: 100%; background-size: cover;">
        </div>
    </div>
</div>

<div class="footer">
    <div class="footer_left">
        <iframe src="https://free.timeanddate.com/clock/i7qi5uos/n820/fn6/fs16/fcfff/tct/pct/ftb/pa8/tt0/tw1/th1/ta1/tb4" frameborder="0" width="213" height="56" allowtransparency="true"></iframe>
        </iframe>
    </div>
    <div class="footer_right">
        <marquee behavior="scroll" direction="left" class="scrollText footer_text">@if(!empty($data->heading1)) {{$data->heading1}} ...@endif
            @if(!empty($data->heading2)) {{$data->heading2}} ...@endif
            @if(!empty($data->heading3)) {{$data->heading3}} ...@endif
            @if(!empty($data->heading4)) {{$data->heading4}} ...@endif
            @if(!empty($data->heading5)) {{$data->heading5}} ...@endif
            @if(!empty($data->heading6)) {{$data->heading6}} ...@endif
            @if(!empty($data->heading7)) {{$data->heading7}} ...@endif
            @if(!empty($data->heading8)) {{$data->heading8}} ...@endif
            @if(!empty($data->heading9)) {{$data->heading9}} ...@endif
            @if(!empty($data->heading10)) {{$data->heading10}} ...@endif </marquee>
    </div>
</div>

<script>
    checkchange();
    function checkchange(){
        $.get("/checked_tv/{{$data->id}}",function(res){
            if(res>0){
                location.reload();
            }
        })
        setTimeout(function(){ checkchange() }, 300000);
    }

</script>

</body>
</html>
