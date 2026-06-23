@extends('layouts.user')

@section('title', 'Subscription')

@section('content')

        <div class="q-user-page-head">
            <h1>Subscription</h1>
            <p>Your current plan and subscription history.</p>
        </div>

        {{-- Current subscription --}}
        @if ($subscription)
            <div class="q-panel" style="border-top:3px solid var(--q-green);margin-bottom:1.5rem">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem">
                    <div>
                        <div class="q-panel-title" style="color:var(--q-green)">Active Subscription</div>
                        <p style="font-size:.88rem;color:var(--q-muted);margin-top:.2rem">{{ $subscription->plan->name }}</p>
                    </div>
                    <span class="q-badge q-badge-active">Active</span>
                </div>

                {{-- Detail rows --}}
                @php
                    $rows = [
                        'Plan'         => $subscription->plan->name,
                        'Duration'     => $subscription->plan->duration_days . ' days',
                        'Price'        => pkr($subscription->plan->price),
                        'Start Date'   => $subscription->start_date->format('d M Y'),
                        'Expiry Date'  => $subscription->end_date->format('d M Y'),
                        'Days Left'    => $daysRemaining . ' day' . ($daysRemaining === 1 ? '' : 's'),
                    ];
                @endphp
                <div style="border:1.5px solid var(--q-border);border-radius:var(--q-radius);overflow:hidden;margin-bottom:1.25rem">
                    @foreach ($rows as $label => $value)
                        <div style="display:flex;align-items:baseline;padding:.6rem 1rem;{{ ! $loop->last ? 'border-bottom:1px solid var(--q-border);' : '' }}">
                            <span style="min-width:130px;font-size:.78rem;color:var(--q-muted);flex-shrink:0">{{ $label }}</span>
                            <span style="font-weight:{{ in_array($label,['Price','Days Left']) ? '700' : '500' }};color:{{ $label === 'Days Left' && $daysRemaining <= 7 ? 'var(--q-gold)' : 'var(--q-ink)' }}">
                                {{ $value }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div style="display:flex;gap:.75rem;flex-wrap:wrap">
                    <a href="{{ route('pricing') }}" class="q-btn q-btn-primary">Renew / Upgrade</a>
                    <span style="font-size:.8rem;color:var(--q-muted);align-self:center">
                        Renewing extends your current plan from the expiry date.
                    </span>
                </div>
            </div>
        @else
            <div class="q-panel" style="border-top:3px solid var(--q-gold);text-align:center;padding:2.5rem 1.5rem;margin-bottom:1.5rem">
                <div class="q-panel-title" style="font-size:1.05rem;margin-bottom:.5rem">No Active Subscription</div>
                <p style="color:var(--q-muted);font-size:.88rem;max-width:40ch;margin:0 auto 1.5rem">
                    Choose a plan to unlock all courses, videos, and PDF materials.
                </p>
                <a href="{{ route('pricing') }}" class="q-btn q-btn-primary q-btn-lg">View Plans &amp; Pricing</a>
            </div>
        @endif

        {{-- Subscription History --}}
        @if ($history->isNotEmpty())
            <div class="q-panel">
                <div class="q-panel-title" style="margin-bottom:1rem">Subscription History</div>
                <div class="q-table-wrap">
                    <table class="q-table">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Start</th>
                                <th>Expiry</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $sub)
                                @php
                                    $isActive = $sub->status === 'active' && $sub->end_date->gte(today());
                                @endphp
                                <tr>
                                    <td style="font-weight:500">{{ $sub->plan->name }}</td>
                                    <td style="color:var(--q-muted);font-size:.82rem">{{ $sub->start_date->format('d M Y') }}</td>
                                    <td style="color:var(--q-muted);font-size:.82rem">{{ $sub->end_date->format('d M Y') }}</td>
                                    <td style="color:var(--q-muted);font-size:.82rem">{{ $sub->plan->duration_days }} days</td>
                                    <td>
                                        @if ($isActive)
                                            <span class="q-badge q-badge-active">Active</span>
                                        @else
                                            <span class="q-badge q-badge-expired">Expired</span>
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
