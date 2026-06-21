@extends('layouts.app')

@section('title', $course->title)

@push('styles')
<style>
.q-course-hero {
    background: var(--q-parch-2);
    border-bottom: 1.5px solid var(--q-border);
}
.q-course-hero-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.75rem;
    align-items: start;
}
@media (min-width: 768px) {
    .q-course-hero-inner { grid-template-columns: 380px 1fr; }
}
.q-course-hero-thumb {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: var(--q-radius-lg);
    overflow: hidden;
    border: 1.5px solid var(--q-border);
    background: #e8d9b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--q-font-serif);
    font-size: 5rem;
    color: rgba(27,67,50,.18);
}
.q-course-hero-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.q-course-hero-meta { display: flex; flex-direction: column; gap: .6rem; }
.q-course-hero-title {
    font-family: var(--q-font-serif);
    font-size: clamp(1.4rem, 3vw, 2rem);
    color: var(--q-ink);
    line-height: 1.25;
    margin: .4rem 0;
}
.q-course-hero-desc { font-size: .95rem; color: var(--q-ink-2); line-height: 1.75; }
.q-meta-row { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }

.q-course-body-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: start;
}
@media (min-width: 900px) {
    .q-course-body-wrap { grid-template-columns: 1fr 320px; }
}

.q-course-description {
    font-family: var(--q-font-prose);
    font-size: .97rem;
    color: var(--q-ink-2);
    line-height: 1.85;
}

.q-lesson-list { list-style: none; display: flex; flex-direction: column; gap: .4rem; }
.q-lesson-item {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .75rem 1rem;
    border-radius: var(--q-radius);
    background: var(--q-parch-2);
    border: 1.5px solid var(--q-border);
    font-size: .88rem;
    color: var(--q-ink-2);
}
.q-lesson-num {
    font-size: .72rem;
    font-weight: 700;
    color: var(--q-muted);
    min-width: 28px;
    text-align: center;
}
.q-lesson-title { flex: 1; }
.q-lesson-lock { font-size: .75rem; color: var(--q-muted); white-space: nowrap; opacity: .7; }

.q-pdf-item {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .75rem 1rem;
    border-radius: var(--q-radius);
    background: rgba(154,107,31,.06);
    border: 1.5px solid var(--q-border);
    font-size: .88rem;
    color: var(--q-ink-2);
}

.q-course-sidebar { display: flex; flex-direction: column; gap: 1.25rem; }

.q-included-list { list-style: none; display: flex; flex-direction: column; gap: .5rem; margin-top: .75rem; }
.q-included-item { display: flex; align-items: center; gap: .65rem; font-size: .88rem; color: var(--q-ink-2); }
.q-included-check {
    width: 20px; height: 20px;
    border-radius: 50%;
    background: var(--q-green-light);
    display: grid;
    place-items: center;
    font-size: .65rem;
    color: var(--q-green);
    flex-shrink: 0;
}

.q-subscribe-panel {
    background: var(--q-green);
    border-radius: var(--q-radius-lg);
    padding: 1.5rem;
    text-align: center;
    color: var(--q-parch);
}
.q-subscribe-panel h3 {
    font-family: var(--q-font-serif);
    font-size: 1.1rem;
    margin-bottom: .5rem;
    color: var(--q-parch);
}
.q-subscribe-panel p {
    font-size: .82rem;
    opacity: .75;
    margin-bottom: 1.1rem;
    line-height: 1.6;
}
.q-btn-parch { background: var(--q-parch); color: var(--q-green); font-weight: 700; }
.q-btn-parch:hover { background: var(--q-parch-2); }

.q-breadcrumb {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .8rem;
    color: var(--q-muted);
    max-width: 1100px;
    margin: 0 auto;
    padding: 1rem 1.5rem .25rem;
}
.q-breadcrumb a { color: var(--q-green); }
.q-breadcrumb a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')

<nav class="q-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('courses.index') }}">Courses</a>
    <span aria-hidden="true">/</span>
    <span>{{ $course->title }}</span>
