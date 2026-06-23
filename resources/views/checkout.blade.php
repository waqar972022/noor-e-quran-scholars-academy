@extends('layouts.app')

@section('title', 'Checkout — ' . $plan->name)

@push('styles')
<style>
.q-co-wrap {
    max-width: 680px;
    margin: 0 auto;
    padding: 2rem 1.5rem 5rem;
}
.q-co-summary {
    background: var(--q-green);
    color: var(--q-parch);
    border-radius: var(--q-radius-lg);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.q-co-plan-name { font-family: var(--q-font-serif); font-size: 1.1rem; color: var(--q-parch); }
.q-co-plan-sub  { font-size: .82rem; opacity: .75; margin-top: .15rem; }
.q-co-amount    { font-size: 2rem; font-weight: 800; color: var(--q-parch); white-space: nowrap; line-height: 1; }
.q-co-amount-sub { font-size: .72rem; opacity: .65; text-align: right; }

.q-jc-box {
    background: color-mix(in srgb, var(--q-gold) 8%, transparent);
    border: 2px solid var(--q-gold);
    border-radius: var(--q-radius-lg);
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin: 1rem 0;
}
.q-jc-number { font-family: monospace; font-size: 1.35rem; font-weight: 700; color: var(--q-ink); letter-spacing: .06em; }
.q-jc-acct   { font-size: .82rem; color: var(--q-muted); margin-top: .2rem; }
.q-copy-btn  {
    background: var(--q-gold);
    color: #fff;
    border: none;
    border-radius: var(--q-radius);
    padding: .45rem .9rem;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    flex-shrink: 0;
    transition: opacity .15s;
}
.q-copy-btn:hover { opacity: .85; }

.q-how-steps {
    padding-left: 1.3rem;
    display: flex;
    flex-direction: column;
    gap: .6rem;
    font-size: .9rem;
    color: var(--q-ink-2);
    line-height: 1.6;
}
.q-how-steps li::marker { color: var(--q-green); font-weight: 700; }

.q-acct-strip {
    background: var(--q-parch-2);
    border-radius: var(--q-radius);
    padding: .85rem 1rem;
    margin: 1rem 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: .3rem;
}
.q-acct-strip-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--q-muted);
    margin-bottom: .2rem;
}

