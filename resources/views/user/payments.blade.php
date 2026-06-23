@extends('layouts.user')

@section('title', 'Payment History')

@section('content')

        <div class="q-user-page-head">
            <h1>Payment History</h1>
            <p>All your subscription payment requests and their status.</p>
        </div>

        <div class="q-panel">
            @if ($payments->isEmpty())
                <p style="color:var(--q-muted);font-size:.88rem;padding:.5rem 0">
                    You haven't made any payment requests yet.
                    <a href="{{ route('pricing') }}" style="color:var(--q-green);font-weight:600">View pricing plans</a>
                </p>
            @else
                <div class="q-table-wrap">
                    <table class="q-table">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $pr)
                                <tr>
                                    <td style="font-weight:500">{{ $pr->plan->name }}</td>
                                    <td style="font-weight:700;color:var(--q-green)">{{ pkr($pr->amount) }}</td>
                                    <td>
                                        <code style="font-size:.8rem;background:var(--q-parch-3);padding:2px 7px;border-radius:4px;letter-spacing:.03em">
                                            {{ $pr->transaction_id }}
                                        </code>
                                    </td>
                                    <td style="color:var(--q-muted);font-size:.82rem;white-space:nowrap">
                                        {{ $pr->created_at->format('d M Y') }}<br>
                                        <span style="font-size:.75rem">{{ $pr->created_at->format('h:i A') }}</span>
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
                                    <td style="font-size:.82rem;color:var(--q-muted);max-width:200px">
                                        @if ($pr->status === 'rejected' && $pr->admin_note)
                                            <span style="color:#f87171">{{ $pr->admin_note }}</span>
                                        @elseif ($pr->status === 'approved')
                                            <span style="color:var(--q-green)">Subscription activated</span>
                                        @elseif ($pr->status === 'pending')
                                            Under review
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($payments->hasPages())
                    <div style="margin-top:1.25rem">
                        {{ $payments->links() }}
                    </div>
                @endif
            @endif
        </div>

        <div style="margin-top:1rem;font-size:.82rem;color:var(--q-muted)">
            Pending payments are usually reviewed within 24 hours.
            If you have questions, contact us via WhatsApp.
        </div>

@endsection
