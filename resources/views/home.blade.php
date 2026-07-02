@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
<style>
    /* ── Hero Slider ─────────────────────────────────── */
    .q-slider {
        position: relative;
        overflow: hidden;
        border-bottom: 1.5px solid var(--q-border);
        touch-action: pan-y;
    }
    .q-slide {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 500px;
        padding-top: 58px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .65s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-sizing: border-box;
    }
    .q-slide.active { position: relative; opacity: 1; pointer-events: auto; }
    .q-slide::before {
        content: '';
        position: absolute;
        inset: -30px;
        background: inherit;
        background-size: cover;
        background-position: center;
        filter: blur(18px) brightness(.65);
        z-index: 0;
    }
    .q-slide img {
        position: relative;
        z-index: 1;
        max-height: calc(500px - 58px);
        max-width: 100%;
        width: auto;
        height: auto;
        display: block;
    }
    @media (max-width: 600px) {
        .q-slide { height: 300px; padding-top: 85px; }
        .q-slide img {
            width: 100%;
            max-width: 100%;
            height: auto;
            max-height: none;
        }
    }

    .q-hero-btns {
        display: flex;
        gap: 1rem;
        justify-content: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1.5px solid var(--q-border);
        flex-wrap: wrap;
        background: var(--q-parch);
    }
    @media (max-width: 480px) {
        .q-hero-btns { gap: .6rem; padding: 1rem 1.25rem; }
        .q-hero-btns .q-btn { padding: 9px 18px; font-size: 13px; }
    }

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
        .q-slider-arrow { display: none; }
        .q-scholar-grid { grid-template-columns: 1fr !important; text-align: center; padding-left: 1rem !important; padding-right: 1rem !important; }
        .q-scholar-grid img { margin: 0 auto; width: 100% !important; max-width: 100% !important; }
    }

    .q-courses-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
    }

    /* ── Stats band ──────────────────────────────────── */
    .q-stats-band {
        border-top: 1.5px solid var(--q-border);
        border-bottom: 1.5px solid var(--q-border);
        background: var(--q-parch-2);
    }
    .q-stats-grid {
        max-width: 900px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
    }
    .q-stats-item {
        text-align: center;
        padding: 1.4rem 1rem;
        border-left: 1px solid var(--q-border);
    }
    .q-stats-item:first-child { border-left: none; }
    .q-stats-num {
        font-family: var(--q-font-serif);
        font-size: clamp(1.4rem, 3vw, 1.8rem);
        font-weight: 700;
        color: var(--q-green);
        margin-bottom: .25rem;
    }
    .q-stats-label {
        font-size: .72rem;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--q-muted);
        font-weight: 600;
    }
    @media (max-width: 600px) {
        .q-stats-item { padding: 1rem .5rem; }
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

    .q-vid-card {
        flex: 0 0 210px;
        padding: 0;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s, transform .18s;
    }
    .q-vid-card:hover { transform: scale(1.04); box-shadow: var(--q-shadow-card); }
    .q-book-card {
        flex: 0 0 150px;
        padding: 0;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s, transform .18s;
    }
    .q-book-card:hover { transform: translateY(-2px); box-shadow: var(--q-shadow-card); }
    @media (max-width: 600px) {
        .q-vid-card { flex: 0 0 88%; }
        .q-book-card { flex: 0 0 calc(50% - .5rem); }
    }

    /* ── How It Works ─────────────────────────────────── */
    .q-how-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 3rem;
        align-items: start;
    }
    .q-how-header { position: sticky; top: 90px; }
    .q-how-header .q-section-title { margin-top: .3rem; }
    .q-how-timeline { position: relative; }
    .q-how-timeline::before {
        content: '';
        position: absolute;
        left: 17px;
        top: 17px;
        bottom: 17px;
        width: 2px;
        background: linear-gradient(to bottom, var(--q-green), var(--q-gold));
        z-index: 0;
    }
    .q-how-step {
        position: relative;
        display: flex;
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }
    .q-how-step:last-child { margin-bottom: 0; }
    .q-how-num {
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: var(--q-green);
        color: var(--q-parch);
        display: grid;
        place-items: center;
        font-family: var(--q-font-serif);
        font-weight: 700;
        font-size: .85rem;
    }
    .q-how-step h3 { font-family: var(--q-font-serif); font-size: 1rem; color: var(--q-ink); margin-bottom: .4rem; }
    .q-how-step p { font-size: .85rem; color: var(--q-muted); line-height: 1.7; }
    @media (max-width: 768px) {
        .q-how-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .q-how-header { position: static; }
    }

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

</style>
@endpush

@section('content')

