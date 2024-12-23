@extends('layouts.guest')

@section('content')

<link rel="stylesheet" href="{{ asset('landingpage/assets/css/custom.css') }}">
<div style="margin-top: 100px;"></div>
    <div class="container mt-5 mb-5"> <!-- Added mt-5 and mb-5 for spacing -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4"> <!-- Added shadow-sm and mb-4 for spacing and subtle shadow -->
                    <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                        <h4 class="sitename">{{ __('Register') }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name Field -->
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" 
                                       type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name" 
                                       autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" 
                                       type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                             <!-- Phone Number Field -->
                             <div class="form-group mb-3">
                                <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
                                <input id="phone_number" 
                                       type="phone_number" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       required 
                                       autocomplete="phone_number">
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>


                            <!-- Password Field -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" 
                                       type="password" 
                                       class="form-control" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password">
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn text-white" style="background-color: #ce1212;">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                @if (Route::has('login'))
                                    <a class="btn btn-link p-0" href="{{ route('login') }}">
                                        {{ __('Already have an account? Login') }}
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
