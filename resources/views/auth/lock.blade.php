<!DOCTYPE html>

<html lang="en-us" class="no-js">

<head>
    <title>{{ $configuration['name'] }}</title>
    <meta charset="utf-8">
    <meta name="description" content="#">
    <meta name="keywords" content="{{ $configuration['name'] }}">
    <meta name="author" content="#">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" href="{{ config('constants.s3.asset_url') . $configuration['favicon'] }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/errors/css/style.css') }}"/>
</head>

<body>

<a href="{{ route('home') }}" class="logo-link" title="back home">
    <img src="{{ config('constants.s3.asset_url') . $configuration['logo'] }}" width="150"
         alt="{{ $configuration['name'] }}">
</a>

<div class="content">
    <div class="content-box">
        <div class="big-content">
            <div class="list-square">
                <span class="square"></span>
                <span class="square"></span>
                <span class="square"></span>
            </div>

            <!-- Main lines for the content logo in the background -->
            <div class="list-line">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
            <i class="fa fa-search" aria-hidden="true"></i>
            <div class="clear"></div>
        </div>

        <h1>Unlock your session</h1>
        <p>
            Your session is locked <br>
            Please enter valid password for
            {{ auth()->user()->email }}
        </p>

        <form action="{{ route('auth.unlock') }}" method="post"
              enctype="multipart/form-data" class="auth_form" id="auth_form">
            {{ csrf_field() }}

            <div class="text-center">
                <br>
                <div style="display: flex; justify-content: space-between">
                    <input type="password" class="form-control" name="password"
                           placeholder="Enter password" autofocus
                           style="margin: 0 1rem">
                    <button type="submit" class="btn btn-primary">
                        Unlock
                    </button>
                </div>

                @if(\Illuminate\Support\Facades\Session::has('notification'))
                    <span style="color: white; font-size: 1.5rem">
                        {{ \Illuminate\Support\Facades\Session::get('notification.message') }}
                    </span>
                @endif
            </div>
        </form>

        <div class="text-center">
            <br>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="btn btn-primary"
            >Sign Out</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
<footer class="light">
    <ul>
        <li><a href="javascript:void(0);">Support</a></li>
        <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
        <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
    </ul>
</footer>
<script src="{{ asset('theme/errors/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/errors/js/bootstrap.min.js') }}"></script>
<!-- Slideshow plugin -->
<script src="{{ asset('theme/errors/js/vegas.js') }}"></script>

</body>

</html>
