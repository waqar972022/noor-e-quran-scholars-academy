@extends('layouts.app')

@section('title', 'Welcome')

@push('styles')
<style>
    /* ── Hero Slider ─────────────────────────────────── */
    .q-slider {
        position: relative;
        height: 360px;
        overflow: hidden;
        border-bottom: 1.5px solid var(--q-border);
    }
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
    .q-slide-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .q-slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(245,240,228,.8);
        border: 1.5px solid var(--q-border);
        color: var(--q-green);
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
    .q-slider-arrow:hover { background: var(--q-parch-2); }
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
        background: rgba(27,67,50,.2);
        cursor: pointer;
        transition: all .3s;
        padding: 0;
    }
    .q-slider-dot.active { background: var(--q-green); width: 22px; border-radius: 4px; }

    @media (max-width: 600px) {
        .q-slide-deco  { display: none; }
        .q-slider-arrow { display: none; }
        .q-slide-inner { justify-content: center; text-align: center; }
        .q-slide-actions { justify-content: center; }
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
        line-height: 1.55;
    }
    .q-course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: .75rem;
        padding-top: .75rem;
        border-top: 1px solid var(--q-border);
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
        color: rgba(245,240,228,.7);
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
         style="background: linear-gradient(135deg, #EDE6D4 0%, #E2D9C4 40%, #D9CEAF 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">بِسْمِ اللَّهِ</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Begin Your Journey</p>
                <h1 class="q-slide-title">Learn Quran &amp; Hadith from Authentic Sources</h1>
                <p class="q-slide-desc">Video courses, PDF books, and completion certificates — taught by verified scholars.</p>
                <div class="q-slide-actions">
                    <a href="{{ route('register') }}" class="q-btn q-btn-primary">Start Learning</a>
                    <a href="{{ route('courses.index') }}" class="q-btn q-btn-outline">Browse Courses</a>
                </div>
            </div>
        </div>
    </div>

    <div class="q-slide" data-slide="1"
         style="background: linear-gradient(135deg, #E2EDD8 0%, #D4E8C4 40%, #C5DDB0 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الْمَكْتَبَة</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Digital Library</p>
                <h1 class="q-slide-title">350+ Classical Islamic Books in One Place</h1>
                <p class="q-slide-desc">Tafsir Ibn Kathir, Sahih Al-Bukhari, Fiqh us-Sunnah — readable on any device as PDF.</p>
                <div class="q-slide-actions">
                    <a href="#" class="q-btn q-btn-primary">Browse Library</a>
                    <a href="{{ route('pricing') }}" class="q-btn q-btn-outline">View Pricing</a>
                </div>
            </div>
        </div>
    </div>

    <div class="q-slide" data-slide="2"
         style="background: linear-gradient(135deg, #EDE0C4 0%, #E8D4A8 40%, #DEC88E 100%)">
        <div class="q-slide-inner">
            <div class="q-slide-deco" aria-hidden="true">الشَّهَادَة</div>
            <div class="q-slide-content">
                <p class="q-eyebrow">Certificates</p>
                <h1 class="q-slide-title">Earn a Certificate with Every Course</h1>
                <p class="q-slide-desc">Complete a course and receive a verified certificate to share with your community.</p>
                <div class="q-slide-actions">
                    <a href="{{ route('pricing') }}" class="q-btn q-btn-primary">Subscribe Now</a>
                </div>
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


