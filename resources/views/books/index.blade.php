@extends('layouts.app')

@section('title', 'Books')

@push('styles')
<style>
.q-book-card {
    flex: 0 0 155px;
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
.q-book-card:hover { transform: translateY(-2px); box-shadow: var(--q-shadow-card); }
.q-book-thumb {
    position: relative;
    aspect-ratio: 3/4;
    background: var(--q-parch-3);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.q-book-thumb img { width: 100%; height: 100%; object-fit: contain; display: block; }
.q-book-info { padding: .6rem .75rem; flex: 1; }
.q-book-cat { font-size: .7rem; color: var(--q-muted); margin-bottom: .15rem; }
.q-book-title { font-size: .82rem; color: var(--q-ink); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
@media (max-width: 600px) {
    .q-book-card { flex: 0 0 135px; }
    .q-cat-section { padding: 1.5rem 1rem; }
}
</style>
@endpush

@section('content')

<div class="q-browse-hero">
    <h1>Course Books</h1>
    <p>PDF course books — included with every subscription plan.</p>
</div>

@if ($booksByCategory->isEmpty())
    <div style="text-align:center;padding:4rem 1.5rem;color:var(--q-muted)">No books available yet.</div>
@else
    @foreach ($booksByCategory as $categoryName => $books)
    <div class="q-cat-section">
        <div class="q-cat-label">{{ $categoryName }}</div>
        <div class="q-cat-track">
            @foreach ($books as $file)
                <a href="{{ route('content.pdf', [$file->course->slug, $file->id]) }}"
                   class="q-book-card">
                    <div class="q-book-thumb">
                        @if ($file->course->is_free)
                            <span class="q-free-pill">Free</span>
                        @endif
                        @if ($file->course->thumbnail)
                            <img src="{{ asset($file->course->thumbnail) }}"
                                 alt="{{ $file->file_title ?? $file->course->title }}"
                                 loading="lazy">
                        @else
                            <span style="font-size:2.5rem;opacity:.3">&#x1F4D6;</span>
                        @endif
                    </div>
                    <div class="q-book-info">
                        <p class="q-book-cat">{{ $file->course->title }}</p>
                        <p class="q-book-title">{{ $file->file_title ?? $file->course->title }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endforeach
@endif

@endsection
