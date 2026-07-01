@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
<style>
    /* ── Hero Slider ─────────────────────────────────── */
    .q-slider {
        position: relative;
        height: 62vh;
        min-height: 380px;
        overflow: hidden;
        border-bottom: 1.5px solid var(--q-border);
    }
    .q-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity .65s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .q-slide.active { opacity: 1; pointer-events: auto; }
    .q-slide-inner {
        display: flex;
        align-items: center;
        gap: 3rem;
        max-width: 960px;
        width: 100%;
    }
    .q-enrol-card {
        flex-shrink: 0;
        margin-left: auto;
        background: color-mix(in srgb, var(--q-hero-text) 6%, transparent);
        border: 1.5px solid color-mix(in srgb, var(--q-gold) 35%, transparent);
        border-radius: var(--q-radius-lg);
        padding: 1.4rem 1.6rem;
        min-width: 210px;
        backdrop-filter: blur(6px);
    }
    .q-enrol-card-title {
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--q-gold);
        margin-bottom: 1rem;
    }
    .q-enrol-card-item {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .82rem;
        color: var(--q-hero-text);
        margin-bottom: .6rem;
        line-height: 1.4;
    }
    .q-enrol-card-item:last-of-type { margin-bottom: 1.1rem; }
    .q-enrol-card-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--q-gold);
        flex-shrink: 0;
    }
    .q-slide-deco {
        font-family: var(--q-font-serif);
        font-size: 6rem;
        color: var(--q-hero-deco);
        line-height: 1;
        flex-shrink: 0;
        direction: rtl;
        user-select: none;
    }
    .q-slide-content { flex: 1; }
    .q-slide-title {
        font-family: var(--q-font-serif);
        font-size: 2rem;
        color: var(--q-hero-text);
        line-height: 1.3;
        margin-bottom: .7rem;
        font-weight: 700;
    }
    .q-slide-desc {
        font-size: 13px;
        color: var(--q-hero-text-sub);
        line-height: 1.75;
        margin-bottom: 1.2rem;
        max-width: 380px;
    }
    .q-slide-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    /* Slider buttons — gold primary, white ghost outline on dark green bg */
    .q-slider .q-btn-primary { background: var(--q-gold); color: var(--q-hero-text); }
    .q-slider .q-btn-primary:hover { background: var(--q-gold-2); }
    .q-slider .q-btn-outline { border-color: color-mix(in srgb, var(--q-hero-text) 65%, transparent); color: var(--q-hero-text); background: transparent; }
    .q-slider .q-btn-outline:hover { background: color-mix(in srgb, var(--q-hero-text) 12%, transparent); }

    .q-slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: color-mix(in srgb, var(--q-hero-text) 10%, transparent);
        border: 1.5px solid color-mix(in srgb, var(--q-hero-text) 25%, transparent);
        color: var(--q-hero-text);
        width: 36px; height: 36px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
    }
    .q-slider-arrow:hover { background: color-mix(in srgb, var(--q-hero-text) 20%, transparent); }
    .q-slider-prev { left: 14px; }
    .q-slider-next { right: 14px; }

    .q-slider-dots {
        position: absolute;
        bottom: 16px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 10;
    }
    .q-slider-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        border: none;
        background: color-mix(in srgb, var(--q-hero-text) 30%, transparent);
        cursor: pointer;
        transition: all .3s;
        padding: 0;
    }
    .q-slider-dot.active { background: var(--q-gold); width: 22px; border-radius: 4px; }

    @media (max-width: 600px) {
        .q-slide-deco  { display: none; }
        .q-slider-arrow { display: none; }
        .q-slide-inner { justify-content: center; text-align: center; }
        .q-slide-actions { justify-content: center; }
        .q-scholar-grid { grid-template-columns: 1fr !important; text-align: center; }
        .q-scholar-grid img { margin: 0 auto; }
        .q-enrol-card { display: none; }
    }

    /* ── Courses ─────────────────────────────────────── */
    .q-courses-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
    }
    .q-courses-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .q-courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }
    .q-card.q-course-card {
        padding: 0; overflow: hidden; display: flex; flex-direction: column;
        text-decoration: none; color: inherit;
        transition: box-shadow .2s, transform .18s;
    }
    .q-card.q-course-card:hover { box-shadow: var(--q-shadow-card); transform: translateY(-2px); }
    .q-course-thumb {
        height: 220px;
        border-radius: var(--q-radius-lg) var(--q-radius-lg) 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--q-font-serif);
        font-size: 2.2rem;
        color: color-mix(in srgb, var(--q-green) 20%, transparent);
        direction: rtl;
    }
    .q-course-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: center 15%; display: block; }
    .q-course-thumb--quran  { background: color-mix(in srgb, var(--q-green) 20%, transparent); }
    .q-course-thumb--fiqh   { background: var(--q-parch-3); }
    .q-course-thumb--arabic { background: color-mix(in srgb, var(--q-green) 15%, transparent); }
    .q-course-thumb--seerah { background: var(--q-parch-4); }
    .q-course-body { padding: 1rem 1.15rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
    .q-course-title {
        font-family: var(--q-font-prose);
        font-size: .95rem;
        color: var(--q-ink);
        margin: .5rem 0 .3rem;
        line-height: 1.45;
    }
    .q-course-instructor {
        font-size: .82rem;
        color: var(--q-muted);
        line-height: 1.65;
        margin-bottom: .85rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .q-course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: .8rem;
        border-top: 1px solid var(--q-border);
    }

    /* ── Scroll reveal ───────────────────────────────── */
    .q-reveal {
        opacity: 0;
        transform: translateY(26px);
        transition: opacity .55s ease, transform .55s ease;
    }
    .q-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .q-reveal[data-delay="1"] { transition-delay: .10s; }
    .q-reveal[data-delay="2"] { transition-delay: .20s; }
    .q-reveal[data-delay="3"] { transition-delay: .30s; }
    .q-reveal[data-delay="4"] { transition-delay: .40s; }
    .q-reveal[data-delay="5"] { transition-delay: .50s; }

    /* ── Full-page scroll snap ───────────────────────── */
    html { scroll-snap-type: y proximity; }
    section {
        scroll-snap-align: start;
        scroll-margin-top: 58px;
    }
    .q-slider {
        scroll-margin-top: 0;
    }
    footer { scroll-snap-align: start; scroll-margin-top: 58px; }

    /* ── Pricing (home) ─────────────────────────────── */
    .q-plan-grid-home {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
    }
    @media (min-width: 540px) { .q-plan-grid-home { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 860px) { .q-plan-grid-home { grid-template-columns: repeat(3, 1fr); } }

    .q-plan-card-home {
        display: flex;
        flex-direction: column;
        border: 1.5px solid var(--q-border);
        border-radius: var(--q-radius-xl);
        background: var(--q-parch-2);
        box-shadow: var(--q-shadow-card);
        position: relative;
        margin-top: 1rem;
        transition: box-shadow .2s, transform .18s;
        overflow: visible;
    }
    .q-plan-card-home:hover {
        box-shadow: var(--q-shadow-panel);
        transform: translateY(-3px);
    }
    .q-plan-card-home--popular {
        border-color: var(--q-green);
        box-shadow: 0 0 0 3px rgba(27,67,50,.1), var(--q-shadow-panel);
    }
    .q-plan-card-home .q-plan-popular-badge {
        position: absolute;
        top: 0; left: 50%;
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
    .q-plan-card-home .q-plan-header {
        padding: 2rem 1.5rem 1.5rem;
        border-bottom: 1.5px solid var(--q-border);
        text-align: center;
    }
    .q-plan-card-home .q-plan-name {
        font-family: var(--q-font-serif);
        font-size: 1.2rem;
        color: var(--q-ink);
        margin-bottom: .25rem;
    }
    .q-plan-card-home .q-plan-duration { font-size: .8rem; color: var(--q-muted); margin-bottom: 1.1rem; }
    .q-plan-card-home .q-plan-price {
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--q-green);
        line-height: 1;
    }
    .q-plan-card-home .q-plan-price-sub {
        font-size: .78rem;
        font-weight: 400;
        color: var(--q-muted);
        display: block;
        margin-top: .25rem;
    }
    .q-plan-card-home .q-plan-features {
        list-style: none;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        flex: 1;
    }
    .q-plan-card-home .q-plan-feature {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: .88rem;
        color: var(--q-ink-2);
    }
    .q-plan-card-home .q-plan-check {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--q-green-light);
        display: grid;
        place-items: center;
        font-size: .6rem;
        color: var(--q-green);
        flex-shrink: 0;
    }
    .q-plan-card-home .q-plan-cta { padding: 0 1.5rem 1.75rem; }
    .q-plan-card-home .q-pricing-note {
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

    /* ── CTA Band ────────────────────────────────────── */
    .q-cta-band {
        background: var(--q-green);
        padding: 2.5rem 1.5rem;
        text-align: center;
    }
    .q-cta-band h2 {
        font-family: var(--q-font-serif);
        font-size: 1.6rem;
        color: var(--q-parch);
        margin-bottom: .6rem;
    }
    .q-cta-band p {
        font-size: 13px;
        color: var(--q-hero-text-sub);
        margin-bottom: 1.2rem;
    }
    .q-btn-parch { background: var(--q-parch); color: var(--q-green); font-weight: 700; }
    .q-btn-parch:hover { background: var(--q-parch-2); }
</style>
@endpush

@section('content')

{{-- ══ SECTION 1 — Hero Slider ══ --}}
<section class="q-slider" id="heroSlider" aria-label="Featured slides">

    <div class="q-slide active" data-slide="0"
         style="background: linear-gradient(135deg, var(--q-hero-from) 0%, var(--q-hero-to) 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">بِسْمِ اللَّهِ</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Begin Your Journey</p>
                <h1 class="q-slide-title">Learn Quran &amp; Hadith from Authentic Sources</h1>
                <p class="q-slide-desc">Video courses and PDF books — taught by verified Islamic scholars.</p>
                <div class="q-slide-actions">
                    <a href="{{ route('register') }}" class="q-btn q-btn-primary">Start Learning</a>
                    <a href="{{ route('courses.index') }}" class="q-btn q-btn-outline">Browse Courses</a>
                </div>
            </div>
            <div class="q-enrol-card" aria-hidden="true">
                <p class="q-enrol-card-title">Now Enrolling</p>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>3-Day Free Trial</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Flexible Timings</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Affordable PKR Pricing</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>WhatsApp Support</div>
                <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm" style="width:100%;text-align:center">Start Free Trial</a>
            </div>
        </div>
    </div>

    <div class="q-slide" data-slide="1"
         style="background: linear-gradient(135deg, var(--q-hero-to) 0%, var(--q-hero-from) 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الْعِلْم</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Live Classes</p>
                <h1 class="q-slide-title">Learn Live with a Qualified Scholar</h1>
                <p class="q-slide-desc">One-on-one and group sessions with verified Islamic scholars — flexible scheduling, PKR pricing.</p>
                <div class="q-slide-actions">
                    <a href="{{ route('live-classes') }}" class="q-btn q-btn-primary">View Live Classes</a>
                    <a href="{{ route('pricing') }}" class="q-btn q-btn-outline">View Pricing</a>
                </div>
            </div>
            <div class="q-enrol-card" aria-hidden="true">
                <p class="q-enrol-card-title">Now Enrolling</p>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>3-Day Free Trial</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Flexible Timings</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Affordable PKR Pricing</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>WhatsApp Support</div>
                <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm" style="width:100%;text-align:center">Start Free Trial</a>
            </div>
        </div>
    </div>

    <div class="q-slide" data-slide="2"
         style="background: linear-gradient(135deg, var(--q-hero-from) 0%, var(--q-hero-to) 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الْإِسْلَام</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Start Today</p>
                <h1 class="q-slide-title">Authentic Islamic Education — Anytime, Anywhere</h1>
                <p class="q-slide-desc">Video lessons, PDF books, and live classes taught by verified scholars at affordable PKR pricing.</p>
                <div class="q-slide-actions">
                    <a href="{{ route('pricing') }}" class="q-btn q-btn-primary">Subscribe Now</a>
                    <a href="{{ route('courses.index') }}" class="q-btn q-btn-outline">Browse Courses</a>
                </div>
            </div>
            <div class="q-enrol-card" aria-hidden="true">
                <p class="q-enrol-card-title">Now Enrolling</p>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>3-Day Free Trial</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Flexible Timings</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>Affordable PKR Pricing</div>
                <div class="q-enrol-card-item"><span class="q-enrol-card-dot"></span>WhatsApp Support</div>
                <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm" style="width:100%;text-align:center">Start Free Trial</a>
            </div>
        </div>
    </div>

    <button class="q-slider-arrow q-slider-prev" id="sliderPrev" aria-label="Previous slide">&#8249;</button>
    <button class="q-slider-arrow q-slider-next" id="sliderNext" aria-label="Next slide">&#8250;</button>

    <div class="q-slider-dots" role="tablist" aria-label="Slide navigation">
        <button class="q-slider-dot active" data-dot="0" role="tab" aria-label="Slide 1" aria-selected="true"></button>
        <button class="q-slider-dot"        data-dot="1" role="tab" aria-label="Slide 2" aria-selected="false"></button>
        <button class="q-slider-dot"        data-dot="2" role="tab" aria-label="Slide 3" aria-selected="false"></button>
    </div>

</section>

@if($stats->isNotEmpty())
<div style="border-bottom:1.5px solid var(--q-border);background:var(--q-section-alt,var(--q-parch))">
    <div style="max-width:960px;margin:0 auto;padding:.9rem 1.5rem;display:flex;flex-wrap:wrap;gap:1.5rem 2.5rem;align-items:center;justify-content:center">
        @if($stats->has('courses'))
            <div class="q-reveal" style="display:flex;align-items:center;gap:.6rem">
                <span style="font-family:var(--q-font-serif);font-size:1.5rem;font-weight:700;color:var(--q-green)">{{ $stats['courses'] }}+</span>
                <span style="font-size:.8rem;color:var(--q-muted);line-height:1.3">Video<br>Courses</span>
            </div>
        @endif
        @if($stats->has('students'))
            <div class="q-reveal" data-delay="1" style="display:flex;align-items:center;gap:.6rem">
                <span style="font-family:var(--q-font-serif);font-size:1.5rem;font-weight:700;color:var(--q-green)">{{ $stats['students'] }}+</span>
                <span style="font-size:.8rem;color:var(--q-muted);line-height:1.3">Active<br>Students</span>
            </div>
        @endif
        @if($stats->has('videos'))
            <div class="q-reveal" data-delay="2" style="display:flex;align-items:center;gap:.6rem">
                <span style="font-family:var(--q-font-serif);font-size:1.5rem;font-weight:700;color:var(--q-green)">{{ $stats['videos'] }}+</span>
                <span style="font-size:.8rem;color:var(--q-muted);line-height:1.3">Video<br>Lessons</span>
            </div>
        @endif
    </div>
</div>
@endif


{{-- ══ SECTION 1b — Meet the Scholar ══ --}}
<section aria-labelledby="scholar-heading" style="border-bottom:1.5px solid var(--q-border)">
    <div class="q-scholar-grid q-reveal" style="max-width:900px;margin:0 auto;padding:2rem 1.5rem;display:grid;grid-template-columns:200px 1fr;gap:2.5rem;align-items:center">

        <div style="text-align:center">
            <img src="{{ asset('images/scholar.jpeg') }}"
                 alt="Scholar"
                 style="width:160px;height:160px;border-radius:50%;object-fit:cover;
                        border:3px solid var(--q-green);box-shadow:0 4px 24px rgba(0,0,0,.12)">
        </div>

        <div>
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--q-green);margin-bottom:.4rem">Your Teacher</p>
            <h2 id="scholar-heading" style="font-family:var(--q-font-serif);font-size:1.6rem;color:var(--q-ink);margin-bottom:.3rem">Ustadh / Scholar Name</h2>
            <p style="font-size:.85rem;color:var(--q-green);font-weight:600;margin-bottom:.85rem">Dars-e-Nizami Graduate · Islamic Studies</p>
            <p style="font-size:.9rem;color:var(--q-ink-2);line-height:1.8;max-width:48ch">
                A qualified Islamic scholar with expertise in Quran recitation, Tajweed, and classical Islamic sciences.
                Teaching students of all levels through structured video courses and live one-on-one sessions.
            </p>
        </div>

    </div>
</section>

{{-- ══ SECTION 2 — Why Choose Us ══ --}}
<section class="q-section-alt" aria-label="Why choose us">
    <div style="max-width:1100px;margin:0 auto;padding:2.5rem 1.5rem">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.25rem">

            <div class="q-card q-reveal" data-delay="1" style="padding:1.5rem 1.6rem">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--q-green);margin-bottom:1rem"></div>
                <strong style="font-size:.95rem;color:var(--q-ink);display:block;margin-bottom:.4rem">Taught by Qualified Scholars</strong>
                <p style="font-size:.82rem;color:var(--q-muted);line-height:1.65;margin:0">Every instructor is a verified Dars-e-Nizami graduate. You learn from authentic scholarly chains, not self-taught content.</p>
            </div>

            <div class="q-card q-reveal" data-delay="2" style="padding:1.5rem 1.6rem">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--q-gold);margin-bottom:1rem"></div>
                <strong style="font-size:.95rem;color:var(--q-ink);display:block;margin-bottom:.4rem">Rooted in Classical Sources</strong>
                <p style="font-size:.82rem;color:var(--q-muted);line-height:1.65;margin:0">Curriculum drawn from the Qur'an, Hadith, and classical texts — structured for all levels from beginner to advanced.</p>
            </div>

            <div class="q-card q-reveal" data-delay="3" style="padding:1.5rem 1.6rem">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--q-green);margin-bottom:1rem"></div>
                <strong style="font-size:.95rem;color:var(--q-ink);display:block;margin-bottom:.4rem">Flexible &amp; Family-Friendly</strong>
                <p style="font-size:.82rem;color:var(--q-muted);line-height:1.65;margin:0">Live classes at times that suit your schedule. PKR pricing, WhatsApp support, and progress reports for parents.</p>
            </div>

        </div>
    </div>
