<aside class="q-user-sidebar">
    <div class="q-user-sidebar-head">
        <div class="q-user-avatar">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="q-user-name">{{ auth()->user()->name }}</div>
        <div class="q-user-email">{{ auth()->user()->email }}</div>
    </div>
    <nav class="q-user-nav" aria-label="User navigation">
        <a href="{{ route('dashboard') }}"
           class="q-user-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('user.learning') }}"
           class="q-user-nav-link {{ request()->routeIs('user.learning') ? 'active' : '' }}">
            My Learning
        </a>
        <a href="{{ route('user.subscription') }}"
           class="q-user-nav-link {{ request()->routeIs('user.subscription') ? 'active' : '' }}">
            Subscription
        </a>
        <a href="{{ route('user.payments') }}"
           class="q-user-nav-link {{ request()->routeIs('user.payments') ? 'active' : '' }}">
            Payment History
        </a>
        <a href="{{ route('notifications.index') }}"
           class="q-user-nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
           style="display:flex;justify-content:space-between;align-items:center">
            <span>Notifications</span>
            @php $navUnread = auth()->user()->unreadNotifications()->count(); @endphp
            @if ($navUnread > 0)
                <span style="background:#dc2626;color:#fff;border-radius:999px;padding:0 6px;font-size:.65rem;font-weight:700;line-height:1.6">
                    {{ $navUnread > 9 ? '9+' : $navUnread }}
                </span>
            @endif
        </a>
<a href="{{ route('profile.edit') }}"
           class="q-user-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            Profile
        </a>
    </nav>
</aside>
