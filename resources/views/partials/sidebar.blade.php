@php
    $variant = $variant ?? 'app';

    $links = [];

    if (auth()->check()) {
        $links[] = ['label' => __('ui.nav.dashboard'), 'route' => 'dashboard', 'match' => 'dashboard'];

        if (auth()->user()->role === 'admin') {
            $links[] = ['label' => __('ui.nav.admin'), 'route' => 'admin.dashboard', 'match' => 'admin.*'];
        }

        $links[] = ['label' => __('ui.nav.home'), 'route' => 'home', 'match' => 'home'];
    } else {
        $links[] = ['label' => __('ui.nav.home'), 'route' => 'home', 'match' => 'home'];
        $links[] = ['label' => __('ui.nav.login'), 'route' => 'login', 'match' => 'login'];
        $links[] = ['label' => __('ui.nav.register'), 'route' => 'register', 'match' => 'register'];
    }

    $sidebarNote = $variant === 'auth'
        ? __('ui.auth.login_copy')
        : __('ui.home.subtitle');
@endphp

<aside class="sidebar sidebar--{{ $variant }}">
    <div class="sidebar-brand">
        <div class="brand-mark">Q</div>
        <div class="brand-copy">
            <strong>{{ setting('site_name', config('app.name')) }}</strong>
            <span>{{ __('ui.brand_tag') }}</span>
        </div>
    </div>

    <div class="sidebar-group">
        <span class="sidebar-kicker">{{ __('ui.nav.language') }}</span>
        <p class="sidebar-note">{{ $sidebarNote }}</p>
    </div>

    <nav class="sidebar-nav" aria-label="{{ __('ui.nav.language') }}">
        @foreach ($links as $link)
            <a
                href="{{ route($link['route']) }}"
                class="sidebar-link {{ request()->routeIs($link['match']) ? 'active' : '' }}"
            >
                <span>{{ $link['label'] }}</span>
                <small>&gt;</small>
            </a>
        @endforeach
    </nav>

    <div class="sidebar-footer">
        <div class="locale-pill" aria-label="{{ __('ui.nav.language') }}">
            <span>{{ __('ui.nav.language') }}:</span>
            <a class="{{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('locale.switch', 'en') }}">{{ __('ui.nav.english') }}</a>
            <a class="{{ app()->getLocale() === 'ur' ? 'active' : '' }}" href="{{ route('locale.switch', 'ur') }}">{{ __('ui.nav.urdu') }}</a>
        </div>

        <div class="sidebar-note">
            {{ auth()->check() ? auth()->user()->name : __('ui.auth.login_eyebrow') }}
        </div>
    </div>
</aside>
