@extends('layouts.guest')

@section('content')

<link rel="stylesheet" href="{{ asset('landingpage/assets/css/custom.css') }}">
<div style="margin-top: 100px;"></div>


    <div class="container mt-5 mb-5"> <!-- Added mt-5 and mb-5 for spacing -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4"> <!-- Added shadow-sm and mb-4 for spacing and subtle shadow -->
                    <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                        <h4 class="sitename">{{ __('Login') }}</h4>
                    </div>
                    

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" 
                                       type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn text-white" style="background-color: #ce1212;">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            <!-- Forgot Password and Register Links -->
                            <div class="d-flex justify-content-between">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

                                @if (Route::has('register'))
                                    <a class="btn btn-link p-0" href="{{ route('register') }}">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
