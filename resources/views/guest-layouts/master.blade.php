<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>{{ $configuration['name'] }}</title>
    @include('layouts.style')
</head>

<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<div class="d-flex flex-column flex-root">
    @yield('content')
</div>

@include('layouts.scroll_top')
@include('layouts.script')
@yield('page_js')
</body>
</html>
