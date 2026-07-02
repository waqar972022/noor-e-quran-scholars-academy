@extends('layouts.admin')

@section('title', 'Categories')

@section('content')

<div class="q-page-header">
    <div>
        <p class="q-page-sub">{{ $categories->total() }} total</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="q-btn q-btn-primary q-btn-sm">
        + New Category
    </a>
</div>

<div class="q-panel" style="padding:0;overflow:hidden">
    <div class="q-table-wrap">
        <table class="q-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Courses</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $cat)
                    <tr>
                        <td style="font-weight:500;color:var(--q-ink)">{{ $cat->name }}</td>
                        <td style="font-family:monospace;font-size:.8rem;color:var(--q-muted)">{{ $cat->slug }}</td>
                        <td>{{ $cat->courses_count }}</td>
                        <td>
                            <div style="display:flex;gap:.4rem;align-items:center">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="q-btn q-btn-ghost q-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                                      onsubmit="return confirm('Delete category «{{ addslashes($cat->name) }}»? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="q-btn q-btn-danger q-btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:var(--q-muted);padding:2rem">
                            No categories yet. <a href="{{ route('admin.categories.create') }}" style="color:var(--q-green)">Create one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $categories->links() }}

@endsection
