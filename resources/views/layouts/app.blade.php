<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — {{ setting('site_name', config('app.name')) }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body { background: var(--q-parch); }
        main { display: block; }

        /* ── Navbar ─────────────────────────────────────────── */
        .q-navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 50;
            background: var(--q-parch);
            border-bottom: 1.5px solid var(--q-border);
            padding: 0 1.5rem;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: background .25s ease, border-color .25s ease, backdrop-filter .25s ease, box-shadow .25s ease;
        }
        .q-navbar.is-scrolled {
            background: color-mix(in srgb, var(--q-parch) 82%, transparent);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: var(--q-shadow-card);
        }
        /* Home hero — navbar floats transparent over the slide's own blurred backdrop */
        body.q-page-home .q-navbar:not(.is-scrolled) {
            background: transparent;
            border-bottom-color: transparent;
        }
        body.q-page-home .q-navbar:not(.is-scrolled) .q-navbar-name,
        body.q-page-home .q-navbar:not(.is-scrolled) .q-navbar-sub,
        body.q-page-home .q-navbar:not(.is-scrolled) .q-navbar-links a {
            color: #fff;
            text-shadow: 0 1px 4px rgba(0,0,0,.7);
        }
        body.q-page-home .q-navbar:not(.is-scrolled) .q-navbar-links a:hover,
        body.q-page-home .q-navbar:not(.is-scrolled) .q-navbar-links a.active {
            color: var(--q-gold-2);
        }
        body.q-page-home .q-navbar:not(.is-scrolled) .q-nav-hamburger span { background: #fff; }
        body.q-page-home .q-navbar:not(.is-scrolled) .q-btn-ghost   { border-color: rgba(255,255,255,.55); color: #fff; }
        body.q-page-home .q-navbar:not(.is-scrolled) .q-btn-outline { border-color: rgba(255,255,255,.85); color: #fff; }
        .q-navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .q-navbar-icon {
            display: flex;
            flex-shrink: 0;
            color: var(--q-gold);
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
        .q-navbar-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

        @media (min-width: 640px) {
            .q-navbar-links { display: flex; }
        }

        /* ── Mobile navbar text fixes ────────────────────────── */
        @media (max-width: 639px) {
            .q-navbar { padding: 0 1rem; gap: .5rem; }
            .q-navbar-name { font-size: .875rem; white-space: nowrap; }
            .q-navbar-actions { display: none; }
        }
        @media (max-width: 400px) {
            .q-navbar-name { font-size: .78rem; }
        }

        /* ── Hamburger button (mobile only) ─────────────────── */
        .q-nav-hamburger {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px 4px;
            flex-shrink: 0;
        }
        .q-nav-hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--q-ink);
            border-radius: 2px;
            transition: transform .2s, opacity .2s;
        }
        @media (min-width: 640px) {
            .q-nav-hamburger { display: none; }
        }

        /* ── Mobile nav drawer ───────────────────────────────── */
        .q-mobile-menu {
            display: none;
            position: fixed;
            top: 58px;
            left: 0; right: 0;
            z-index: 49;
            background: var(--q-parch);
            border-bottom: 1.5px solid var(--q-border);
            padding: .25rem 0 .5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.06);
        }
        .q-mobile-menu.open { display: block; }
        .q-mobile-menu a,
        .q-mobile-menu button {
            display: block;
            width: 100%;
            padding: .75rem 1.5rem;
            color: var(--q-ink-2);
            font-size: .9rem;
            text-decoration: none;
            text-align: right;
            border-top: 1px solid var(--q-border);
            background: none;
            border-left: none;
            border-right: none;
            border-bottom: none;
            cursor: pointer;
            font-family: inherit;
        }
        .q-mobile-menu a:hover,
        .q-mobile-menu button:hover,
        .q-mobile-menu a.active {
            color: var(--q-green);
            background: color-mix(in srgb, var(--q-green) 5%, transparent);
        }
        .q-mobile-menu .q-mob-divider {
            height: 1px;
            background: var(--q-border);
            margin: .25rem 0;
        }
        .q-mobile-menu .q-mob-auth-label {
            padding: .5rem 1.5rem .25rem;
            font-size: .7rem;
            color: var(--q-muted);
            text-align: right;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        @media (min-width: 640px) {
            .q-mobile-menu { display: none !important; }
        }
    </style>

    @stack('styles')
</head>
<body class="{{ request()->routeIs('home') ? 'q-page-home' : '' }}">

    {{-- ── Sticky Navbar ── --}}
    <nav class="q-navbar" role="navigation" aria-label="Main navigation">
        <a class="q-navbar-brand" href="{{ url('/') }}">
            <span class="q-navbar-icon" aria-hidden="true">@include('partials.logo-icon')</span>
            @php $siteNameParts = site_name_parts(); @endphp
            <div>
                <span class="q-navbar-name">{{ $siteNameParts[0] }}</span>
                <span class="q-navbar-sub">{{ $siteNameParts[1] ?? '' }}</span>
            </div>
        </a>

        <ul class="q-navbar-links">
            <li><a href="{{ url('/') }}"                  class="{{ request()->routeIs('home')          ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('videos.index') }}"     class="{{ request()->routeIs('videos.*')      ? 'active' : '' }}">Videos</a></li>
            <li><a href="{{ route('books.index') }}"      class="{{ request()->routeIs('books.*')       ? 'active' : '' }}">Books</a></li>
            <li><a href="{{ route('live-classes') }}"     class="{{ request()->routeIs('live-classes')  ? 'active' : '' }}">Live Classes</a></li>
            <li><a href="{{ route('pricing') }}"          class="{{ request()->routeIs('pricing')       ? 'active' : '' }}">Pricing</a></li>
        </ul>

        <button class="q-nav-hamburger" id="q-hamburger" aria-label="Open navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <div class="q-navbar-actions">
            @auth
                @if (auth()->user()->role !== 'admin')
                    @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                    <a href="{{ route('notifications.index') }}"
                       class="q-btn q-btn-ghost q-btn-sm"
                       style="position:relative;padding-right:{{ $unreadCount > 0 ? '1.6rem' : '.75rem' }}"
                       aria-label="Notifications{{ $unreadCount > 0 ? ' ('.$unreadCount.' unread)' : '' }}">
                        Alerts
                        @if ($unreadCount > 0)
                            <span style="position:absolute;top:3px;right:3px;
                                         background:#dc2626;color:#fff;
                                         border-radius:999px;padding:0 5px;
                                         font-size:.6rem;font-weight:700;line-height:1.5;
                                         min-width:16px;text-align:center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>
                @endif
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

    {{-- ── Mobile nav drawer ── --}}
    <div class="q-mobile-menu" id="q-mobile-menu">
        <a href="{{ url('/') }}"                 class="{{ request()->routeIs('home')         ? 'active' : '' }}">Home</a>
        <a href="{{ route('videos.index') }}"    class="{{ request()->routeIs('videos.*')     ? 'active' : '' }}">Videos</a>
        <a href="{{ route('books.index') }}"     class="{{ request()->routeIs('books.*')      ? 'active' : '' }}">Books</a>
        <a href="{{ route('live-classes') }}"    class="{{ request()->routeIs('live-classes') ? 'active' : '' }}">Live Classes</a>
        <a href="{{ route('pricing') }}"         class="{{ request()->routeIs('pricing')      ? 'active' : '' }}">Pricing</a>
        <div class="q-mob-divider"></div>
        @auth
            @if (auth()->user()->role !== 'admin')
                <a href="{{ route('notifications.index') }}">Alerts</a>
            @endif
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sign Out</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="{{ request()->routeIs('login')    ? 'active' : '' }}">Sign In</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
        @endauth
    </div>

    {{-- Home hero sits under the transparent navbar; every other page needs the offset --}}
    <div style="{{ request()->routeIs('home') ? '' : 'padding-top:58px' }}">

    {{-- ── Flash messages ── --}}
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
            padding: .7rem 1.5rem;
            font-size: .88rem;
            font-weight: 500;
            text-align: center;
            border-bottom: 1px solid var(--q-border);
        ">
            {{ $flashMsg }}
        </div>
    @endif

    {{-- ── Page Content ── --}}
    <main role="main">
        @yield('content')
    </main>

    </div>

    {{-- ── Footer ── --}}
    @include('partials.footer')

    @stack('scripts')
    <script>
    (function () {
        var nav = document.querySelector('.q-navbar');
        if (!nav) return;
        function onScroll() { nav.classList.toggle('is-scrolled', window.scrollY > 8); }
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    })();
    (function () {
        var btn  = document.getElementById('q-hamburger');
        var menu = document.getElementById('q-mobile-menu');
        if (!btn || !menu) return;
        btn.addEventListener('click', function () {
            var open = menu.classList.toggle('open');
            btn.setAttribute('aria-expanded', open);
        });
        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    }());
    </script>
</body>
</html>
