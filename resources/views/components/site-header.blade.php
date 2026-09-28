@php
    $promoBarItems = [
        ['FREE SHIPPING NATIONWIDE', 'Next day & standard delivery*'],
        ['ASICS GEL-CUMULUS', 'Where comfort pursues us'],
        ['CLICK AND COLLECT', 'Available in web & app'],
        ['NEW ARRIVALS', 'Just landed — fresh picks'],
        ['FLASH SALE', 'Up to 70% off — today only'],
        ['EXCLUSIVE PERKS', 'Early access — join now'],
    ];
@endphp

{{-- Top Utility Bar --}}
<div class="border-b border-gray-200 bg-white px-4 py-1.5 text-[11px] font-medium text-gray-700 lg:px-8">
    <div class="mx-auto flex max-w-7xl items-center justify-between">
        <div class="hidden items-center gap-4 md:flex">
            <a href="#" class="flex items-center gap-1.5 hover:text-black">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
                Download the App
            </a>
            <span class="text-gray-300" aria-hidden="true">|</span>
            <a href="#" class="hover:text-black">Help &amp; Contact</a>
            <span class="text-gray-300" aria-hidden="true">|</span>
            <a href="#" class="hover:text-black">Track Order</a>
        </div>

        <div class="ml-auto flex items-center gap-4">
            <a href="#" class="hidden hover:text-black sm:inline">Store Locator</a>
            <span class="hidden text-gray-300 sm:inline" aria-hidden="true">|</span>
            <button type="button" class="flex items-center gap-1 hover:text-black">
                Deliver To...
                <svg class="ml-0.5 h-3 w-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                </svg>
            </button>
            <span class="text-gray-300" aria-hidden="true">|</span>
            <a href="{{ route('login') }}" class="font-semibold text-black hover:underline">Login</a>
        </div>
    </div>
</div>

{{-- Main Header --}}
<header class="sticky top-0 z-40 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-3.5 lg:px-8">
        <div class="flex items-center justify-between gap-4">

            {{-- Hamburger (mobile) --}}
            <button type="button" id="mobile-menu-btn" class="text-gray-800 md:hidden"
                aria-label="Open navigation menu" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0" aria-label="Upsilon — Home">
                <img src="{{ asset('storage/images/sample/logo-black.png') }}" alt="Upsilon"
                    class="h-8 w-auto object-contain lg:h-9">
            </a>

            {{-- Search (desktop) --}}
            <div class="hidden max-w-xl flex-1 md:block">
                <form action="{{ route('shop') }}" method="GET" class="relative w-full" role="search">
                    <label for="desktop-search" class="sr-only">Search products</label>
                    <input id="desktop-search" type="text" name="search"
                        class="w-full rounded-full border border-transparent bg-[#f4f4f4] py-2 pl-4 pr-10 text-xs placeholder-gray-500 transition focus:border-black focus:bg-white focus:outline-none"
                        placeholder="Search products, categories, or brands">
                    <button type="submit"
                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-black"
                        aria-label="Search">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Ikon cepat --}}
            <div class="flex items-center gap-5">
                {{-- Mobile search --}}
                <button type="button" id="mobile-search-btn" class="text-gray-800 md:hidden"
                    aria-label="Open search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>


                <a href="#" class="hidden text-gray-800 hover:text-black sm:block" aria-label="Notifications">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Mobile search --}}
        <div id="mobile-search" class="hidden border-t border-gray-100 pt-3 md:hidden">
            <form action="{{ route('shop') }}" method="GET" class="relative w-full" role="search">
                <label for="mobile-search-input" class="sr-only">Search products</label>
                <input id="mobile-search-input" type="text" name="search"
                    class="w-full rounded-full border border-transparent bg-[#f4f4f4] py-2 pl-4 pr-10 text-xs placeholder-gray-500 focus:border-black focus:bg-white focus:outline-none"
                    placeholder="Search products, categories, or brands">
                <button type="submit"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-black"
                    aria-label="Search">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Main navigation (desktop) --}}
        <nav class="mt-2.5 hidden items-center justify-center gap-8 border-t border-gray-100 pt-3 text-xs font-bold uppercase tracking-wider text-black md:flex"
            aria-label="Main navigation">
            <a href="{{ route('home') }}" class="transition hover:text-brand-orange">Home</a>
            <a href="{{ route('shop') }}" class="transition hover:text-brand-orange">Shop</a>
            <a href="{{ route('about') }}" class="transition hover:text-brand-orange">About</a>
            <a href="{{ route('contact') }}" class="transition hover:text-brand-orange">Contact</a>
        </nav>

        {{-- Menu mobile --}}
        <div id="mobile-menu" class="hidden border-t border-gray-100 pb-2 pt-3 md:hidden">
            <nav class="flex flex-col gap-1 text-sm font-semibold" aria-label="Mobile navigation">
                <a href="{{ route('home') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Home</a>
                <a href="{{ route('shop') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Shop</a>
                <a href="{{ route('about') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">About</a>
                <a href="{{ route('contact') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Contact</a>
                <a href="{{ route('login') }}"
                    class="mt-1 rounded bg-black px-3 py-2.5 text-center text-white">Login</a>
            </nav>
        </div>
    </div>
</header>

{{-- Mobile nav JS (scoped to this component so it runs on every page) --}}
<script>
(function () {
    var menuBtn    = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            var isHidden = mobileMenu.classList.toggle('hidden');
            menuBtn.setAttribute('aria-expanded', String(!isHidden));
        });
    }

    var searchBtn    = document.getElementById('mobile-search-btn');
    var mobileSearch = document.getElementById('mobile-search');
    if (searchBtn && mobileSearch) {
        searchBtn.addEventListener('click', function () {
            var isHidden = mobileSearch.classList.toggle('hidden');
            searchBtn.setAttribute('aria-expanded', String(!isHidden));
            if (!isHidden) {
                var inp = mobileSearch.querySelector('input');
                if (inp) inp.focus();
            }
        });
    }
})();
</script>

{{-- Promo Bar --}}
<div class="border-y border-yellow-400 bg-brand-yellow font-bold uppercase tracking-tight text-black overflow-hidden"
    role="region" aria-label="Promo berjalan">
    <div class="mx-auto max-w-7xl px-4 py-2 lg:px-8">
        <div class="flex items-center gap-x-4 whitespace-nowrap text-[10px] animate-promo-scroll">
            @foreach ($promoBarItems as $promo)
                <span class="flex items-center gap-1.5 shrink-0">
                    <span>{{ $promo[0] }}</span>
                    <span class="text-[8px] font-medium">—</span>
                    <span>{{ $promo[1] }}</span>
                </span>
                <span class="text-gray-500 shrink-0" aria-hidden="true">|</span>
            @endforeach
            @foreach ($promoBarItems as $promo)
                <span class="flex items-center gap-1.5 shrink-0">
                    <span>{{ $promo[0] }}</span>
                    <span class="text-[8px] font-medium">—</span>
                    <span>{{ $promo[1] }}</span>
                </span>
                <span class="text-gray-500 shrink-0" aria-hidden="true">|</span>
            @endforeach
        </div>
    </div>
</div>
