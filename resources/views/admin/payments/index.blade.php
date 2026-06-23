@extends('layouts.admin')

@section('title', 'Payment Requests')

@section('content')

{{-- Status filter tabs --}}
<div style="display:flex;gap:.5rem;margin-bottom:1.5rem;flex-wrap:wrap;align-items:center">
    @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All'] as $key => $label)
        <a href="{{ route('admin.payments.index', ['status' => $key]) }}"
           class="q-btn q-btn-sm {{ $status === $key ? 'q-btn-primary' : 'q-btn-outline' }}"
           style="display:inline-flex;align-items:center;gap:.4rem">
            {{ $label }}
            <span style="
                background: {{ $status === $key ? 'rgba(245,240,228,.25)' : 'var(--q-parch-2)' }};
                color: {{ $status === $key ? 'var(--q-parch)' : 'var(--q-muted)' }};
                border-radius: 999px;
                padding: 1px 7px;
                font-size: .72rem;
                font-weight: 700;
            ">{{ $counts[$key] }}</span>
        </a>
    @endforeach
</div>

<div class="q-panel">
    @if ($paymentRequests->isEmpty())
        <p style="color:var(--q-muted);font-size:.88rem;padding:.5rem 0">
            No {{ $status === 'all' ? '' : $status }} payment requests.
        </p>
    @else
        <div class="q-table-wrap">
            <table class="q-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Transaction ID</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentRequests as $pr)
                        <tr>
                            <td style="color:var(--q-muted);font-size:.82rem">{{ $pr->id }}</td>
                            <td>
                                <div style="font-weight:500;color:var(--q-ink)">{{ $pr->user->name }}</div>
                                <div style="font-size:.78rem;color:var(--q-muted)">{{ $pr->user->phone }}</div>
                            </td>
                            <td>{{ $pr->plan->name }}</td>
                            <td style="font-weight:700;color:var(--q-green)">
                                PKR {{ number_format($pr->amount, 0) }}
                            </td>
                            <td>
                                <code style="font-size:.82rem;background:var(--q-parch-2);padding:2px 6px;border-radius:4px">
                                    {{ $pr->transaction_id }}
                                </code>
                            </td>
                            <td style="color:var(--q-muted);font-size:.82rem;white-space:nowrap">
                                {{ $pr->created_at->format('d M Y') }}<br>
                                <span style="font-size:.75rem">{{ $pr->created_at->format('H:i') }}</span>
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
                                    Review →
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($paymentRequests->hasPages())
            <div style="margin-top:1.25rem">
                {{ $paymentRequests->links() }}
            </div>
        @endif
    @endif
</div>

@endsection
