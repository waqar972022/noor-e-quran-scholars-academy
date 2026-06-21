{{--
    layouts/app.blade.php
    General-purpose layout for ALL pages (public + logged-in).
    Sticky navbar + @yield('content') + footer.
    No sidebar at the layout level — add sidebar inside @section('content') when needed.
--}}
<!doctype html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — {{ setting('site_name', config('app.name')) }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    {{-- NOTE: do NOT add qalam-theme.css here; app.css already @imports it --}}

    <style>
        body {
            background: var(--q-parch);
        }

        main { display: block; }

        /* ── Urdu / RTL font stack ───────────────────────── */
        :lang(ur),
        [dir="rtl"] .q-navbar-name,
        [dir="rtl"] .q-navbar-links a,
        [dir="rtl"] .q-slide-title,
        [dir="rtl"] .q-slide-desc,
        [dir="rtl"] .q-slide-eyebrow {
            font-family: 'Noto Nastaliq Urdu', 'Urdu Typesetting', 'Traditional Arabic', 'Scheherazade New', serif;
            line-height: 1.9;
        }

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

        /* ── Language toggle ─────────────────────────────── */
        .q-lang-toggle {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            border: 1px solid var(--q-border);
            border-radius: 20px;
            padding: 2px 8px;
            background: transparent;
        }
        .q-lang-toggle a {
            color: var(--q-ink-2);
            text-decoration: none;
            transition: color .2s;
            padding: 1px 3px;
            border-radius: 10px;
        }
        .q-lang-toggle a:hover { color: var(--q-green); }
        .q-lang-toggle a.q-lang-active { color: var(--q-green); font-weight: 700; }
        .q-lang-sep { color: var(--q-border); font-size: 10px; }

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
                <span class="q-navbar-sub">{{ __('ui.nav.brand_tag') }}</span>
            </div>
        </a>

        <ul class="q-navbar-links">
            <li><a href="{{ url('/') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('ui.nav.home') }}</a></li>
            <li><a href="#">{{ __('ui.nav.courses') }}</a></li>
            <li><a href="#">{{ __('ui.nav.library') }}</a></li>
            <li><a href="#">{{ __('ui.nav.pricing') }}</a></li>
        </ul>

        <div class="q-navbar-actions">

            {{-- Language switcher --}}
            <div class="q-lang-toggle" aria-label="{{ __('ui.nav.language') }}">
                <a href="{{ route('locale.switch', 'en') }}"
                   class="{{ app()->getLocale() === 'en' ? 'q-lang-active' : '' }}"
                   aria-label="Switch to English">EN</a>
                <span class="q-lang-sep">|</span>
                <a href="{{ route('locale.switch', 'ur') }}"
                   class="{{ app()->getLocale() === 'ur' ? 'q-lang-active' : '' }}"
                   aria-label="Switch to Urdu">اردو</a>
            </div>

            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                   class="q-btn q-btn-outline q-btn-sm">
                    {{ __('ui.nav.dashboard') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="q-btn q-btn-ghost q-btn-sm">{{ __('ui.nav.sign_out') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="q-btn q-btn-ghost q-btn-sm {{ request()->routeIs('login') ? 'active' : '' }}">
                    {{ __('ui.nav.sign_in') }}
                </a>
                <a href="{{ route('register') }}"
                   class="q-btn q-btn-primary q-btn-sm {{ request()->routeIs('register') ? 'active' : '' }}">
                    {{ __('ui.nav.register') }}
                </a>
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
