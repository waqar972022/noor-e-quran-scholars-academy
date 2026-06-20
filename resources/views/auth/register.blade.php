{{--
    views/auth/register.blade.php
    Route:      GET /register   (name: register)
    Controller: Auth\RegisterController or Laravel Breeze equivalent
    Layout:     layouts/auth
    Notes:
      - Phone is required (per spec)
      - No email verification
      - On success: redirects to /dashboard (user) or /admin (admin)
--}}
@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')

    <h1 class="auth-heading">Create account</h1>
    <p class="auth-subheading">Begin your journey of sacred knowledge today.</p>

    {{-- Tab switcher — Register pre-selected --}}
    <div class="auth-tabs" role="tablist" aria-label="Authentication options">
        <button
            class="auth-tab"
            data-tab="login"
            role="tab"
            aria-selected="false"
            onclick="window.location.href='{{ route('login') }}'"
        >Sign In</button>
        <button
            class="auth-tab active"
            data-tab="register"
            role="tab"
            aria-selected="true"
            onclick="switchAuthTab('register')"
        >Register</button>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="q-alert q-alert-error" role="alert">
            <strong>Please fix the following:</strong>
            <ul style="margin-top:.4rem; padding-left:1.1rem; font-size:13px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Register form --}}
    <div class="auth-form-panel active" data-panel="register">
        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            {{-- Full name --}}
            <div class="q-form-group">
                <label class="q-label" for="name">Full Name</label>
                <input
                    class="q-input @error('name') is-invalid @enderror"
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Your full name"
                    autocomplete="name"
                    autofocus
                    required
                >
                @error('name')
                    <p class="q-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="q-form-group">
                <label class="q-label" for="email">Email Address</label>
                <input
                    class="q-input @error('email') is-invalid @enderror"
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    autocomplete="email"
                    required
                >
                @error('email')
                    <p class="q-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone (required per project spec) --}}
            <div class="q-form-group">
                <label class="q-label" for="phone">
                    Phone Number
                    <span style="color:var(--q-gold); margin-left:2px;" title="Required">*</span>
                </label>
                <input
                    class="q-input @error('phone') is-invalid @enderror"
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="03XX-XXXXXXX"
                    autocomplete="tel"
                    required
                >
                @error('phone')
                    <p class="q-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="q-form-group">
                <label class="q-label" for="password">Password</label>
                <input
                    class="q-input @error('password') is-invalid @enderror"
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Min. 8 characters"
                    autocomplete="new-password"
                    required
                >
                @error('password')
                    <p class="q-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm password --}}
            <div class="q-form-group">
                <label class="q-label" for="password_confirmation">Confirm Password</label>
                <input
                    class="q-input"
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Re-enter your password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button type="submit" class="q-btn q-btn-primary q-btn-full q-btn-lg">
                Create My Account
            </button>

            <p style="font-size:11px; color:var(--q-muted); text-align:center; margin-top:.75rem; line-height:1.6;">
                By registering you agree to our
                <a href="#" style="color:var(--q-green);">Terms of Service</a>.
            </p>
        </form>

        <p class="auth-footer-text">
            Already have an account?
            <a href="{{ route('login') }}">Sign in here</a>
        </p>
    </div>

@endsection
