@extends('layouts.admin')

@section('title', 'Settings')

@section('content')

<div class="q-page-header">
    <div>
        <h2 class="q-page-heading">Settings</h2>
        <p class="q-page-sub">Platform configuration — changes take effect immediately.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="q-panel">
        <div class="q-panel-title">JazzCash</div>

        <div class="q-form-row">
            <div class="q-field">
                <label class="q-label" for="jazzcash_number">JazzCash Number</label>
                <input class="q-input @error('jazzcash_number') is-invalid @enderror"
                       type="text" id="jazzcash_number" name="jazzcash_number"
                       placeholder="03XX-XXXXXXX" required
                       value="{{ old('jazzcash_number', $settings['jazzcash_number'] ?? '') }}">
                @error('jazzcash_number')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="jazzcash_account_name">JazzCash Account Name</label>
                <input class="q-input @error('jazzcash_account_name') is-invalid @enderror"
                       type="text" id="jazzcash_account_name" name="jazzcash_account_name"
                       value="{{ old('jazzcash_account_name', $settings['jazzcash_account_name'] ?? '') }}" required>
                @error('jazzcash_account_name')<span class="q-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="q-panel">
        <div class="q-panel-title">Subscription Plan Prices (PKR)</div>

        @if ($plans->isEmpty())
            <p style="color:var(--q-muted);font-size:.88rem">No plans found. Run the database seeder to create the default plans.</p>
        @else
            <div class="q-form-row" style="grid-template-columns:repeat({{ $plans->count() }},1fr)">
                @foreach ($plans as $plan)
                    <div class="q-field">
                        <label class="q-label" for="plan_price_{{ $plan->id }}">
                            {{ $plan->name }}
                            <span style="font-weight:400;color:var(--q-muted)">({{ $plan->duration_days }} days)</span>
                        </label>
                        <input class="q-input @error('plan_price.' . $plan->id) is-invalid @enderror"
                               type="number" id="plan_price_{{ $plan->id }}"
                               name="plan_price[{{ $plan->id }}]"
                               min="0" step="1" required
                               value="{{ old('plan_price.' . $plan->id, (int) $plan->price) }}">
                        @error('plan_price.' . $plan->id)
                            <span class="q-error">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <button type="submit" class="q-btn q-btn-primary">Save Settings</button>
</form>

@endsection
