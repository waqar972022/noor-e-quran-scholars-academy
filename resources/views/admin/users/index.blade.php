@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<form method="GET" action="{{ route('admin.users.index') }}"
      style="display:flex;gap:.5rem;margin-bottom:1.5rem;flex-wrap:wrap;align-items:center">
    <input type="search"
           name="search"
           value="{{ $search }}"
           placeholder="Search name, email or phone…"
           class="q-input"
           style="flex:1;min-width:200px;max-width:340px" />
    <button type="submit" class="q-btn q-btn-primary q-btn-sm">Search</button>
    @if ($search)
        <a href="{{ route('admin.users.index') }}" class="q-btn q-btn-ghost q-btn-sm">Clear</a>
    @endif
    <span style="margin-left:auto;font-size:.82rem;color:var(--q-muted)">
        {{ $users->total() }} user{{ $users->total() === 1 ? '' : 's' }}
    </span>
</form>

<div class="q-panel">
    @if ($users->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem;padding:.5rem 0">
            No users found{{ $search ? ' matching "' . e($search) . '"' : '' }}.
        </p>
    @else
        <div class="q-table-wrap">
            <table class="q-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Subscription</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td style="color:var(--q-muted);font-size:.82rem">{{ $u->id }}</td>
                            <td style="font-weight:500;color:var(--q-ink)">{{ $u->name }}</td>
                            <td style="font-size:.83rem;color:var(--q-muted)">{{ $u->email }}</td>
                            <td style="font-size:.83rem;color:var(--q-muted);white-space:nowrap">{{ $u->phone }}</td>
                            <td style="font-size:.8rem;color:var(--q-muted);white-space:nowrap">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                            <td>
                                @if ($u->active_sub_count > 0)
                                    <span class="q-badge q-badge-active">Active</span>
                                @else
                                    <span class="q-badge" style="background:var(--q-parch-2);color:var(--q-muted)">None</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $u) }}"
                                   class="q-btn q-btn-ghost q-btn-sm">
                                    Manage →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div style="margin-top:1.25rem">{{ $users->links() }}</div>
        @endif
    @endif
</div>

@endsection