{{-- ══ SECTION 1 — Hero Slider ══ --}}
<section class="q-slider" id="heroSlider" aria-label="Featured slides">

    <div class="q-slide active" data-slide="0" style="background-image:url('{{ asset('images/slides/slide-1.jpeg') }}')">
        <img src="{{ asset('images/slides/slide-1.jpeg') }}" alt="Slide 1" loading="eager">
    </div>

    <div class="q-slide" data-slide="1" style="background-image:url('{{ asset('images/slides/slide-2.jpeg') }}')">
        <img src="{{ asset('images/slides/slide-2.jpeg') }}" alt="Slide 2" loading="lazy">
    </div>

    <div class="q-slide" data-slide="2" style="background-image:url('{{ asset('images/slides/slide-3.jpeg') }}')">
        <img src="{{ asset('images/slides/slide-3.jpeg') }}" alt="Slide 3" loading="lazy">
    </div>

    <button class="q-slider-arrow q-slider-prev" id="sliderPrev" aria-label="Previous slide">&#8249;</button>
    <button class="q-slider-arrow q-slider-next" id="sliderNext" aria-label="Next slide">&#8250;</button>

    <div class="q-slider-dots" role="tablist" aria-label="Slide navigation">
        <button class="q-slider-dot active" data-dot="0" role="tab" aria-label="Slide 1" aria-selected="true"></button>
        <button class="q-slider-dot"        data-dot="1" role="tab" aria-label="Slide 2" aria-selected="false"></button>
        <button class="q-slider-dot"        data-dot="2" role="tab" aria-label="Slide 3" aria-selected="false"></button>
    </div>

</section>

{{-- ══ Hero action buttons ══ --}}
<div class="q-hero-btns">
    <a href="{{ route('pricing') }}" class="q-btn q-btn-primary q-btn-lg">Subscribe Now</a>
    <a href="{{ route('register') }}" class="q-btn q-btn-outline q-btn-lg">Create Free Account</a>
</div>

@if($stats->isNotEmpty())
<div class="q-stats-band">
    <div class="q-stats-grid">
        @if($stats->has('courses'))
            <div class="q-stats-item q-reveal">
                <p class="q-stats-num">{{ $stats['courses'] }}+</p>
                <p class="q-stats-label">Video Courses</p>
            </div>
        @endif
        @if($stats->has('students'))
            <div class="q-stats-item q-reveal" data-delay="1">
                <p class="q-stats-num">{{ $stats['students'] }}+</p>
                <p class="q-stats-label">Active Students</p>
            </div>
        @endif
        @if($stats->has('videos'))
            <div class="q-stats-item q-reveal" data-delay="2">
                <p class="q-stats-num">{{ $stats['videos'] }}+</p>
                <p class="q-stats-label">Video Lessons</p>
            </div>
        @endif
    </div>
</div>
@endif


{{-- ══ SECTION 1b — Meet the Scholar ══ --}}
<section aria-labelledby="scholar-heading" style="border-bottom:1.5px solid var(--q-border)">
    <div class="q-scholar-grid q-reveal" style="max-width:900px;margin:0 auto;padding:2rem 1.5rem;display:grid;grid-template-columns:280px 1fr;gap:2.5rem;align-items:center">

        <div style="text-align:center">
            <img src="{{ asset('images/scholar.jpeg') }}"
                 alt="Scholar"
                 style="width:260px;max-width:100%;aspect-ratio:4/5;border-radius:20px;object-fit:cover;
                        border:4px solid var(--q-green);box-shadow:0 4px 24px rgba(0,0,0,.12)">
            <div style="display:inline-flex;align-items:center;justify-content:center;gap:.5rem;margin-top:.75rem">
                <div style="position:relative;display:inline-block;font-size:1.1rem;line-height:1;letter-spacing:2px">
                    <span style="color:var(--q-border)">★★★★★</span>
                    <span style="position:absolute;inset:0;overflow:hidden;width:90%;color:var(--q-gold)">★★★★★</span>
                </div>
                <span style="font-size:.85rem;color:var(--q-ink-2);font-weight:600">4.5</span>
            </div>
        </div>

        <div>
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--q-green);margin-bottom:.4rem">Your Teacher</p>
            <h2 id="scholar-heading" style="font-family:var(--q-font-serif);font-size:1.6rem;color:var(--q-ink);margin-bottom:.3rem">مفتی محمد طاہر رضا قادری</h2>
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




