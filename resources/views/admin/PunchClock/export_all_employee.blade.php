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
        <table class="page" id="customers" align="center" style="width:90%;padding-bottom:auto; padding-top:auto">
            <tr>
                <th colspan="6" style="text-align: center; font-size:23px; width:500px; background-color:#92d050"><b>{{explode("-", $totalData[0]['from'])[0].".".explode("-", $totalData[0]['from'])[1].".".explode("-", $totalData[0]['from'])[2]}} ~ {{explode("-", $totalData[0]['to'])[0].".".explode("-", $totalData[0]['to'])[1].".".explode("-", $totalData[0]['to'])[2]}}</b></th>
            </tr>
            <tr><th colspan="6" style="height:60px"></th></tr>
        
        
            <tr>
                <td id="title" align="center"></td>
                <td id="title" style="width:150px"><b>Name</b></td>
                <td id="title" style="width:160px"><b>Login</b></td>
                <td id="title" style="width:160px"><b>Logout</b></td>
                <td id="title"><b>Lunch</b></td>
                <td id="title"><b>Total Time</b></td>
            </tr>
            @foreach ($totalData as $index => $employee)

                @foreach ($employee['totalArray'] as $index => $item)
                    <tr>
                        <td id="number">{{$index + 1}}</td>
                        
                        <td>{{$item['name']}}</td>
                        <td>{{$item['login']}}</td>
                        <td>{{$item['logout']}}</td>
                        <td>{{$item['lunch']}}</td>
                        <td id="time">{{$item['time']}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td id="title" style="text-align: right;" colspan="5"><b>Total:</b></td>
                    <td id="title"><b>{{$employee['totalTime']}}</b></td>
                </tr>
            @endforeach
        </table>
        
    </body>

</html>