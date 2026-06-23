@extends('layouts.app')

@section('title', $video->video_title . ' — ' . $course->title)

@push('styles')
<style>
.q-player-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 1.5rem 1.5rem 4rem;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: start;
}
@media (min-width: 900px) {
    .q-player-wrap { grid-template-columns: 1fr 280px; }
}
.q-video-frame {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    border-radius: var(--q-radius-lg);
    overflow: hidden;
    border: 1.5px solid var(--q-border);
    background: #000;
}
.q-video-frame iframe {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    border: none;
}
.q-playlist { list-style: none; display: flex; flex-direction: column; gap: .35rem; }
.q-playlist-item {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .65rem .9rem;
    border-radius: var(--q-radius);
    border: 1.5px solid var(--q-border);
    background: var(--q-parch-2);
    font-size: .84rem;
    color: var(--q-ink-2);
    text-decoration: none;
    transition: background .15s, border-color .15s;
}
.q-playlist-item:hover { background: var(--q-parch-3); border-color: var(--q-green); }
.q-playlist-item.active {
    background: var(--q-green);
    border-color: var(--q-green);
    color: var(--q-parch);
    font-weight: 600;
}
.q-playlist-num {
    font-size: .7rem;
    font-weight: 700;
    color: var(--q-muted);
    min-width: 20px;
    text-align: center;
    flex-shrink: 0;
}
.q-playlist-item.active .q-playlist-num { color: color-mix(in srgb, var(--q-ink) 70%, transparent); }
.q-playlist-item.completed .q-playlist-num { color: var(--q-green); }
.q-progress-bar-track {
    height: 6px;
    background: var(--q-parch-3);
    border-radius: 3px;
    overflow: hidden;
    margin-top: .4rem;
}
.q-progress-bar-fill {
    height: 100%;
    background: var(--q-green);
    border-radius: 3px;
    transition: width .3s;
}
</style>
@endpush

@section('content')

<div style="max-width:1100px;margin:0 auto;padding:1rem 1.5rem .25rem">
    <nav style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--q-muted)">
        <a href="{{ route('courses.index') }}" style="color:var(--q-green)">Courses</a>
        <span>/</span>
        <a href="{{ route('courses.show', $course->slug) }}" style="color:var(--q-green)">{{ $course->title }}</a>
        <span>/</span>
        <span>{{ $video->video_title }}</span>
    </nav>
</div>

<div class="q-player-wrap">

    <div>
        <h1 style="font-family:var(--q-font-serif);font-size:1.3rem;color:var(--q-ink);margin-bottom:1rem;line-height:1.3">
            {{ $video->video_title }}
        </h1>

        <div class="q-video-frame">
            <iframe
                src="{{ $embedUrl }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                title="{{ $video->video_title }}"
            ></iframe>
        </div>

        {{-- Mark as Complete --}}
        <div style="margin-top:1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem">
            <a href="{{ route('courses.show', $course->slug) }}" class="q-btn q-btn-outline q-btn-sm">
                &larr; Back to Course
            </a>

            <form method="POST" action="{{ route('content.video.complete', [$course->slug, $video->id]) }}">
                @csrf
                @if ($isCompleted)
                    <button type="submit"
                            class="q-btn q-btn-sm"
                            style="background:var(--q-green-light);color:var(--q-green);border:1.5px solid color-mix(in srgb, var(--q-green) 30%, transparent);font-weight:600">
                        &#x2713; Completed &mdash; Undo
                    </button>
                @else
                    <button type="submit" class="q-btn q-btn-primary q-btn-sm">
                        Mark as Complete
                    </button>
                @endif
            </form>
        </div>

        {{-- Navigation: prev / next lesson --}}
        @php
            $allArr = $allVideos->values();
            $currentIdx = $allArr->search(fn($v) => $v->id === $video->id);
            $prevVideo = $currentIdx > 0 ? $allArr[$currentIdx - 1] : null;
            $nextVideo = $currentIdx < $allArr->count() - 1 ? $allArr[$currentIdx + 1] : null;
        @endphp
        @if ($prevVideo || $nextVideo)
            <div style="margin-top:1rem;display:flex;gap:.6rem;flex-wrap:wrap">
                @if ($prevVideo)
                    <a href="{{ route('content.video', [$course->slug, $prevVideo->id]) }}"
                       class="q-btn q-btn-ghost q-btn-sm">&larr; Previous</a>
                @endif
                @if ($nextVideo)
                    <a href="{{ route('content.video', [$course->slug, $nextVideo->id]) }}"
                       class="q-btn q-btn-primary q-btn-sm">Next &rarr;</a>
                @endif
            </div>
        @endif
    </div>

    <aside>
        <div class="q-panel">
            <div class="q-panel-title">All Lessons</div>

            {{-- Progress --}}
            <div style="margin:.75rem 0 1rem">
                <div style="display:flex;justify-content:space-between;font-size:.75rem;color:var(--q-muted)">
                    <span>Progress</span>
                    <span>{{ $completedCount }} / {{ $totalVideos }}</span>
                </div>
                <div class="q-progress-bar-track">
                    @if ($totalVideos > 0)
                        <div class="q-progress-bar-fill"
                             style="width:{{ round($completedCount / $totalVideos * 100) }}%"></div>
                    @endif
                </div>
            </div>

            <ul class="q-playlist">
                @foreach ($allVideos as $v)
                    @php $done = in_array($v->id, $completedIds); @endphp
                    <li>
                        <a href="{{ route('content.video', [$course->slug, $v->id]) }}"
                           class="q-playlist-item {{ $v->id === $video->id ? 'active' : ($done ? 'completed' : '') }}"
                           style="{{ $done && $v->id !== $video->id ? 'border-color:color-mix(in srgb, var(--q-green) 25%, transparent)' : '' }}">
                            <span class="q-playlist-num">
                                @if ($done && $v->id !== $video->id)
                                    &#x2713;
                                @else
                                    {{ $loop->iteration }}
                                @endif
                            </span>
                            <span style="flex:1">{{ $v->video_title }}</span>
                            @if ($v->id === $video->id)
                                <span style="font-size:.7rem;opacity:.7">&#x25B6; Now</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

</div>

@endsection
