@extends('layouts.home')

@section('title', 'How to Order — Upsilon Store')
@section('description', 'Order on Upsilon via WhatsApp: browse our collection, send us a message, discuss and confirm your order with our team, and get it delivered to your door.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    @php
        $whatsappNumber = preg_replace('/\D+/', '', $siteSettings['whatsapp_number'] ?? '');
        $whatsappLink = $whatsappNumber ? 'https://wa.me/' . $whatsappNumber : null;

        $orderMessage = "Hi Upsilon, I'd like to place an order. Please help me with the details:\n"
            . "- Product:\n- Size / Color:\n- Quantity:\n- Delivery address:";

        $orderLink = $whatsappLink ? $whatsappLink . '?text=' . urlencode($orderMessage) : null;
    @endphp

    <main class="w-full bg-white text-neutral-900 antialiased">
        {{-- Hero --}}
        <section class="w-full border-b border-neutral-200 bg-gradient-to-b from-neutral-50 to-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
                <div class="mx-auto max-w-3xl text-center">
                    <span class="inline-flex items-center gap-2 rounded-full border border-neutral-200 bg-white px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-neutral-700 shadow-sm">
                        <span class="material-symbols-outlined text-base text-[#25D366]">chat</span>
                        Order via WhatsApp
                    </span>
                    <h1 class="mt-5 text-4xl font-extrabold uppercase leading-tight tracking-tight text-neutral-950 sm:text-5xl lg:text-6xl">
                        How to Order
                    </h1>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-neutral-600 sm:text-lg">
                        Ordering on Upsilon is simple and personal. Browse the collection, send us a WhatsApp
                        message with what you want, then discuss and confirm your order directly with our team.
                    </p>

                    @if ($orderLink)
                        <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                            <a href="{{ $orderLink }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] px-7 py-3.5 text-sm font-bold uppercase tracking-widest text-white shadow-lg shadow-[#25D366]/25 transition hover:bg-[#1ebe5d] sm:w-auto">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                                <span>Start Order on WhatsApp</span>
                            </a>
                            <a href="{{ route('shop') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-neutral-300 px-7 py-3.5 text-sm font-bold uppercase tracking-widest text-neutral-900 transition hover:border-neutral-900 sm:w-auto">
                                <span class="material-symbols-outlined text-lg">storefront</span>
                                <span>Browse Products</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Steps --}}
        <section class="w-full py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto mb-12 max-w-2xl text-center">
                    <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Six Simple Steps</span>
                    <h2 class="mt-3 text-3xl font-extrabold uppercase tracking-tight text-neutral-950 sm:text-4xl">
                        From Chat to Checkout
                    </h2>
                    <p class="mt-3 text-sm text-neutral-600 sm:text-base">
                        No complicated forms. A short conversation is all it takes to get your order on its way.
                    </p>
                </div>

                @php
                    $steps = [
                        [
                            'icon' => 'search',
                            'title' => 'Find Your Product',
                            'body' => 'Browse the Shop by category, or search by product name. Open a product page to check the available sizes, colors, and details before you message us.',
                        ],
                        [
                            'icon' => 'chat',
                            'title' => 'Send a WhatsApp Message',
                            'body' => 'Tap the WhatsApp button and tell us what you want: the product, size, color, and quantity. A ready-made message template is provided so you only need to fill in the blanks.',
                        ],
                        [
                            'icon' => 'forum',
                            'title' => 'Discuss Your Order',
                            'body' => 'Our team replies in the same chat to confirm stock, final price, available vouchers, and estimated shipping. Ask anything here — colors, sizing, delivery time, or care instructions.',
                        ],
                        [
                            'icon' => 'location_on',
                            'title' => 'Share Delivery Details',
                            'body' => 'Send the recipient name, active phone number, and complete delivery address with postal code. We will repeat the full order summary back to you for confirmation.',
                        ],
                        [
                            'icon' => 'payments',
                            'title' => 'Complete the Payment',
                            'body' => 'After you confirm the summary, our team will share the payment instructions. Send the payment confirmation in the same chat so we can process your order immediately.',
                        ],
                        [
                            'icon' => 'local_shipping',
                            'title' => 'Track Your Delivery',
                            'body' => 'Once payment is verified, your order is packed and shipped. Delivery updates are shared through the same WhatsApp conversation, and you can also check the status on the Track Order page.',
                        ],
                    ];
                @endphp

                <ol class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($steps as $index => $step)
                        <li class="flex h-full flex-col rounded-2xl border border-neutral-200 bg-white p-7 shadow-sm transition hover:shadow-lg">
                            <div class="flex items-center gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-neutral-950 text-[#25D366]">
                                    <span class="material-symbols-outlined text-2xl">{{ $step['icon'] }}</span>
                                </span>
                                <span class="text-3xl font-black text-neutral-200">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <h3 class="mt-5 text-lg font-bold uppercase tracking-tight text-neutral-950">
                                {{ $step['title'] }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-neutral-600">
                                {{ $step['body'] }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- What to include in your first message --}}
        <section class="w-full border-y border-neutral-200 bg-neutral-50 py-14 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-16">

                    <div>
                        <span class="inline-flex items-center gap-2 rounded-md border border-[#25D366]/30 bg-[#25D366]/10 px-3 py-1 text-xs font-bold uppercase tracking-widest text-[#128C4A]">
                            <span class="material-symbols-outlined text-base">edit_square</span>
                            Message Template
                        </span>
                        <h2 class="mt-4 text-2xl font-extrabold uppercase tracking-tight text-neutral-950 sm:text-3xl">
                            What To Include In Your First Message
                        </h2>
                        <p class="mt-4 text-sm leading-relaxed text-neutral-600">
                            The more detail you send up front, the faster we can confirm your order. Copy the
                            template below and fill in your preferences.
                        </p>

                        <div class="mt-6 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
                            <div class="flex items-center gap-2 border-b border-neutral-100 bg-neutral-100/70 px-4 py-2.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-neutral-300"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-neutral-300"></span>
                                <span class="h-2.5 w-2.5 rounded-full bg-neutral-300"></span>
                                <span class="ml-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-500">
                                    WhatsApp Message
                                </span>
                            </div>
                            <pre class="overflow-x-auto whitespace-pre-wrap px-4 py-4 font-mono text-xs leading-relaxed text-neutral-700"><code>Hi Upsilon, I'd like to place an order.
