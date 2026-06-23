@extends('layouts.user')

@section('title', 'Profile')

@section('content')

        <div class="q-user-page-head">
            <h1>Profile</h1>
            <p>Update your account details and password.</p>
        </div>

        {{-- ── Account Details ── --}}
        <div class="q-panel" style="margin-bottom:1.5rem">
            <div class="q-panel-title" style="margin-bottom:1.1rem">Account Details</div>

            @if (session('success') && ! session('password_success'))
                <div style="background:rgba(34,197,94,.12);color:#4ade80;padding:.65rem 1rem;border-radius:var(--q-radius);font-size:.88rem;margin-bottom:1rem">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="q-form-2col">
                    {{-- Name --}}
                    <div>
                        <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                            Full Name <span style="color:#dc2626">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="q-input"
                            style="width:100%"
                            required
                            maxlength="100"
                        >
                        @error('name')
                            <span style="font-size:.78rem;color:#f87171;display:block;margin-top:.25rem">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                            Phone / WhatsApp <span style="color:#dc2626">*</span>
                        </label>
                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="q-input"
                            style="width:100%"
                            required
                            maxlength="20"
                        >
                        @error('phone')
                            <span style="font-size:.78rem;color:#f87171;display:block;margin-top:.25rem">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Email (read-only) --}}
                <div style="margin-bottom:1.25rem">
                    <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                        Email Address
                    </label>
                    <input
                        type="email"
                        value="{{ $user->email }}"
                        class="q-input"
                        style="width:100%;opacity:.65;cursor:not-allowed"
                        disabled
                    >
                    <span style="font-size:.75rem;color:var(--q-muted);margin-top:.25rem;display:block">
                        Email cannot be changed. Contact support if needed.
                    </span>
                </div>

                <button type="submit" class="q-btn q-btn-primary">Save Changes</button>
            </form>
        </div>

        {{-- ── Change Password ── --}}
        <div class="q-panel">
            <div class="q-panel-title" style="margin-bottom:1.1rem">Change Password</div>

            @if (session('success') && str_contains(session('success'), 'Password'))
                <div style="background:rgba(34,197,94,.12);color:#4ade80;padding:.65rem 1rem;border-radius:var(--q-radius);font-size:.88rem;margin-bottom:1rem">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                {{-- Current password --}}
                <div style="margin-bottom:1rem">
                    <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                        Current Password <span style="color:#dc2626">*</span>
                    </label>
                    <input
                        type="password"
                        name="current_password"
                        class="q-input"
                        style="width:100%;max-width:400px"
                        required
                        autocomplete="current-password"
                    >
                    @error('current_password')
                        <span style="font-size:.78rem;color:#f87171;display:block;margin-top:.25rem">{{ $message }}</span>
                    @enderror
                </div>

                <div class="q-form-2col" style="margin-bottom:1.25rem">
                    {{-- New password --}}
                    <div>
                        <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                            New Password <span style="color:#dc2626">*</span>
                        </label>
                        <input
                            type="password"
                            name="password"
                            class="q-input"
                            style="width:100%"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        @error('password')
                            <span style="font-size:.78rem;color:#f87171;display:block;margin-top:.25rem">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm password --}}
                    <div>
                        <label style="display:block;font-size:.83rem;font-weight:600;color:var(--q-ink-2);margin-bottom:.4rem">
                            Confirm New Password <span style="color:#dc2626">*</span>
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="q-input"
                            style="width:100%"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <button type="submit" class="q-btn q-btn-primary">Update Password</button>
            </form>
        </div>

@endsection
