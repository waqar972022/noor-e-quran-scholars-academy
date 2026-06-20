@extends('layouts.app')

@section('content')
    <section class="panel">
        <div class="page-top">
            <div>
                <span class="hero-kicker">{{ __('ui.admin.kicker') }}</span>
                <h1 class="section-title">{{ __('ui.admin.title') }}</h1>
                <p class="section-note">{{ __('ui.admin.copy') }}</p>
            </div>
            <div class="toolbar">
                <div class="stat">
                    <small class="muted">{{ __('ui.admin.jazzcash') }}</small>
                    <strong>{{ setting('jazzcash_number', 'Not set') }}</strong>
                </div>
                <div class="stat">
                    <small class="muted">{{ __('ui.admin.premium_plan') }}</small>
                    <strong>{{ pkr(setting('premium_plan_price', 0)) }}</strong>
                </div>
            </div>
        </div>
    </section>
@endsection
