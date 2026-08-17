@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="auth-page">
        <div class="auth-card">
            <div class="auth-heading text-center">
                <div class="auth-logo-icon mx-auto mb-3" aria-hidden="true">
                    <i class="fa-solid fa-user-plus"></i>
                </div>

                <h2 class="auth-title mb-2">Create your account!</h2>
                <p class="auth-subtitle mb-0">Join us and start sharing your favorite moments.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label auth-label">Name</label>

                    <div class="auth-input-wrap">
                        <i class="fa-regular fa-user auth-input-icon" aria-hidden="true"></i>
                        <input id="name" type="text"
                            class="form-control auth-input @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" placeholder="Your name"
                            required autocomplete="name" autofocus>
                    </div>

                    @error('name')
                        <div class="text-danger small mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label auth-label">Email address</label>

                    <div class="auth-input-wrap">
                        <i class="fa-regular fa-envelope auth-input-icon" aria-hidden="true"></i>
                        <input id="email" type="email"
                            class="form-control auth-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="you@example.com"
                            required autocomplete="email">
                    </div>

                    @error('email')
                        <div class="text-danger small mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label auth-label">Password</label>

                    <div class="auth-input-wrap">
                        <i class="fa-solid fa-lock auth-input-icon" aria-hidden="true"></i>
                        <input id="password" type="password"
                            class="form-control auth-input @error('password') is-invalid @enderror"
                            name="password" placeholder="Create a password"
                            required autocomplete="new-password">
                    </div>

                    @error('password')
                        <div class="text-danger small mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label auth-label">Confirm password</label>

                    <div class="auth-input-wrap">
                        <i class="fa-solid fa-shield-heart auth-input-icon" aria-hidden="true"></i>
                        <input id="password-confirm" type="password" class="form-control auth-input"
                            name="password_confirmation" placeholder="Enter your password again"
                            required autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn auth-submit">
                    Sign up
                    <i class="fa-solid fa-arrow-right ms-2" aria-hidden="true"></i>
                </button>
            </form>

            @if (Route::has('login'))
                <p class="auth-register text-center mb-0">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </p>
            @endif
        </div>
    </div>
@endsection
