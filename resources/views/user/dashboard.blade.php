@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')

        {{-- Page head --}}
        <div class="q-user-page-head">
            <h1>Welcome back, {{ auth()->user()->name }}</h1>
            <p>{{ now()->format('l, d F Y') }}</p>
        </div>

        {{-- ── Unread Notifications ── --}}
        @if ($unreadNotifications->isNotEmpty())
            <div class="q-panel" style="border-left:3px solid var(--q-gold);margin-bottom:1.5rem;padding:.9rem 1.1rem">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem">
                    <div class="q-panel-title" style="font-size:.88rem;color:var(--q-gold)">
                        New Notifications
                    </div>
                    <a href="{{ route('notifications.index') }}" style="font-size:.78rem;color:var(--q-green)">
                        View all &rarr;
                    </a>
                </div>
                <div style="display:flex;flex-direction:column;gap:.5rem">
                    @foreach ($unreadNotifications as $n)
                        <div style="font-size:.85rem;color:var(--q-ink);padding:.45rem 0;border-bottom:1px solid var(--q-border)">
                            {{ $n->data['message'] ?? '' }}
                            <span style="font-size:.72rem;color:var(--q-muted);margin-left:.5rem">
                                {{ $n->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ── Subscription Status ── --}}
        @if ($subscription)
            <div class="q-panel" style="border-top:3px solid var(--q-green);margin-bottom:1.5rem">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:.75rem;margin-bottom:1.25rem">
                    <div>
                        <div class="q-panel-title" style="color:var(--q-green)">Subscription Active</div>
                        <p style="color:var(--q-muted);font-size:.85rem;margin-top:.2rem">
                            {{ $subscription->plan->name }}
                        </p>
                    </div>
                    <span class="q-badge q-badge-active">Active</span>
                </div>

                <div class="q-stat-cards">
                    <div class="q-stat-card {{ $daysRemaining <= 7 ? 'q-stat-card--warn' : '' }}">
                        <div class="q-stat-card-num">{{ $daysRemaining }}</div>
                        <div class="q-stat-card-label">Days Remaining</div>
                    </div>
                    <div class="q-stat-card">
                        <div class="q-stat-card-num" style="font-size:1.1rem">
                            {{ $subscription->start_date->format('d M Y') }}
                        </div>
                        <div class="q-stat-card-label">Start Date</div>
                    </div>
                    <div class="q-stat-card">
                        <div class="q-stat-card-num" style="font-size:1.1rem">
                            {{ $subscription->end_date->format('d M Y') }}
                        </div>
                        <div class="q-stat-card-label">Expires</div>
                    </div>
                    <div class="q-stat-card">
                        <div class="q-stat-card-num">{{ $courseCount }}</div>
                        <div class="q-stat-card-label">Courses Available</div>
                    </div>
                </div>

                @if ($daysRemaining <= 7)
                    <div style="margin-top:1rem;padding:.75rem 1rem;background:rgba(154,107,31,.08);border-radius:var(--q-radius);font-size:.85rem;color:var(--q-gold);display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
                        <span>Your subscription expires in {{ $daysRemaining }} day{{ $daysRemaining === 1 ? '' : 's' }}.</span>
                        <a href="{{ route('pricing') }}" class="q-btn q-btn-sm q-btn-primary">Renew Now</a>
                    </div>
                @endif
            </div>
        @else
            <div class="q-panel" style="border-top:3px solid var(--q-gold);margin-bottom:1.5rem;text-align:center;padding:2.5rem 1.5rem">
                <div style="font-family:var(--q-font-serif);font-size:1.75rem;color:var(--q-gold);margin-bottom:.5rem">&#x10E60;</div>
                <div class="q-panel-title" style="font-size:1.05rem;margin-bottom:.5rem">No Active Subscription</div>
                <p style="color:var(--q-muted);font-size:.88rem;max-width:38ch;margin:0 auto 1.5rem">
                    Subscribe to unlock all courses, video lessons, and PDF materials.
                </p>
                <a href="{{ route('pricing') }}" class="q-btn q-btn-primary q-btn-lg">View Plans &amp; Pricing</a>
            </div>
        @endif

        {{-- ── Quick Links ── --}}
        <div class="q-user-page-head" style="margin-bottom:.75rem">
            <h1 style="font-size:1rem;font-family:var(--q-font-sans)">Quick Access</h1>
        </div>
        <div class="q-quick-grid">
            <a href="{{ route('user.learning') }}" class="q-quick-card">
                <div class="q-quick-card-icon">&#x2665;</div>
                <div class="q-quick-card-title">My Learning</div>
                <div class="q-quick-card-sub">{{ $courseCount }} course{{ $courseCount === 1 ? '' : 's' }} available</div>
            </a>
            <a href="{{ route('user.subscription') }}" class="q-quick-card">
                <div class="q-quick-card-icon">&#x2605;</div>
                <div class="q-quick-card-title">Subscription</div>
                <div class="q-quick-card-sub">{{ $subscription ? 'Active — renew or view details' : 'No active plan' }}</div>
            </a>
            <a href="{{ route('user.payments') }}" class="q-quick-card">
                <div class="q-quick-card-icon">&#x2710;</div>
                <div class="q-quick-card-title">Payment History</div>
                @if ($pendingCount > 0)
                    <div class="q-quick-card-sub" style="color:var(--q-gold)">{{ $pendingCount }} pending</div>
                @else
                    <div class="q-quick-card-sub">All payments</div>
                @endif
            </a>
            <a href="{{ route('profile.edit') }}" class="q-quick-card">
                <div class="q-quick-card-icon">&#x270E;</div>
                <div class="q-quick-card-title">Profile</div>
                <div class="q-quick-card-sub">Update your details</div>
            </a>
        </div>

        {{-- ── Recent Payments ── --}}
        @if ($recentPayments->isNotEmpty())
            <div class="q-panel">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
                    <div class="q-panel-title">Recent Payments</div>
                    <a href="{{ route('user.payments') }}" class="q-btn q-btn-ghost q-btn-sm">View all</a>
                </div>
                <div class="q-table-wrap">
                    <table class="q-table">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPayments as $pr)
                                <tr>
                                    <td>{{ $pr->plan->name }}</td>
                                    <td style="font-weight:600;color:var(--q-green)">{{ pkr($pr->amount) }}</td>
                                    <td style="color:var(--q-muted);font-size:.82rem">{{ $pr->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($pr->status === 'approved')
                                            <span class="q-badge q-badge-active">Approved</span>
                                        @elseif ($pr->status === 'rejected')
                                            <span class="q-badge q-badge-expired">Rejected</span>
                                        @else
                                            <span class="q-badge q-badge-gold">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

@endsection
