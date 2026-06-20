<div class="header-inner">
    <div class="brand">
        <span class="brand-name">{{ setting('site_name', config('app.name')) }}</span>
        <span class="brand-tag">{{ __('ui.brand_tag') }}</span>
    </div>

    <nav class="nav">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('ui.nav.home') }}</a>
        @auth
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('ui.nav.dashboard') }}</a>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">{{ __('ui.nav.admin') }}</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">{{ __('ui.nav.logout') }}</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">{{ __('ui.nav.login') }}</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">{{ __('ui.nav.register') }}</a>
        @endauth
        <span class="locale-pill" aria-label="{{ __('ui.nav.language') }}">
            <span>{{ __('ui.nav.language') }}:</span>
            <a class="{{ app()->getLocale() === 'en' ? 'active' : '' }}" href="{{ route('locale.switch', 'en') }}">{{ __('ui.nav.english') }}</a>
            <a class="{{ app()->getLocale() === 'ur' ? 'active' : '' }}" href="{{ route('locale.switch', 'ur') }}">{{ __('ui.nav.urdu') }}</a>
        </span>
    </nav>
</div>
