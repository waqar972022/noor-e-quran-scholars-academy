@extends('layouts.app')

@section('title', 'Live 1-on-1 Classes')

@php
    $rawNum   = preg_replace('/[^0-9]/', '', setting('jazzcash_number', ''));
    $waNumber = $rawNum
        ? (str_starts_with($rawNum, '0') ? '92' . substr($rawNum, 1) : $rawNum)
        : '';
    $waUrl    = $waNumber ? 'https://wa.me/' . $waNumber : '#';
@endphp

@push('styles')
<style>
.q-lc-hero {
    background: linear-gradient(135deg, #1B4332 0%, #2D6A4F 100%);
    padding: 3.5rem 1.5rem;
    text-align: center;
    color: var(--q-parch);
}
.q-lc-hero h1 {
    font-family: var(--q-font-serif);
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    margin-bottom: .6rem;
    color: var(--q-parch);
}
.q-lc-hero p {
    font-size: 1rem;
    opacity: .8;
    max-width: 50ch;
    margin: 0 auto 1.5rem;
    line-height: 1.7;
}
.q-lc-badge {
    display: inline-block;
    background: rgba(245,240,228,.15);
    border: 1px solid rgba(245,240,228,.25);
    color: var(--q-parch);
    border-radius: 999px;
    padding: .35rem 1rem;
    font-size: .82rem;
    letter-spacing: .06em;
    margin-bottom: 1.25rem;
}

.q-lc-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 3rem 1.5rem 5rem;
}

/* ── Section headings ───────────────────────────────── */
.q-lc-section { margin-bottom: 3.5rem; }
.q-lc-section-head { margin-bottom: 1.75rem; }

/* ── What We Teach grid ─────────────────────────────── */
.q-teach-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    align-items: stretch;
}
@media (min-width: 700px) {
    .q-teach-grid { grid-template-columns: 1fr 1fr; }
}
.q-teach-card {
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.q-teach-card-header {
    background: var(--q-green);
    color: var(--q-parch);
    padding: .85rem 1.25rem;
    font-family: var(--q-font-serif);
    font-size: 1rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    flex-shrink: 0;
}
.q-teach-card-header .q-lc-urdu {
    font-size: .9rem;
    font-family: 'Noto Nastaliq Urdu', 'Traditional Arabic', serif;
    direction: rtl;
    opacity: .85;
    font-weight: 400;
}
.q-teach-list {
    list-style: none;
    margin: 0;
    padding: .35rem 1.25rem .75rem;
    display: flex;
    flex-direction: column;
    background: var(--q-parch-2);
    flex: 1;
}
.q-teach-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .75rem;
    padding: .42rem 0;
    border-bottom: 1px solid rgba(0,0,0,.06);
    line-height: 1.45;
}
.q-teach-list li:last-child { border-bottom: none; }
.q-teach-en {
    font-size: .82rem;
    color: var(--q-ink-2);
    flex: 1;
}
.q-teach-ur {
    direction: rtl;
    font-family: 'Noto Nastaliq Urdu', 'Traditional Arabic', serif;
    font-size: .95rem;
    color: var(--q-ink);
    text-align: right;
    flex-shrink: 0;
}
.q-teach-list .q-teach-divider {
    display: block;
    border-bottom: none;
    border-top: 1.5px solid var(--q-border);
    margin-top: .4rem;
    padding: .55rem 0 .15rem;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .09em;
    text-transform: uppercase;
    color: var(--q-gold);
}

/* ── Pricing ────────────────────────────────────────── */
.q-pricing-toggle {
    display: flex;
    gap: .5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}
.q-ptab {
    padding: .55rem 1.25rem;
    border-radius: var(--q-radius);
    border: 1.5px solid var(--q-border);
    background: var(--q-parch-2);
    font-size: .88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .18s;
    color: var(--q-ink-2);
}
.q-ptab.active { background: var(--q-green); color: var(--q-parch); border-color: var(--q-green); }

.q-pricing-table-wrap { display: none; }
.q-pricing-table-wrap.active { display: block; }

