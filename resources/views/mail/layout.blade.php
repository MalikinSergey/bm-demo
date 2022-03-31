<html>
<head>
    <title></title>

    <style>
        @media screen and (max-width: 600px) {

        }
    </style>

</head>
<body style="padding: 0; margin: 0">

<div bgcolor="#f2f3f4" style="margin:0;padding:0">

    <table bgcolor="#f2f3f4" width="100%" style="color: #333; font-size: 16px; font-family: Segoe,Roboto,Arial; min-width:320px" cellspacing="0" cellpadding="0" class="container">

        <tbody>
        <tr>

            <td>

                <table width="600" align="center" style="width:100%!important;max-width:600px;margin:0 auto" cellpadding="0" cellspacing="0">

                    <tr>

                        <td style="padding:32px 0">

                            <table width="100%" cellpadding="0" cellspacing="0">

                                <tr>

                                    <td bgcolor="#ffffff" style="padding: 32px; border-radius: 16px">

                                        <!--Контент внутри белой плашки-->

                                        <table width="100%" cellpadding="0" cellspacing="0">

                                            <tr>

                                                <td style="padding: 0 0 32px 0">

                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="width: 50%; text-align: left; vertical-align: top">
                                                                <img width="200" height="60" src="{{config('app.url')}}/mail/bm_logo.png" alt="Boyko Market" class="logo">
                                                            </td>

                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>

                                        </table>

                                        <!--линия-->

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 0 0px 32px 0px ">
                                                    <hr style="width: 100%; border: 0; border-bottom: 1px solid #e4e4e4; display:block; margin: 0">
                                                </td>
                                            </tr>
                                        </table>

                                        <!--/линия-->

                                        {{-- контет письма--}}

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 0 0 32px 0; line-height: 1.375">

                                                    @section('content')

                                                    @show

                                                </td>
                                            </tr>

                                        </table>

                                        {{-- контет письма--}}


                                    <!--линия-->

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 0 0px 0px 0px ">
                                                    <hr style="width: 100%; border: 0; border-bottom: 1px solid #e4e4e4; display:block; margin: 0">
                                                </td>
                                            </tr>
                                        </table>

                                        <!--/линия-->

                                        <!--футер-->

                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 32px 0px 0px 0px">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="font-size: 10px; color: #bfbfbf; line-height: 1.4; vertical-align: top">
{{--                                                                boykomarket.com--}}
                                                            </td>
                                                            <td style="padding: 0 48px 0 48px; line-height: 1.4; vertical-align: top">

                                                            </td>
                                                            <td style="text-align: right; line-height: 1.4;  vertical-align: top; width: 30%" align="right">

                                                                © {{date('Y')}} <br>

                                                                Boyko Market

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--футер-->

                                        <!--/Контент внутри белой плашки-->

                                    </td>
                                </tr>

                            </table>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

</div>

</body>
</html>
