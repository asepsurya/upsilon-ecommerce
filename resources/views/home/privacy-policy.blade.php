@extends('layouts.home')

@section('title', 'Privacy Policy — Upsilon Store')
@section('description', 'Privacy policy explaining how Upsilon Store collects, uses, and protects your personal information.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    <main class="w-full bg-white text-neutral-900 antialiased">
        <section class="w-full border-b border-neutral-200 bg-gradient-to-b from-neutral-50 to-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h1 class="text-4xl font-extrabold uppercase leading-tight tracking-tight text-neutral-950 sm:text-5xl lg:text-6xl">
                        Privacy Policy
                    </h1>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-neutral-600 sm:text-lg">
                        This policy explains how Upsilon collects, uses, and protects your personal information when you
                        visit our website or place an order.
                    </p>
                </div>
            </div>
        </section>

        <section class="w-full py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl space-y-8 text-sm leading-relaxed text-neutral-600">

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">1. Information We Collect</h2>
                    <p>
                        We collect information you provide directly, such as your name, email address, phone number,
                        delivery address, and order details when you place an order or contact us. We may also collect
                        technical data such as your IP address, browser type, and pages visited.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">2. How We Use Your Information</h2>
                    <p>
                        We use your information to process and fulfill orders, communicate about your order, provide
                        customer support, improve our website and services, and send promotional communications (which
                        you may opt out of at any time).
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">3. Sharing &amp; Disclosure</h2>
                    <p>
                        We do not sell your personal information. We may share information with third parties only as
                        necessary to fulfill your order, such as courier and payment providers, or when required by law.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">4. Data Security</h2>
                    <p>
                        We implement appropriate technical and organizational measures to protect your personal
                        information from unauthorized access, alteration, disclosure, or destruction. However, no method
                        of transmission over the internet is 100% secure.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">5. Cookies</h2>
                    <p>
                        Our website uses cookies to improve functionality, remember your preferences, and analyze
                        traffic. You can control or disable cookies through your browser settings.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">6. Your Rights</h2>
                    <p>
                        You may request access to, correction of, or deletion of your personal data. To exercise these
                        rights, contact us using the details below.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">7. Children's Privacy</h2>
                    <p>
                        Our services are not intended for children under 13. We do not knowingly collect personal
                        information from children under 13.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">8. Changes to This Policy</h2>
                    <p>
                        We may update this Privacy Policy from time to time. Changes are effective when posted on this
                        page. Your continued use constitutes acceptance of the revised policy.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">9. Contact Us</h2>
                    <p>
                        If you have any questions about this Privacy Policy or your personal data, please contact us at
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'hello@upsilon.id' }}"
                           class="text-primary hover:underline">{{ $siteSettings['contact_email'] ?? 'hello@upsilon.id' }}</a>.
                    </p>

                </div>
            </div>
        </section>
    </main>
@endsection
