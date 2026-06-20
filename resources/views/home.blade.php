@extends('layouts.app')

@section('content')
    <section class="panel hero">
        <div class="shell-grid">
            <span class="hero-kicker">{{ __('ui.home.kicker') }}</span>
            <h1>{{ __('ui.home.title') }}</h1>
            <p>{{ __('ui.home.subtitle') }}</p>
            <div class="form-actions">
                @guest
                    <a class="btn btn-primary" href="{{ route('register') }}">{{ __('ui.home.primary_guest') }}</a>
                    <a class="btn btn-secondary" href="{{ route('login') }}">{{ __('ui.home.secondary') }}</a>
                @endguest
                @auth
                    <a class="btn btn-primary" href="{{ route('dashboard') }}">{{ __('ui.home.primary_auth') }}</a>
                @endauth
            </div>
        </div>

        <div class="panel hero-card">
            <div class="stat-grid">
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.site_name') }}</small>
                    <strong>{{ setting('site_name', config('app.name')) }}</strong>
                </div>
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.basic_plan') }}</small>
                    <strong>{{ pkr(setting('basic_plan_price', 0)) }}</strong>
                </div>
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.standard_plan') }}</small>
                    <strong>{{ pkr(setting('standard_plan_price', 0)) }}</strong>
                </div>
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.premium_plan') }}</small>
                    <strong>{{ pkr(setting('premium_plan_price', 0)) }}</strong>
                </div>
            </div>
        </div>
    </section>

    <section class="split-grid split-grid--spaced">
        <div class="panel">
            <h2 class="section-title">{{ __('ui.home.included_title') }}</h2>
            <p class="section-note">{{ __('ui.home.included_copy') }}</p>
        </div>

        <div class="panel accent-panel">
            <h2 class="section-title">{{ __('ui.nav.language') }}</h2>
            <p class="section-note">{{ __('ui.home.language_help') }}</p>
        </div>
    </section>
@endsection
