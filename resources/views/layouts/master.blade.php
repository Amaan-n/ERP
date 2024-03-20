<?php
$is_RTL_enabled = \Illuminate\Support\Facades\App::getLocale() === 'ar' ? 'rtl' : '';
?>

<!DOCTYPE html>
<html lang="en" direction="{{ $is_RTL_enabled ?? '' }}" dir="{{ $is_RTL_enabled ?? '' }}"
      style="direction: {{ $is_RTL_enabled ?? '' }}">
<head>
    <base href="">
    <meta charset="utf-8"/>
    @include('layouts.style')
</head>

@php $current = \Route::currentRouteName(); @endphp
<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading
                {{ in_array($current, ['']) ? 'aside-minimize' : '' }} aside-minimize {{ in_array($current, ['pos.create']) ? '' : 'custom_zoom' }}">

@include('layouts.header')

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        @include('layouts.sidebar')

        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('layouts.header_content')
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                @yield('content')
            </div>
            {{--@include('layouts.footer')--}}
        </div>
    </div>
</div>

@include('layouts.user_slider')
@include('layouts.notes_slider')

@include('layouts.scroll_top')
@include('layouts.script')
@yield('page_js')
</body>
</html>
