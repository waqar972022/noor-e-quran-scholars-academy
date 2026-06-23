@extends('layouts.admin')

@section('title', $user->name)

@section('content')

{{-- Back --}}
<div style="margin-bottom:1.25rem">
    <a href="{{ route('admin.users.index') }}" class="q-btn q-btn-ghost q-btn-sm">← Back to Users</a>
</div>

{{-- ── User Info ── --}}
<div class="q-panel" style="margin-bottom:1.25rem">
    <div class="q-panel-title" style="margin-bottom:1rem">User Profile</div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.75rem 1.5rem;font-size:.88rem">
        <div>
            <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Name</div>
            <div style="font-weight:600;color:var(--q-ink)">{{ $user->name }}</div>
        </div>
        <div>
            <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Email</div>
            <div>{{ $user->email }}</div>
        </div>
        <div>
            <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Phone</div>
            <div>{{ $user->phone }}</div>
        </div>
        <div>
            <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Joined</div>
            <div>{{ $user->created_at->format('d M Y') }}</div>
        </div>
        <div>
            <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Account Status</div>
            <span class="q-badge {{ $user->account_status === 'active' ? 'q-badge-active' : 'q-badge-expired' }}">
                {{ ucfirst($user->account_status) }}
            </span>
        </div>
    </div>
</div>

{{-- ── Active Subscription ── --}}
<div class="q-panel" style="margin-bottom:1.25rem">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem">
        <div class="q-panel-title">Active Subscription</div>
        @if ($activeSubscription)
            <form method="POST" action="{{ route('admin.users.revoke', $user) }}"
                  onsubmit="return confirm('Revoke subscription for {{ addslashes($user->name) }}? They will lose access immediately.')">
                @csrf
                <button type="submit" class="q-btn q-btn-sm"
                        style="background:rgba(220,38,38,.15);color:#f87171;border:1px solid rgba(220,38,38,.35)">
                    Revoke Subscription
                </button>
            </form>
        @endif
    </div>

    @if ($activeSubscription)
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:.75rem 1.5rem;font-size:.88rem">
            <div>
                <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Plan</div>
                <div style="font-weight:600;color:var(--q-green)">{{ $activeSubscription->plan->name }}</div>
            </div>
            <div>
                <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Start Date</div>
                <div>{{ $activeSubscription->start_date->format('d M Y') }}</div>
            </div>
            <div>
                <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Expiry Date</div>
                <div>{{ $activeSubscription->end_date->format('d M Y') }}</div>
            </div>
            <div>
                <div style="font-size:.72rem;color:var(--q-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.2rem">Days Remaining</div>
                <div style="font-weight:700">{{ max(0, today()->diffInDays($activeSubscription->end_date)) }}</div>
            </div>
        </div>
    @else
        <p style="color:var(--q-muted);font-size:.88rem">No active subscription.</p>
    @endif
</div>