.q-field { display: flex; flex-direction: column; gap: .35rem; margin-bottom: 1.25rem; }
.q-field label { font-size: .83rem; font-weight: 600; color: var(--q-ink-2); }
.q-field input[type="text"] {
    width: 100%;
    padding: .7rem .9rem;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius);
    background: var(--q-parch);
    font-size: .95rem;
    color: var(--q-ink);
    transition: border-color .18s;
    box-sizing: border-box;
}
.q-field input[type="text"]:focus { outline: none; border-color: var(--q-green); }
.q-field-hint  { font-size: .78rem; color: var(--q-muted); }
.q-field-error { font-size: .78rem; color: #f87171; font-weight: 500; }

.q-upload-zone {
    border: 2px dashed var(--q-border);
    border-radius: var(--q-radius-lg);
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    position: relative;
    overflow: hidden;
}
.q-upload-zone:hover { border-color: var(--q-green); background: rgba(27,67,50,.03); }
.q-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
</style>
@endpush

@section('content')

<div class="q-co-wrap">

    {{-- Breadcrumb --}}
    <nav style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:var(--q-muted);margin-bottom:1.25rem">
        <a href="{{ route('pricing') }}" style="color:var(--q-green)">Pricing</a>
        <span>/</span>
        <span>Checkout</span>
    </nav>

    {{-- Order summary --}}
    <div class="q-co-summary">
        <div>
            <div class="q-co-plan-name">{{ $plan->name }}</div>
            <div class="q-co-plan-sub">{{ $plan->duration_days }}-day access · All courses &amp; content</div>
        </div>
        <div style="text-align:right">
            <div class="q-co-amount">PKR {{ number_format($plan->price, 0) }}</div>
            <div class="q-co-amount-sub">one-time payment</div>
        </div>
    </div>

    {{-- Step 1: Pay --}}
    <div class="q-panel" style="margin-bottom:1.5rem">
        <div class="q-panel-title">Step 1 — Make the JazzCash Payment</div>

        <ol class="q-how-steps" style="margin-top:1rem">
            <li>Open your <strong>JazzCash app</strong> or dial <strong>*786#</strong></li>
            <li>Send exactly <strong>PKR {{ number_format($plan->price, 0) }}</strong> to this number:</li>
        </ol>

        <div class="q-jc-box">
            <div>
                <div class="q-jc-number" id="jcNum">{{ setting('jazzcash_number', '—') }}</div>
                <div class="q-jc-acct">{{ setting('jazzcash_account_name', 'Noor-e-Quran Academy') }}</div>
            </div>
            <button class="q-copy-btn" type="button" onclick="copyJcNumber()">Copy</button>
        </div>

        <ol class="q-how-steps" start="3">
            <li>Take a <strong>screenshot</strong> of the transaction confirmation message</li>
            <li>Come back here and complete Step 2 below</li>
        </ol>
    </div>

    {{-- Step 2: Submit --}}
    <div class="q-panel">
        <div class="q-panel-title">Step 2 — Confirm Your Payment</div>

        {{-- Read-only account info --}}
        <div class="q-acct-strip">
            <span class="q-acct-strip-label">Submitting as</span>
            <span style="font-size:.9rem;font-weight:600;color:var(--q-ink)">{{ auth()->user()->name }}</span>
            <span style="font-size:.82rem;color:var(--q-muted)">{{ auth()->user()->email }}</span>
            <span style="font-size:.82rem;color:var(--q-muted)">{{ auth()->user()->phone }}</span>
        </div>

        <form method="POST" action="{{ route('checkout.store', $plan) }}"
              enctype="multipart/form-data" novalidate>
            @csrf

            {{-- Transaction ID --}}
            <div class="q-field">
                <label for="transaction_id">
                    Transaction ID <span style="color:#f87171" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    id="transaction_id"
                    name="transaction_id"
                    value="{{ old('transaction_id') }}"
                    placeholder="e.g. TXN1234567890"
                    maxlength="100"
                    autocomplete="off"
                    required
                >
                <span class="q-field-hint">The transaction/reference number shown on your JazzCash confirmation</span>
                @error('transaction_id')
                    <span class="q-field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Screenshot upload --}}
            <div class="q-field">
                <label for="screenshot">
                    Payment Screenshot <span style="color:#f87171" aria-hidden="true">*</span>
                </label>
                <div class="q-upload-zone" id="uploadZone">
                    <input
                        type="file"
                        id="screenshot"
                        name="screenshot"
                        accept="image/jpeg,image/png,image/webp"
                        required
                        onchange="handleFileChange(this)"
                    >
                    <div id="uploadDefault">
                        <div style="font-size:2rem;margin-bottom:.5rem">📸</div>
                        <div style="font-size:.88rem;color:var(--q-ink-2)">Tap to upload your JazzCash screenshot</div>
                        <div style="font-size:.75rem;color:var(--q-muted);margin-top:.3rem">JPG, PNG or WebP · Max 5 MB</div>
                    </div>
                    <div id="uploadPreview" style="display:none">
                        <img id="previewImg" src="" alt="Preview"
                             style="max-height:200px;max-width:100%;border-radius:8px;margin-bottom:.5rem">
                        <div id="previewLabel" style="font-size:.78rem;color:var(--q-muted)"></div>
                    </div>
                </div>
                @error('screenshot')
                    <span class="q-field-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="q-btn q-btn-primary q-btn-full" style="margin-top:.25rem">
                Submit Payment Request
            </button>

            <p style="font-size:.78rem;color:var(--q-muted);text-align:center;margin-top:.85rem;line-height:1.65">
                Admin will verify your payment and activate your access within 24 hours.
                You will be notified on your dashboard.
            </p>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
function copyJcNumber() {
    var num = document.getElementById('jcNum').textContent.trim();
    navigator.clipboard.writeText(num).then(function () {
        var btn = document.querySelector('.q-copy-btn');
        btn.textContent = 'Copied!';
        setTimeout(function () { btn.textContent = 'Copy'; }, 2000);
    });
}

function handleFileChange(input) {
    if (!input.files || !input.files[0]) return;
    var file = input.files[0];
    var mb = (file.size / 1024 / 1024).toFixed(2);
    var reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('uploadDefault').style.display = 'none';
        document.getElementById('uploadPreview').style.display = 'block';
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewLabel').textContent = file.name + ' (' + mb + ' MB)';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
