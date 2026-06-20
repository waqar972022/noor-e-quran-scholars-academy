{{--
    views/auth/login.blade.php
    Route:      GET /login   (name: login)
    Controller: Auth\LoginController or Laravel Breeze equivalent
    Layout:     layouts/auth
--}}
@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')

    <h1 class="auth-heading">Welcome back</h1>
    <p class="auth-subheading">Sign in to continue your journey of sacred knowledge.</p>

    {{-- Tab switcher — Login pre-selected --}}
    <div class="auth-tabs" role="tablist" aria-label="Authentication options">
        <button
            class="auth-tab active"
            data-tab="login"
            role="tab"
            aria-selected="true"
            onclick="switchAuthTab('login')"
        >Sign In</button>
        <button
            class="auth-tab"
            data-tab="register"
            role="tab"
            aria-selected="false"
            onclick="window.location.href='{{ route('register') }}'"
        >Register</button>
    </div>

    {{-- Session / validation errors --}}
    @if ($errors->any())
        <div class="q-alert q-alert-error" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="q-alert q-alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- Login form --}}
    <div class="auth-form-panel active" data-panel="login">
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

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
                    autofocus
                    required
                >
                @error('email')
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
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
                @error('password')
                    <p class="q-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:1.25rem;">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    style="accent-color: var(--q-green); width:15px; height:15px; cursor:pointer;"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label for="remember" style="font-size:13px; color:var(--q-muted); cursor:pointer;">
                    Keep me signed in
                </label>
            </div>

            <button type="submit" class="q-btn q-btn-primary q-btn-full q-btn-lg">
                Sign In to My Account
            </button>
        </form>

        <p class="auth-footer-text">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </p>
    </div>

@endsection
