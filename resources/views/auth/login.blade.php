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
                        <form method="POST" action="{{ route('login') }}" class="login_form" id="login_form">
                            @csrf

                            @if(\Illuminate\Support\Facades\Session::has('notification'))
                                <div class="form-group mb-10">
                                    <div
                                        class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                                        <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                                    </div>
                                </div>
                            @endif

                            <div class="pb-5 pb-lg-15">
                                <h3 class="font-weight-bold font-size-h2 font-size-h1-lg">Sign In</h3>
                            </div>

                            <div class="form-group mb-15">
                                <label class="font-size-h6 font-weight-bold" for="email">
                                    {{ __('E-Mail Address') }}
                                </label>
                                <input
                                    class="form-control @error('email') is-invalid @enderror"
                                    type="text" name="email" id="email"
                                    autocomplete="off" value="{{ old('email') }}" autofocus/>

                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bold" for="password">
                                        {{ __('Password') }}
                                    </label>
                                </div>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pb-lg-0 pb-5">
                                <button type="submit" id="kt_login_singin_form_submit_button"
                                        class="btn btn-primary font-size-h6">Sign In
                                </button>
                            </div>

                            <div class="form-group mt-5 float-right">
                                @if (Route::has('password.reset'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-primary font-size-h6 text-hover-primary pull-right">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="right_card w-50">
            <div class="background_card font-size-h6 2-"
                 style="background-image: url('{{ config('constants.s3.asset_url') . $configuration['logo'] }}'); background-size: 70%">
                <div class="background_layer"></div>
            </div>
        </div>
    </div>
@endsection