.q-pricing-table {
    width: 100%;
    border-collapse: collapse;
    border: 1.5px solid var(--q-border);
    border-radius: var(--q-radius-lg);
    overflow: hidden;
}
.q-pricing-table th {
    background: var(--q-green);
    color: var(--q-parch);
    padding: .85rem 1.25rem;
    text-align: left;
    font-size: .82rem;
    font-weight: 600;
    letter-spacing: .04em;
}
.q-pricing-table td {
    padding: .9rem 1.25rem;
    font-size: .92rem;
    color: var(--q-ink-2);
    border-bottom: 1px solid var(--q-border);
    background: var(--q-parch-2);
}
.q-pricing-table tr:last-child td { border-bottom: none; }
.q-pricing-table tr:hover td { background: var(--q-parch-3, #ede8d9); }
.q-pricing-table .q-price-highlight {
    font-weight: 700;
    color: var(--q-green);
    font-size: 1rem;
}
.q-session-note {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-top: 1rem;
    font-size: .83rem;
    color: var(--q-muted);
}

/* ── WhatsApp CTA ───────────────────────────────────── */
.q-wa-cta {
    background: var(--q-green);
    border-radius: var(--q-radius-xl);
    padding: 2.5rem 2rem;
    text-align: center;
    color: var(--q-parch);
}
.q-wa-cta h2 {
    font-family: var(--q-font-serif);
    font-size: 1.5rem;
    margin-bottom: .5rem;
    color: var(--q-parch);
}
.q-wa-cta p { font-size: .9rem; opacity: .78; margin-bottom: 1.4rem; line-height: 1.65; }
.q-btn-wa {
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    background: #25D366;
    color: #fff;
    font-weight: 700;
    border-radius: var(--q-radius);
    padding: .85rem 1.75rem;
    font-size: .97rem;
    transition: background .18s;
}
.q-btn-wa:hover { background: #1ebe57; }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="q-lc-hero">
    <div class="q-lc-badge">Live 1-on-1 Online Classes</div>
    <h1>Learn with a Qualified Scholar — Live</h1>
    <p>Personal online sessions tailored to your level. Children's Islamic education to advanced Dars-e-Nizami. First 3 days free.</p>
    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="q-btn-wa">
        📱 Book a Free Trial on WhatsApp
    </a>
</div>

<div class="q-lc-wrap">

    {{-- ── What We Teach ── --}}
    <div class="q-lc-section">
        <div class="q-lc-section-head">
            <p class="q-eyebrow">Curriculum</p>
            <h2 class="q-section-title">What We Teach</h2>
        </div>

        <div class="q-teach-grid">

            {{-- For Children --}}
            <div class="q-teach-card">
                <div class="q-teach-card-header">
                    <span>For Children</span>
                    <span class="q-lc-urdu">بچوں کے لیے</span>
                </div>
                <ul class="q-teach-list">
                    <li><span class="q-teach-en">Nazira Quran</span><span class="q-teach-ur">ناظرہ قرآن</span></li>
                    <li><span class="q-teach-en">Hifz Quran</span><span class="q-teach-ur">حفظ قرآن</span></li>
                    <li><span class="q-teach-en">Quran Course</span><span class="q-teach-ur">قرآن کورس</span></li>
                    <li><span class="q-teach-en">Hadith Course</span><span class="q-teach-ur">حدیث کورس</span></li>
                    <li><span class="q-teach-en">Duas</span><span class="q-teach-ur">دعائیں</span></li>
                    <li><span class="q-teach-en">Six Kalimas</span><span class="q-teach-ur">چھ کلمات</span></li>
                    <li><span class="q-teach-en">Prayer Essentials</span><span class="q-teach-ur">مسائل نماز</span></li>
                    <li><span class="q-teach-en">Islamic Character</span><span class="q-teach-ur">اخلاقی تربیت</span></li>
                </ul>
            </div>

            {{-- Dars-e-Nizami + Full Programs (these were all in the client's text) --}}
            <div class="q-teach-card">
                <div class="q-teach-card-header">
                    <span>Dars-e-Nizami</span>
                    <span class="q-lc-urdu">درس نظامی</span>
                </div>
                <ul class="q-teach-list">
                    <li><span class="q-teach-en">Arabic Morphology</span><span class="q-teach-ur">علم صرف</span></li>
                    <li><span class="q-teach-en">Arabic Grammar</span><span class="q-teach-ur">علم نحو</span></li>
                    <li><span class="q-teach-en">Text Correction</span><span class="q-teach-ur">تصحیح عبارت</span></li>
                    <li><span class="q-teach-en">Arabic Language</span><span class="q-teach-ur">عربی لینگویج</span></li>
                    <li><span class="q-teach-en">Jurisprudence</span><span class="q-teach-ur">فقہ</span></li>
                    <li><span class="q-teach-en">Islamic Beliefs</span><span class="q-teach-ur">عقائد</span></li>
                    <li><span class="q-teach-en">Principles of Fiqh</span><span class="q-teach-ur">اصول فقہ</span></li>
                    <li><span class="q-teach-en">Islamic Logic</span><span class="q-teach-ur">منطق</span></li>
                    <li><span class="q-teach-en">Rhetoric</span><span class="q-teach-ur">بلاغت</span></li>
                    <li><span class="q-teach-en">Hadith Sciences</span><span class="q-teach-ur">اصول حدیث</span></li>
                    <li><span class="q-teach-en">Tafsir Sciences</span><span class="q-teach-ur">اصول تفسیر</span></li>
                    <li><span class="q-teach-en">Quran Translation</span><span class="q-teach-ur">ترجمہ قرآن</span></li>
                    <li class="q-teach-divider">Full Programs</li>
                    <li><span class="q-teach-en">4-Year Dars-e-Nizami</span><span class="q-teach-ur">چار سالہ درس نظامی</span></li>
                    <li><span class="q-teach-en">2-Year Fiqh Specialisation</span><span class="q-teach-ur">دو سالہ تخصص فی الفقہ</span></li>
                    <li><span class="q-teach-en">2-Year Hadith Specialisation</span><span class="q-teach-ur">دو سالہ تخصص فی الحدیث</span></li>
                </ul>
            </div>

        </div>
    </div>

    {{-- ── Pricing ── --}}
    <div class="q-lc-section">
        <div class="q-lc-section-head">
            <p class="q-eyebrow">Session Fees</p>
            <h2 class="q-section-title">Live Class Pricing</h2>
            <p style="color:var(--q-muted);font-size:.9rem;margin-top:.4rem">30-minute sessions. Contact via WhatsApp to schedule.</p>
        </div>

        <div class="q-pricing-toggle">
            <button class="q-ptab active" onclick="showTab('pkr', this)">🇵🇰 Pakistan (PKR)</button>
            <button class="q-ptab"        onclick="showTab('usd', this)">🌍 International (USD)</button>
        </div>

        <div class="q-pricing-table-wrap active" id="tab-pkr">
            <table class="q-pricing-table">
                <thead>
                    <tr>
                        <th>Days per Week</th>
                        <th>Sessions / Month</th>
                        <th>Monthly Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2 days / week</td>
                        <td>~8 sessions</td>
                        <td class="q-price-highlight">PKR 3,000</td>
                    </tr>
                    <tr>
                        <td>3 days / week</td>
                        <td>~12 sessions</td>
                        <td class="q-price-highlight">PKR 4,000</td>
                    </tr>
                    <tr>
                        <td>4 days / week</td>
                        <td>~16 sessions</td>
                        <td class="q-price-highlight">PKR 5,000</td>
                    </tr>
                    <tr>
                        <td>5 days / week</td>
                        <td>~20 sessions</td>
                        <td class="q-price-highlight">PKR 5,500</td>
                    </tr>
                </tbody>
            </table>
            <p class="q-session-note">⏱ Each session is 30 minutes.</p>
        </div>

        <div class="q-pricing-table-wrap" id="tab-usd">
            <table class="q-pricing-table">
                <thead>
                    <tr>
                        <th>Days per Week</th>
                        <th>Sessions / Month</th>
                        <th>Monthly Fee</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2 days / week</td>
                        <td>~8 sessions</td>
                        <td class="q-price-highlight">$30</td>
                    </tr>
                    <tr>
                        <td>3 days / week</td>
                        <td>~12 sessions</td>
                        <td class="q-price-highlight">$40</td>
                    </tr>
                    <tr>
                        <td>4 days / week</td>
                        <td>~16 sessions</td>
                        <td class="q-price-highlight">$50</td>
                    </tr>
                    <tr>
                        <td>5 days / week</td>
                        <td>~20 sessions</td>
                        <td class="q-price-highlight">$60</td>
                    </tr>
                </tbody>
            </table>
            <p class="q-session-note">⏱ Each session is 30 minutes.</p>
        </div>
    </div>

    {{-- ── WhatsApp CTA ── --}}
    <div class="q-wa-cta">
        <h2>Ready to Start?</h2>
        <p>
            First 3 days are completely free. Message us on WhatsApp to book your trial class
            and discuss your schedule and learning goals.
        </p>
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="q-btn-wa">
            📱 Message on WhatsApp
        </a>
    </div>

</div>

@endsection

@push('scripts')
<script>
function showTab(tab, btn) {
    document.querySelectorAll('.q-pricing-table-wrap').forEach(function(el) {
        el.classList.remove('active');
    });
    document.querySelectorAll('.q-ptab').forEach(function(el) {
        el.classList.remove('active');
    });
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}
</script>
@endpush
