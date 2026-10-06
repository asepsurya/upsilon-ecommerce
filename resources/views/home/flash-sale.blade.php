@extends('layouts.home')

@section('title', 'Flash Sale — Upsilon Store')
@section('description', 'Shop limited-time flash sale deals at Upsilon. Grab discounted products before the countdown hits zero.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    @php
        $waNumber = preg_replace('/\D+/', '', $siteSettings['whatsapp_number'] ?? '');
        $waLink = $waNumber
            ? 'https://wa.me/' . $waNumber . '?text=' . urlencode("Hi Upsilon, I'd like to order from the Flash Sale page.")
            : null;
    @endphp

    <main class="w-full bg-[#2A2E33] text-white antialiased">
        {{-- Header + countdown --}}
        <section class="border-b border-gray-700">
            <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8 lg:py-14">
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="flex items-center gap-2 text-xs font-semibold text-gray-400">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li aria-hidden="true" class="material-symbols-outlined text-sm">chevron_right</li>
                        <li class="text-white" aria-current="page">Flash Sale</li>
                    </ol>
                </nav>

                @if ($flashSale)
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <h1 class="text-3xl font-condensed font-extrabold tracking-wide text-[#FF5000] md:text-5xl">
                                {{ $flashSale->title }}
                            </h1>
                            @if ($flashSale->description)
                                <p class="mt-3 max-w-2xl text-sm text-gray-300 sm:text-base">
                                    {{ $flashSale->description }}
                                </p>
                            @endif
                        </div>

                        <div class="shrink-0">
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-300" data-countdown
                                role="timer" aria-label="Time remaining">
                                <span>{{ $flashSale->subtitle ?? 'Ends in' }}</span>
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold tabular-nums" data-h>20</span>
                                <span aria-hidden="true">:</span>
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold tabular-nums" data-m>01</span>
                                <span aria-hidden="true">:</span>
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold tabular-nums" data-s>41</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <h1 class="text-3xl font-condensed font-extrabold tracking-wide text-[#FF5000] md:text-5xl">
                            Flash Sale
                        </h1>
                        <p class="mt-3 max-w-2xl text-sm text-gray-300 sm:text-base">
                            There is no flash sale running right now. Stay tuned — new deals launch regularly.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Products --}}
        <section class="py-10 lg:py-14">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">

                @if ($products && $products->isNotEmpty())
                    <div class="mb-6 flex items-center justify-between border-b border-gray-700 pb-3">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">
                            {{ $products->total() }} {{ Str::plural('Product', $products->total()) }} on sale
                        </p>
                        @if ($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#25D366] px-4 py-2 text-[11px] font-bold uppercase tracking-widest text-white transition hover:bg-[#1ebe5d]">
                                <span class="material-symbols-outlined text-base">chat</span>
                                <span>Order via WhatsApp</span>
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <div class="mt-10 flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="rounded-2xl border border-gray-700 bg-[#23272B] px-6 py-16 text-center">
                        <span class="material-symbols-outlined text-5xl text-gray-600">bolt</span>
                        <h2 class="mt-4 text-xl font-bold uppercase tracking-tight text-white">No Deals Available</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-400">
                            This flash sale has ended or has not started yet. Browse the full collection to find
                            something you like.
                        </p>
                        <div class="mt-7 flex flex-col items-center justify-center gap-3 sm:flex-row">
                            <a href="{{ route('shop') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#FF5000] px-6 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:bg-[#E04400] sm:w-auto">
                                <span class="material-symbols-outlined text-lg">storefront</span>
                                <span>Browse The Shop</span>
                            </a>
                            <a href="{{ route('how.to.order') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-gray-600 px-6 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:border-white sm:w-auto">
                                <span class="material-symbols-outlined text-lg">info</span>
                                <span>How To Order</span>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            (function () {
                var countdown = document.querySelector('[data-countdown]');

                if (countdown) {
                    var now = Math.floor(Date.now() / 1000);
                    var remaining = {{ (int) $flashSaleDeadline }} - now;

                    var elH = countdown.querySelector('[data-h]');
                    var elM = countdown.querySelector('[data-m]');
                    var elS = countdown.querySelector('[data-s]');

                    function renderCountdown() {
                        if (remaining < 0) remaining = 0;
                        var h = String(Math.floor(remaining / 3600)).padStart(2, '0');
                        var m = String(Math.floor((remaining % 3600) / 60)).padStart(2, '0');
                        var s = String(remaining % 60).padStart(2, '0');
                        if (elH) elH.textContent = h;
                        if (elM) elM.textContent = m;
                        if (elS) elS.textContent = s;
                    }

                    renderCountdown();
                    setInterval(function () {
                        if (remaining > 0) {
                            remaining -= 1;
                            renderCountdown();
                        }
                    }, 1000);
                }
            })();
        </script>
    @endpush
@endsection
