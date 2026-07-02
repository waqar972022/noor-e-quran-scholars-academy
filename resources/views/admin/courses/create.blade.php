@extends('layouts.admin')

@section('title', 'New Course')

@push('styles')
<style>
.pdf-row {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: .75rem;
    margin-bottom: .75rem;
    align-items: start;
}
@media (max-width: 600px) {
    .pdf-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<div class="q-page-header">
    <div>
        <p class="q-page-sub">All courses are premium. Add video lessons after saving.</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="q-btn q-btn-ghost q-btn-sm">← Back</a>
</div>

<form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf

    {{-- Core details --}}
    <div class="q-panel">
        <div class="q-panel-title">Course Details</div>

        <div class="q-field">
            <label class="q-label" for="title">Title</label>
            <input class="q-input @error('title') is-invalid @enderror"
                   type="text" id="title" name="title"
                   value="{{ old('title') }}" autofocus placeholder="Course title" required>
            @error('title')<span class="q-error">{{ $message }}</span>@enderror
        </div>

        <div class="q-form-row">
            <div class="q-field">
                <label class="q-label" for="category_id">Category</label>
                <select class="q-input q-select @error('category_id') is-invalid @enderror"
                        id="category_id" name="category_id" required>
                    <option value="">— Select category —</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="status">Status</label>
                <select class="q-input q-select @error('status') is-invalid @enderror"
                        id="status" name="status">
                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')<span class="q-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="q-field">
            <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer">
                <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--q-green)">
                <span class="q-label" style="margin:0">Free Course</span>
            </label>
            <span class="q-help-text">Anyone can access this course without a subscription.</span>
        </div>

        <div class="q-field">
            <label class="q-label" for="short_description">Short Description</label>
            <textarea class="q-input q-textarea @error('short_description') is-invalid @enderror"
                      id="short_description" name="short_description"
                      maxlength="500" rows="2" required
                      placeholder="One-paragraph summary shown on course cards (max 500 chars)">{{ old('short_description') }}</textarea>
            @error('short_description')<span class="q-error">{{ $message }}</span>@enderror
        </div>

        <div class="q-field">
            <label class="q-label" for="long_description">Full Description</label>
            <textarea class="q-input q-textarea @error('long_description') is-invalid @enderror"
                      id="long_description" name="long_description" required
                      rows="6"
                      placeholder="Detailed course description, curriculum, prerequisites…">{{ old('long_description') }}</textarea>
            @error('long_description')<span class="q-error">{{ $message }}</span>@enderror
        </div>
    </div>

    {{-- Thumbnail --}}
    <div class="q-panel">
        <div class="q-panel-title">Thumbnail</div>

        <div class="q-field">
            <label class="q-label" for="thumbnail">Cover Image</label>
            <input class="q-input q-input-file @error('thumbnail') is-invalid @enderror"
                   type="file" id="thumbnail" name="thumbnail"
                   accept=".jpg,.jpeg,.png,.webp" required>
            @error('thumbnail')<span class="q-error">{{ $message }}</span>@enderror
            <span class="q-help-text">JPG, PNG, or WebP — max 5 MB. Minimum 400×300 px recommended.</span>
        </div>
    </div>

    {{-- PDF Files --}}
    <div class="q-panel">
        <div class="q-panel-title">PDF Study Materials</div>
        <p style="font-size:.82rem;color:var(--q-muted);margin-bottom:1rem">
            PDFs are stored privately and served only to subscribed users. Max 100 MB each.
        </p>

        <div id="pdf-rows">
            <div class="pdf-row">
                <div class="q-field" style="margin:0">
                    <label class="q-label">Title</label>
                    <input class="q-input" type="text" name="pdf_titles[]" placeholder="e.g. Lesson Notes">
                </div>
                <div class="q-field" style="margin:0">
                    <label class="q-label">PDF File</label>
                    <input class="q-input q-input-file @error('pdf_files.0') is-invalid @enderror"
                           type="file" name="pdf_files[]" accept=".pdf">
                    @error('pdf_files.0')<span class="q-error">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <button type="button" class="q-btn q-btn-ghost q-btn-sm" id="add-pdf" style="margin-top:.25rem">
            + Add Another PDF
        </button>
        @error('pdf_files')<div class="q-error" style="margin-top:.35rem">{{ $message }}</div>@enderror
    </div>

    <div style="display:flex;gap:.5rem">
        <button type="submit" class="q-btn q-btn-primary">Create Course</button>
        <a href="{{ route('admin.courses.index') }}" class="q-btn q-btn-ghost">Cancel</a>
    </div>
</form>

@endsection

@push('scripts')
<script>
(function () {
    var idx = 1;
    document.getElementById('add-pdf').addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'pdf-row';
        row.style.cssText = '';
        row.innerHTML =
            '<div class="q-field" style="margin:0">' +
                '<label class="q-label">Title</label>' +
                '<input class="q-input" type="text" name="pdf_titles[]" placeholder="e.g. Lesson Notes">' +
            '</div>' +
            '<div class="q-field" style="margin:0">' +
                '<label class="q-label">PDF File</label>' +
                '<input class="q-input q-input-file" type="file" name="pdf_files[]" accept=".pdf">' +
            '</div>';
        document.getElementById('pdf-rows').appendChild(row);
        idx++;
    });
})();
</script>
@endpush