</section>


{{-- ══ SECTION 3 — Featured Courses ══ --}}
<section aria-labelledby="courses-heading">
    <div class="q-courses-wrap">

        <div class="q-courses-header q-reveal">
            <div>
                <p class="q-eyebrow">Learn From Scholars</p>
                <h2 id="courses-heading" class="q-section-title">Featured Courses</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="q-btn q-btn-outline">View All Courses</a>
        </div>

        <div class="q-courses-grid">
            @forelse ($featuredCourses as $course)
                @php
                    $thumbClasses = ['q-course-thumb--quran','q-course-thumb--fiqh','q-course-thumb--arabic','q-course-thumb--seerah'];
                    $tc = $thumbClasses[$loop->index % 4];
                @endphp
                <a href="{{ route('courses.show', $course->slug) }}" class="q-card q-course-card q-reveal" data-delay="{{ ($loop->index % 4) + 1 }}">
                    <div class="q-course-thumb {{ $tc }}">
                        @if ($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}"
                                 alt="{{ $course->title }}"
                                 loading="lazy">
                        @else
                            {{ mb_substr($course->title, 0, 1) }}
                        @endif
                    </div>
                    <div class="q-course-body">
                        @if ($course->category)
                            <span class="q-badge q-badge-green">{{ $course->category->name }}</span>
                        @endif
                        <h3 class="q-course-title">{{ $course->title }}</h3>
                        @if ($course->short_description)
                            <p class="q-course-instructor">{{ Str::limit($course->short_description, 60) }}</p>
                        @endif
                        @if ($course->videos_count > 0 || $course->files_count > 0)
                            <div style="display:flex;gap:.75rem;margin-bottom:.75rem;flex-wrap:wrap">
                                @if ($course->videos_count > 0)
                                    <span style="font-size:.75rem;color:var(--q-muted)">▶ {{ $course->videos_count }} {{ Str::plural('lesson', $course->videos_count) }}</span>
                                @endif
                                @if ($course->files_count > 0)
                                    <span style="font-size:.75rem;color:var(--q-muted)">[PDF] {{ $course->files_count }} {{ Str::plural('file', $course->files_count) }}</span>
                                @endif
                            </div>
                        @endif
                        <div class="q-course-footer">
                            @if ($course->is_free)
                                <span class="q-badge" style="background:color-mix(in srgb,var(--q-green) 15%,transparent);color:var(--q-green);border:1px solid color-mix(in srgb,var(--q-green) 30%,transparent)">Free</span>
                                <span class="q-btn q-btn-primary q-btn-sm">Start Free</span>
                            @else
                                <span class="q-badge q-badge-gold">Premium</span>
                                <span class="q-btn q-btn-primary q-btn-sm">Enroll</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <p class="q-text-muted" style="grid-column:1/-1;text-align:center;padding:2rem 0">
                    Courses coming soon — check back shortly.
                </p>
            @endforelse
        </div>

    </div>
