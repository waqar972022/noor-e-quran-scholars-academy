@extends('layouts.user')

@section('title', 'My Learning')

@section('content')

        <div class="q-user-page-head">
            <h1>My Learning</h1>
            <p>{{ $isSubscribed ? 'Full access — all courses are unlocked for you.' : 'Subscribe to unlock all courses and content.' }}</p>
        </div>

        @if (! $isSubscribed)
            <div class="q-panel" style="border-top:3px solid var(--q-gold);text-align:center;padding:2.5rem 1.5rem;margin-bottom:1.5rem">
                <div class="q-panel-title" style="font-size:1.05rem;margin-bottom:.5rem">Subscription Required</div>
                <p style="color:var(--q-muted);font-size:.88rem;max-width:40ch;margin:0 auto 1.5rem;line-height:1.7">
                    All video lessons, PDF books, and course materials are available with any subscription plan.
                </p>
                <a href="{{ route('pricing') }}" class="q-btn q-btn-primary q-btn-lg">View Plans &amp; Pricing</a>
            </div>
        @endif

        @if ($courses->isEmpty())
            <div class="q-panel" style="text-align:center;padding:2.5rem 1.5rem;color:var(--q-muted)">
                No courses published yet. Check back soon.
            </div>
        @else
            <div class="q-learn-grid">
                @foreach ($courses as $course)
                    <a href="{{ route('courses.show', $course->slug) }}" class="q-learn-card" style="text-decoration:none">
                        @if ($course->thumbnail)
                            <img
                                src="{{ asset($course->thumbnail) }}"
                                alt="{{ $course->title }}"
                                class="q-learn-thumb"
                                loading="lazy"
                            >
                        @else
                            <div class="q-learn-thumb-placeholder">&#x0646;</div>
                        @endif

                        <div class="q-learn-body">
                            @if ($course->category)
                                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--q-muted);margin-bottom:.1rem">
                                    {{ $course->category->name }}
                                </div>
                            @endif
                            <div class="q-learn-title">{{ $course->title }}</div>
                            @if ($course->short_description)
                                <div class="q-learn-meta" style="margin-top:.2rem;line-height:1.5">
                                    {{ Str::limit($course->short_description, 80) }}
                                </div>
                            @endif

                            @php
                                $totalVideos = $course->videos->count();
                                $completed   = $completedByCourse[$course->id] ?? 0;
                            @endphp
                            @if (($isSubscribed || $course->is_free) && $totalVideos > 0)
                                <div style="margin-top:.5rem">
                                    <div style="display:flex;justify-content:space-between;font-size:.72rem;color:var(--q-muted);margin-bottom:.3rem">
                                        <span>Progress</span>
                                        <span>{{ $completed }} / {{ $totalVideos }} lessons</span>
                                    </div>
                                    <div style="height:5px;background:var(--q-parch-3);border-radius:3px;overflow:hidden">
                                        <div style="height:100%;background:var(--q-green);border-radius:3px;width:{{ round($completed / $totalVideos * 100) }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="q-learn-footer">
                                <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                                    @if ($course->videos->count())
                                        <span class="q-badge q-badge-green">
                                            {{ $course->videos->count() }} video{{ $course->videos->count() === 1 ? '' : 's' }}
                                        </span>
                                    @endif
                                    @if ($course->files->count())
                                        <span class="q-badge" style="background:var(--q-parch-3);color:var(--q-ink-2)">
                                            {{ $course->files->count() }} PDF{{ $course->files->count() === 1 ? '' : 's' }}
                                        </span>
                                    @endif
                                </div>
                                @if ($isSubscribed || $course->is_free)
                                    <span style="font-size:.75rem;color:var(--q-green);font-weight:600">Open &rarr;</span>
                                @else
                                    <span style="font-size:.75rem;color:var(--q-muted)">Locked</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

@endsection
