@extends('layouts.admin')

@section('title', 'Payment Request #' . $paymentRequest->id)

@push('styles')
<style>
.q-pay-grid {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 1.5rem;
    align-items: start;
}
@media (max-width: 900px) { .q-pay-grid { grid-template-columns: 1fr; } }
.q-detail-row {
    display: flex;
    align-items: baseline;
    gap: .5rem;
    padding: .6rem 0;
    border-bottom: 1px solid var(--q-border);
    font-size: .9rem;
}
.q-detail-row:last-child { border-bottom: none; }
.q-detail-label { color: var(--q-muted); font-size: .78rem; min-width: 130px; flex-shrink: 0; }
.q-detail-value { color: var(--q-ink); font-weight: 500; flex: 1; }
.q-action-panel { border-radius: var(--q-radius-lg); border: 1.5px solid var(--q-border); overflow: hidden; margin-bottom: 1rem; }
.q-action-header { padding: .75rem 1.25rem; font-weight: 700; font-size: .88rem; }
.q-action-body { padding: 1.1rem 1.25rem; }
.q-admin-textarea {
    width: 100%;
    padding: .65rem .85rem;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius);
    background: var(--q-parch);
    font-size: .9rem;
    color: var(--q-ink);
    resize: vertical;
    min-height: 80px;
    box-sizing: border-box;
    font-family: inherit;
    transition: border-color .18s;
}
.q-admin-textarea:focus { outline: none; border-color: var(--q-green); }
</style>
@endpush

@section('content')

<div style="margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem">
    <a href="{{ route('admin.payments.index') }}" class="q-btn q-btn-outline q-btn-sm">← Back to list</a>

    @if ($paymentRequest->status === 'approved')
        <span class="q-badge q-badge-active" style="font-size:.82rem;padding:.35rem .9rem">✓ Approved</span>
    @elseif ($paymentRequest->status === 'rejected')
        <span class="q-badge q-badge-expired" style="font-size:.82rem;padding:.35rem .9rem">✗ Rejected</span>
    @else
        <span class="q-badge q-badge-gold" style="font-size:.82rem;padding:.35rem .9rem">Pending Review</span>
    @endif
</div>

