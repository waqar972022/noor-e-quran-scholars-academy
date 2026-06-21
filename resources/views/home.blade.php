@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
<style>
    /* ══════════════════════════════════════════════════
       HOME PAGE — Section & Component Styles
       All classes prefixed to avoid collision with theme
    ══════════════════════════════════════════════════ */

    /* ── Hero Slider ─────────────────────────────────── */
    .q-slider {
        position: relative;
        height: 360px;
        overflow: hidden;
        border-bottom: 1.5px solid var(--q-border);
    }
    /* All slides stacked via position:absolute — true cross-fade */
    .q-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .65s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .q-slide.active { opacity: 1; }

    .q-slide-inner {
        display: flex;
        align-items: center;
        gap: 3rem;
        max-width: 700px;
        width: 100%;
    }
    .q-slide-deco {
        font-family: var(--q-font-serif);
        font-size: 6rem;
        color: rgba(27,67,50,.08);
        line-height: 1;
        flex-shrink: 0;
        direction: rtl;
        user-select: none;
    }
    .q-slide-content { flex: 1; }
    .q-slide-title {
        font-family: var(--q-font-serif);
        font-size: 2rem;
        color: var(--q-ink);
        line-height: 1.3;
        margin-bottom: .7rem;
        font-weight: 700;
    }
    .q-slide-desc {
        font-size: 13px;
        color: var(--q-muted);
        line-height: 1.75;
        margin-bottom: 1.2rem;
        max-width: 380px;
    }
    .q-slide-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Arrows */
    .q-slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(245,240,228,.8);
        border: 1.5px solid var(--q-border);
        color: var(--q-green);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
    }
    .q-slider-arrow:hover { background: var(--q-parch-2); }
    .q-slider-prev { left: 14px; }
    .q-slider-next { right: 14px; }

    /* Dots — pill-shaped active dot matching reference */
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
        width: 7px;
        height: 7px;
        border-radius: 50%;
        border: none;
        background: rgba(27,67,50,.2);
        cursor: pointer;
        transition: all .3s;
        padding: 0;
    }
    .q-slider-dot.active {
        background: var(--q-green);
        width: 22px;
        border-radius: 4px;
    }

    @media (max-width: 600px) {
        .q-slide-deco  { display: none; }
        .q-slider-arrow { display: none; }
        .q-slide-inner { justify-content: center; text-align: center; }
        .q-slide-actions { justify-content: center; }
    }

    /* ── Stats Strip ─────────────────────────────────── */
    .q-stats-strip {
        background: var(--q-green);
        border-bottom: 1.5px solid rgba(0,0,0,.08);
    }
    .q-stats-inner {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    .q-stat-item {
        padding: 1rem 2.5rem;
        text-align: center;
        border-right: 1px solid rgba(245,240,228,.12);
    }
    .q-stat-item:last-child { border-right: none; }
    .q-stat-num {
        display: block;
        font-family: var(--q-font-serif);
        font-size: 1.6rem;
        color: var(--q-parch);
        font-weight: 700;
    }
    .q-stat-label {
        display: block;
        font-size: 11px;
        color: rgba(245,240,228,.65);
        letter-spacing: .06em;
        margin-top: 1px;
    }
    @media (max-width: 600px) {
        .q-stat-item { border-right: none; border-bottom: 1px solid rgba(245,240,228,.12); width: 50%; }
        .q-stat-item:last-child { border-bottom: none; }
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
    .q-card.q-course-card { padding: 0; overflow: hidden; }
    .q-course-thumb {
        height: 90px;
        border-radius: var(--q-radius-lg) var(--q-radius-lg) 0 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--q-font-serif);
        font-size: 2.2rem;
        color: rgba(27,67,50,.2);
        direction: rtl;
    }
    .q-course-thumb--quran  { background: #d4e8c4; }
    .q-course-thumb--fiqh   { background: #e8d9b8; }
    .q-course-thumb--arabic { background: #c8dfc8; }
    .q-course-thumb--seerah { background: #e0d4b8; }
    .q-course-body { padding: 1rem 1.1rem 1.2rem; }
    .q-course-title {
        font-family: var(--q-font-prose);
        font-size: .95rem;
        color: var(--q-ink);
        margin: .5rem 0 .25rem;
        line-height: 1.45;
    }
    .q-course-instructor {
        font-size: .78rem;
        color: var(--q-muted);
        margin-bottom: .85rem;
    }
    .q-course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: .75rem;
        padding-top: .75rem;
        border-top: 1px solid var(--q-border);
    }
    .q-course-price {
        font-family: var(--q-font-sans);
        font-size: .85rem;
        font-weight: 700;
        color: var(--q-green);
    }
    .q-course-price::before { content: 'PKR '; font-weight: 400; opacity: .7; font-size: .75rem; }

    /* ── Testimonials ────────────────────────────────── */
    .q-testimonials-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
    }
    .q-testimonials-header { text-align: center; margin-bottom: 2.5rem; }
    .q-testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .q-testimonial {
        display: flex;
        flex-direction: column;
        gap: .85rem;
    }
    .q-stars {
        color: var(--q-gold-2);
        font-size: 1rem;
        letter-spacing: 3px;
    }
    .q-testimonial-quote {
        font-family: var(--q-font-prose);
        font-style: italic;
        color: var(--q-ink-2);
        line-height: 1.85;
        font-size: .93rem;
        flex: 1;
    }
    .q-testimonial-author { display: flex; flex-direction: column; gap: 2px; margin-top: auto; }
    .q-testimonial-author strong { font-size: .88rem; color: var(--q-ink); }
    .q-testimonial-author span  { font-size: .76rem; color: var(--q-muted); }

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
        color: rgba(245,240,228,.7);
        margin-bottom: 1.2rem;
    }
    .q-btn-parch {
        background: var(--q-parch);
        color: var(--q-green);
        font-weight: 700;
    }
    .q-btn-parch:hover { background: var(--q-parch-2); }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════
     SECTION 1 — Hero Slider
══════════════════════════════════════════════════ --}}
<section class="q-slider" id="heroSlider" aria-label="Featured slides">

    {{-- Slide 1 --}}
    <div class="q-slide active" data-slide="0"
         style="background: linear-gradient(135deg, #EDE6D4 0%, #E2D9C4 40%, #D9CEAF 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">بِسْمِ اللَّهِ</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">{{ __('ui.home.slide1_eyebrow') }}</p>
                <h1 class="q-slide-title">{{ __('ui.home.slide1_title') }}</h1>
                <p class="q-slide-desc">{{ __('ui.home.slide1_desc') }}</p>
                <div class="q-slide-actions">
                    <a href="{{ route('register') }}" class="q-btn q-btn-primary">{{ __('ui.home.slide1_cta1') }}</a>
                    <a href="#" class="q-btn q-btn-outline">{{ __('ui.home.slide1_cta2') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 2 --}}
    <div class="q-slide" data-slide="1"
         style="background: linear-gradient(135deg, #E2EDD8 0%, #D4E8C4 40%, #C5DDB0 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الْمَكْتَبَة</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">{{ __('ui.home.slide2_eyebrow') }}</p>
                <h1 class="q-slide-title">{{ __('ui.home.slide2_title') }}</h1>
                <p class="q-slide-desc">{{ __('ui.home.slide2_desc') }}</p>
                <div class="q-slide-actions">
                    <a href="#" class="q-btn q-btn-primary">{{ __('ui.home.slide2_cta1') }}</a>
                    <a href="#" class="q-btn q-btn-outline">{{ __('ui.home.slide2_cta2') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 3 --}}
    <div class="q-slide" data-slide="2"
         style="background: linear-gradient(135deg, #EDE0C4 0%, #E8D4A8 40%, #DEC88E 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الشَّهَادَة</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">{{ __('ui.home.slide3_eyebrow') }}</p>
                <h1 class="q-slide-title">{{ __('ui.home.slide3_title') }}</h1>
                <p class="q-slide-desc">{{ __('ui.home.slide3_desc') }}</p>
                <div class="q-slide-actions">
                    <a href="{{ route('register') }}" class="q-btn q-btn-primary">{{ __('ui.home.slide3_cta1') }}</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Arrow controls --}}
    <button class="q-slider-arrow q-slider-prev" id="sliderPrev" aria-label="Previous slide">&#8249;</button>
    <button class="q-slider-arrow q-slider-next" id="sliderNext" aria-label="Next slide">&#8250;</button>

    {{-- Dot navigation --}}
    <div class="q-slider-dots" role="tablist" aria-label="Slide navigation">
        <button class="q-slider-dot active" data-dot="0" role="tab" aria-label="Slide 1" aria-selected="true"></button>
        <button class="q-slider-dot"        data-dot="1" role="tab" aria-label="Slide 2" aria-selected="false"></button>
        <button class="q-slider-dot"        data-dot="2" role="tab" aria-label="Slide 3" aria-selected="false"></button>
    </div>

