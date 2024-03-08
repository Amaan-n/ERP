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
                        <form method="POST" action="{{ route('password.update') }}" class="reset_password_form"
                              id="reset_password_form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="pb-5 pb-lg-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">{{ __('Reset Password') }}</h3>
                            </div>

                            <div class="form-group mb-15">
                                <label class="font-size-h6 font-weight-bold" for="email">
                                    {{ __('E-Mail Address') }}
                                </label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="text" name="email" id="email"
                                    autocomplete="off" value="{{ $email ?? old('email') }}"/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-15">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bold" for="password">
                                        {{ __('Password') }}
                                    </label>
                                </div>

                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       autocomplete="current-password" autofocus>

                                @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-15">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bold" for="password-confirm">
                                        {{ __('Confirm Password') }}
                                    </label>
                                </div>
                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       autocomplete="new-password">
                            </div>

                            <div class="pb-lg-0 pb-5">
                                <button type="submit" class="btn btn-primary font-size-h6">
                                    {{ __('Reset Password') }}
                                </button>
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
