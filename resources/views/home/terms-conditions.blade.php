@extends('layouts.home')

@section('title', 'Terms &amp; Conditions — Upsilon Store')
@section('description', 'Terms and conditions governing the use of Upsilon Store and purchase of products.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    <main class="w-full bg-white text-neutral-900 antialiased">
        <section class="w-full border-b border-neutral-200 bg-gradient-to-b from-neutral-50 to-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <h1 class="text-4xl font-extrabold uppercase leading-tight tracking-tight text-neutral-950 sm:text-5xl lg:text-6xl">
                        Terms &amp; Conditions
                    </h1>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-neutral-600 sm:text-lg">
                        Please read these terms carefully before using our website or placing an order with Upsilon.
                    </p>
                </div>
            </div>
        </section>

        <section class="w-full py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl space-y-8 text-sm leading-relaxed text-neutral-600">

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">1. Acceptance of Terms</h2>
                    <p>
                        By accessing or using the Upsilon website and placing an order, you agree to be bound by these
                        Terms &amp; Conditions. If you do not agree, please do not use our services.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">2. Orders</h2>
                    <p>
                        All orders are subject to availability and confirmation by our team. We reserve the right to
                        accept or decline any order at our sole discretion. Prices are displayed in Indonesian Rupiah
                        (IDR) and include any applicable tax unless stated otherwise.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">3. Payment</h2>
                    <p>
                        Payment must be completed before your order is processed. We accept payment via bank transfer
                        and other methods communicated during checkout. Once payment is confirmed, your order will be
                        packed and shipped.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">4. Shipping &amp; Delivery</h2>
                    <p>
                        We ship nationwide. Delivery times vary by location and courier. Delivery estimates are shared
                        after your order is confirmed and are not guaranteed. Upsilon is not liable for delays caused by
                        the courier or force majeure.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">5. Returns &amp; Exchanges</h2>
                    <p>
                        All sales are final unless the item received is damaged, defective, or incorrect. Please
                        contact us within 2 days of receiving your order with photos of the issue to request a return
                        or exchange.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">6. User Conduct</h2>
                    <p>
                        You agree not to misuse our website, including any unlawful, fraudulent, or harmful activity.
                        We may suspend or terminate access at our discretion.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">7. Limitation of Liability</h2>
                    <p>
                        Upsilon is not liable for any indirect, incidental, or consequential damages arising out of or
                        in connection with your use of the website or purchase of products.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">8. Changes to These Terms</h2>
                    <p>
                        We may update these Terms &amp; Conditions from time to time. Changes are effective when posted
                        on this page. Your continued use constitutes acceptance of the revised terms.
                    </p>

                    <h2 class="text-xl font-bold uppercase tracking-tight text-neutral-950">9. Contact Us</h2>
                    <p>
                        If you have any questions about these terms, please contact us at
                        <a href="mailto:{{ $siteSettings['contact_email'] ?? 'hello@upsilon.id' }}"
                           class="text-primary hover:underline">{{ $siteSettings['contact_email'] ?? 'hello@upsilon.id' }}</a>.
                    </p>

                </div>
            </div>
        </section>
    </main>
@endsection
