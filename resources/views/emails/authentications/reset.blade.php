<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>

    <style type="text/css">

        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');

        body {
            margin-top: 0;
            margin-left: 0;
            font-family: Source Sans Pro;
            font-weight: normal;
            font-style: normal;
        }

        .content {
            position: relative;
            overflow: hidden;
            padding: 0;
            border: none;
        }

        .content .page-content {
            border: none;
            margin: 30px 0 0 24px;
            padding: 0;
            overflow: hidden;
            width: 750px;
        }

        .content .logo {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 685px;
            /*height: 836px;*/
            vertical-align: bottom;
        }

        .table td {
            vertical-align: top;
        }

        h4, th, td, h2, p {
            font-family: Source Sans Pro;
            margin: 10px 0;
        }

        .item_details td {
            color: #626b6b;
        }

        .grey {
            color: #626b6b;
        }
    </style>
</head>
<body>

<div class="content" style="font-family:Verdana">
    <div class="page-header">
        <div class="logo">
            <center>
                @if(!empty($configuration['actual_logo']) && !empty($configuration['name']))
                    <a href="{{ route('home') }}" class="login-logo text-center">
                        <img
                            src="{{ config('constants.s3.asset_url') . $configuration['actual_logo'] }}"
                            alt="{{ $configuration['name'] }}" width="300">
                    </a>
                @endif
            </center>
        </div>
    </div>
    <div class="page-content">
        <hr>
        <br>

        <h1 class="grey">Here’s your verification code for reset password:
            <br><br>
            <span style="border: 1px solid grey; padding: 10px;">
                {{ isset($reset_password_token) ? $reset_password_token : '' }}
            </span>
        </h1>
        <br>
    </div>
</div>
</body>
</html>
