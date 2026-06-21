<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ setting('site_name', config('app.name')) }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @stack('styles')
</head>
<body class="q-admin-body">

<div class="q-admin-wrap">

    {{-- ── Sidebar ── --}}
    <aside class="q-admin-sidebar">
        <a class="q-admin-brand" href="{{ route('admin.dashboard') }}">
            <div class="q-navbar-mark" style="width:30px;height:30px;font-size:15px;">ن</div>
            Admin Panel
        </a>

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

            <span class="q-admin-nav-section">Config</span>
            <a href="{{ route('admin.settings') }}"
               class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                Settings
            </a>
        </nav>

        <div class="q-admin-sidebar-foot">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="q-admin-logout">Sign Out</button>
            </form>
        </div>
    </aside>

    {{-- ── Main ── --}}
    <div class="q-admin-main">
        <header class="q-admin-topbar">
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

@stack('scripts')
</body>
</html>
