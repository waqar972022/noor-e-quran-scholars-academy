@extends('layouts.admin')

@section('title', 'Courses')

@section('content')

<div class="q-page-header">
    <div>
        <h2 class="q-page-heading">Courses</h2>
        <p class="q-page-sub">{{ $courses->total() }} total</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="q-btn q-btn-primary q-btn-sm">+ New Course</a>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.courses.index') }}" class="q-search-bar">
    <input class="q-input" type="search" name="search"
           value="{{ request('search') }}"
           placeholder="Search by title…">
    <button type="submit" class="q-btn q-btn-ghost q-btn-sm">Search</button>
    @if (request('search'))
        <a href="{{ route('admin.courses.index') }}" class="q-btn q-btn-ghost q-btn-sm">Clear</a>
    @endif
</form>

<div class="q-panel" style="padding:0;overflow:hidden">
    <div class="q-table-wrap">
        <table class="q-table">
            <thead>
                <tr>
                    <th style="width:52px"></th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                     alt="" class="q-thumb-sm">
                            @else
                                <span class="q-thumb-placeholder">—</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight:500;color:var(--q-ink)">{{ $course->title }}</span>
                            <div style="font-size:.75rem;color:var(--q-muted)">{{ Str::limit($course->short_description, 55) }}</div>
                        </td>
                        <td>{{ $course->category?->name ?? '—' }}</td>
                        <td>
                            <span class="q-badge q-badge-{{ $course->status }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        <td style="color:var(--q-muted)">{{ $course->created_at->format('d M Y') }}</td>
                        <td>
                            <div style="display:flex;gap:.4rem">
                                <a href="{{ route('admin.courses.edit', $course) }}"
                                   class="q-btn q-btn-ghost q-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                      onsubmit="return confirm('Delete «{{ addslashes($course->title) }}»? All its files and videos will also be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="q-btn q-btn-danger q-btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:var(--q-muted);padding:2rem">
                            No courses yet. <a href="{{ route('admin.courses.create') }}" style="color:var(--q-green)">Create one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $courses->links() }}

@endsection
