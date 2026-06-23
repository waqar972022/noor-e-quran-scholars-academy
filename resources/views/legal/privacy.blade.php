@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div style="max-width:720px;margin:3rem auto;padding:0 1.5rem 4rem">

    <h1 style="font-family:var(--q-font-serif);font-size:1.9rem;color:var(--q-green);margin-bottom:.4rem">
        Privacy Policy
    </h1>
    <p style="font-size:.85rem;color:var(--q-muted);margin-bottom:2.5rem">
        Last updated: {{ date('F Y') }}
    </p>

    <div style="display:flex;flex-direction:column;gap:2rem;font-size:.93rem;line-height:1.8;color:var(--q-ink-2)">

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                1. Information We Collect
            </h2>
            <p>
                When you register on {{ setting('site_name', config('app.name')) }}, we collect your name,
                email address, and phone number. When you submit a payment request, we store your transaction
                ID and a screenshot of the payment proof you upload.
            </p>
            <p style="margin-top:.75rem">
                We automatically collect basic technical information (IP address, browser type, pages visited)
                through server logs to maintain platform security and performance.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                2. How We Use Your Information
            </h2>
            <p>We use your information to:</p>
            <ul style="margin-top:.5rem;padding-left:1.5rem;display:flex;flex-direction:column;gap:.35rem">
                <li>Create and manage your account</li>
                <li>Verify subscription payments and grant course access</li>
                <li>Send account-related notifications (subscription status, payment updates)</li>
                <li>Respond to support enquiries via WhatsApp</li>
                <li>Maintain platform security and prevent fraud</li>
            </ul>
            <p style="margin-top:.75rem">
                We do not sell, rent, or share your personal information with third parties for marketing purposes.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                3. Data Storage &amp; Security
            </h2>
            <p>
                Your data is stored on servers located in accordance with our hosting provider's terms.
                Payment screenshots are stored in a private, non-publicly-accessible location and are only
                accessible to authorised administrators for verification purposes.
            </p>
            <p style="margin-top:.75rem">
                We implement appropriate technical and organisational measures to protect your data against
                unauthorised access, alteration, disclosure, or destruction.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                4. Cookies
            </h2>
            <p>
                We use essential session cookies to keep you logged in. We do not use tracking or advertising
                cookies. No third-party analytics scripts are loaded on this platform.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                5. Your Rights
            </h2>
            <p>
                You may update your name and phone number at any time via your Profile page. To request
                deletion of your account and associated data, contact us via WhatsApp. We will process
                deletion requests within 14 days subject to any legal retention requirements.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                6. Children's Privacy
            </h2>
            <p>
                The Platform is not directed at children under the age of 13. We do not knowingly collect
                personal information from children. If you believe a child has registered without parental
                consent, please contact us to have the account removed.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                7. Changes to This Policy
            </h2>
            <p>
                We may update this Privacy Policy periodically. Significant changes will be communicated
                through in-platform notifications. Continued use of the Platform after changes are posted
                constitutes acceptance.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                8. Contact
            </h2>
            <p>
                For privacy-related questions or data requests, contact us via WhatsApp at
                {{ setting('whatsapp_number', '+92 300 0000000') }}.
            </p>
        </section>

    </div>
</div>
@endsection
