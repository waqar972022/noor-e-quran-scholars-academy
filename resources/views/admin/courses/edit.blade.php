@extends('layouts.admin')

@section('title', 'Edit: ' . $course->title)

@section('content')

<div class="q-page-header">
    <div>
        <h2 class="q-page-heading">Edit Course</h2>
        <p class="q-page-sub">{{ $course->title }}</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="q-btn q-btn-ghost q-btn-sm">← Back</a>
</div>

{{-- ── Course Details ── --}}
<form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="q-panel">
        <div class="q-panel-title">Course Details</div>

        <div class="q-field">
            <label class="q-label" for="title">Title</label>
            <input class="q-input @error('title') is-invalid @enderror"
                   type="text" id="title" name="title"
                   value="{{ old('title', $course->title) }}" required>
            @error('title')<span class="q-error">{{ $message }}</span>@enderror
        </div>

        <div class="q-form-row">
            <div class="q-field">
                <label class="q-label" for="category_id">Category</label>
                <select class="q-input q-select @error('category_id') is-invalid @enderror"
                        id="category_id" name="category_id" required>
                    <option value="">— Select category —</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ old('category_id', $course->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="status">Status</label>
                <select class="q-input q-select" id="status" name="status">
                    <option value="draft" {{ old('status', $course->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $course->status) === 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>
        </div>

        <div class="q-field">
            <label style="display:flex;align-items:center;gap:.6rem;cursor:pointer">
                <input type="checkbox" name="is_free" value="1"
                       {{ old('is_free', $course->is_free) ? 'checked' : '' }}
                       style="width:16px;height:16px;accent-color:var(--q-green)">
                <span class="q-label" style="margin:0">Free Course</span>
            </label>
            <span class="q-help-text">Anyone can access this course without a subscription.</span>
        </div>

        <div class="q-field">
            <label class="q-label" for="short_description">Short Description</label>
            <textarea class="q-input q-textarea @error('short_description') is-invalid @enderror"
                      id="short_description" name="short_description"
                      maxlength="500" rows="2" required>{{ old('short_description', $course->short_description) }}</textarea>
            @error('short_description')<span class="q-error">{{ $message }}</span>@enderror
        </div>

        <div class="q-field">
            <label class="q-label" for="long_description">Full Description</label>
            <textarea class="q-input q-textarea"
                      id="long_description" name="long_description" required
                      rows="6">{{ old('long_description', $course->long_description) }}</textarea>
        </div>
    </div>

    {{-- Thumbnail --}}
    <div class="q-panel">
        <div class="q-panel-title">Thumbnail</div>

        @if ($course->thumbnail)
            <div style="margin-bottom:.85rem">
                <img src="{{ asset($course->thumbnail) }}"
                     alt="Current thumbnail"
                     style="max-width:220px;border-radius:var(--q-radius);border:1.5px solid var(--q-border)">
                <p style="font-size:.75rem;color:var(--q-muted);margin-top:.35rem">Current thumbnail</p>
            </div>
        @endif

        <div class="q-field">
            <label class="q-label" for="thumbnail">Replace Thumbnail</label>
            <input class="q-input q-input-file @error('thumbnail') is-invalid @enderror"
                   type="file" id="thumbnail" name="thumbnail"
                   accept=".jpg,.jpeg,.png,.webp">
            @error('thumbnail')<span class="q-error">{{ $message }}</span>@enderror
            <span class="q-help-text">Leave empty to keep current. JPG, PNG, or WebP — max 5 MB.</span>
        </div>
    </div>

    {{-- Add more PDFs --}}
    <div class="q-panel">
        <div class="q-panel-title">Add More PDF Materials</div>

        <div id="pdf-rows">
            <div class="pdf-row" style="display:grid;grid-template-columns:1fr 2fr;gap:.75rem;margin-bottom:.75rem;align-items:start">
                <div class="q-field" style="margin:0">
                    <label class="q-label">Title</label>
                    <input class="q-input" type="text" name="pdf_titles[]" placeholder="e.g. Week 1 Notes">
                </div>
                <div class="q-field" style="margin:0">
                    <label class="q-label">PDF File</label>
                    <input class="q-input q-input-file" type="file" name="pdf_files[]" accept=".pdf">
                </div>
            </div>
        </div>
        <button type="button" class="q-btn q-btn-ghost q-btn-sm" id="add-pdf">+ Add Another PDF</button>
    </div>

    <div style="display:flex;gap:.5rem;margin-bottom:1.5rem">
        <button type="submit" class="q-btn q-btn-primary">Save Changes</button>
        <a href="{{ route('admin.courses.index') }}" class="q-btn q-btn-ghost">Cancel</a>
    </div>
</form>

{{-- ── Existing PDFs ── --}}
@if ($course->files->isNotEmpty())
<div class="q-panel">
    <div class="q-panel-title">PDF Files ({{ $course->files->count() }})</div>
    @foreach ($course->files as $file)
        <div class="q-file-row">
            <div>
                <span class="q-file-icon">📄</span>
                <span style="font-weight:500;color:var(--q-ink)">{{ $file->file_title }}</span>
                <span style="font-size:.75rem;color:var(--q-muted);margin-left:.4rem">
                    {{ basename($file->file_path) }}
                </span>
            </div>
            <form method="POST"
                  action="{{ route('admin.courses.files.destroy', [$course, $file]) }}"
                  onsubmit="return confirm('Remove this PDF permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="q-btn q-btn-danger q-btn-sm">Remove</button>
            </form>
        </div>
    @endforeach
</div>
@endif

{{-- ── Video Lessons ── --}}
<div class="q-panel">
    <div class="q-panel-title">
        Video Lessons ({{ $course->videos->count() }})
        <span style="font-size:.75rem;color:var(--q-muted);font-weight:400">
            Lower order number = shown first
        </span>
    </div>

    @foreach ($course->videos as $video)
        <div class="q-video-row">
            <form method="POST" action="{{ route('admin.courses.videos.update', [$course, $video]) }}"
                  style="display:contents">
                @csrf
                @method('PUT')

                <input class="q-input q-video-order-input" type="number"
                       name="video_order" value="{{ $video->video_order }}"
                       min="0" title="Order">

                <input class="q-input" type="text" name="video_title"
                       value="{{ $video->video_title }}" placeholder="Lesson title"
                       style="flex:1;min-width:160px">

                <input class="q-input" type="url" name="youtube_url"
                       value="{{ $video->youtube_url }}" placeholder="YouTube URL"
                       style="flex:2;min-width:200px">

                <button type="submit" class="q-btn q-btn-ghost q-btn-sm">Save</button>
            </form>

            <form method="POST"
                  action="{{ route('admin.courses.videos.destroy', [$course, $video]) }}"
                  onsubmit="return confirm('Remove this video?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="q-btn q-btn-danger q-btn-sm">Remove</button>
            </form>
        </div>
    @endforeach

    @if ($course->videos->isEmpty())
        <p style="color:var(--q-muted);font-size:.85rem;margin-bottom:1rem">No video lessons yet. Add one below.</p>
    @endif

    {{-- Add new video --}}
    <form method="POST" action="{{ route('admin.courses.videos.store', $course) }}"
          style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--q-border)">
        @csrf

        <p class="q-label" style="margin-bottom:.6rem">Add New Video Lesson</p>

        <div class="q-video-row" style="border:none;padding:0">
            <div class="q-field" style="margin:0;width:70px">
                <label class="q-label" style="font-size:.7rem">Order</label>
                <input class="q-input q-video-order-input" type="number"
                       name="video_order" value="{{ $course->videos->count() + 1 }}" min="0">
                @error('video_order')<span class="q-error">{{ $message }}</span>@enderror
            </div>

            <div class="q-field" style="margin:0;flex:1;min-width:160px">
                <label class="q-label" style="font-size:.7rem">Title</label>
                <input class="q-input @error('video_title') is-invalid @enderror"
                       type="text" name="video_title"
                       value="{{ old('video_title') }}"
                       placeholder="e.g. Introduction to Tajweed">
                @error('video_title')<span class="q-error">{{ $message }}</span>@enderror
            </div>

            <div class="q-field" style="margin:0;flex:2;min-width:200px">
                <label class="q-label" style="font-size:.7rem">YouTube URL</label>
                <input class="q-input @error('youtube_url') is-invalid @enderror"
                       type="url" name="youtube_url"
                       value="{{ old('youtube_url') }}"
                       placeholder="https://www.youtube.com/watch?v=…">
                @error('youtube_url')<span class="q-error">{{ $message }}</span>@enderror
            </div>

            <div style="padding-top:1.2rem">
                <button type="submit" class="q-btn q-btn-primary q-btn-sm">Add Video</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
(function () {
    document.getElementById('add-pdf').addEventListener('click', function () {
        var row = document.createElement('div');
        row.className = 'pdf-row';
        row.style.cssText = 'display:grid;grid-template-columns:1fr 2fr;gap:.75rem;margin-bottom:.75rem;align-items:start';
        row.innerHTML =
            '<div class="q-field" style="margin:0">' +
                '<label class="q-label">Title</label>' +
                '<input class="q-input" type="text" name="pdf_titles[]" placeholder="e.g. Week 2 Notes">' +
            '</div>' +
            '<div class="q-field" style="margin:0">' +
                '<label class="q-label">PDF File</label>' +
                '<input class="q-input q-input-file" type="file" name="pdf_files[]" accept=".pdf">' +
            '</div>';
        document.getElementById('pdf-rows').appendChild(row);
    });
})();
</script>
@endpush
