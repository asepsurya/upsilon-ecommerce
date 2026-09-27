<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    <title>JD Sports | King of Trainers</title>
    <meta name="description"
        content="Sneakers, clothing, and accessories from Nike, adidas, New Balance, Puma, and more. Free shipping nationwide.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="JD Sports | King of Trainers">
    <meta property="og:description" content="Sneakers & streetwear. Free shipping nationwide.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('storage/images/jd-sports/hero-banner.jpg') }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        jd: {
                            yellow: '#F5E400',
                            orange: '#FF5000',
                            darkorange: '#E04400',
                            black: '#111111',
                            dark: '#1A1A1A',
                            cardbg: '#252525'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Oswald', 'sans-serif'],
                        impact: ['Anton', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #111111;
            background-color: #FFFFFF;
            overflow-x: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        .font-condensed {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .font-impact {
            font-family: 'Anton', sans-serif;
        }

        @keyframes promo-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-promo-scroll {
            animation: promo-scroll 35s linear infinite;
        }

        .animate-promo-scroll:hover {
            animation-play-state: paused;
        }
    </style>
</head>

<body class="antialiased selection:bg-black selection:text-white">

    @php
        /* ============================================================================
           PERSIAPAN DATA HALAMAN
           ----------------------------------------------------------------------------
            Preparing data + fallback so the page always looks clean even
            when the database is empty. For production, the take/slice logic
            should ideally be moved to HomeController (see example at the
            bottom of this document).
           ============================================================================ */

        // --- 0. Fallback helper harga (hapus bila helpers.php sudah terdaftar) ---
        if (!function_exists('currency')) {
            function currency($amount)
            {
                return '$' . number_format((float) $amount, 2, '.', ',');
            }
        }

        // --- 1. Produk unggulan dibagi per section ---
        $limitedPairs = $featuredProducts->take(5);           // section "Limited Pairs Only"
        $topPicks = $featuredProducts->slice(5)->take(4); // section "Our Top Picks"

        // --- 2. Fallback products (dummy) when database is empty ---
        $fallbackProducts = collect([
            ['name' => 'Nike Air Max AP', 'image' => 'product-nike-airmax.jpg', 'brand' => 'Nike', 'base_price' => 1909000, 'sale_price' => 1336000],
            ['name' => "Nike Vomero 5 Women's", 'image' => 'product-nike-vomero.jpg', 'brand' => 'Nike', 'base_price' => 2489000, 'sale_price' => 1742000],
            ['name' => 'New Balance 1000', 'image' => 'product-newbalance-1000.jpg', 'brand' => 'New Balance', 'base_price' => 2599000, 'sale_price' => 1559000],
            ['name' => 'adidas Adizero Evo SL', 'image' => 'product-adidas-adizero.jpg', 'brand' => 'adidas', 'base_price' => 2500000, 'sale_price' => 1750000],
            ['name' => 'On Cloudtilt', 'image' => 'product-on-running.jpg', 'brand' => 'On', 'base_price' => 2800000, 'sale_price' => 1960000],
            ['name' => 'Nike Mind 001 Slides', 'image' => 'product-nike-mind-slides.jpg', 'brand' => 'Nike', 'base_price' => 1199000, 'sale_price' => null],
            ['name' => 'adidas Essentials T-Shirt', 'image' => 'product-adidas-tshirt.jpg', 'brand' => 'adidas', 'base_price' => 550000, 'sale_price' => null],
            ['name' => 'Nike Mind 001 Slides', 'image' => 'product-nike-mind-blue.jpg', 'brand' => 'Nike', 'base_price' => 1199000, 'sale_price' => null],
            ['name' => 'Nike Heritage Backpack', 'image' => 'product-nike-backpack.jpg', 'brand' => 'Nike', 'base_price' => 499000, 'sale_price' => null],
        ])->map(function ($p) {
            return (object) array_merge($p, [
                'image_url' => asset('storage/images/jd-sports/' . $p['image']),
                'permalink' => route('shop'),
            ]);
        });

        $limitedPairsList = $limitedPairs->isNotEmpty() ? $limitedPairs : $fallbackProducts->take(5);
        $topPicksList = $topPicks->isNotEmpty() ? $topPicks : $fallbackProducts->slice(5)->take(4);

        // --- 3. Kategori fallback ---
        $fallbackCategories = collect([
            ['name' => 'Men', 'image' => 'category-mens.jpg'],
            ['name' => 'Women', 'image' => 'category-womens.jpg'],
            ['name' => 'Kids', 'image' => 'category-kids.jpg'],
        ])->map(function ($c) {
            return (object) [
                'name' => $c['name'],
                'image_url' => asset('storage/images/jd-sports/' . $c['image']),
                'product_count' => 0,
            ];
        });

        $categoriesList = $categories->isNotEmpty() ? $categories : $fallbackCategories;

        // --- 4. Slider fallback ---
        $sliderList = $sliders->isNotEmpty() ? $sliders : collect([
            (object) ['image_url' => asset('storage/images/jd-sports/hero-banner.jpg')],
        ]);

        // --- 5. Artikel fallback (editorial) ---
        $fallbackArticles = collect([
            [
                'title' => 'adidas Originals x JENNIE: A Collection Every Fan Must See',
                'excerpt' => 'JENNIE\'s first collaboration with adidas Originals is finally here! From Superstar with a ballet twist to effortless apparel.',
                'image' => 'article-1.jpg'
            ],
            [
                'title' => 'New Drop, Instant Crush: adidas Originals ANFU',
                'excerpt' => 'New mood, new kicks! adidas Originals ANFU brings a versatile retro Mary Jane touch for your daily OOTD.',
                'image' => 'article-2.jpg'
            ],
            [
                'title' => 'Cute Meets Classic: Meet the PUMA Tacklette',
                'excerpt' => 'Meet your new sneaker crush, PUMA Tacklette! Classic terrace style meets playful Mary Jane touches, chic and stylish.',
                'image' => 'article-3.jpg'
            ],
        ])->map(function ($a) {
            return (object) [
                'title' => $a['title'],
                'excerpt' => $a['excerpt'],
                'image_url' => asset('storage/images/jd-sports/' . $a['image']),
                'permalink' => '#',
            ];
        });

        // Normalisasi artikel: dukung Model Eloquent maupun array asosiatif
        $articlesList = collect($articles ?? [])->map(function ($a) {
            if (is_object($a) && method_exists($a, 'toArray')) {
                $a = $a->toArray();
            }
            return (object) (array) $a;
        });

        if ($articlesList->isEmpty()) {
            $articlesList = $fallbackArticles;
        }

        // --- 6. Data section statis ---
        $brandOffers = [
            ['brand' => 'NIKE', 'slug' => 'nike', 'discount' => 50],
            ['brand' => 'ADIDAS', 'slug' => 'adidas', 'discount' => 50],
            ['brand' => 'NEW BALANCE', 'slug' => 'new-balance', 'discount' => 50],
            ['brand' => 'PUMA', 'slug' => 'puma', 'discount' => 50],
        ];

        $featuredBrands = [
            ['name' => 'Nike', 'slug' => 'nike', 'image' => 'brand-nike.jpg'],
            ['name' => 'adidas', 'slug' => 'adidas', 'image' => 'brand-adidas.jpg'],
            ['name' => 'On', 'slug' => 'on', 'image' => 'brand-on.jpg'],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'image' => 'brand-newbalance.jpg'],
        ];
    @endphp

    {{-- Skip link untuk aksesibilitas --}}
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:z-[60] focus:bg-black focus:px-4 focus:py-2 focus:text-white">
        Skip to main content
    </a>

    {{-- ============================================================
    1. TOP UTILITY BAR
    ============================================================ --}}
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

    {{-- ============================================================
    2. HEADER UTAMA
    ============================================================ --}}
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
                <a href="{{ route('home') }}" class="shrink-0" aria-label="JD Sports — Home">
                    <img src="{{ asset('storage/images/sample/logo-black.png') }}" alt="JD Sports"
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

                    {{-- Wishlist --}}
                    <a href="{{ route('wishlist') }}" class="relative text-gray-800 hover:text-black"
                        aria-label="Wishlist ({{ $wishlistItemCount ?? 0 }} item)">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" />
                        </svg>
                        @if (($wishlistItemCount ?? 0) > 0)
                            <span
                                class="absolute -top-1.5 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-black text-[9px] font-bold text-white">{{ $wishlistItemCount }}</span>
                        @endif
                    </a>

                    {{-- Cart --}}
                    <a href="{{ route('cart') }}" class="relative text-gray-800 hover:text-black"
                        aria-label="Shopping cart ({{ $cartItemCount ?? 0 }} item)">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="1.8" />
                        </svg>
                        @if (($cartItemCount ?? 0) > 0)
                            <span
                                class="absolute -top-1.5 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-black text-[9px] font-bold text-white">{{ $cartItemCount }}</span>
                        @endif
                    </a>

                    {{-- Notifications --}}
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
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Main navigation (desktop) --}}
            <nav class="mt-2.5 hidden items-center justify-center gap-8 border-t border-gray-100 pt-3 text-xs font-bold uppercase tracking-wider text-black md:flex"
                aria-label="Main navigation">
                <a href="{{ route('home') }}" class="transition hover:text-jd-orange">Home</a>
                <a href="{{ route('shop') }}" class="transition hover:text-jd-orange">Shop</a>
                <a href="{{ route('about') }}" class="transition hover:text-jd-orange">About</a>
                <a href="{{ route('contact') }}" class="transition hover:text-jd-orange">Contact</a>
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

    {{-- ============================================================
    3. PROMO BAR (SCROLLER)
    ============================================================ --}}
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

    <div class="border-y border-yellow-400 bg-jd-yellow font-bold uppercase tracking-tight text-black overflow-hidden"
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

    <main id="main-content">

        {{-- ============================================================
        4. HERO CAROUSEL
        ============================================================ --}}
        <section class="relative w-full overflow-hidden bg-black" aria-label="Main banner">
            <div id="hero-slider" class="relative aspect-[21/9] max-h-[700px] min-h-[440px] w-full">

                @foreach ($sliderList as $index => $slider)
                    <div class="hero-slide absolute inset-0 h-full w-full transition-all duration-1000 ease-in-out {{ $index === 0 ? 'z-10 opacity-100 scale-100' : 'opacity-0 scale-105' }}"
                        data-index="{{ $index }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                        <img src="{{ $slider->image_url }}" alt="{{ $slider->title ?? 'Featured promotion' }}"
                            class="h-full w-full object-cover object-center">
                    </div>
                @endforeach

                {{-- Panah --}}
                <button type="button" id="hero-prev"
                    class="absolute left-4 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/40 text-white transition hover:bg-black/70"
                    aria-label="Previous slide">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
                <button type="button" id="hero-next"
                    class="absolute right-4 top-1/2 z-20 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/40 text-white transition hover:bg-black/70"
                    aria-label="Next slide">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>

                {{-- Dot indicators (generated by JavaScript) --}}
                <div id="hero-dots"
                    class="absolute bottom-20 left-0 right-0 z-20 flex items-center justify-center gap-2 md:bottom-10">
                </div>

                {{-- CTA buttons --}}
                <div
                    class="absolute bottom-6 right-6 z-20 flex flex-wrap items-center justify-end gap-3 md:bottom-10 md:right-12">
                    {{-- Adjust 'gender' parameter to match your controller filter --}}
                    <a href="{{ route('shop', ['gender' => 'men']) }}"
                        class="bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">Shop
                        Men's</a>
                    <a href="{{ route('shop', ['gender' => 'women']) }}"
                        class="bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">Shop
                        Women's</a>
                    <a href="{{ route('shop', ['gender' => 'kids']) }}"
                        class="bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">Shop
                        Kids'</a>
                </div>
            </div>
        </section>

        {{-- ============================================================
        5. LIMITED PAIRS + COUNTDOWN
        ============================================================ --}}
        <section class="bg-[#2A2E33] py-8 text-white" aria-labelledby="limited-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">

                {{-- Header + countdown --}}
                <div class="mb-6 flex flex-wrap items-center justify-between gap-2 border-b border-gray-700 pb-2">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <h2 id="limited-heading"
                            class="text-2xl font-condensed font-extrabold tracking-wide text-[#FF5000] md:text-3xl">
                            Limited Pairs Only
                        </h2>
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-300" data-countdown
                            role="timer" aria-label="Time remaining">
                            <span>Ends in</span>
                            <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums"
                                data-h>20</span>
                            <span aria-hidden="true">:</span>
                            <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums"
                                data-m>01</span>
                            <span aria-hidden="true">:</span>
                            <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums"
                                data-s>41</span>
                        </div>
                    </div>
                    <a href="{{ route('shop') }}"
                        class="text-xs font-semibold text-gray-300 underline hover:text-white">View all</a>
                </div>

                {{-- Produk + banner FINAL CALL --}}
                <div class="grid grid-cols-2 gap-3 md:grid-cols-6">
                    <div
                        class="col-span-2 flex flex-col items-center justify-center border border-gray-700 bg-gradient-to-b from-[#2E3339] to-[#1E2125] p-4 text-center md:col-span-1">
                        <h3 class="font-impact text-3xl leading-none tracking-wider text-white md:text-4xl">
                            FINAL<br><span class="text-gray-400">CALL</span>
                        </h3>
                        <p class="mt-2 text-[10px] font-semibold uppercase tracking-widest text-gray-400">Special
                            Pricing</p>
                    </div>

                    @foreach ($limitedPairsList as $product)
                        <x-product-card :product="$product" show-stock />
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        6. SHOP THE OFFERS
        ============================================================ --}}
        <section class="bg-[#F25C19] py-8 text-white" aria-labelledby="offers-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="offers-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">Shop
                        The Offers</h2>
                    <a href="{{ route('shop') }}"
                        class="text-xs font-bold uppercase tracking-wider hover:underline">Shop All</a>
                </div>

                {{-- Tile diskon per merek --}}
                <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($brandOffers as $offer)
                        {{-- Adjust 'brand' parameter to match your controller filter --}}
                        <a href="{{ route('shop', ['brand' => $offer['slug']]) }}"
                            class="flex aspect-[4/3] items-center justify-center rounded-sm border border-gray-600 bg-[#3b434a] p-4 text-center transition hover:scale-[1.02]">
                            <span>
                                <span
                                    class="block font-impact text-2xl tracking-wider text-orange-500 md:text-4xl">{{ $offer['brand'] }}</span>
                                <span
                                    class="mt-1 block font-impact text-2xl leading-none tracking-wide text-white md:text-3xl">
                                    UP TO {{ $offer['discount'] }}% OFF
                                </span>
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Banner New Balance 530 --}}
                <div class="flex flex-wrap items-center justify-between gap-4 rounded bg-white p-4 text-black">
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                        <span class="font-impact text-xl tracking-wider">JD EXCLUSIVE</span>
                        <h3 class="font-impact text-2xl tracking-tight md:text-3xl">NEW BALANCE 530</h3>
                    </div>
                    <a href="{{ route('shop') }}"
                        class="bg-black px-6 py-2 font-condensed text-xs font-bold tracking-wider text-white transition hover:bg-gray-800">
                        Shop Now
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================================
        7. SHOP BY CATEGORY
        ============================================================ --}}
        <section class="bg-[#F25C19] pb-12 pt-4 text-white" aria-labelledby="categories-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <h2 id="categories-heading" class="mb-6 text-2xl font-condensed font-black tracking-wide md:text-3xl">
                    Shop by Category
                </h2>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach ($categoriesList as $category)
                        @php
                            $categoryUrl = isset($category->id)
                                ? route('shop.category', $category->slug)
                                : route('shop');
                        @endphp
                        <div class="flex flex-col">
                            <a href="{{ $categoryUrl }}" class="group block">
                                <div class="relative aspect-[3/4] w-full overflow-hidden rounded shadow-lg">
                                    <img src="{{ $category->image_url }}" alt="Category {{ $category->name }}" loading="lazy"
                                        class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 flex items-end justify-center bg-gradient-to-t from-black/80 via-transparent to-transparent pb-8">
                                        <h3 class="font-impact text-3xl tracking-wider text-white md:text-4xl">
                                            SHOP {{ strtoupper($category->name) }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        8. OUR TOP PICKS
        ============================================================ --}}
        <section class="bg-[#F25C19] pb-10 text-white" aria-labelledby="top-picks-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <h2 id="top-picks-heading" class="mb-4 text-2xl font-condensed font-black tracking-wide md:text-3xl">
                    Our Top Picks
                </h2>

                {{-- Category tabs (functional links, adjust the parameters) --}}
                <div class="mb-6 flex flex-wrap items-center gap-2">
                    <a href="{{ route('shop', ['gender' => 'men']) }}"
                        class="rounded-sm bg-black px-4 py-2 text-xs font-bold text-white transition hover:bg-gray-900">Shop
                        Men's</a>
                    <a href="{{ route('shop', ['gender' => 'women']) }}"
                        class="rounded-sm border border-white/50 px-4 py-2 text-xs font-bold text-white transition hover:bg-white/10">Shop
                        Women's</a>
                    <a href="{{ route('shop', ['gender' => 'kids']) }}"
                        class="rounded-sm border border-white/50 px-4 py-2 text-xs font-bold text-white transition hover:bg-white/10">Shop
                        Kids'</a>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($topPicksList as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        9. SEASONAL SPOTLIGHT BANNERS
        ============================================================ --}}
        <section class="bg-black py-4" aria-label="Seasonal promotions">
            <div class="mx-auto max-w-7xl space-y-4 px-4 lg:px-8">

                {{-- Promo tas adidas --}}
                <div class="flex flex-wrap items-center justify-between gap-4 rounded bg-[#1C3545] p-4 text-white">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-bold leading-none"><span class="text-white/70">///</span> JD</span>
                        <h3 class="font-condensed text-lg font-bold tracking-wider md:text-xl">
                            Complimentary adidas Adicolor Classic Bag
                        </h3>
                    </div>
                    <a href="{{ route('shop') }}"
                        class="bg-white px-6 py-1.5 font-condensed text-xs font-bold tracking-wider text-black transition hover:bg-gray-100">
                        Shop Now
                    </a>
                </div>

                {{-- Banner Salomon --}}
                <a href="{{ route('shop') }}" class="block overflow-hidden rounded">
                    <img src="{{ asset('storage/images/jd-sports/banner-salomon.jpg') }}"
                        alt="Salomon for urban expeditions" loading="lazy"
                        class="h-auto w-full object-cover transition duration-500 hover:scale-[1.02]">
                </a>

                {{-- Dua promo produk --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @foreach ([
                            ['title' => 'Asics Gel-Kayano 14', 'image' => 'product-asics-kayano.jpg'],
                            ['title' => 'adidas Originals by JENNIE', 'image' => 'product-adidas-jennie.jpg'],
                        ] as $promo)
                        <a href="{{ route('shop') }}" class="group overflow-hidden rounded bg-gray-900">
                            <img src="{{ asset('storage/images/jd-sports/' . $promo['image']) }}"
                                alt="{{ $promo['title'] }}" loading="lazy"
                                class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="flex items-center justify-between bg-black p-3 text-white">
                                <span class="text-xs font-bold uppercase tracking-wider">{{ $promo['title'] }}</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" />
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        10. THE BRANDS YOU LOVE
        ============================================================ --}}
        <section class="bg-[#F25C19] py-8 text-white" aria-labelledby="brands-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="brands-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        The Brands You Love
                    </h2>
                    <a href="{{ route('shop') }}"
                        class="text-xs font-bold uppercase tracking-wider hover:underline">View All</a>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($featuredBrands as $brand)
                        {{-- Adjust 'brand' parameter to match your controller filter --}}
                        <a href="{{ route('shop', ['brand' => $brand['slug']]) }}" class="group block">
                            <div class="relative aspect-square w-full overflow-hidden rounded shadow">
                                <img src="{{ asset('storage/images/jd-sports/' . $brand['image']) }}"
                                    alt="{{ $brand['name'] }} Collection" loading="lazy"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                <div
                                    class="absolute bottom-3 left-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/80 text-black backdrop-blur-sm">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="mt-2 text-xs font-bold uppercase tracking-wider">{{ $brand['name'] }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        11. DISCOVER JD STYLE (EDITORIAL)
        ============================================================ --}}
        <section class="bg-[#F25C19] pb-12 text-white" aria-labelledby="editorial-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="editorial-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Discover JD Style
                    </h2>
                    <a href="#" class="text-xs font-bold uppercase tracking-wider hover:underline">View All</a>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    @foreach ($articlesList as $article)
                        @php
                            // Adjust attribute names (image/permalink) to match your data structure
                            $articleImage = $article->image_url
                                ?? ($article->image ?: null)
                                ?? asset('storage/images/jd-sports/article-1.jpg');
                            $articleUrl = $article->permalink ?? '#';
                        @endphp
                        <article class="flex flex-col justify-between overflow-hidden rounded bg-white text-black shadow">
                            <a href="{{ $articleUrl }}" class="block aspect-square w-full overflow-hidden">
                                <img src="{{ $articleImage }}" alt="{{ $article->title }}" loading="lazy"
                                    class="h-full w-full object-cover transition duration-300 hover:scale-105">
                            </a>
                            <div class="p-3">
                                <h3 class="text-xs font-bold leading-snug line-clamp-2">{{ $article->title }}</h3>
                                <p class="mt-1.5 text-[11px] leading-relaxed text-gray-600 line-clamp-3">
                                    {{ $article->excerpt }}</p>
                                <a href="{{ $articleUrl }}"
                                    class="mt-2 inline-flex items-center gap-1 text-[11px] font-bold uppercase hover:underline">
                                    Read More <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    @endforeach

                    {{-- Kartu spesial (gradient) melengkapi grid bila artikel < 4 --}} @if ($articlesList->count() < 4)
                        <a href="#"
                            class="flex aspect-square items-center justify-center rounded bg-gradient-to-br from-red-600 to-indigo-900 p-4 text-center shadow transition hover:scale-[1.02]">
                            <div class="text-white">
                                <span class="block font-impact text-xl tracking-wider md:text-2xl">SPECIAL</span>
                                <span class="mt-1 block font-impact text-2xl tracking-wide md:text-3xl">WORLD CUP FINAL
                                    </span>
                                <span
                                    class="mt-3 block text-[11px] font-semibold uppercase tracking-widest text-white/80">
                                    Read Full Editorial &rarr;
                                </span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
        </section>

        {{-- ============================================================
        12. NEWSLETTER
        ============================================================ --}}
        <section class="bg-black py-12 text-white" aria-labelledby="newsletter-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="flex flex-col items-center text-center">
                    <h2 id="newsletter-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Get Release Info &amp; Exclusive Promos
                    </h2>
                    <p class="mt-2 max-w-xl text-sm text-gray-400">
                        Sign up for the JD Sports newsletter and be the first to know about the latest sneakers,
                        collaborations, and big sales.
                    </p>

                    {{-- Replace action with your newsletter route, e.g., route('newsletter.subscribe') --}}
                    <form action="#" method="POST" class="mt-6 flex w-full max-w-md gap-2">
                        @csrf
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input id="newsletter-email" type="email" name="email" required
                            class="flex-1 rounded-full border border-white/20 bg-white/10 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-jd-yellow focus:outline-none"
                            placeholder="Your email address">
                        <button type="submit"
                            class="rounded-full bg-jd-yellow px-6 py-2.5 font-condensed text-xs font-bold tracking-wider text-black transition hover:bg-yellow-300">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>

    {{-- ============================================================
    13. FOOTER
    ============================================================ --}}
    <footer class="bg-jd-dark text-gray-300">
        <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-5">

                {{-- Brand --}}
                <div class="col-span-2 md:col-span-1 lg:col-span-2">
                    <a href="{{ route('home') }}" class="inline-block" aria-label="JD Sports — Home">
                        {{-- Adjust to match your white logo version --}}
                        <img src="{{ asset('storage/images/sample/logo-white.png') }}" alt="JD Sports"
                            class="h-8 w-auto" onerror="this.style.display='none'">
                    </a>
                    <p class="mt-4 max-w-xs text-xs leading-relaxed text-gray-400">
                        JD Sports — your premier destination for original sneakers and streetwear
                        from the world's biggest brands.
                    </p>

                    {{-- Social media --}}
                    <div class="mt-4 flex items-center gap-3">
                        <a href="#" class="text-gray-400 transition hover:text-white" aria-label="Instagram">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2" />
                                <circle cx="12" cy="12" r="4" stroke-width="2" />
                                <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition hover:text-white" aria-label="Facebook">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14 8h2.5V5H14a4 4 0 00-4 4v2H7.5v3H10v7h3v-7h2.5l.5-3H13V9a1 1 0 011-1z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition hover:text-white" aria-label="X">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L2.8 2h6.4l4.4 5.9L18.9 2z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 transition hover:text-white" aria-label="YouTube">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="4" stroke-width="2" />
                                <path d="M10 9l6 3-6 3V9z" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Help --}}
                <nav aria-label="Help">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">Help</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#" class="hover:text-white">Track Order</a></li>
                        <li><a href="#" class="hover:text-white">Delivery</a></li>
                        <li><a href="#" class="hover:text-white">Returns &amp; Refund</a></li>
                        <li><a href="#" class="hover:text-white">Size Guide</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a></li>
                    </ul>
                </nav>

                {{-- About --}}
                <nav aria-label="About JD">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">About JD</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Careers</a></li>
                        <li><a href="#" class="hover:text-white">Store Locator</a></li>
                        <li><a href="#" class="hover:text-white">Loyalty Program</a></li>
                    </ul>
                </nav>

                {{-- Shop --}}
                <nav aria-label="Shop">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">Shop</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="{{ route('shop', ['gender' => 'men']) }}" class="hover:text-white">Men</a></li>
                        <li><a href="{{ route('shop', ['gender' => 'women']) }}" class="hover:text-white">Women</a>
                        </li>
                        <li><a href="{{ route('shop', ['gender' => 'kids']) }}" class="hover:text-white">Kids</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:text-white">All Products</a></li>
                    </ul>
                </nav>
            </div>

            {{-- Payment methods --}}
            <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-white/10 pt-6">
                <span class="mr-2 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Payment
                    Methods</span>
                @foreach (['Visa', 'Mastercard', 'Apple Pay', 'Google Pay', 'PayPal', 'American Express'] as $payment)
                    <span
                        class="rounded border border-white/10 px-2.5 py-1 text-[10px] font-semibold text-gray-400">{{ $payment }}</span>
                @endforeach
            </div>

            {{-- Bottom bar --}}
            <div
                class="mt-6 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-[11px] text-gray-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} JD Sports. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-gray-300">Terms &amp; Conditions</a>
                    <a href="#" class="hover:text-gray-300">Privacy Policy</a>
                </div>
            </div>
            </div>
        </div>
    </footer>

    {{-- ============================================================
    14. JAVASCRIPT
    ============================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* =====================================================
               1. HERO SLIDER
               ===================================================== */
            var slides = Array.prototype.slice.call(document.querySelectorAll('.hero-slide'));
            var dotsBox = document.getElementById('hero-dots');
            var prevBtn = document.getElementById('hero-prev');
            var nextBtn = document.getElementById('hero-next');

            if (slides.length > 0 && dotsBox) {
                var current = 0;
                var timer = null;
                var dots = [];

                // Create dot indicators
                slides.forEach(function (_, i) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'h-2.5 w-2.5 rounded-full bg-white/40 transition-all duration-300';
                    dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                    dot.addEventListener('click', function () { goTo(i); });
                    dotsBox.appendChild(dot);
                    dots.push(dot);
                });

                function goTo(index) {
                    // Non-aktifkan slide & titik saat ini
                    slides[current].classList.remove('opacity-100', 'scale-100', 'z-10');
                    slides[current].classList.add('opacity-0', 'scale-105');
                    dots[current].classList.remove('bg-white', 'w-5');
                    dots[current].classList.add('bg-white/40', 'w-2.5');

                    current = (index + slides.length) % slides.length;

                    // Aktifkan slide & titik baru
                    slides[current].classList.remove('opacity-0', 'scale-105');
                    slides[current].classList.add('opacity-100', 'scale-100', 'z-10');
                    dots[current].classList.remove('bg-white/40', 'w-2.5');
                    dots[current].classList.add('bg-white', 'w-5');

                    restartAutoplay();
                }

                function restartAutoplay() {
                    clearInterval(timer);
                    if (slides.length > 1) {
                        timer = setInterval(function () { goTo(current + 1); }, 6000);
                    }
                }

                if (slides.length > 1) {
                    if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1); });
                    if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1); });
                    goTo(0);
                } else {
                    // Sembunyikan kontrol bila hanya ada 1 slide
                    if (prevBtn) prevBtn.classList.add('hidden');
                    if (nextBtn) nextBtn.classList.add('hidden');
                }
            }

            /* =====================================================
               2. COUNTDOWN "LIMITED PAIRS ONLY"
               ===================================================== */
            var countdown = document.querySelector('[data-countdown]');

            if (countdown) {
                // Deadline dalam detik. Idealnya dikirim dari controller
                // sebagai $flashSaleDeadline agar sinkron dengan server.
                var remaining = {{ (int) ($flashSaleDeadline ?? 72101) }}; // 20:01:41

                var elH = countdown.querySelector('[data-h]');
                var elM = countdown.querySelector('[data-m]');
                var elS = countdown.querySelector('[data-s]');

                function renderCountdown() {
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

            /* =====================================================
               3. MENU MOBILE
               ===================================================== */
            var menuBtn = document.getElementById('mobile-menu-btn');
            var mobileMenu = document.getElementById('mobile-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    var isHidden = mobileMenu.classList.toggle('hidden');
                    menuBtn.setAttribute('aria-expanded', String(!isHidden));
                });
            }

            /* =====================================================
               4. PENCARIAN MOBILE
               ===================================================== */
            var searchBtn = document.getElementById('mobile-search-btn');
            var mobileSearch = document.getElementById('mobile-search');

            if (searchBtn && mobileSearch) {
                searchBtn.addEventListener('click', function () {
                    var isHidden = mobileSearch.classList.toggle('hidden');
                    searchBtn.setAttribute('aria-expanded', String(!isHidden));
                    if (!isHidden) {
                        var input = mobileSearch.querySelector('input');
                        if (input) input.focus();
                    }
                });
            }
        });
    </script>

</body>

</html