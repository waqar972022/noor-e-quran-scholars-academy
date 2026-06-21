@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="q-stat-cards">
    <div class="q-stat-card">
        <div class="q-stat-card-num">{{ number_format($stats['total_users']) }}</div>
        <div class="q-stat-card-label">Total Users</div>
    </div>
    <div class="q-stat-card">
        <div class="q-stat-card-num">{{ number_format($stats['active_subscriptions']) }}</div>
        <div class="q-stat-card-label">Active Subscriptions</div>
    </div>
    <div class="q-stat-card q-stat-card--warn">
        <div class="q-stat-card-num">{{ number_format($stats['pending_payments']) }}</div>
        <div class="q-stat-card-label">Pending Payments</div>
    </div>
    <div class="q-stat-card">
        <div class="q-stat-card-num">{{ number_format($stats['total_courses']) }}</div>
        <div class="q-stat-card-label">Total Courses</div>
    </div>
    <div class="q-stat-card">
        <div class="q-stat-card-num">{{ number_format($stats['published_courses']) }}</div>
        <div class="q-stat-card-label">Published Courses</div>
    </div>
</div>

{{-- Recent Registrations --}}
<div class="q-panel">
    <div class="q-panel-title">
        Recent Registrations
        <a href="#" class="q-btn q-btn-ghost q-btn-sm">View All</a>
    </div>

    @if ($recent->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem">No users yet.</p>
    @else
        <div class="q-table-wrap">
            <table class="q-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recent as $user)
                        <tr>
                            <td style="font-weight:500;color:var(--q-ink)">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="q-badge q-badge-{{ $user->account_status === 'active' ? 'active' : 'expired' }}">
                                    {{ ucfirst($user->account_status) }}
                                </span>
                            </td>
                            <td style="color:var(--q-muted)">{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