</section>


{{-- ══ SECTION 4 — How It Works ══ --}}
<section class="q-section-alt" aria-labelledby="how-heading">
    <div class="q-courses-wrap" style="padding-top:3rem;padding-bottom:3rem">
        <div class="q-reveal" style="text-align:center;margin-bottom:2.5rem">
            <p class="q-eyebrow">How It Works</p>
            <h2 id="how-heading" class="q-section-title">Start Learning in 3 Steps</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem">

            <div class="q-card q-reveal" data-delay="1" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">01</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Create Your Account</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Register free with your name, email, and phone. Only takes a minute.</p>
            </div>

            <div class="q-card q-reveal" data-delay="2" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">02</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Choose a Plan</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Pick monthly or annual. Send payment via JazzCash — simple and local.</p>
            </div>

            <div class="q-card q-reveal" data-delay="3" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">03</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Access Everything</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Once approved, all video courses and PDF books are yours.</p>
            </div>

        </div>
    </div>
</section>


{{-- ══ SECTION 5 — Pricing ══ --}}
@if($plans->isNotEmpty())
<section aria-labelledby="pricing-heading">
    <div class="q-courses-wrap" style="padding-top:3rem;padding-bottom:3rem">

        <div class="q-reveal" style="text-align:center;margin-bottom:2.5rem">
            <p class="q-eyebrow">Plans &amp; Pricing</p>
            <h2 id="pricing-heading" class="q-section-title">Simple, Transparent Pricing</h2>
            <p style="font-size:.88rem;color:var(--q-muted);margin-top:.5rem">Every plan unlocks all video courses and PDF books.</p>
        </div>

        <div class="q-plan-grid-home">
            @foreach($plans as $plan)
                @php $isPopular = $loop->count > 1 && $loop->iteration === (int) ceil($loop->count / 2); @endphp
                <div class="q-plan-card-home {{ $isPopular ? 'q-plan-card-home--popular' : '' }} q-reveal" data-delay="{{ $loop->index + 1 }}">

                    @if($isPopular)
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
                        <li class="q-plan-feature"><span class="q-plan-check" aria-hidden="true">✓</span> Scholar Q&amp;A support</li>
                    </ul>

                    <div class="q-plan-cta">
                        <a href="{{ route('checkout.show', $plan) }}"
                           class="q-btn {{ $isPopular ? 'q-btn-primary' : 'q-btn-outline' }} q-btn-full">
                            Subscribe
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="q-reveal" style="text-align:center;max-width:500px;margin:2rem auto 0;font-size:.85rem;color:var(--q-muted);padding:1.1rem 1.5rem;border:1.5px solid var(--q-border);border-radius:var(--q-radius-lg);background:var(--q-parch-2)">
            Payment via JazzCash. Admin approves access within 24 hours.
        </div>

    </div>
