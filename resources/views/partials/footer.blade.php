<footer class="q-footer">
    <div class="q-footer-grid">

        {{-- Col 1: Brand --}}
        <div class="q-footer-col">
            <div class="q-footer-brand">
                <div class="q-footer-mark" style="background:transparent;color:var(--q-gold)">@include('partials.logo-icon', ['size' => 26])</div>
                <span class="q-footer-name">{{ setting('site_name', config('app.name')) }}</span>
            </div>
            <p class="q-footer-tagline">
                Authentic Islamic knowledge — anytime, anywhere.
                Digital courses and live 1-on-1 classes with verified scholars.
            </p>
        </div>

        {{-- Col 2: Learn --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Learn</h4>
            <ul class="q-footer-links">
                <li><a href="{{ route('videos.index') }}">Videos</a></li>
                <li><a href="{{ route('books.index') }}">Books</a></li>
                <li><a href="{{ route('live-classes') }}">Live 1-on-1 Classes</a></li>
                <li><a href="{{ route('pricing') }}">Pricing &amp; Plans</a></li>
            </ul>
        </div>

        {{-- Col 3: Account --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Account</h4>
            <ul class="q-footer-links">
                <li><a href="{{ route('login') }}">Sign In</a></li>
                <li><a href="{{ route('register') }}">Register Free</a></li>
            </ul>
        </div>

        {{-- Col 4: Legal --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Legal</h4>
            <ul class="q-footer-links">
                <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
            </ul>
        </div>

    </div>

    <div class="q-footer-bottom">
        <span>&copy; {{ date('Y') }} {{ setting('site_name', config('app.name')) }}. All Rights Reserved.</span>
        <span class="q-footer-sub">Powered by Faith &amp; Technology</span>
    </div>
</footer>