</section>


{{-- ══════════════════════════════════════════════════
     SECTION 2 — Stats Strip
══════════════════════════════════════════════════ --}}
<section class="q-stats-strip" aria-label="Platform statistics">
    <div class="q-stats-inner">
        <div class="q-stat-item">
            <span class="q-stat-num">{{ __('ui.home.stats_learners_num') }}</span>
            <span class="q-stat-label">{{ __('ui.home.stats_learners_label') }}</span>
        </div>
        <div class="q-stat-item">
            <span class="q-stat-num">{{ __('ui.home.stats_courses_num') }}</span>
            <span class="q-stat-label">{{ __('ui.home.stats_courses_label') }}</span>
        </div>
        <div class="q-stat-item">
            <span class="q-stat-num">{{ __('ui.home.stats_books_num') }}</span>
            <span class="q-stat-label">{{ __('ui.home.stats_books_label') }}</span>
        </div>
        <div class="q-stat-item">
            <span class="q-stat-num">{{ __('ui.home.stats_scholars_num') }}</span>
            <span class="q-stat-label">{{ __('ui.home.stats_scholars_label') }}</span>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     SECTION 3 — Featured Courses
══════════════════════════════════════════════════ --}}
<section aria-labelledby="courses-heading">
    <div class="q-courses-wrap">

        <div class="q-courses-header">
            <div>
                <p class="q-eyebrow">{{ __('ui.home.courses_eyebrow') }}</p>
                <h2 id="courses-heading" class="q-section-title">{{ __('ui.home.courses_heading') }}</h2>
            </div>
            <a href="#" class="q-btn q-btn-outline">{{ __('ui.home.courses_view_all') }}</a>
        </div>

        <div class="q-courses-grid">

            {{-- Course 1: Tajweed --}}
            <article class="q-card q-course-card">
                <div class="q-course-thumb q-course-thumb--quran" aria-hidden="true">ق</div>
                <div class="q-course-body">
                    <span class="q-badge q-badge-green">Quran</span>
                    <h3 class="q-course-title">Tajweed &amp; Quran Recitation</h3>
                    <p class="q-course-instructor">Sh. Abdullah Al-Qari</p>
                    <div class="q-course-footer">
                        <span class="q-course-price">2,500</span>
                        <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm">{{ __('ui.home.courses_enroll') }}</a>
                    </div>
                </div>
            </article>

            {{-- Course 2: Fiqh --}}
            <article class="q-card q-course-card">
                <div class="q-course-thumb q-course-thumb--fiqh" aria-hidden="true">ف</div>
                <div class="q-course-body">
                    <span class="q-badge q-badge-gold">Fiqh</span>
                    <h3 class="q-course-title">Islamic Jurisprudence (Hanafi Fiqh)</h3>
                    <p class="q-course-instructor">Mufti Tariq Masood</p>
                    <div class="q-course-footer">
                        <span class="q-course-price">3,500</span>
                        <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm">{{ __('ui.home.courses_enroll') }}</a>
                    </div>
                </div>
            </article>

            {{-- Course 3: Arabic --}}
            <article class="q-card q-course-card">
                <div class="q-course-thumb q-course-thumb--arabic" aria-hidden="true">ع</div>
                <div class="q-course-body">
                    <span class="q-badge q-badge-green">Arabic</span>
                    <h3 class="q-course-title">Arabic Language for Beginners</h3>
                    <p class="q-course-instructor">Ustadh Ibrahim Khan</p>
                    <div class="q-course-footer">
                        <span class="q-course-price">1,800</span>
                        <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm">{{ __('ui.home.courses_enroll') }}</a>
                    </div>
                </div>
            </article>

            {{-- Course 4: Seerah --}}
            <article class="q-card q-course-card">
                <div class="q-course-thumb q-course-thumb--seerah" aria-hidden="true">س</div>
                <div class="q-course-body">
                    <span class="q-badge q-badge-gold">Seerah</span>
                    <h3 class="q-course-title">Seerah of the Prophet ﷺ</h3>
                    <p class="q-course-instructor">Dr. Hassan Al-Madani</p>
                    <div class="q-course-footer">
                        <span class="q-course-price">2,000</span>
                        <a href="{{ route('register') }}" class="q-btn q-btn-primary q-btn-sm">{{ __('ui.home.courses_enroll') }}</a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     SECTION 4 — Ornament Divider
