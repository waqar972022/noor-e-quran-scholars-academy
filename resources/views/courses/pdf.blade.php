@extends('layouts.app')

@section('title', $file->file_title . ' — ' . $course->title)

@push('styles')
<style>
.q-pdf-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1rem 1.5rem 3rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.q-pdf-controls {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}
.q-pdf-canvas-wrap {
    width: 100%;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
    background: #525659;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
    min-height: 300px;
    text-align: center;
}
#pdf-canvas {
    display: none;
    margin: 0 auto;
    max-width: 100%;
}
.q-pdf-loading {
    padding: 3rem 1.5rem;
    color: #ccc;
    font-size: .9rem;
}
@media (max-width: 600px) {
    .q-pdf-wrap { padding: .75rem .75rem 2rem; }
}
</style>
@endpush

@section('content')

<div class="q-pdf-wrap">

    <nav style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--q-muted);flex-wrap:wrap">
        <a href="{{ route('courses.index') }}" style="color:var(--q-green)">Courses</a>
        <span>/</span>
        <a href="{{ route('courses.show', $course->slug) }}" style="color:var(--q-green)">{{ $course->title }}</a>
        <span>/</span>
        <span>{{ $file->file_title }}</span>
    </nav>

    <h1 style="font-family:var(--q-font-serif);font-size:1.3rem;color:var(--q-ink);line-height:1.3">
        {{ $file->file_title }}
    </h1>

    <div class="q-pdf-controls">
        <button id="pdf-prev" class="q-btn q-btn-ghost q-btn-sm" disabled>← Prev</button>
        <span style="font-size:.85rem;color:var(--q-ink-2)">
            Page <span id="pdf-page-num">–</span> of <span id="pdf-page-count">–</span>
        </span>
        <button id="pdf-next" class="q-btn q-btn-ghost q-btn-sm" disabled>Next →</button>
    </div>

    <div class="q-pdf-canvas-wrap">
        <p class="q-pdf-loading" id="pdf-loading">Loading document…</p>
        <canvas id="pdf-canvas"></canvas>
    </div>

    <p style="font-size:.78rem;color:var(--q-muted)">View-only. This document cannot be downloaded.</p>

    <div>
        <a href="{{ route('courses.show', $course->slug) }}" class="q-btn q-btn-outline q-btn-sm">
            ← Back to Course
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
(function () {
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    var url      = @json(route('content.pdf.stream', [$course->slug, $file]));
    var canvas   = document.getElementById('pdf-canvas');
    var ctx      = canvas.getContext('2d');
    var loading  = document.getElementById('pdf-loading');
    var prevBtn  = document.getElementById('pdf-prev');
    var nextBtn  = document.getElementById('pdf-next');
    var pageNum  = document.getElementById('pdf-page-num');
    var pageCnt  = document.getElementById('pdf-page-count');

    var pdfDoc = null, currentPage = 1, rendering = false, pending = null;

    function getScale() {
        var wrap = canvas.parentElement;
        var maxW = (wrap.clientWidth || window.innerWidth) - 4;
        return Math.min(1.5, maxW / 612); // 612pt = standard page width
    }

    function renderPage(num) {
        rendering = true;
        pdfDoc.getPage(num).then(function (page) {
            var viewport = page.getViewport({ scale: getScale() });
            canvas.width  = viewport.width;
            canvas.height = viewport.height;
            page.render({ canvasContext: ctx, viewport: viewport }).promise.then(function () {
                rendering = false;
                if (pending !== null) { renderPage(pending); pending = null; }
            });
        });
        pageNum.textContent  = num;
        prevBtn.disabled     = (num <= 1);
        nextBtn.disabled     = (num >= pdfDoc.numPages);
    }

    function queuePage(num) {
        if (rendering) { pending = num; } else { renderPage(num); }
    }

    pdfjsLib.getDocument({ url: url, withCredentials: true }).promise.then(function (doc) {
        pdfDoc = doc;
        pageCnt.textContent    = doc.numPages;
        loading.style.display  = 'none';
        canvas.style.display   = 'block';
        renderPage(1);
    }).catch(function () {
        loading.textContent = 'Failed to load document. Please try again.';
    });

    prevBtn.addEventListener('click', function () {
        if (currentPage <= 1) return;
        currentPage--;
        queuePage(currentPage);
    });

    nextBtn.addEventListener('click', function () {
        if (!pdfDoc || currentPage >= pdfDoc.numPages) return;
        currentPage++;
        queuePage(currentPage);
    });

    window.addEventListener('resize', function () {
        if (pdfDoc) queuePage(currentPage);
    });
}());
</script>
@endpush