{{-- ══ SECTION 4 — Videos by Category ══ --}}
@if ($videosByCategory->isNotEmpty())
<section style="border-bottom:1.5px solid var(--q-border)">
    <div class="q-courses-wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem" class="q-reveal">
            <div>
                <p class="q-eyebrow">Video Lessons</p>
                <h2 class="q-section-title" style="margin-top:.2rem">Videos</h2>
            </div>
            <a href="{{ route('videos.index') }}" class="q-btn q-btn-outline">View All</a>
        </div>

        @foreach ($videosByCategory as $catName => $videos)
        <div style="margin-bottom:2rem">
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--q-green);margin-bottom:.7rem;padding-bottom:.4rem;border-bottom:1px solid var(--q-border)">{{ $catName }}</p>
            <div class="q-cat-track">
                @foreach ($videos as $video)
                    @php
                        preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $video->youtube_url ?? '', $m);
                        $ytId = $m[1] ?? null;
                    @endphp
                    <a href="{{ route('content.video', [$video->course->slug, $video->id]) }}"
                       class="q-card q-vid-card">
                        <div style="position:relative;aspect-ratio:16/9;background:var(--q-parch-3);overflow:hidden">
                            @if ($ytId)
                                <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg"
                                     alt="{{ $video->video_title }}"
                                     style="width:100%;height:100%;object-fit:cover;display:block"
                                     loading="lazy">
                            @endif
                            @if ($video->is_free_preview)
                                <span class="q-free-pill">Free</span>
                            @endif
                            <span style="position:absolute;inset:0;display:grid;place-items:center;background:rgba(0,0,0,.22)">
                                <span style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.9);display:grid;place-items:center;font-size:.85rem">&#x25B6;</span>
                            </span>
                        </div>
                        <div style="padding:.65rem .85rem;flex:1">
                            <p style="font-size:.72rem;color:var(--q-green);font-weight:600;margin-bottom:.2rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $video->course->title }}</p>
                            <p style="font-size:.82rem;color:var(--q-ink);line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $video->video_title }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ══ SECTION 5 — Books by Category ══ --}}
@if ($booksByCategory->isNotEmpty())
<section style="border-bottom:1.5px solid var(--q-border)">
    <div class="q-courses-wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:.75rem" class="q-reveal">
            <div>
                <p class="q-eyebrow">PDF Course Books</p>
                <h2 class="q-section-title" style="margin-top:.2rem">Books</h2>
            </div>
            <a href="{{ route('books.index') }}" class="q-btn q-btn-outline">View All</a>
        </div>

        @foreach ($booksByCategory as $catName => $files)
        <div style="margin-bottom:2rem">
            <p style="font-size:.75rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--q-green);margin-bottom:.7rem;padding-bottom:.4rem;border-bottom:1px solid var(--q-border)">{{ $catName }}</p>
            <div class="q-cat-track">
                @foreach ($files as $file)
                    <a href="{{ route('content.pdf', [$file->course->slug, $file->id]) }}"
                       class="q-card q-book-card">
                        <div style="position:relative;aspect-ratio:3/4;background:var(--q-parch-3);overflow:hidden;display:flex;align-items:center;justify-content:center">
                            @if ($file->course->is_free)
                                <span class="q-free-pill">Free</span>
                            @endif
                            @if ($file->course->thumbnail)
                                <img src="{{ asset($file->course->thumbnail) }}"
                                     alt="{{ $file->file_title ?? $file->course->title }}"
                                     style="width:100%;height:100%;object-fit:contain;display:block"
                                     loading="lazy">
                            @else
                                <span style="font-size:2rem;opacity:.3">&#x1F4D6;</span>
                            @endif
                        </div>
                        <div style="padding:.6rem .75rem;flex:1">
                            <p style="font-size:.7rem;color:var(--q-muted);margin-bottom:.15rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $file->course->title }}</p>
                            <p style="font-size:.8rem;color:var(--q-ink);line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $file->file_title ?? $file->course->title }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ══ SECTION 6 — How It Works ══ --}}
<section class="q-section-alt" aria-labelledby="how-heading">
    <div class="q-courses-wrap" style="padding-top:3rem;padding-bottom:3rem">
        <div class="q-how-grid">
            <div class="q-how-header q-reveal">
                <p class="q-eyebrow">How It Works</p>
                <h2 id="how-heading" class="q-section-title">Start Learning in 3 Steps</h2>
            </div>

            <div class="q-how-timeline">

                <div class="q-how-step q-reveal" data-delay="1">
                    <div class="q-how-num">01</div>
                    <div>
                        <h3>Create Your Account</h3>
                        <p>Register free with your name, email, and phone. Only takes a minute.</p>
                    </div>
                </div>

                <div class="q-how-step q-reveal" data-delay="2">
                    <div class="q-how-num">02</div>
                    <div>
                        <h3>Choose a Plan</h3>
                        <p>Pick a plan and send payment via JazzCash — simple and local.</p>
                    </div>
                </div>

                <div class="q-how-step q-reveal" data-delay="3">
                    <div class="q-how-num">03</div>
                    <div>
                        <h3>Access Everything</h3>
                        <p>Once approved, all video courses and PDF books are yours.</p>
                    </div>
                </div>

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
