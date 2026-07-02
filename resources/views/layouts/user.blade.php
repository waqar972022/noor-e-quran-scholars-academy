<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ setting('site_name', config('app.name')) }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
    .q-user-topbar-right {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: .75rem;
        margin-left: auto;
    }
    @media (max-width: 400px) {
        .q-user-topbar-name { display: none; }
        .q-user-topbar-right { gap: .4rem; }
    }
    .q-user-content-home-link {
        display: inline-block;
        font-size: .82rem;
        color: var(--q-muted);
        text-decoration: none;
        margin-bottom: .85rem;
    }
    .q-user-content-home-link:hover { color: var(--q-green); }
    </style>

    @stack('styles')
</head>
<body class="q-user-body">

<div class="q-user-shell">

    {{-- ── Sidebar ── --}}
    @include('partials.user-nav')

    {{-- ── Main ── --}}
    <div class="q-user-main">

        <header class="q-user-topbar">
            <button class="q-user-hamburger" id="q-user-hamburger" aria-label="Open menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <div class="q-user-topbar-right">
                <span class="q-user-topbar-name">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="q-admin-logout">Sign Out</button>
                </form>
            </div>
        </header>

        <div class="q-user-content">

            <a href="{{ url('/') }}" class="q-user-content-home-link">← Home</a>

            @if (session()->hasAny(['success', 'warning', 'error', 'info']))
                @php
                    $flashType = session('success') ? 'success'
                        : (session('warning') ? 'warning'
                        : (session('error') ? 'error' : 'info'));
                    $flashMsg = session($flashType);
                    $flashColors = [
                        'success' => ['bg' => 'rgba(34,197,94,.12)',  'color' => '#4ade80'],
                        'warning' => ['bg' => 'rgba(245,158,11,.12)', 'color' => '#fbbf24'],
                        'error'   => ['bg' => 'rgba(220,38,38,.12)',  'color' => '#f87171'],
                        'info'    => ['bg' => 'rgba(59,130,246,.12)', 'color' => '#93c5fd'],
                    ];
                @endphp
                <div style="
                    background: {{ $flashColors[$flashType]['bg'] }};
                    color: {{ $flashColors[$flashType]['color'] }};
                    padding: .65rem 1rem;
                    font-size: .88rem;
                    font-weight: 500;
                    border-radius: var(--q-radius);
                    margin-bottom: 1.25rem;
                    border: 1px solid {{ $flashColors[$flashType]['color'] }}33;
                ">
                    {{ $flashMsg }}
                </div>
            @endif

            @yield('content')

        </div>
    </div>

</div>

<script>
(function () {
    var btn  = document.getElementById('q-user-hamburger');
    var menu = document.getElementById('q-user-nav');
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