</section>
@endif


{{-- ══ SECTION 6 — CTA Band ══ --}}
<section class="q-cta-band" aria-labelledby="cta-heading">
    <h2 id="cta-heading" class="q-reveal">Begin your journey of sacred knowledge</h2>
    <p class="q-reveal" data-delay="1">Join thousands of learners studying the Qur'an and Sunnah.</p>
    <a href="{{ route('register') }}" class="q-btn q-btn-lg q-btn-parch q-reveal" data-delay="2">Create Free Account</a>
</section>

@endsection

@push('scripts')
<script>
    (function () {
        const slides = Array.from(document.querySelectorAll('.q-slide'));
        const dots   = Array.from(document.querySelectorAll('.q-slider-dot'));
        if (!slides.length) return;

        let current = 0, timer;

        function goTo(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            dots[current].setAttribute('aria-selected', 'false');
            current = ((n % slides.length) + slides.length) % slides.length;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
            dots[current].setAttribute('aria-selected', 'true');
        }

        function startAuto() { timer = setInterval(function () { goTo(current + 1); }, 4500); }
        function stopAuto()  { clearInterval(timer); }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () { stopAuto(); goTo(parseInt(this.dataset.dot, 10)); startAuto(); });
        });

        var prev = document.getElementById('sliderPrev');
        var next = document.getElementById('sliderNext');
        if (prev) prev.addEventListener('click', function () { stopAuto(); goTo(current - 1); startAuto(); });
        if (next) next.addEventListener('click', function () { stopAuto(); goTo(current + 1); startAuto(); });

        var slider = document.getElementById('heroSlider');
        if (slider) {
            slider.addEventListener('mouseenter', stopAuto);
            slider.addEventListener('mouseleave', startAuto);
            slider.addEventListener('touchstart', stopAuto, { passive: true });
            slider.addEventListener('touchend',   startAuto, { passive: true });
        }

        startAuto();
    })();

    // ── Scroll reveal ──────────────────────────────────────
    (function () {
        var els = document.querySelectorAll('.q-reveal');
        if (!els.length) return;

        if (!('IntersectionObserver' in window)) {
            els.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        els.forEach(function (el) { observer.observe(el); });
    })();
</script>
@endpush