{{-- ── Activate / Extend Subscription ── --}}
<div class="q-panel" style="margin-bottom:1.25rem">
    <div class="q-panel-title" style="margin-bottom:1rem">
        {{ $activeSubscription ? 'Extend Subscription' : 'Activate Subscription' }}
    </div>

    @if ($plans->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem">No active subscription plans configured.</p>
    @else
        <form method="POST" action="{{ route('admin.users.activate', $user) }}"
              style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end">
            @csrf

            <div style="flex:1;min-width:160px">
                <label style="display:block;font-size:.78rem;color:var(--q-muted);margin-bottom:.3rem">Plan</label>
                <select name="plan_id" class="q-input" required>
                    @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}">
                            {{ $plan->name }} — {{ $plan->duration_days }} days ({{ pkr($plan->price) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="min-width:140px">
                <label style="display:block;font-size:.78rem;color:var(--q-muted);margin-bottom:.3rem">
                    Custom days <span style="font-weight:400">(overrides plan)</span>
                </label>
                <input type="number" name="custom_days" min="1" max="3650"
                       class="q-input" placeholder="e.g. 30" />
            </div>

            <div>
                <button type="submit" class="q-btn q-btn-primary q-btn-sm">
                    {{ $activeSubscription ? 'Extend' : 'Activate' }}
                </button>
            </div>
        </form>
        @if ($activeSubscription)
            <p style="margin-top:.6rem;font-size:.78rem;color:var(--q-muted)">
                Current end date ({{ $activeSubscription->end_date->format('d M Y') }}) will be pushed forward by the selected days.
            </p>
        @endif
    @endif
</div>

{{-- ── Set Password ── --}}
<div class="q-panel" style="margin-bottom:1.25rem">
    <div class="q-panel-title" style="margin-bottom:1rem">Set New Password</div>
    <form method="POST" action="{{ route('admin.users.password', $user) }}"
          style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end">
        @csrf
        <div style="min-width:200px">
            <label style="display:block;font-size:.78rem;color:var(--q-muted);margin-bottom:.3rem">New Password</label>
            <input type="password" name="new_password" class="q-input" required minlength="8" placeholder="Min. 8 characters" />
        </div>
        <div style="min-width:200px">
            <label style="display:block;font-size:.78rem;color:var(--q-muted);margin-bottom:.3rem">Confirm Password</label>
            <input type="password" name="new_password_confirmation" class="q-input" required placeholder="Repeat password" />
        </div>
        <div>
            <button type="submit" class="q-btn q-btn-outline q-btn-sm"
                    onclick="return confirm('Set a new password for {{ addslashes($user->name) }}?')">
                Set Password
            </button>
        </div>
    </form>
    @error('new_password')
        <p style="margin-top:.5rem;font-size:.82rem;color:#f87171">{{ $message }}</p>
    @enderror
</div>

{{-- ── Subscription History ── --}}
<div class="q-panel" style="margin-bottom:1.25rem">
    <div class="q-panel-title" style="margin-bottom:1rem">Subscription History</div>
    @if ($user->subscriptions->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem">No subscriptions on record.</p>
    @else
        <div class="q-table-wrap">
            <table class="q-table">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->subscriptions->sortByDesc('created_at') as $sub)
                        <tr>
                            <td>{{ $sub->plan->name }}</td>
                            <td>
                                @if ($sub->status === 'active')
                                    <span class="q-badge q-badge-active">Active</span>
                                @elseif ($sub->status === 'revoked')
                                    <span class="q-badge q-badge-expired">Revoked</span>
                                @else
                                    <span class="q-badge q-badge-gold">{{ ucfirst($sub->status) }}</span>
                                @endif
                            </td>
                            <td style="font-size:.83rem;color:var(--q-muted)">
                                {{ $sub->start_date?->format('d M Y') ?? '—' }}
                            </td>
                            <td style="font-size:.83rem;color:var(--q-muted)">
                                {{ $sub->end_date?->format('d M Y') ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- ── Payment Requests ── --}}
<div class="q-panel">
    <div class="q-panel-title" style="margin-bottom:1rem">Payment Requests</div>
    @if ($user->paymentRequests->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem">No payment requests.</p>
    @else
        <div class="q-table-wrap">
            <table class="q-table">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->paymentRequests->sortByDesc('created_at')->take(15) as $pr)
                        <tr>
                            <td>{{ $pr->plan->name }}</td>
                            <td style="font-weight:700;color:var(--q-green)">{{ pkr($pr->amount) }}</td>
                            <td>
                                <code style="font-size:.8rem;background:var(--q-parch-2);padding:2px 6px;border-radius:4px">
                                    {{ $pr->transaction_id }}
                                </code>
                            </td>
                            <td style="font-size:.82rem;color:var(--q-muted);white-space:nowrap">
                                {{ $pr->created_at->format('d M Y') }}
                            </td>
                            <td>
                                @if ($pr->status === 'approved')
                                    <span class="q-badge q-badge-active">Approved</span>
                                @elseif ($pr->status === 'rejected')
                                    <span class="q-badge q-badge-expired">Rejected</span>
                                @else
                                    <span class="q-badge q-badge-gold">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.payments.show', $pr) }}"
                                   class="q-btn q-btn-ghost q-btn-sm">
                                    View →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
