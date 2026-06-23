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

    @stack('styles')
</head>
<body class="q-user-body">

<div class="q-user-shell">

    {{-- ── Sidebar ── --}}
    @include('partials.user-nav')

    {{-- ── Main ── --}}
    <div class="q-user-main">

        <header class="q-user-topbar">
            <a href="{{ url('/') }}" class="q-user-topbar-brand">
                ← {{ setting('site_name', config('app.name')) }}
            </a>
            <div style="display:flex;align-items:center;gap:.75rem">
                <span class="q-user-topbar-name">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="q-admin-logout">Sign Out</button>
                </form>
            </div>
        </header>

        <div class="q-user-content">

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

@stack('scripts')
</body>
</html>