══════════════════════════════════════════════════ --}}
<div style="padding: .5rem 1.5rem 0">
    <div class="q-ornament" aria-hidden="true">✦ &nbsp; ✦ &nbsp; ✦</div>
</div>


{{-- ══════════════════════════════════════════════════
     SECTION 5 — Testimonials
══════════════════════════════════════════════════ --}}
<section class="q-section-alt" aria-labelledby="testimonials-heading">
    <div class="q-testimonials-wrap">

        <div class="q-testimonials-header">
            <p class="q-eyebrow">{{ __('ui.home.testimonials_eyebrow') }}</p>
            <h2 id="testimonials-heading" class="q-section-title">{{ __('ui.home.testimonials_heading') }}</h2>
        </div>

        <div class="q-testimonials-grid">

            <blockquote class="q-card q-testimonial">
                <div class="q-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="q-testimonial-quote">
                    "The Tajweed course transformed my recitation completely.
                    Sh. Abdullah's explanations are patient and incredibly clear.
                    Alhamdulillah, I can now recite with proper Tajweed."
                </p>
                <footer class="q-testimonial-author">
                    <strong>Fatima Malik</strong>
                    <span>Karachi, Pakistan</span>
                </footer>
            </blockquote>

            <blockquote class="q-card q-testimonial">
                <div class="q-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="q-testimonial-quote">
                    "Best PKR-priced Islamic learning platform I've found.
                    I completed the Fiqh course in 3 months alongside full-time work.
                    The flexible schedule makes all the difference."
                </p>
                <footer class="q-testimonial-author">
                    <strong>Ahmed Raza</strong>
                    <span>Lahore, Pakistan</span>
                </footer>
            </blockquote>

            <blockquote class="q-card q-testimonial">
                <div class="q-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="q-testimonial-quote">
                    "The digital library alone is worth the subscription. Access to classical
                    texts I couldn't find anywhere else online. A must for serious students of
                    Islamic knowledge."
                </p>
                <footer class="q-testimonial-author">
                    <strong>Zainab Hussain</strong>
                    <span>Islamabad, Pakistan</span>
                </footer>
            </blockquote>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════
     SECTION 6 — CTA Band
