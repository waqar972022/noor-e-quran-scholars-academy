{{--
    layouts/auth.blade.php
    Used by: login.blade.php, register.blade.php
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
    <title>@yield('title', 'Welcome') — {{ setting('site_name', config('app.name')) }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            background:
                radial-gradient(ellipse at 0% 0%, color-mix(in srgb, var(--q-green) 8%, transparent) 0%, transparent 45%),
                radial-gradient(ellipse at 100% 100%, color-mix(in srgb, var(--q-gold) 7%, transparent) 0%, transparent 45%),
                var(--q-parch);
        }

        /* ── Navbar ─────────────────────────────────────────── */
        .q-navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--q-parch-2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
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

        /* ── Auth shell ─────────────────────────────────────── */
        .auth-shell {
            min-height: calc(100vh - 58px);
            display: grid;
            place-items: center;
            padding: 1.5rem 1rem;
        }

        /* ── Auth panel ─────────────────────────────────────── */
        .auth-panel {
            width: min(940px, 100%);
            background: var(--q-parch-2);
            border: 1.5px solid var(--q-border);
            border-radius: var(--q-radius-xl);
            box-shadow: var(--q-shadow-panel);
            overflow: hidden;
        }

        .auth-grid {
            display: grid;
            grid-template-columns: 1fr;
        }
        @media (min-width: 860px) {
            .auth-grid { grid-template-columns: 1.1fr .9fr; }
            .hero-side {
                border-bottom: none !important;
                border-inline-end: 1.5px solid var(--q-border);
            }
        }

        /* ── Hero side ──────────────────────────────────────── */
        .hero-side {
            padding: 2rem;
            background:
                radial-gradient(ellipse at 20% 80%, color-mix(in srgb, var(--q-green) 8%, transparent) 0%, transparent 55%),
                var(--q-parch-3);
            border-bottom: 1.5px solid var(--q-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.5rem;
        }
        .brand-lockup { display: flex; align-items: center; gap: 12px; }
        .brand-mark {
            width: 46px; height: 46px; border-radius: 12px;
            background: var(--q-green);
            display: grid; place-items: center;
            font-family: var(--q-font-serif);
            font-size: 24px; color: var(--q-parch); font-weight: 700; flex-shrink: 0;
        }
        .brand-copy strong {
            display: block; font-family: var(--q-font-serif);
            font-size: 1.1rem; color: var(--q-ink); line-height: 1.2;
        }
        .brand-copy span { font-size: .78rem; color: var(--q-muted); letter-spacing: .07em; }
        .hero-body { flex: 1; }
        .hero-deco {
            font-family: var(--q-font-serif);
            font-size: clamp(3rem, 10vw, 5.5rem);
            color: color-mix(in srgb, var(--q-green) 9%, transparent);
            line-height: 1; margin-bottom: 1rem;
            direction: rtl; user-select: none;
        }
        .hero-title {
            font-family: var(--q-font-serif);
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            color: var(--q-ink); line-height: 1.25; max-width: 14ch;
        }
        .hero-desc {
            margin-top: .75rem; font-size: .9rem;
            color: var(--q-muted); line-height: 1.8; max-width: 38ch;
        }
        .feature-list { display: flex; flex-wrap: wrap; gap: .5rem; margin-top: 1.25rem; }
        .feature-badge {
            padding: .45rem .85rem; border-radius: 999px;
            border: 1.5px solid var(--q-border);
            background: var(--q-parch-3);
            color: var(--q-ink-2); font-size: .75rem; font-weight: 500;
        }
        .hero-stats {
            display: flex; gap: 1.5rem;
            padding-top: 1.25rem; border-top: 1.5px solid var(--q-border);
        }
        .hero-stat-num {
            font-family: var(--q-font-serif); font-size: 1.4rem;
            color: var(--q-green); font-weight: 700; line-height: 1;
        }
        .hero-stat-label { font-size: .72rem; color: var(--q-muted); letter-spacing: .05em; margin-top: 2px; }

        /* ── Form side ──────────────────────────────────────── */
        .form-side { padding: 2rem; display: flex; align-items: center; justify-content: center; }
        .auth-inner { width: 100%; max-width: 380px; }
        .auth-heading {
            font-family: var(--q-font-serif); font-size: 1.75rem;
            color: var(--q-ink); line-height: 1.2; margin-bottom: .35rem;
        }
        .auth-subheading { font-size: .85rem; color: var(--q-muted); margin-bottom: 1.5rem; line-height: 1.6; }
        .auth-tabs {
            display: flex; background: var(--q-parch-3);
            border-radius: var(--q-radius); padding: 3px; margin-bottom: 1.5rem; gap: 3px;
        }
        .auth-tab {
            flex: 1; padding: 8px; text-align: center; font-size: 13px;
            font-family: var(--q-font-sans); cursor: pointer;
            border-radius: 6px; border: none; background: transparent;
            color: var(--q-muted); transition: all .2s;
        }
        .auth-tab.active {
            background: var(--q-parch); color: var(--q-green);
            font-weight: 600; border: 1px solid var(--q-border);
        }
        .auth-form-panel         { display: none; }
        .auth-form-panel.active  { display: block; }
        .auth-footer-text { text-align: center; font-size: .8rem; color: var(--q-muted); margin-top: 1rem; }
        .auth-footer-text a { color: var(--q-green); font-weight: 500; cursor: pointer; }
    </style>
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
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('courses.index') }}">Courses</a></li>
            <li><a href="{{ route('live-classes') }}">Live Classes</a></li>
            <li><a href="{{ route('pricing') }}">Pricing</a></li>
        </ul>

        <div class="q-navbar-actions">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? '/admin' : '/dashboard' }}"
                   class="q-btn q-btn-outline q-btn-sm">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="q-btn q-btn-ghost q-btn-sm {{ request()->routeIs('login') ? 'active' : '' }}">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="q-btn q-btn-primary q-btn-sm {{ request()->routeIs('register') ? 'active' : '' }}">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    {{-- ── Auth Card ── --}}
    <div class="auth-shell">
        <main class="auth-panel" role="main">
            <div class="auth-grid">

                <div class="hero-side" aria-hidden="true">
                    <div class="brand-lockup">
                        <div class="brand-mark">ن</div>
                        <div class="brand-copy">
                            <strong>{{ setting('site_name', config('app.name')) }}</strong>
                            <span>Islamic Learning Platform</span>
                        </div>
                    </div>

                    @php
                        $heroVideoCount   = \App\Models\CourseVideo::count();
                        $heroPdfCount     = \App\Models\CourseFile::count();
                        $heroVideoDisplay = $heroVideoCount < 10 ? '10+' : $heroVideoCount;
                        $heroPdfDisplay   = $heroPdfCount   < 10 ? '10+' : $heroPdfCount;
                        $heroPlans        = \App\Models\SubscriptionPlan::where('status', 'active')
                                               ->orderBy('sort_order')->get();
                    @endphp

                    <div class="hero-body">
                        <div class="hero-deco">بِسْمِ اللَّهِ</div>
                        <h2 class="hero-title">Authentic Islamic Knowledge — Anytime, Anywhere</h2>
                        <p class="hero-desc">
                            Video lessons, downloadable PDF materials, and live 1-on-1 classes —
                            taught by qualified scholars.
                        </p>
                        <div class="feature-list">
                            <span class="feature-badge">{{ $heroVideoDisplay }} Videos</span>
                            <span class="feature-badge">{{ $heroPdfDisplay }} PDFs</span>
                            <span class="feature-badge">PKR Pricing</span>
                        </div>
                    </div>

                    <div class="hero-stats">
                        @foreach ($heroPlans as $heroPlan)
                            <div>
                                <div class="hero-stat-num" style="font-size:1.1rem">{{ pkr($heroPlan->price) }}</div>
                                <div class="hero-stat-label">{{ $heroPlan->name }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-side">
                    <div class="auth-inner">
                        @yield('content')
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        window.switchAuthTab = function (tab) {
            document.querySelectorAll('.auth-tab').forEach((btn) => {
                btn.classList.toggle('active', btn.dataset.tab === tab);
            });
            document.querySelectorAll('.auth-form-panel').forEach((panel) => {
                panel.classList.toggle('active', panel.dataset.panel === tab);
            });
        };
    </script>

    @stack('scripts')
</body>
</html>
