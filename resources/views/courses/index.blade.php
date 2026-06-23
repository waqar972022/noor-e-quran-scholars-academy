@extends('layouts.app')

@section('title', 'All Courses')

@push('styles')
<style>
.q-page-hero {
    background: var(--q-parch-2);
    border-bottom: 1.5px solid var(--q-border);
    padding: 2.5rem 1.5rem 2rem;
}
.q-page-hero-inner { max-width: 1100px; margin: 0 auto; }

.q-listing-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
}

.q-filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: .6rem;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1rem 1.25rem;
    background: var(--q-parch-2);
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
}
.q-filter-search { flex: 1; min-width: 200px; }
.q-filter-cat    { min-width: 160px; cursor: pointer; }
@media (max-width: 480px) {
    .q-filter-search, .q-filter-cat { min-width: 100%; }
}

.q-course-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.5rem;
}

.q-crd {
    display: flex;
    flex-direction: column;
    padding: 0;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .2s, transform .18s;
}
.q-crd:hover {
    box-shadow: var(--q-shadow-card);
    transform: translateY(-2px);
}
.q-crd-thumb {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--q-font-serif);
    font-size: 3rem;
    color: color-mix(in srgb, var(--q-green) 20%, transparent);
}
.q-crd-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.q-crd-thumb.c0 { background: color-mix(in srgb, var(--q-green) 20%, transparent); }
.q-crd-thumb.c1 { background: var(--q-parch-3); }
.q-crd-thumb.c2 { background: color-mix(in srgb, var(--q-green) 15%, transparent); }
.q-crd-thumb.c3 { background: var(--q-parch-4); }
.q-crd-body { padding: 1rem 1.15rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
.q-crd-title {
    font-family: var(--q-font-prose);
    font-size: .95rem;
    color: var(--q-ink);
    margin: .5rem 0 .3rem;
    line-height: 1.45;
}
.q-crd-desc {
    font-size: .82rem;
    color: var(--q-muted);
    line-height: 1.65;
    margin-bottom: .85rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.q-crd-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: .8rem;
    border-top: 1px solid var(--q-border);
    margin-top: auto;
}

.q-pagination {
    display: flex;
    justify-content: center;
    gap: .4rem;
    margin-top: 2.5rem;
    flex-wrap: wrap;
}
.q-pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 36px;
    height: 36px;
    padding: 0 .6rem;
    border-radius: var(--q-radius);
    border: 1.5px solid var(--q-border);
    background: var(--q-parch-2);
    color: var(--q-ink-2);
    font-size: .85rem;
    text-decoration: none;
    transition: all .18s;
}
.q-pagination .page-link:hover,
.q-pagination .active .page-link {
    background: var(--q-green);
    color: var(--q-parch);
    border-color: var(--q-green);
}
.q-pagination .disabled .page-link { opacity: .4; pointer-events: none; }

.q-empty {
    text-align: center;
    padding: 5rem 1.5rem;
    color: var(--q-muted);
}
.q-empty-glyph {
    font-family: var(--q-font-serif);
    font-size: 3.5rem;
    opacity: .2;
    margin-bottom: 1rem;
    direction: rtl;
}
</style>
@endpush

@section('content')

<div class="q-page-hero">
    <div class="q-page-hero-inner">
        <p class="q-eyebrow">Islamic Curriculum</p>
        <h1 class="q-section-title" style="margin-top:.3rem">All Courses</h1>
    </div>
</div>

<div class="q-listing-wrap">

    <form method="GET" action="{{ route('courses.index') }}" role="search">
        <div class="q-filter-bar">

            <input class="q-input q-filter-search"
                   type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Search courses…"
                   aria-label="Search courses">

            @if ($categories->isNotEmpty())
                <select class="q-input q-select q-filter-cat"
                        name="category"
                        aria-label="Filter by category"
                        onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}"
                                {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->courses_count }})
                        </option>
                    @endforeach
                </select>
            @endif

            <button type="submit" class="q-btn q-btn-primary">Search</button>

            @if (request('q') || request('category'))
                <a href="{{ route('courses.index') }}" class="q-btn q-btn-ghost" aria-label="Clear filters">✕ Clear</a>
            @endif

        </div>
    </form>

    @if ($courses->isEmpty())
        <div class="q-empty">
            <div class="q-empty-glyph" aria-hidden="true">ق</div>
            <p>{{ request('q') || request('category')
                ? 'No courses match your search or filter.'
                : 'No published courses yet. Check back soon.' }}</p>
        </div>
    @else
        <div class="q-course-grid">
            @foreach ($courses as $course)
                @php $ci = $loop->index % 4; @endphp
                <a href="{{ route('courses.show', $course->slug) }}" class="q-card q-crd">

                    <div class="q-crd-thumb c{{ $ci }}">
                        @if ($course->thumbnail)
                            <img src="{{ Storage::url($course->thumbnail) }}"
                                 alt="{{ $course->title }}"
                                 loading="lazy">
                        @else
                            {{ mb_substr($course->title, 0, 1) }}
                        @endif
                    </div>

                    <div class="q-crd-body">
                        @if ($course->category)
                            <span class="q-badge q-badge-green">{{ $course->category->name }}</span>
                        @endif
                        <h3 class="q-crd-title">{{ $course->title }}</h3>
                        @if ($course->short_description)
                            <p class="q-crd-desc">{{ $course->short_description }}</p>
                        @endif
                        <div class="q-crd-footer">
                            @if ($course->is_free)
                                <span class="q-badge" style="background:color-mix(in srgb,var(--q-green) 15%,transparent);color:var(--q-green);border:1px solid color-mix(in srgb,var(--q-green) 30%,transparent)">Free</span>
                            @else
                                <span class="q-badge q-badge-gold">Premium</span>
                            @endif
                            <span class="q-btn q-btn-primary q-btn-sm">Enroll</span>
                        </div>
                    </div>

                </a>
            @endforeach
        </div>

        @if ($courses->hasPages())
            <div class="q-pagination">
                {{ $courses->links() }}
            </div>
        @endif
    @endif

</div>

@endsection