Please help me with the details:

- Product:
- Size / Color:
- Quantity:
- Delivery address:</code></pre>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold uppercase tracking-tight text-neutral-950">
                            Good To Know Before You Order
                        </h3>
                        <ul class="mt-5 space-y-3">
                            @foreach ([
                                'Stock and final pricing are confirmed by our team before any payment is taken.',
                                'Vouchers apply to your order — just mention the code in your message.',
                                'Product questions, sizing help, and delivery estimates are all discussed in the same chat.',
                                'Keep your payment receipt ready so the order can be processed without delay.',
                            ] as $note)
                                <li class="flex items-start gap-3 rounded-xl border border-neutral-200 bg-white px-4 py-3.5 text-sm font-medium text-neutral-700">
                                    <span class="material-symbols-outlined mt-0.5 text-lg text-emerald-600">check_circle</span>
                                    <span>{{ $note }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6 rounded-xl border border-neutral-200 bg-white p-6">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-neutral-950">
                                Prefer to order through the website?
                            </h4>
                            <p class="mt-2 text-sm leading-relaxed text-neutral-600">
                                You can also add items to your cart and check out directly. If you get stuck at any
                                step, message us on WhatsApp and our team will take it from there.
                            </p>
                            <a href="{{ route('shop') }}"
                                class="mt-4 inline-flex items-center gap-2 bg-neutral-950 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-neutral-800">
                                <span>Go to Shop</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="w-full py-14 lg:py-20">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <h2 class="text-2xl font-extrabold uppercase tracking-tight text-neutral-950 sm:text-3xl">
                    Ready To Place Your Order?
                </h2>
                <p class="mt-3 text-sm text-neutral-600 sm:text-base">
                    Our team is available to help you choose the right product and answer any questions.
                </p>

                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    @if ($orderLink)
                        <a href="{{ $orderLink }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex w-full items-center justify-center gap-2.5 rounded-xl bg-[#25D366] px-7 py-3.5 text-sm font-bold uppercase tracking-widest text-white shadow-lg shadow-[#25D366]/25 transition hover:bg-[#1ebe5d] sm:w-auto">
                            <span class="material-symbols-outlined text-lg">chat</span>
                            <span>Chat on WhatsApp</span>
                        </a>
                    @endif
                    <a href="{{ route('contact') }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-neutral-300 px-7 py-3.5 text-sm font-bold uppercase tracking-widest text-neutral-900 transition hover:border-neutral-900 sm:w-auto">
                        <span class="material-symbols-outlined text-lg">support_agent</span>
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
