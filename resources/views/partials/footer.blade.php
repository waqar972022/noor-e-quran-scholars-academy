<footer class="q-footer">
    <div class="q-footer-grid" style="grid-template-columns: 1.5fr 1fr 1fr">

        {{-- Col 1: Brand --}}
        <div class="q-footer-col">
            <div class="q-footer-brand">
                <div class="q-footer-mark">ن</div>
                <span class="q-footer-name">{{ setting('site_name', config('app.name')) }}</span>
            </div>
            <p class="q-footer-tagline">
                Authentic Islamic knowledge — anytime, anywhere.
                Digital courses, live 1-on-1 classes, and completion certificates.
            </p>
        </div>

        {{-- Col 2: Learn --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Learn</h4>
            <ul class="q-footer-links">
                <li><a href="{{ route('courses.index') }}">All Courses</a></li>
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

    </div>

    <div class="q-footer-bottom">
        <span>&copy; {{ date('Y') }} {{ setting('site_name', config('app.name')) }}. All Rights Reserved.</span>
        <span class="q-footer-sub">Powered by Faith &amp; Technology</span>
    </div>
</footer>
