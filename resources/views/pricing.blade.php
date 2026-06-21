@extends('layouts.app')

@section('title', 'Pricing')

@push('styles')
<style>
.q-pricing-hero {
    background: var(--q-parch-2);
    border-bottom: 1.5px solid var(--q-border);
    text-align: center;
    padding: 3rem 1.5rem 2.5rem;
}
.q-pricing-sub {
    font-size: .97rem;
    color: var(--q-muted);
    max-width: 52ch;
    margin: .75rem auto 0;
    line-height: 1.7;
}

.q-pricing-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 3rem 1.5rem 5rem;
}
.q-plan-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}
@media (min-width: 640px) { .q-plan-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 900px) { .q-plan-grid { grid-template-columns: repeat(3, 1fr); } }

.q-plan-card {
    display: flex;
    flex-direction: column;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-xl);
    overflow: hidden;
    background: var(--q-parch-2);
    box-shadow: var(--q-shadow-card);
    position: relative;
    transition: box-shadow .2s, transform .18s;
}
.q-plan-card:hover {
    box-shadow: var(--q-shadow-panel);
    transform: translateY(-3px);
}
.q-plan-card--popular {
    border-color: var(--q-green);
    box-shadow: 0 0 0 3px rgba(27,67,50,.1), var(--q-shadow-panel);
}

.q-plan-popular-badge {
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    background: var(--q-green);
    color: var(--q-parch);
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    padding: 3px 14px;
    border-radius: 999px;
    white-space: nowrap;
}

.q-plan-header {
    padding: 2rem 1.5rem 1.5rem;
    border-bottom: 1.5px solid var(--q-border);
    text-align: center;
}
.q-plan-name {
    font-family: var(--q-font-serif);
    font-size: 1.2rem;
    color: var(--q-ink);
    margin-bottom: .25rem;
}
.q-plan-duration { font-size: .8rem; color: var(--q-muted); margin-bottom: 1.1rem; }
.q-plan-price {
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--q-green);
    line-height: 1;
}
.q-plan-price-sub {
    font-size: .78rem;
    font-weight: 400;
    color: var(--q-muted);
    display: block;
    margin-top: .25rem;
}

.q-plan-features {
    list-style: none;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: .75rem;
    flex: 1;
}
.q-plan-feature { display: flex; align-items: center; gap: .6rem; font-size: .88rem; color: var(--q-ink-2); }
.q-plan-check {
    width: 18px; height: 18px;
    border-radius: 50%;
    background: var(--q-green-light);
    display: grid;
    place-items: center;
    font-size: .6rem;
    color: var(--q-green);
    flex-shrink: 0;
}

.q-plan-cta { padding: 0 1.5rem 1.75rem; }

.q-pricing-note {
    text-align: center;
    max-width: 500px;
    margin: 2rem auto 0;
    font-size: .85rem;
    color: var(--q-muted);
    padding: 1.1rem 1.5rem;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
    background: var(--q-parch-2);
}
</style>
@endpush

@section('content')

<div class="q-pricing-hero">
    <p class="q-eyebrow">Plans &amp; Pricing</p>
    <h1 class="q-section-title" style="margin-top:.3rem">Simple, Transparent Pricing</h1>
    <p class="q-pricing-sub">Every plan unlocks all video courses, PDF books, and completion certificates.</p>
</div>

<div class="q-pricing-wrap">

    @if ($plans->isEmpty())
        <p style="text-align:center;color:var(--q-muted);padding:4rem 0">
            Pricing plans are being set up. Please check back soon.
        </p>
    @else
        <div class="q-plan-grid">
            @foreach ($plans as $plan)
                @php $isPopular = $loop->count > 1 && $loop->iteration === (int) ceil($loop->count / 2); @endphp
                <div class="q-plan-card {{ $isPopular ? 'q-plan-card--popular' : '' }}">

                    @if ($isPopular)
                        <div class="q-plan-popular-badge">Most Popular</div>
                    @endif

                    <div class="q-plan-header">
                        <p class="q-plan-name">{{ $plan->name }}</p>
                        <p class="q-plan-duration">for {{ $plan->duration_days }} days</p>
                        <div class="q-plan-price">PKR {{ number_format($plan->price, 0) }}</div>
                        <span class="q-plan-price-sub">one-time payment</span>
                    </div>

                    <ul class="q-plan-features">
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> Access to all courses</li>
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> HD video lessons</li>
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> Full PDF book library</li>
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> Completion certificates</li>
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> Scholar Q&amp;A support</li>
                    </ul>

                    <div class="q-plan-cta">
                        @auth
                            {{-- Checkout link — wired in Prompt 5 --}}
                            <a href="#" class="q-btn {{ $isPopular ? 'q-btn-primary' : 'q-btn-outline' }} q-btn-full">
                                Get Started
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="q-btn {{ $isPopular ? 'q-btn-primary' : 'q-btn-outline' }} q-btn-full">
                                Get Started
                            </a>
                        @endauth
                    </div>

                </div>
            @endforeach
        </div>

        <div class="q-pricing-note">
            Payment via JazzCash. Admin approves access within 24 hours.
        </div>
    @endif

</div>

@endsection
