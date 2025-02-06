<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MROIS</title>
    <style>
        body {
            font-family: Arial, sans-serif !important;
            line-height: 1.6;
            color: #000;
        }

        pre {
            font-family: Arial, sans-serif !important;
        }

        /* Wrapper for the email content */
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            text-align: right;
            padding: 30px 0;
        }

        /* Logo styles */
        img.logo {
            max-width: 100px !important;
            max-height: 80px !important;
            text-align: right;
        }

        /* Main content styles */
        .content {
            background-color: #fff;
            /* White background for content */
            padding: 20px;
        }

        /* Call to action button styles */
        .cta-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #23336c;
            /* Blue button background */
            color: #fff;
            /* White text color */
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* Footer styles */
        .footer {
            text-align: center;
            padding: 20px 0;
        }

    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="header">
            <img class="logo" src="{{asset('assets/img/logo.png')}}" alt="Logo">
        </div>
        <div class="content">
            <p>Dear {{$displayName}},</p>
            <p>{!! $info !!}</p>
            <p>Thank You.</p>
            <p style="margin-top: -8px;">FMDQ Securities Exchange</p>
        </div>
        <div class="footer">
            &copy; {{date('Y')}} FMDQ Group. All rights reserved.
        </div>
    </div>
</body>

</html>
