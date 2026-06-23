@extends('layouts.admin')

@section('title', 'New Category')

@section('content')

<div class="q-page-header">
    <div>
        <h2 class="q-page-heading">New Category</h2>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="q-btn q-btn-ghost q-btn-sm">← Back</a>
</div>

<div class="q-panel" style="max-width:480px">
    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        <div class="q-field">
            <label class="q-label" for="name">Category Name</label>
            <input class="q-input @error('name') is-invalid @enderror"
                   type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   autofocus placeholder="e.g. Quran Studies" required>
            @error('name')<span class="q-error">{{ $message }}</span>@enderror
            <span class="q-help-text">Slug is generated automatically from the name.</span>
        </div>

        <div style="display:flex;gap:.5rem;margin-top:1.1rem">
            <button type="submit" class="q-btn q-btn-primary">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="q-btn q-btn-ghost">Cancel</a>
        </div>
    </form>
</div>

@endsection
