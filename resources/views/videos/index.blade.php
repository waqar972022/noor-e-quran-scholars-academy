@extends('layouts.app')

@section('title', 'Videos')

@push('styles')
<style>
.q-vid-card {
    flex: 0 0 220px;
    padding: 0;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    transition: box-shadow .2s, transform .18s;
    border-radius: var(--q-radius-lg);
    border: 1.5px solid var(--q-border);
    background: var(--q-parch-2);
}
.q-vid-card:hover { transform: translateY(-2px); box-shadow: var(--q-shadow-card); }
.q-vid-thumb {
    position: relative;
    aspect-ratio: 16/9;
    background: var(--q-parch-3);
    overflow: hidden;
}
.q-vid-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.q-vid-play {
    position: absolute;
    inset: 0;
    display: grid;
    place-items: center;
    background: rgba(0,0,0,.25);
}
.q-vid-play span {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,.9);
    display: grid;
    place-items: center;
    font-size: .85rem;
}
.q-vid-info { padding: .65rem .85rem; flex: 1; }
.q-vid-course { font-size: .72rem; color: var(--q-green); font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: .2rem; }
.q-vid-title { font-size: .85rem; color: var(--q-ink); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
@media (max-width: 600px) {
    .q-vid-card { flex: 0 0 155px; }
    .q-cat-section { padding: 1.5rem 1rem; }
}
</style>
@endpush

@section('content')

<div class="q-browse-hero">
    <h1>Video Lessons</h1>
    <p>Watch video lessons from all courses — first lesson of each course is free.</p>
</div>

@if ($videosByCategory->isEmpty())
    <div style="text-align:center;padding:4rem 1.5rem;color:var(--q-muted)">No videos available yet.</div>
@else
    @foreach ($videosByCategory as $categoryName => $videos)
    <div class="q-cat-section">
        <div class="q-cat-label">{{ $categoryName }}</div>
        <div class="q-cat-track">
            @foreach ($videos as $video)
                @php
                    preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_-]{11})/', $video->youtube_url ?? '', $m);
                    $ytId = $m[1] ?? null;
                @endphp
                <a href="{{ route('content.video', [$video->course->slug, $video->id]) }}"
                   class="q-vid-card">
                    <div class="q-vid-thumb">
                        @if ($ytId)
                            <img src="https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg"
                                 alt="{{ $video->video_title }}"
                                 loading="lazy">
                        @endif
                        @if ($video->is_free_preview)
                            <span class="q-free-pill">Free</span>
                        @endif
                        <div class="q-vid-play"><span>&#x25B6;</span></div>
                    </div>
                    <div class="q-vid-info">
                        <p class="q-vid-course">{{ $video->course->title }}</p>
                        <p class="q-vid-title">{{ $video->video_title }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endforeach
@endif

@endsection