</nav>

<div class="q-course-hero">
    <div class="q-course-hero-inner">

        <div class="q-course-hero-thumb">
            @if ($course->thumbnail)
                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
            @else
                {{ mb_substr($course->title, 0, 1) }}
            @endif
        </div>

        <div class="q-course-hero-meta">
            <div class="q-meta-row">
                @if ($course->category)
                    <span class="q-badge q-badge-green">{{ $course->category->name }}</span>
                @endif
                <span class="q-badge q-badge-gold">Premium</span>
            </div>

            <h1 class="q-course-hero-title">{{ $course->title }}</h1>

            @if ($course->short_description)
                <p class="q-course-hero-desc">{{ $course->short_description }}</p>
            @endif

            <div class="q-meta-row" style="margin-top:.5rem;font-size:.82rem;color:var(--q-muted)">
                @if ($course->videos->isNotEmpty())
                    <span>{{ $course->videos->count() }} video lessons</span>
                @endif
                @if ($course->files->isNotEmpty())
                    <span>· PDF course book included</span>
                @endif
            </div>
        </div>

    </div>
</div>

<div class="q-course-body-wrap">

    <div>

        @if ($course->long_description)
            <div class="q-panel" style="margin-bottom:1.5rem">
                <div class="q-panel-title">About This Course</div>
                <div class="q-course-description">
                    {!! nl2br(e($course->long_description)) !!}
                </div>
            </div>
        @endif

        @if ($course->videos->isNotEmpty() || $course->files->isNotEmpty())
            <div class="q-panel">
                <div class="q-panel-title">Lessons</div>

                <ul class="q-lesson-list">
                    @foreach ($course->videos as $video)
                        <li class="q-lesson-item">
                            <span class="q-lesson-num">{{ $loop->iteration }}</span>
                            <span aria-hidden="true">▶</span>
                            <span class="q-lesson-title">{{ $video->video_title }}</span>
                            <span class="q-lesson-lock">🔒 Subscribe to unlock</span>
                        </li>
                    @endforeach

                    @foreach ($course->files as $file)
                        <li class="q-pdf-item">
                            <span aria-hidden="true">📄</span>
                            <span class="q-lesson-title">{{ $file->file_title ?? 'PDF Course Book' }}</span>
                            <span class="q-lesson-lock">🔒 Subscribe to unlock</span>
                        </li>
                    @endforeach
                </ul>

            </div>
        @endif

    </div>

    <aside class="q-course-sidebar">

        <div class="q-panel">
            <div class="q-panel-title">What's Included</div>
            <ul class="q-included-list">
                @if ($course->videos->isNotEmpty())
                    <li class="q-included-item">
                        <span class="q-included-check" aria-hidden="true">✓</span>
                        {{ $course->videos->count() }} video lessons
                    </li>
                @endif
                @if ($course->files->isNotEmpty())
                    <li class="q-included-item">
                        <span class="q-included-check" aria-hidden="true">✓</span>
                        PDF course book
                    </li>
                @endif
                <li class="q-included-item">
                    <span class="q-included-check" aria-hidden="true">✓</span>
                    Completion certificate
                </li>
                <li class="q-included-item">
                    <span class="q-included-check" aria-hidden="true">✓</span>
                    Lifetime access
                </li>
            </ul>
        </div>

        <div class="q-subscribe-panel">
            <h3>Subscribe to Access All Courses</h3>
            <p>Plans start from PKR 500. Every plan unlocks all courses.</p>
            <a href="{{ route('pricing') }}" class="q-btn q-btn-parch q-btn-full">View Pricing</a>
            @guest
                <a href="{{ route('register') }}"
                   class="q-btn q-btn-full"
                   style="margin-top:.6rem;border:1px solid rgba(245,240,228,.25);color:rgba(245,240,228,.8);background:transparent">
                    Register Free
                </a>
            @endguest
        </div>

    </aside>

</div>

@endsection
