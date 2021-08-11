<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <title>Email template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ">
    <meta name="format-detection" content="telephone=no">
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!--<![endif]-->
    <style type="text/css">
        a {
            text-decoration: none;
            color: #f94848;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            -webkit-text-size-adjust: 100% !important;
            -ms-text-size-adjust: 100% !important;
            -webkit-font-smoothing: antialiased !important;
  
        }

        img {
            border: 0 !important;
            outline: none !important;
        }

        p {
            Margin: 0px !important;
            Padding: 0px !important;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0px;
            mso-table-rspace: 0px;
      
        }

        td, a, span {
            border-collapse: collapse;
            mso-line-height-rule: exactly;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        .em_defaultlink a {
            color: inherit !important;
            text-decoration: none !important;
        }

        span.MsoHyperlink {
            mso-style-priority: 99;
            color: inherit;
        }

        span.MsoHyperlinkFollowed {
            mso-style-priority: 99;
            color: inherit;
        }

        @media only screen and (min-width: 481px) and (max-width: 699px) {
            .em_main_table {
                width: 100% !important;
            }

            .em_wrapper {
                width: 100% !important;
            }

            .em_hide {
                display: none !important;
            }

            .em_img {
                width: 100% !important;
                height: auto !important;
            }

            .em_h20 {
                height: 20px !important;
            }

            .em_padd {
                padding: 20px 10px !important;
            }
        }

        @media screen and (max-width: 480px) {
            .em_main_table {
                width: 100% !important;
            }

            .em_wrapper {
                width: 100% !important;
            }

            .em_hide {
                display: none !important;
            }

            .em_img {
                width: 100% !important;
                height: auto !important;
            }

            .em_h20 {
                height: 20px !important;
            }

            .em_padd {
                padding: 20px 10px !important;
            }

            .em_text1 {
                font-size: 16px !important;
                line-height: 24px !important;
            }

            u + .em_body .em_full_wrap {
                width: 100% !important;
                width: 100vw !important;
            }
        }

        td {
            font-family: 'Open Sans', Arial, sans-serif;
            font-size: 16px;
            line-height: 30px;
            color: #000000;
        }
.btn{
    background: #FFF;
    padding: 10px 30px;
    color: #0d1121;
}
    </style>
</head>

<body class="em_body" style="margin:0px; padding:0px;" bgcolor="#ffffff">
<table class="em_full_wrap" valign="top" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"
       align="center">
    <tbody>
    <tr>
        <td valign="top" align="center">
            <table class="em_main_table" style="width:700px;" width="700" cellspacing="0" cellpadding="0" border="0"
                   align="center">

                <!--Banner section-->
                <tr>
                    <td valign="top" align="center">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody>
                            <tr>
                                <td valign="top" align="center"><img class="em_img" alt="logo"
                                                                     style="display:block; font-family:Arial, sans-serif; font-size:30px; line-height:34px; color:#000000; max-width:700px;"
                                                                     src="{{ url('http://totalassociation.rocknik.baby/mail/new_banner.png') }}"
                                                                     width="700" border="0" ></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!--//Banner section-->
                <!--Content Text Section-->
                <tr>
                    <td style="padding:30px 15px;" class="em_padd" valign="top" bgcolor="#f6f7f8">
                        @if(isset($details))
                            {!! $details !!}
                            @endif
                           
                    </td>
                </tr>

                <!--//Content Text Section-->
                <!--Footer Section-->
                <tr>
                    <td  class="em_padd" valign="top" bgcolor="#f6f7f8" align="center">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="background:url('http://totalassociation.rocknik.baby/mail/footer.jpg')  no-repeat;height: 88px;background-size: cover;border-bottom: 2px solid #455879;">
                            <tbody>
                            <tr>
                                <td style="font-family:'Open Sans', Arial, sans-serif; font-size:11px; line-height:18px; color:#ffffff;padding:15px"
                                    valign="top" align="right">
                                    Manors of Inverrary Building XII Association, Inc.<br>
                                    Lauderhill, Florida,  USA - 33319

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="em_hide" style="line-height:1px;min-width:700px;background-color:#ffffff;"><img alt=""
                                                                                                               src=""
                                                                                                               style="max-height:1px; min-height:1px; display:block; width:700px; min-width:700px;"
                                                                                                               width="700"
                                                                                                               border="0"
                                                                                                               height="1">
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    </tbody>
</table>
<div class="em_hide" style="white-space: nowrap; display: none; font-size:0px; line-height:0px;">&nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
</body>
</html>
