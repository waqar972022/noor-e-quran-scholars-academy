@extends('layouts.app')

@section('title', $file->file_title . ' — ' . $course->title)

@push('styles')
<style>
.q-pdf-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem 1.5rem 3rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.q-pdf-viewer {
    width: 100%;
    height: 80vh;
    min-height: 500px;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
    background: var(--q-parch-2);
    display: block;
}
</style>
@endpush

@section('content')

<div class="q-pdf-wrap">

    <nav style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--q-muted)">
        <a href="{{ route('courses.index') }}" style="color:var(--q-green)">Courses</a>
        <span>/</span>
        <a href="{{ route('courses.show', $course->slug) }}" style="color:var(--q-green)">{{ $course->title }}</a>
        <span>/</span>
        <span>{{ $file->file_title }}</span>
    </nav>

    <h1 style="font-family:var(--q-font-serif);font-size:1.3rem;color:var(--q-ink);line-height:1.3">
        {{ $file->file_title }}
    </h1>

    <iframe
        class="q-pdf-viewer"
        src="{{ $pdfUrl }}"
        title="{{ $file->file_title }}"
    ></iframe>

    <div style="font-size:.78rem;color:var(--q-muted)">
        View-only. This document cannot be downloaded.
    </div>

    <div>
        <a href="{{ route('courses.show', $course->slug) }}" class="q-btn q-btn-outline q-btn-sm">
            ← Back to Course
        </a>
    </div>

</div>

@endsection