══════════════════════════════════════════════════ --}}
<section class="q-cta-band" aria-labelledby="cta-heading">
    <h2 id="cta-heading">{{ __('ui.home.cta_heading') }}</h2>
    <p>{{ __('ui.home.cta_desc') }}</p>
    <a href="{{ route('register') }}" class="q-btn q-btn-lg q-btn-parch">{{ __('ui.home.cta_btn') }}</a>
</section>

@endsection

@push('scripts')
<script>
    // Vanilla JS hero slider — no external dependencies
    (function () {
        const slides = Array.from(document.querySelectorAll('.q-slide'));
        const dots   = Array.from(document.querySelectorAll('.q-slider-dot'));
        if (!slides.length) return;

        let current = 0;
        let timer;

        function goTo(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            dots[current].setAttribute('aria-selected', 'false');

            current = ((n % slides.length) + slides.length) % slides.length;

            slides[current].classList.add('active');
            dots[current].classList.add('active');
            dots[current].setAttribute('aria-selected', 'true');
        }

        function startAuto() {
            timer = setInterval(function () { goTo(current + 1); }, 4500);
        }

        function stopAuto() {
            clearInterval(timer);
        }

        // Dot click handlers
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                stopAuto();
                goTo(parseInt(this.dataset.dot, 10));
                startAuto();
            });
        });

        // Arrow handlers
        var prev = document.getElementById('sliderPrev');
        var next = document.getElementById('sliderNext');
        if (prev) prev.addEventListener('click', function () { stopAuto(); goTo(current - 1); startAuto(); });
        if (next) next.addEventListener('click', function () { stopAuto(); goTo(current + 1); startAuto(); });

        // Pause on hover
        var slider = document.getElementById('heroSlider');
        if (slider) {
            slider.addEventListener('mouseenter', stopAuto);
            slider.addEventListener('mouseleave', startAuto);
            // Pause on touch (mobile tap)
            slider.addEventListener('touchstart', stopAuto, { passive: true });
            slider.addEventListener('touchend',   function () { startAuto(); }, { passive: true });
        }

        startAuto();
    })();
</script>
@endpush
