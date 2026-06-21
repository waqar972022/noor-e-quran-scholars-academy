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
                       placeholder="03XX-XXXXXXX"
                       value="{{ old('jazzcash_number', $settings['jazzcash_number'] ?? '') }}">
                @error('jazzcash_number')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="jazzcash_account_name">JazzCash Account Name</label>
                <input class="q-input @error('jazzcash_account_name') is-invalid @enderror"
                       type="text" id="jazzcash_account_name" name="jazzcash_account_name"
                       value="{{ old('jazzcash_account_name', $settings['jazzcash_account_name'] ?? '') }}">
                @error('jazzcash_account_name')<span class="q-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="q-panel">
        <div class="q-panel-title">Subscription Plan Prices (PKR)</div>

        <div class="q-form-row" style="grid-template-columns:1fr 1fr 1fr">
            <div class="q-field">
                <label class="q-label" for="basic_plan_price">Basic Plan</label>
                <input class="q-input @error('basic_plan_price') is-invalid @enderror"
                       type="number" id="basic_plan_price" name="basic_plan_price" min="0" step="1"
                       value="{{ old('basic_plan_price', $settings['basic_plan_price'] ?? '') }}">
                @error('basic_plan_price')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="standard_plan_price">Standard Plan</label>
                <input class="q-input @error('standard_plan_price') is-invalid @enderror"
                       type="number" id="standard_plan_price" name="standard_plan_price" min="0" step="1"
                       value="{{ old('standard_plan_price', $settings['standard_plan_price'] ?? '') }}">
                @error('standard_plan_price')<span class="q-error">{{ $message }}</span>@enderror
            </div>
            <div class="q-field">
                <label class="q-label" for="premium_plan_price">Premium Plan</label>
                <input class="q-input @error('premium_plan_price') is-invalid @enderror"
                       type="number" id="premium_plan_price" name="premium_plan_price" min="0" step="1"
                       value="{{ old('premium_plan_price', $settings['premium_plan_price'] ?? '') }}">
                @error('premium_plan_price')<span class="q-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <button type="submit" class="q-btn q-btn-primary">Save Settings</button>
</form>

@endsection