<div class="q-pay-grid">

    {{-- Left column: details + actions --}}
    <div>

        {{-- Request details --}}
        <div class="q-panel" style="margin-bottom:1.25rem">
            <div class="q-panel-title">Request Details</div>
            <div style="margin-top:.5rem">
                <div class="q-detail-row">
                    <span class="q-detail-label">Request ID</span>
                    <span class="q-detail-value">#{{ $paymentRequest->id }}</span>
                </div>
                <div class="q-detail-row">
                    <span class="q-detail-label">Submitted</span>
                    <span class="q-detail-value">{{ $paymentRequest->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="q-detail-row">
                    <span class="q-detail-label">User</span>
                    <span class="q-detail-value">
                        {{ $paymentRequest->user->name }}<br>
                        <span style="font-weight:400;color:var(--q-muted);font-size:.82rem">
                            {{ $paymentRequest->user->email }} · {{ $paymentRequest->user->phone }}
                        </span>
                    </span>
                </div>
                <div class="q-detail-row">
                    <span class="q-detail-label">Plan</span>
                    <span class="q-detail-value">
                        {{ $paymentRequest->plan->name }}
                        <span style="font-weight:400;color:var(--q-muted)">({{ $paymentRequest->plan->duration_days }} days)</span>
                    </span>
                </div>
                <div class="q-detail-row">
                    <span class="q-detail-label">Amount</span>
                    <span class="q-detail-value" style="color:var(--q-green);font-size:1rem">
                        PKR {{ number_format($paymentRequest->amount, 0) }}
                    </span>
                </div>
                <div class="q-detail-row">
                    <span class="q-detail-label">Transaction ID</span>
                    <span class="q-detail-value">
                        <code style="font-size:.88rem;background:var(--q-parch-2);padding:2px 8px;border-radius:4px;letter-spacing:.04em">
                            {{ $paymentRequest->transaction_id }}
                        </code>
                    </span>
                </div>
                @if ($paymentRequest->reviewed_at)
                    <div class="q-detail-row">
                        <span class="q-detail-label">Reviewed by</span>
                        <span class="q-detail-value">
                            {{ $paymentRequest->reviewer?->name ?? '—' }}
                            <span style="font-weight:400;color:var(--q-muted)">
                                · {{ $paymentRequest->reviewed_at->format('d M Y, H:i') }}
                            </span>
                        </span>
                    </div>
                @endif
                @if ($paymentRequest->admin_note)
                    <div class="q-detail-row">
                        <span class="q-detail-label">Rejection reason</span>
                        <span class="q-detail-value" style="color:#f87171">{{ $paymentRequest->admin_note }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Actions (only shown for pending) --}}
        @if ($paymentRequest->status === 'pending')

            <div class="q-action-panel" style="border-top:3px solid var(--q-green)">
                <div class="q-action-header" style="background:rgba(27,67,50,.05);color:var(--q-green)">
                    ✓ Approve Payment
                </div>
                <div class="q-action-body">
                    <p style="font-size:.88rem;color:var(--q-muted);margin-bottom:1rem;line-height:1.6">
                        Verify the transaction ID against your JazzCash history, then approve.
                        This will activate the user's subscription for <strong>{{ $paymentRequest->plan->duration_days }} days</strong>
                        (stacked on any existing subscription).
                    </p>
                    <form method="POST" action="{{ route('admin.payments.approve', $paymentRequest) }}">
                        @csrf
                        <button type="submit"
                                class="q-btn q-btn-primary"
                                onclick="return confirm('Approve this payment and activate the subscription?')">
                            ✓ Approve &amp; Activate Subscription
                        </button>
                    </form>
                </div>
            </div>

            <div class="q-action-panel" style="border-top:3px solid #dc2626;margin-top:.75rem">
                <div class="q-action-header" style="background:rgba(220,38,38,.12);color:#dc2626">
                    ✗ Reject Payment
                </div>
                <div class="q-action-body">
                    <form method="POST" action="{{ route('admin.payments.reject', $paymentRequest) }}">
                        @csrf
                        <div style="margin-bottom:.85rem">
                            <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                                Reason for rejection <span style="color:#dc2626">*</span>
                            </label>
                            <textarea
                                name="admin_note"
                                class="q-admin-textarea"
                                placeholder="e.g. Transaction ID not found in JazzCash records"
                                required
                            >{{ old('admin_note') }}</textarea>
                            @error('admin_note')
                                <span style="font-size:.78rem;color:#f87171;margin-top:.25rem;display:block">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit"
                                class="q-btn q-btn-sm"
                                style="background:#dc2626;color:#fff;border:none"
                                onclick="return confirm('Reject this payment request?')">
                            ✗ Reject Request
                        </button>
                    </form>
                </div>
            </div>

        @elseif ($paymentRequest->status === 'approved')
            <div class="q-panel" style="border-top:3px solid var(--q-green)">
                <div class="q-panel-title" style="color:var(--q-green)">✓ Payment Approved</div>
                <p style="font-size:.88rem;color:var(--q-muted);margin-top:.5rem;line-height:1.6">
                    Approved by <strong>{{ $paymentRequest->reviewer?->name ?? '—' }}</strong>
                    on {{ $paymentRequest->reviewed_at?->format('d M Y, H:i') }}.
                    Subscription activated.
                </p>
            </div>

        @else
            <div class="q-panel" style="border-top:3px solid #dc2626">
                <div class="q-panel-title" style="color:#dc2626">✗ Payment Rejected</div>
                <p style="font-size:.88rem;color:var(--q-muted);margin-top:.5rem;line-height:1.6">
                    Rejected by <strong>{{ $paymentRequest->reviewer?->name ?? '—' }}</strong>
                    on {{ $paymentRequest->reviewed_at?->format('d M Y, H:i') }}.
                </p>
                @if ($paymentRequest->admin_note)
                    <div style="margin-top:.75rem;background:rgba(220,38,38,.12);border-radius:var(--q-radius);padding:.75rem 1rem;font-size:.88rem;color:#f87171">
                        <strong>Reason:</strong> {{ $paymentRequest->admin_note }}
                    </div>
                @endif
            </div>
        @endif

    </div>

    {{-- Right column: screenshot --}}
    <div class="q-panel">
        <div class="q-panel-title">Payment Screenshot</div>
        @if ($paymentRequest->screenshot)
            <a href="{{ asset('payment-screenshots/' . basename($paymentRequest->screenshot)) }}"
               target="_blank" rel="noopener"
               style="display:block;margin-top:.75rem">
                <img
                    src="{{ asset('payment-screenshots/' . basename($paymentRequest->screenshot)) }}"
                    alt="Payment screenshot"
                    style="width:100%;border-radius:var(--q-radius);border:1.5px solid var(--q-border);display:block"
                >
            </a>
            <p style="font-size:.75rem;color:var(--q-muted);margin-top:.5rem;text-align:center">
                Click image to open full size
            </p>
        @else
            <p style="color:var(--q-muted);font-size:.88rem;margin-top:.75rem">No screenshot uploaded.</p>
        @endif
    </div>

</div>

@endsection
