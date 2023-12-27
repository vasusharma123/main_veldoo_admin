<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Register Template</title>
    <style>
        *,
        body,
        html {
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Heebo', sans-serif;
        }

        a.btn:hover {
            background: #34657F !important;
            box-shadow: none !important;
        }

    </style>
</head>
<body style="background: #f9f9f9; padding: 20px;">
    <div class="email_template">
        <div class="email_body" style=" max-width: 594px; margin:auto; background: white;">
            <div class="header" style="padding: 35px 50px;">
                <div class="brand">
                    <img src="{{ asset('images/email_templates/logo.png')}}" alt="logo" style="max-width: 179px;" />
                </div>
            </div>
            <div class="main_body">
                <h1 class="title" style="color: #060F21; font-size: 35px; font-weight: 700; text-align: center; margin: 50px;">Thank you for registration</h1>
                <p class="msg" style="color: #060F21; font-size: 16px; line-height: 28px; text-align: center; padding: 0px 20px 50px 20px;">You have successfully finished the first part of the registration process.</p>
                <img src="{{ asset('images/email_templates/mansearch.png')}}" alt="Search" style="max-width: 247px; margin: auto; display: block; padding-bottom: 50px;" />
                <p class="msg" style="color: #060F21; font-size: 16px; line-height: 28px; text-align: center; padding: 0px 20px 50px 20px;">Please confirm your email address by tapping the link below.</p>
                <div class="btnaction" style="text-align: center; display: block; padding-bottom: 35px;">
                    <a href="{{ route('serviceProviderVerify', $token) }}" class="btn" style="background: #FC4C02; color: white; padding: 13px; text-decoration: none; font-weight: 500; font-size: 20px; border-radius: 46px; box-shadow: 0px 3px 8px #00000040; display: inline-block;">Confirm email address</a>
                </div>
            </div>
            <!-- /Body-->
            <div class="footer" style="background: #20262E; padding: 35px;">
                <div class="divider_hr" style="height: .5px; background: #D9D9D9; display: block;"></div>
                <table style="margin-top: 35px;">
                    <tr>
                        <td style="width: 76%;">
                            <a href="veldoo.com" target="_blank" style="font-family:'Arial-Regular', Helvetica; color:#f5f5f7; font-size: 14px;">Our stores</a>
                        </td>
                        <td>
                            <p class="footerText" style="font-family:'Arial-Regular', Helvetica;  color: #f5f5f7; font-size: 14px;">Follow us on social</p>
                        </td>
                    </tr>
                </table>
                <table style="margin-top: 35px;">
                    <tr>
                        <td style="width: 67%;">
                            <p class="footerText" style="font-family:'Arial-Regular', Helvetica;  color: #f5f5f7; font-size: 12px; line-height: 20px;">If you prefer not to receive emails like this, you may <a href="veldoo.com" target="_blank" style="color: #f5f5f7; text-decoration: underline; ">unsubscribe</a> © 2023 Veldoo. All rights reserved.</p>
                        </td>
                        <td>
                            <div class="social" style="text-align: right;">
                                <a href="#" style="text-decoration: none;">
                                    <img src="{{ asset('images/email_templates/twitter.png')}}" alt="Twitter" style="max-width: 26px;">
                                </a>
                                <a href="#" style="text-decoration: none;">
                                    <img src="{{ asset('images/email_templates/youtube.png')}}" alt="youtube" style="max-width: 26px;">
                                </a>
                                <a href="#" style="text-decoration: none;">
                                    <img src="{{ asset('images/email_templates/fb.png')}}" alt="facebook" style="max-width: 26px;">
                                </a>
                                <a href="#" style="text-decoration: none;">
                                    <img src="{{ asset('images/email_templates/insta.png')}}" alt="Instagram" style="max-width: 26px;">
                                </a>
                                <a href="#" style="text-decoration: none;">
                                    <img src="{{ asset('images/email_templates/tiktok.png')}}" alt="Tik Tok" style="max-width: 26px;">
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
