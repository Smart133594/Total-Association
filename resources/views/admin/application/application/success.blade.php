<html>
<head>
    <title>

        @if($data->paymentStatus==1)
            Payment Successful
        @else
            Payment Fail
        @endif


    </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <style type="text/css">

        body {
            background: #ccc;
        }

        .payment {
            border: 1px solid #f2f2f2;
            height: 555px;
            border-radius: 3px;
            background: #fff;
        }

        .payment_header {
            padding: 50px 20px 0px 20px;
        }

        .check {
            margin: 0px auto;
            width: 50px;
            height: 50px;
            border-radius: 100%;
            background-color: rgb(55 178 121);
            text-align: center;
        }

        .check i {
            vertical-align: middle;
            line-height: 50px;
            color: #FFF;
            font-size: 30px;
        }

        .content {
            text-align: center;
        }

        .content h1 {
            font-size: 25px;
            padding-top: 25px;
        }

        .content a {
            width: 200px;
            height: 35px;
            color: #fff;
            border-radius: 3px;
            padding: 5px 10px;
            background: rgb(1 136 204);
            transition: all ease-in-out 0.3s;
        }

        .content a:hover {
            text-decoration: none;
            background: #000;
        }
td,th{
    padding: 10px 5px;
}
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="payment">
                <div class="payment_header">
                    <div class="check"><i class="fa fa-check" aria-hidden="true"></i></div>
                </div>
                <div class="content">
                    <h1>Payment Success !</h1>
                    <p>Thank you, We will contact you once your application is reviewed</p>
                    <center>
                    <table style="width:300px;margin: 30px 0px">
                        <tr>
                            <td>
                                Name
                            </td>
                            <td style="text-align: right">
                                {{$data->firstName}} {{$data->lastName}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Mobile Number
                            </td>
                            <td style="text-align: right">
                                {{$data->phoneNo}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Payment Type
                            </td>
                            <td style="text-align: right">
                                {{$data->paymentType}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Association
                            </td>
                            <td style="text-align: right">
                                {{$association->name}}
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Amount Paid
                            </th>
                            <th style="text-align: right">
                                ${{$data->amount}}
                            </th>
                        </tr>
                        <tr>
                            <td>
                                Transaction Id
                            </td>
                            <td style="text-align: right">
                                {{$data->transactionId}}
                            </td>
                        </tr>

                    </table>
                    </center>
                    <a href="#" onclick="print()">Print</a>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>






