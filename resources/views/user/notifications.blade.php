@extends('layouts.user')

@section('title', 'Notifications')

@section('content')

        <div class="q-user-page-head" style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:.75rem">
            <div>
                <h1>Notifications</h1>
                <p>Your activity updates and account alerts.</p>
            </div>
            @if ($notifications->isNotEmpty())
                <form method="POST" action="{{ route('notifications.markAllRead') }}">
                    @csrf
                    <button type="submit" class="q-btn q-btn-outline q-btn-sm">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @if ($notifications->isEmpty())
            <div class="q-panel" style="text-align:center;padding:2.5rem 1.5rem;color:var(--q-muted)">
                No notifications yet.
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:.5rem">
                @foreach ($notifications as $n)
                    @php
                        $data   = $n->data;
                        $type   = $data['type'] ?? '';
                        $isRead = ! is_null($n->read_at);

                        $iconMap = [
                            'payment_submitted'       => ['&#x25A0;', 'var(--q-green)'],
                            'payment_approved'        => ['&#x2713;', 'var(--q-green)'],
                            'payment_rejected'        => ['&#x2717;', '#f87171'],
                            'subscription_expiring_soon' => ['&#x25B2;', '#fbbf24'],
                            'subscription_expired'    => ['&#x25BC;', '#f87171'],
                            'certificate_issued'      => ['&#x2605;', 'var(--q-gold)'],
                        ];
                        [$icon, $iconColor] = $iconMap[$type] ?? ['&#x25CB;', 'var(--q-muted)'];
                    @endphp
                    <div class="q-panel"
                         style="padding:.9rem 1.1rem;{{ $isRead ? 'opacity:.75' : 'border-left:3px solid var(--q-green)' }}">
                        <div style="display:flex;gap:.85rem;align-items:flex-start">
                            <div style="flex-shrink:0;width:28px;height:28px;border-radius:50%;
                                        background:{{ $isRead ? 'var(--q-parch-3)' : 'var(--q-parch-2)' }};
                                        display:grid;place-items:center;
                                        font-size:.7rem;color:{{ $iconColor }};font-weight:700">
                                {!! $icon !!}
                            </div>
                            <div style="flex:1">
                                <div style="font-size:.875rem;color:var(--q-ink);line-height:1.55;{{ $isRead ? '' : 'font-weight:500' }}">
                                    {{ $data['message'] ?? '' }}
                                </div>

                                {{-- Extra detail lines per type --}}
                                @if ($type === 'payment_rejected' && ! empty($data['reason']))
                                    <div style="margin-top:.35rem;font-size:.8rem;color:#f87171;padding:.4rem .7rem;background:rgba(220,38,38,.06);border-radius:var(--q-radius)">
                                        Reason: {{ $data['reason'] }}
                                    </div>
                                @endif
                                @if (in_array($type, ['subscription_expiring_soon', 'subscription_expired']))
                                    <div style="margin-top:.5rem">
                                        <a href="{{ route('pricing') }}"
                                           class="q-btn q-btn-sm q-btn-primary">
                                            Renew Subscription
                                        </a>
                                    </div>
                                @endif
                                @if ($type === 'payment_approved' && ! empty($data['end_date']))
                                    <div style="margin-top:.35rem;font-size:.8rem;color:var(--q-muted)">
                                        Plan: {{ $data['plan'] ?? '' }}
                                        &nbsp;&middot;&nbsp;
                                        Active until {{ \Carbon\Carbon::parse($data['end_date'])->format('d M Y') }}
                                    </div>
                                @endif

                                <div style="margin-top:.4rem;font-size:.72rem;color:var(--q-muted)">
                                    {{ $n->created_at->diffForHumans() }}
                                    @if ($isRead)
                                        &nbsp;&middot;&nbsp; Read
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($notifications->hasPages())
                <div style="margin-top:1.25rem">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif

@endsection
