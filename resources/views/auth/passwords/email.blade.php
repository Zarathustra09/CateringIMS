@extends('layouts.guest')

@section('content')

<link rel="stylesheet" href="{{ asset('landingpage/assets/css/custom.css') }}">

<div class="container mt-5 mb-5"> <!-- Added mt-5 and mb-5 for spacing -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4"> <!-- Added shadow-sm and mb-4 for spacing and subtle shadow -->
                <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                    <h4 class="sitename">{{ __('Reset Password') }}</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn text-white" style="background-color: #ce1212;">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-center">
                            <a class="btn btn-link p-0" href="{{ route('login') }}">
                                {{ __('Back to Login') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
