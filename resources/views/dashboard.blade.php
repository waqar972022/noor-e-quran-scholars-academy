@extends('layouts.app')

@section('content')
    <section class="panel">
        <div class="page-top">
            <div>
                <span class="hero-kicker">{{ __('ui.dashboard.kicker') }}</span>
                <h1 class="section-title">{{ __('ui.dashboard.title') }}</h1>
                <p class="section-note">{{ __('ui.dashboard.copy') }}</p>
            </div>
            <div class="toolbar">
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.site_name') }}</small>
                    <strong>{{ setting('site_name', config('app.name')) }}</strong>
                </div>
                <div class="stat">
                    <small class="muted">{{ __('ui.home.stats.basic_plan') }}</small>
                    <strong>{{ pkr(setting('basic_plan_price', 0)) }}</strong>
                </div>
            </div>
        </div>
    </section>
@endsection
