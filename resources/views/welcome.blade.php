@extends('guest-layouts.master')

@section('content')
    <div class="error error-6 d-flex flex-row-fluid bgi-size-cover bgi-position-center"
         style="background-image: url('{{ asset('theme/media/bg6.jpg') }}');">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-row-fluid text-center">
            <h1 class="error-title font-weight-boldest text-white mb-12" style="margin-top: 12rem;">Oops...</h1>
            <p class="display-4 font-weight-bold text-white">
                Looks like something went wrong.<br>
                We're working on it
            </p>
        </div>
        <!--end::Content-->
    </div>
@stop
