<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? setting('site_name', config('app.name')) }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/qalam-theme.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="shell shell--app">
        @include('partials.sidebar', ['variant' => 'app'])

        <main class="shell-main">
            <div class="content-wrap">
                @yield('content')
            </div>

            <footer class="site-footer">
                @include('partials.footer')
            </footer>
        </main>
    </div>
</body>
</html>
