@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div style="max-width:720px;margin:3rem auto;padding:0 1.5rem 4rem">

    <h1 style="font-family:var(--q-font-serif);font-size:1.9rem;color:var(--q-green);margin-bottom:.4rem">
        Terms of Service
    </h1>
    <p style="font-size:.85rem;color:var(--q-muted);margin-bottom:2.5rem">
        Last updated: {{ date('F Y') }}
    </p>

    <div style="display:flex;flex-direction:column;gap:2rem;font-size:.93rem;line-height:1.8;color:var(--q-ink-2)">

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                1. Acceptance of Terms
            </h2>
            <p>
                By accessing or using the {{ setting('site_name', config('app.name')) }} platform ("the Platform"),
                you agree to be bound by these Terms of Service. If you do not agree, please do not use the Platform.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                2. Use of the Platform
            </h2>
            <p>
                The Platform provides access to Islamic educational content including video lessons, PDF materials,
                and certificates of completion. Access to paid content requires an active subscription purchased
                through the Platform.
            </p>
            <p style="margin-top:.75rem">
                You agree to use the Platform only for lawful purposes and in a manner consistent with Islamic
                values and academic integrity. Sharing account credentials, redistributing course content, or
                circumventing access controls is strictly prohibited.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                3. Subscriptions &amp; Payments
            </h2>
            <p>
                Subscription access is granted upon manual verification of payment by our team. Payments are
                processed offline via bank transfer or mobile wallets. The Platform does not store payment card
                information.
            </p>
            <p style="margin-top:.75rem">
                Subscription periods begin on the date of approval and expire on the stated end date. Renewals
                may be purchased before or after expiry. All prices are stated in Pakistani Rupees (PKR) and
                are inclusive of applicable taxes.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                4. Intellectual Property
            </h2>
            <p>
                All course content, including videos, PDFs, and certificates, is the intellectual property of
                {{ setting('site_name', config('app.name')) }}. You may access content for personal, non-commercial
                study only. Reproduction, redistribution, or resale of any content is not permitted.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                5. Account Responsibilities
            </h2>
            <p>
                You are responsible for maintaining the confidentiality of your account credentials. You must
                notify us immediately if you suspect unauthorised access to your account. The Platform reserves
                the right to suspend or terminate accounts that violate these Terms.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                6. Limitation of Liability
            </h2>
            <p>
                The Platform is provided "as is." We do not guarantee uninterrupted access. To the maximum
                extent permitted by law, {{ setting('site_name', config('app.name')) }} shall not be liable
                for any indirect, incidental, or consequential damages arising from use of the Platform.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                7. Changes to Terms
            </h2>
            <p>
                We may update these Terms from time to time. Continued use of the Platform after changes are
                posted constitutes acceptance of the revised Terms. Material changes will be notified via
                in-platform announcements.
            </p>
        </section>

        <section>
            <h2 style="font-family:var(--q-font-serif);font-size:1.15rem;color:var(--q-ink);margin-bottom:.6rem">
                8. Contact
            </h2>
            <p>
                For questions about these Terms, contact us via WhatsApp at
                {{ setting('whatsapp_number', '+92 300 0000000') }}.
            </p>
        </section>

    </div>
</div>
@endsection
