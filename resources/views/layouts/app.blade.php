<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — {{ setting('site_name', config('app.name')) }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body { background: var(--q-parch); }
        main { display: block; }

        /* ── Navbar ─────────────────────────────────────────── */
        .q-navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--q-parch-2);
            border-bottom: 1.5px solid var(--q-border);
            padding: 0 1.5rem;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .q-navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .q-navbar-mark {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--q-green);
            display: grid;
            place-items: center;
            font-family: var(--q-font-serif);
            font-size: 18px;
            color: var(--q-parch);
            font-weight: 700;
            flex-shrink: 0;
        }
        .q-navbar-name {
            font-family: var(--q-font-serif);
            font-size: 1rem;
            color: var(--q-ink);
            font-weight: 700;
            line-height: 1.2;
        }
        .q-navbar-sub {
            display: block;
            font-size: 10px;
            color: var(--q-muted);
            letter-spacing: .07em;
        }
        .q-navbar-links {
            display: none;
            list-style: none;
            gap: 1.5rem;
            align-items: center;
            margin: 0; padding: 0;
        }
        .q-navbar-links a {
            font-size: 13px;
            color: var(--q-ink-2);
            transition: color .2s;
        }
        .q-navbar-links a:hover,
        .q-navbar-links a.active { color: var(--q-green); font-weight: 500; }
        .q-navbar-actions { display: flex; gap: 8px; align-items: center; }

        @media (min-width: 640px) {
            .q-navbar-links { display: flex; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- ── Sticky Navbar ── --}}
    <nav class="q-navbar" role="navigation" aria-label="Main navigation">
        <a class="q-navbar-brand" href="{{ url('/') }}">
            <div class="q-navbar-mark">ن</div>
            <div>
                <span class="q-navbar-name">{{ setting('site_name', config('app.name')) }}</span>
                <span class="q-navbar-sub">Islamic Learning Platform</span>
            </div>
        </a>

        <ul class="q-navbar-links">
            <li><a href="{{ url('/') }}"                  class="{{ request()->routeIs('home')          ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('courses.index') }}"     class="{{ request()->routeIs('courses.*')     ? 'active' : '' }}">Courses</a></li>
            <li><a href="{{ route('live-classes') }}"      class="{{ request()->routeIs('live-classes')  ? 'active' : '' }}">Live Classes</a></li>
            <li><a href="{{ route('pricing') }}"           class="{{ request()->routeIs('pricing')       ? 'active' : '' }}">Pricing</a></li>
        </ul>

        <div class="q-navbar-actions">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                   class="q-btn q-btn-outline q-btn-sm">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="q-btn q-btn-ghost q-btn-sm">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="q-btn q-btn-ghost q-btn-sm {{ request()->routeIs('login') ? 'active' : '' }}">Sign In</a>
                <a href="{{ route('register') }}"
                   class="q-btn q-btn-primary q-btn-sm {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
            @endauth
        </div>
    </nav>

    {{-- ── Page Content ── --}}
    <main role="main">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