{{-- ══ SECTION 2 — Why Choose Us ══ --}}
<section class="q-section-alt" aria-label="Why choose us">
    <div style="max-width:1100px;margin:0 auto;padding:2.5rem 1.5rem">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1.25rem">

            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:.75rem">
                <span style="font-size:1.8rem">🎓</span>
                <strong style="font-size:.9rem;color:var(--q-ink)">Qualified Scholars</strong>
                <p style="font-size:.78rem;color:var(--q-muted);line-height:1.55">Verified Islamic scholars with formal Dars-e-Nizami education</p>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:.75rem">
                <span style="font-size:1.8rem">🆓</span>
                <strong style="font-size:.9rem;color:var(--q-ink)">3-Day Free Trial</strong>
                <p style="font-size:.78rem;color:var(--q-muted);line-height:1.55">Try live classes for 3 days before committing to any plan</p>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:.75rem">
                <span style="font-size:1.8rem">🕐</span>
                <strong style="font-size:.9rem;color:var(--q-ink)">Flexible Timings</strong>
                <p style="font-size:.78rem;color:var(--q-muted);line-height:1.55">Schedule classes at times that suit you and your family</p>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:.75rem">
                <span style="font-size:1.8rem">💬</span>
                <strong style="font-size:.9rem;color:var(--q-ink)">WhatsApp Support</strong>
                <p style="font-size:.78rem;color:var(--q-muted);line-height:1.55">Direct access to your teacher and admin via WhatsApp</p>
            </div>

            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:.5rem;padding:.75rem">
                <span style="font-size:1.8rem">📋</span>
                <strong style="font-size:.9rem;color:var(--q-ink)">Parent Reports</strong>
                <p style="font-size:.78rem;color:var(--q-muted);line-height:1.55">Regular progress reports shared with parents on WhatsApp</p>
            </div>

        </div>
    </div>
</section>


{{-- ══ SECTION 3 — Featured Courses ══ --}}
<section aria-labelledby="courses-heading">
    <div class="q-courses-wrap">

        <div class="q-courses-header">
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
                <article class="q-card q-course-card">
                    @if ($course->thumbnail)
                        <img style="height:90px;width:100%;object-fit:cover;border-radius:var(--q-radius-lg) var(--q-radius-lg) 0 0"
                             src="{{ Storage::url($course->thumbnail) }}"
                             alt="{{ $course->title }}"
                             loading="lazy">
                    @else
                        <div class="q-course-thumb {{ $tc }}" aria-hidden="true">
                            {{ mb_substr($course->title, 0, 1) }}
                        </div>
                    @endif
                    <div class="q-course-body">
                        @if ($course->category)
                            <span class="q-badge q-badge-green">{{ $course->category->name }}</span>
                        @endif
                        <h3 class="q-course-title">{{ $course->title }}</h3>
                        @if ($course->short_description)
                            <p class="q-course-instructor">{{ Str::limit($course->short_description, 70) }}</p>
                        @endif
                        <div class="q-course-footer">
                            <span class="q-badge q-badge-gold">Premium</span>
                            <a href="{{ route('courses.show', $course->slug) }}"
                               class="q-btn q-btn-primary q-btn-sm">Enroll</a>
                        </div>
                    </div>
                </article>
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
        <div style="text-align:center;margin-bottom:2.5rem">
            <p class="q-eyebrow">How It Works</p>
            <h2 id="how-heading" class="q-section-title">Start Learning in 3 Steps</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem">

            <div class="q-card" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">01</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Create Your Account</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Register free with your name, email, and phone. Only takes a minute.</p>
            </div>

            <div class="q-card" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">02</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Choose a Plan</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Pick monthly or annual. Send payment via JazzCash — simple and local.</p>
            </div>

            <div class="q-card" style="text-align:center;padding:1.75rem 1.25rem">
                <div style="font-family:var(--q-font-serif);font-size:2.4rem;color:var(--q-green);opacity:.25;margin-bottom:.5rem">03</div>
                <h3 style="font-family:var(--q-font-serif);font-size:1rem;color:var(--q-ink);margin-bottom:.5rem">Access Everything</h3>
                <p style="font-size:.85rem;color:var(--q-muted);line-height:1.7">Once approved, all video courses, PDF books, and certificates are yours.</p>
            </div>

        </div>
    </div>
</section>


{{-- ══ SECTION 5 — CTA Band ══ --}}
<section class="q-cta-band" aria-labelledby="cta-heading">
    <h2 id="cta-heading">Begin your journey of sacred knowledge</h2>
    <p>Join thousands of learners studying the Qur'an and Sunnah.</p>
    <a href="{{ route('register') }}" class="q-btn q-btn-lg q-btn-parch">Create Free Account</a>
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
</script>
@endpush
