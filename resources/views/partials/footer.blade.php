<footer class="q-footer">
    <div class="q-footer-grid">

        {{-- Col 1: Brand --}}
        <div class="q-footer-col">
            <div class="q-footer-brand">
                <div class="q-footer-mark">ق</div>
                <span class="q-footer-name">{{ setting('site_name', config('app.name')) }}</span>
            </div>
            <p class="q-footer-tagline">
                Authentic Islamic knowledge — anytime, anywhere.
                Courses, library, and certificates taught by qualified scholars.
            </p>
        </div>

        {{-- Col 2: Courses --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Courses</h4>
            <ul class="q-footer-links">
                <li><a href="#">Quran Recitation</a></li>
                <li><a href="#">Islamic Jurisprudence</a></li>
                <li><a href="#">Arabic Language</a></li>
                <li><a href="#">Hadith Studies</a></li>
                <li><a href="#">Seerah</a></li>
            </ul>
        </div>

        {{-- Col 3: Library --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Library</h4>
            <ul class="q-footer-links">
                <li><a href="#">Classical Texts</a></li>
                <li><a href="#">Tafseer</a></li>
                <li><a href="#">Fiqh Books</a></li>
                <li><a href="#">Seerah Books</a></li>
                <li><a href="#">Browse All Books</a></li>
            </ul>
        </div>

        {{-- Col 4: Contact --}}
        <div class="q-footer-col">
            <h4 class="q-footer-heading">Quick Links</h4>
            <ul class="q-footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Pricing &amp; Plans</a></li>
                <li><a href="#">Certificates</a></li>
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
