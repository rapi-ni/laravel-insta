@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-heading text-center">
                <div class="auth-logo-icon mx-auto mb-3" aria-hidden="true">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <h2 class="auth-title mb-2">Welcome back!</h2>
                <p class="auth-subtitle mb-0">Log in and share your favorite moments.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label auth-label">
                        Email address
                    </label>

                    <div class="auth-input-wrap">
                        <i class="fa-regular fa-envelope auth-input-icon" aria-hidden="true"></i>
                        <input id="email" type="email"
                            class="form-control auth-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="you@example.com"
                            required autocomplete="email" autofocus>
                    </div>

                    @error('email')
                        <div class="text-danger small mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label auth-label">
                        Password
                    </label>

                    <div class="auth-input-wrap">
                        <i class="fa-solid fa-lock auth-input-icon" aria-hidden="true"></i>
                        <input id="password" type="password"
                            class="form-control auth-input @error('password') is-invalid @enderror"
                            name="password" placeholder="Enter your password" required
                            autocomplete="current-password">
                    </div>

                    @error('password')
                        <div class="text-danger small mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn auth-submit">
                    Login
                    <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
                </button>
            </form>

            @if (Route::has('register'))
                <p class="auth-register text-center mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}">Sign up</a>
                </p>
            @endif
        </div>
    </div>
@endsection
