@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="q-page-header">
    <div>
        <p class="q-page-sub">{{ $category->courses_count ?? $category->courses()->count() }} courses in this category</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="q-btn q-btn-ghost q-btn-sm">← Back</a>
</div>

<div class="q-panel" style="max-width:480px">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="q-field">
            <label class="q-label" for="name">Category Name</label>
            <input class="q-input @error('name') is-invalid @enderror"
                   type="text" id="name" name="name"
                   value="{{ old('name', $category->name) }}"
                   autofocus required>
            @error('name')<span class="q-error">{{ $message }}</span>@enderror
            <span class="q-help-text">Current slug: <code>{{ $category->slug }}</code> — will regenerate on save.</span>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.1rem">
            <button type="submit" class="q-btn q-btn-primary">Save Changes</button>
            <a href="{{ route('admin.categories.index') }}" class="q-btn q-btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
