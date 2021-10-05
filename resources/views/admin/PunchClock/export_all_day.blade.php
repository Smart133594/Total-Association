<html>
    <head>
        <style>
        html{margin:40px 50px}
        table, th, td {
            font-size:16px;
            border: 1px solid black;
            border-collapse: collapse;
            width:auto;
            height:30px;
            text-align: center;

        }
        #title
        {
            background-color:#92d050;
        }
        #number
        {
            background-color: #d8e4bc;
            width: 30px;
        }
        #time
        {
            background-color: #d8e4bc;
        }
        #textleft
        {
            text-align: left;
        }
        #textright
        {
            text-align: right;
        }
        .page {
            page-break-inside: auto;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: unset;
        }
  </style>
        </style>
    </head>
    <body>
        @foreach ($totalData as $index => $employee)
        <table class="page" id="customers" align="center" style="width:80%;padding-bottom:auto; padding-top:auto">
            <tr>
                <th colspan="5" style="text-align: center; font-size:23px; width:500px; background-color:#92d050"><b>{{ $employee['employeename']}} Time Sheet</b></th>
            </tr>
            <tr><th colspan="5" style="height:60px"></th></tr>
            <tr>
                <td id="textleft" colspan="5"><b>{{ $employee['legalname']}}</b></td>
            </tr>
            <tr>
                <td id="textleft" colspan="2">{{ $employee['address1']}}</td>
                <td id="textright"><b>Employee Name:</b></td>
                <td colspan="2">{{ $employee['employeename']}}</td>
            </tr>
            <tr>
                <td id="textleft" colspan="2">{{ $employee['address2']}}</td>
                <td id="textright"><b>From Date</b></td>
                <td colspan="2">{{ $employee['from']}}</td>
            </tr>
            <tr>
                <td id="textleft" colspan="2">{{ $employee['city']}}</td>
                <td id="textright"><b>To Date:</b></td>
                <td colspan="2">{{ $employee['to']}}</td>
            </tr>
            <tr>
                <td id="textleft" colspan="2">{{ $employee['telphonenumber']}}</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td id="textleft" colspan="2">{{ $employee['emailaddress']}}</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
        
            <tr><td style="height:60px" colspan="5"></td></tr>
        
            <tr>
                <td id="title" align="center"></td>
                <td id="title" style="width:160px"><b>Login</b></td>
                <td id="title" style="width:160px"><b>Logout</b></td>
                <td id="title"><b>Lunch</b></td>
                <td id="title"><b>Total Time</b></td>
            </tr>
            @foreach ($employee['totalArray'] as $index => $item)
                <tr>
                    <td id="number">{{$index + 1}}</td>
                    
                    <td>{{$item['login']}}</td>
                    <td>{{$item['logout']}}</td>
                    <td>{{$item['lunch']}}</td>
                    <td id="time">{{$item['time']}}</td>
                </tr>
            @endforeach
            <tr>
                <td id="title" style="text-align: right;" colspan="4"><b>Total:</b></td>
                <td id="title"><b>{{$employee['totalTime']}}</b></td>
            </tr>
        </table>
        @endforeach
        
    </body>

</html>