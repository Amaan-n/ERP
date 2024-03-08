@extends('guest-layouts.master')

@section('content')
    <div class="w-100 h-100 d-flex bg-white">
        <div class="left_card w-50">
            <div class="d-flex align-items-center justify-content-center h-100">
                <div class="logo d-none">
                    <h1>{{ $configuration['name'] ?? 'Sample' }}</h1>
                </div>

                <div class="left_card_form border border-1">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}" class="reset_password_form"
                              id="reset_password_form">
                            @csrf

                            @if (session('status'))
                                <div class="alert alert-success mb-5 mb-lg-15" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="pb-5 pb-lg-15">
                                <h3 class="font-weight-bold font-size-h2">Forgotten Password ?</h3>
                                <p class="text-muted font-size-h6">
                                    Enter your email to reset your password
                                </p>
                            </div>

                            <div class="form-group">
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="{{ __('E-Mail Address') }}" name="email" autocomplete="email"
                                       autofocus/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group d-flex flex-wrap">
                                <button type="submit" id="kt_login_forgot_form_submit_button"
                                        class="btn btn-primary font-size-h6 mr-3">{{ __('Send Password Reset Link') }}
                                </button>
                                <a href="{{ route('login') }}" id="kt_login_forgot_cancel"
                                   class="btn btn-light-primary font-size-h6">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="right_card w-50">
            <div class="background_card font-size-h6"
                 style="background-image: url('{{ config('constants.s3.asset_url') . $configuration['logo'] }}'); background-size: 70%">
                <div class="background_layer"></div>
            </div>
        </div>
    </div>
@endsection
