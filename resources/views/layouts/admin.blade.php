<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ setting('site_name', config('app.name')) }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
    .q-admin-topbar { gap: 1rem; }
    .q-admin-topbar-title {
        flex: 1;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .q-admin-user { flex-shrink: 0; }
    @media (max-width: 768px) {
        .q-admin-topbar { padding: .65rem 1rem; }
    }
    @media (max-width: 480px) {
        .q-admin-topbar-title { font-size: .9rem; }
    }
    </style>

    @stack('styles')
</head>
<body class="q-admin-body">

<div class="q-admin-wrap">

    {{-- ── Sidebar ── --}}
    <aside class="q-admin-sidebar">
        <div class="q-admin-brand-row">
            <a class="q-admin-brand" href="{{ route('admin.dashboard') }}">
                <span style="display:flex;flex-shrink:0;color:var(--q-gold)" aria-hidden="true">@include('partials.logo-icon', ['size' => 22])</span>
                Admin Panel
            </a>
        </div>

        <div class="q-admin-collapsible" id="q-admin-collapsible">
        <nav class="q-admin-nav">
            <span class="q-admin-nav-section">Overview</span>
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <span class="q-admin-nav-section">Content</span>
            <a href="{{ route('admin.categories.index') }}"
               class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                Categories
            </a>
            <a href="{{ route('admin.courses.index') }}"
               class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                Courses
            </a>

            <span class="q-admin-nav-section">Payments</span>
            <a href="{{ route('admin.payments.index') }}"
               class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
               style="display:flex;align-items:center;justify-content:space-between">
                <span>Payment Requests</span>
                @php $pendingCount = \App\Models\PaymentRequest::where('status','pending')->count(); @endphp
                @if ($pendingCount > 0)
                    <span style="background:#dc2626;color:#fff;border-radius:999px;padding:1px 7px;font-size:.68rem;font-weight:700;min-width:18px;text-align:center">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <span class="q-admin-nav-section">Users</span>
            <a href="{{ route('admin.users.index') }}"
               class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                All Users
            </a>

            <span class="q-admin-nav-section">Config</span>
            <a href="{{ route('admin.settings') }}"
               class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                Settings
            </a>
        </nav>

        <div class="q-admin-sidebar-foot">
            <a href="{{ url('/') }}" style="display:block;font-size:.8rem;color:var(--q-muted);text-decoration:none;margin-bottom:.5rem;padding:.4rem 0">← View Site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="q-admin-logout">Sign Out</button>
            </form>
        </div>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="q-admin-main">
        <header class="q-admin-topbar">
            <button class="q-admin-hamburger" id="q-admin-hamburger" aria-label="Open admin menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <span class="q-admin-topbar-title">@yield('title', 'Dashboard')</span>
            <div class="q-admin-user">
                <span>{{ auth()->user()->name }}</span>
                <span class="q-badge q-badge-green">Admin</span>
            </div>
        </header>

        <div class="q-admin-content">
            @if (session('success'))
                <div class="q-alert q-alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="q-alert q-alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</div>

<script>
(function () {
    var btn  = document.getElementById('q-admin-hamburger');
    var menu = document.getElementById('q-admin-collapsible');
    if (!btn || !menu) return;
    btn.addEventListener('click', function () {
        var isOpen = menu.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
})();
</script>
@stack('scripts')
</body>
</html>
