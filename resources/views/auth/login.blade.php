@extends('layouts.app')

@section('content')
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 d-flex align-items-center justify-content-between gap-5"> <!-- Added justify-content-between and gap-5 -->
        <!-- Logo Section -->
        <div class="col-md-5 text-center d-flex justify-content-center align-items-center">
            <span class="logo2 me-2 logo-hide"></span> <!-- Use custom class "logo-hide" for custom behavior -->
        </div>

        <!-- Login Form Section -->
        <div class="col-md-5 d-flex align-items-center wcard2 full-screen-form">
            <div class="w-100 pb-5 pt-5">
                <!-- <h1 class="wtitlesp text-center">Invoice Creator</h1> -->
                <h1 class="wtitlesp text-center">Log In</h1>
                
                <div class="row d-flex justify-content-center mb-5">
                    <div class="d-flex justify-content-center">
                        <!-- <h3 class="loginitem me-3">Don't have an account?</h3>
                        <h3 class="loginitem">Create Account Here</h3> -->
                    </div>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="loginitem2">{{ __('Email Address') }}</label>
                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror droptry2" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 pb-5">
                            <label for="password" class=" loginitem2">{{ __('Password') }}</label>
                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror droptry2" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input pinkcheck" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label loginitem3" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary logbutton">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link loginitem3" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
