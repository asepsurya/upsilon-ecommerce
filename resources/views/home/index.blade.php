@php
    /* ============================================================================
       PERSIAPAN DATA HALAMAN
       ----------------------------------------------------------------------------
        Preparing data + fallback so the page always looks clean even
        when the database is empty. For production, the take/slice logic
        should ideally be moved to HomeController (see example at the
        bottom of this document).
       ============================================================================ */

    // --- 1. Produk unggulan dibagi per section ---
    $limitedPairs = $featuredProducts->take(5);           // section "Limited Pairs Only"

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
            'image_url' => asset('storage/images/upsilon/' . $p['image']),
            'permalink' => route('shop'),
        ]);
    });

    $limitedPairsList = $limitedPairs->isNotEmpty() ? $limitedPairs : $fallbackProducts->take(5);

    // --- 3. Kategori fallback ---
    $fallbackCategories = collect([
        ['name' => 'Men', 'image' => 'category-mens.jpg'],
        ['name' => 'Women', 'image' => 'category-womens.jpg'],
        ['name' => 'Kids', 'image' => 'category-kids.jpg'],
    ])->map(function ($c) {
        return (object) [
            'name' => $c['name'],
            'image_url' => asset('storage/images/upsilon/' . $c['image']),
            'product_count' => 0,
        ];
    });

    $categoriesList = $categories->isNotEmpty() ? $categories : $fallbackCategories;

    // --- 4. Slider fallback ---
    $sliderList = $sliders->isNotEmpty() ? $sliders : collect([
        (object) [
            'image_url' => asset('storage/images/upsilon/hero-banner.jpg'),
            'image_mobile_url' => asset('storage/images/upsilon/hero-banner.jpg'),
        ],
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
            'image_url' => asset('storage/images/upsilon/' . $a['image']),
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
    $featuredBrands = [
        ['name' => 'Nike', 'slug' => 'nike', 'image' => 'brand-nike.jpg'],
        ['name' => 'adidas', 'slug' => 'adidas', 'image' => 'brand-adidas.jpg'],
        ['name' => 'On', 'slug' => 'on', 'image' => 'brand-on.jpg'],
        ['name' => 'New Balance', 'slug' => 'new-balance', 'image' => 'brand-newbalance.jpg'],
    ];
@endphp

@extends('layouts.home')

@section('title', 'Upsilon | King of Trainers')
@section('description', 'Sneakers, clothing, and accessories from Nike, adidas, New Balance, Puma, and more. Free shipping nationwide.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    {{-- Skip link untuk aksesibilitas --}}
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:z-[60] focus:bg-black focus:px-4 focus:py-2 focus:text-white">
        Skip to main content
    </a>

    {{-- ============================================================
     3. PROMO BAR (SCROLLER)
     ============================================================ --}}
    @php
        $promoBarItems = $announcements->map(fn($a) => [$a->title, $a->message])->toArray();

        if ($promoBarItems === []) {
            $promoBarItems = [
                ['FREE SHIPPING NATIONWIDE', 'Next day & standard delivery*'],
                ['ASICS GEL-CUMULUS', 'Where comfort pursues us'],
            ];
        }
    @endphp

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

    <main id="main-content">

        {{-- ============================================================
        4. HERO CAROUSEL
        ============================================================ --}}
        <section class="relative w-full overflow-hidden bg-black" aria-label="Main banner">
            <div id="hero-slider" class="relative aspect-[21/9] max-h-[700px] min-h-[440px] w-full">

                @foreach ($sliderList as $index => $slider)
                    <div class="hero-slide absolute inset-0 h-full w-full transition-all duration-1000 ease-in-out {{ $index === 0 ? 'z-10 opacity-100 scale-100' : 'opacity-0 scale-105' }}"
                        data-index="{{ $index }}" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
                        data-link="{{ $slider->link ?? '#' }}" data-link-text="{{ $slider->link_text ?? 'Shop Now' }}">
                        <picture>
                            <source media="(max-width: 768px)" srcset="{{ $slider->image_mobile_url }}">
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->title ?? 'Featured promotion' }}"
                                class="h-full w-full object-cover object-center">
                        </picture>
                        <div class="absolute inset-0 z-10 flex items-center">
                            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                                <div class="max-w-xl text-white">
                                    <h2 class="text-3xl font-black tracking-wide md:text-5xl drop-shadow-md">{{ $slider->heading ?? $slider->title }}</h2>
                                    @if($slider->description)
                                        <p class="mt-3 text-sm text-gray-200 md:text-base drop-shadow-sm">{{ $slider->description }}</p>
                                    @endif
                                    @if($slider->link)
                                        <a href="{{ $slider->link }}"
                                            class="mt-4 inline-block bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">
                                            {{ $slider->link_text ?? 'Shop Now' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
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

                {{-- CTA button --}}
                <div
                    class="absolute bottom-6 right-6 z-20 flex flex-wrap items-center justify-end gap-3 md:bottom-10 md:right-12">
                    <a id="hero-cta"
                        href="#"
                        class="bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">
                        Shop Now
                    </a>
                </div>
            </div>
        </section>

        {{-- ============================================================
        5. LIMITED PAIRS + COUNTDOWN (only show if active flash sale exists)
        ============================================================ --}}
        @if($flashSale && $flashSaleProducts->isNotEmpty())
        <section class="bg-[#2A2E33] py-8 text-white" aria-labelledby="limited-heading">
            {{-- Header + countdown (centered container) --}}
            <div class="mx-auto max-w-7xl px-4 lg:px-8 mb-6">
                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-700 pb-2">
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
                        <h2 id="limited-heading"
                            class="text-2xl font-condensed font-extrabold tracking-wide text-[#FF5000] md:text-3xl">
                            {{ $flashSale->title }}
                        </h2>
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-300" data-countdown
                            role="timer" aria-label="Time remaining">
                            <span>{{ $flashSale->subtitle ?? 'Ends in' }}</span>
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
                    <a href="{{ route('flash.sale') }}"
                        class="text-xs font-semibold text-gray-300 underline hover:text-white">View all</a>
                </div>
            </div>

            {{-- Produk + banner FINAL CALL (full width) --}}
            <div class="flash-sale-scroll-wrapper relative">
                {{-- Desktop Navigation Arrows --}}
                <button type="button" class="flash-sale-prev hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors absolute left-4 top-1/2 -translate-y-1/2 z-10" aria-label="Previous">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" class="flash-sale-next hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors absolute right-4 top-1/2 -translate-y-1/2 z-10" aria-label="Next">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <div
                    class="flash-sale-scroll
                           flex gap-3
                           overflow-x-auto
                           snap-x snap-mandatory
                           md:overflow-x-hidden
                           md:flex md:justify-center
                           px-4 md:px-8 lg:px-8"
                >
                    @foreach ($flashSaleProducts as $product)
                        <div class="flash-sale-scroll-item shrink-0 w-[55%] md:w-[180px] snap-start">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ============================================================
        6. SHOP BY LABELS
        ============================================================ --}}
        <section class="bg-white py-8 text-neutral-900" aria-labelledby="labels-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="labels-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">Shop
                        The Labels</h2>
                    <a href="{{ route('shop') }}"
                        class="text-xs font-bold uppercase tracking-wider hover:underline">Shop All</a>
                </div>

                {{-- Label tiles --}}
                <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($labels as $label)
                        <a href="{{ route('shop', ['label' => $label->slug]) }}"
                            class="flex aspect-[4/3] items-start justify-center rounded-sm p-4 text-center transition hover:scale-[1.02] relative overflow-hidden"
                            style="@if($label->image) background-image: url('{{ $label->image_url }}'); background-size: cover; background-position: center; @endif background-color: {{ $label->color ?? '#3b434a' }}; color: {{ $label->text_color ?? '#ffffff' }};">
                            @if($label->image)
                                <span class="absolute inset-x-0 top-0 h-2/3 bg-gradient-to-b from-black/70 via-black/40 to-transparent"></span>
                            @endif
                            <span class="relative z-10 pt-2">
                                <span class="block font-impact text-xl tracking-wider md:text-2xl">{{ $label->name }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>

                @if($labels->isEmpty())
                    <p class="text-center text-gray-400 text-sm">No labels available yet.</p>
                @endif
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
                                            {{ strtoupper($category->name) }}
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
        @php
            $activePromoBanners = collect($promoBanners ?? [])->filter(fn ($b) => !empty($b->image_url))->values();
        @endphp
        @if($activePromoBanners->isNotEmpty())
            <section class="bg-[#F25C19] py-4" aria-label="Seasonal promotions">
                <div class="mx-auto max-w-7xl px-4 lg:px-8">
                    @if($activePromoBanners->count() > 1)
                        <div class="relative">
                            <div id="promo-banner-slider" class="overflow-hidden rounded">
                                <div id="promo-banner-track" class="flex transition-transform duration-500">
                                    @foreach($activePromoBanners as $banner)
                                        <div class="w-full flex-shrink-0">
                                            <a href="{{ $banner->link ?? '#' }}" class="block">
                                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Promo' }}" loading="lazy"
                                                    class="h-auto w-full object-cover transition duration-500 hover:scale-[1.02]">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" id="promo-prev" aria-label="Previous banner"
                                class="absolute left-4 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-black/40 px-3 py-2 text-white transition hover:bg-black/70 md:flex items-center justify-center">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            </button>
                            <button type="button" id="promo-next" aria-label="Next banner"
                                class="absolute right-4 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-black/40 px-3 py-2 text-white transition hover:bg-black/70 md:flex items-center justify-center">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            </button>
                        </div>
                    @else
                        @foreach($activePromoBanners as $banner)
                            <a href="{{ $banner->link ?? '#' }}" class="block overflow-hidden rounded">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title ?? 'Promo' }}" loading="lazy"
                                    class="h-auto w-full object-cover transition duration-500 hover:scale-[1.02]">
                            </a>
                        @endforeach
                    @endif
                </div>
            </section>
        @endif

        {{-- ============================================================
        10. THE BRANDS YOU LOVE
        ============================================================ --}}
        <section class="bg-[#F25C19] py-8 text-white" aria-labelledby="brands-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="brands-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Top Upsilon Bundle
                    </h2>
                    <a href="{{ route('bundles') }}"
                        class="text-xs font-bold uppercase tracking-wider hover:underline">View All</a>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($bundles as $bundle)
                        <button type="button" class="bundle-card group block w-full text-left" data-bundle-id="{{ $bundle->id }}">
                            <div class="relative aspect-square w-full overflow-hidden rounded shadow">
                                @if($bundle->thumbnail)
                                    <img src="{{ asset('storage/' . $bundle->thumbnail) }}" alt="{{ $bundle->name }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <img src="https://placehold.co/600x600/1E2125/FFFFFF?text={{ urlencode($bundle->name) }}"
                                        alt="{{ $bundle->name }}" loading="lazy"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @endif
                                @if($bundle->discount_percent > 0)
                                    <div
                                        class="absolute top-3 left-3 bg-brand-yellow text-black px-2 py-1 font-condensed text-[10px] uppercase tracking-wider rounded">
                                        Save {{ $bundle->discount_percent }}%
                                    </div>
                                @endif
                                <div
                                    class="absolute bottom-3 left-3 flex h-8 w-8 items-center justify-center rounded-full bg-white/80 text-black backdrop-blur-sm">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="mt-2 text-xs font-bold uppercase tracking-wider">{{ $bundle->name }}</h3>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

{{-- ============================================================
        11. DISCOVER JD STYLE (EDITORIAL)
        ============================================================ --}}
        <section class="pb-12  mt-5" aria-labelledby="editorial-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <h2 id="editorial-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Discover Upsilon Style
                    </h2>
                    <a href="{{ route('discover-upsilon-style') }}" class="text-xs font-bold uppercase tracking-wider hover:underline">View All</a>
                </div>

{{-- Instagram Feed --}}
                <section class="bg-white py-12">
                    <div class="mx-auto max-w-7xl px-4 lg:px-8">
                        <x-instagram-feed :limit="8" :columns="4" heading="Follow Us On Instagram" />
                    </div>
                </section>


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
                        Sign up for the Upsilon newsletter and be the first to know about the latest sneakers,
                        collaborations, and big sales.
                    </p>

                    {{-- Replace action with your newsletter route, e.g., route('newsletter.subscribe') --}}
                    <form action="#" method="POST" class="mt-6 flex w-full max-w-md gap-2">
                        @csrf
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input id="newsletter-email" type="email" name="email" required
                            class="flex-1 rounded-full border border-white/20 bg-white/10 px-4 py-2.5 text-sm text-white placeholder-gray-500 focus:border-brand-yellow focus:outline-none"
                            placeholder="Your email address">
                        <button type="submit"
                            class="rounded-full bg-brand-yellow px-6 py-2.5 font-condensed text-xs font-bold tracking-wider text-black transition hover:bg-yellow-300">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>

 

    {{-- ============================================================
    14. JAVASCRIPT
    ============================================================ --}}
    <script>
        var CURRENCY_SYMBOL = @json(currency_symbol());

        document.addEventListener('DOMContentLoaded', function () {
            var bundlesData = @json($bundles);

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
                var ctaBtn = document.getElementById('hero-cta');

                function updateCta() {
                    if (!ctaBtn) return;
                    var slide = slides[current];
                    var link = slide.getAttribute('data-link') || '#';
                    var text = slide.getAttribute('data-link-text') || 'Shop Now';
                    ctaBtn.setAttribute('href', link);
                    ctaBtn.textContent = text;
                }

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

                    updateCta();
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
                    updateCta();
                } else {
                    // Sembunyikan kontrol bila hanya ada 1 slide
                    if (prevBtn) prevBtn.classList.add('hidden');
                    if (nextBtn) nextBtn.classList.add('hidden');
                    updateCta();
                }
            }

            /* =====================================================
               2. COUNTDOWN "LIMITED PAIRS ONLY"
               ===================================================== */
            var countdown = document.querySelector('[data-countdown]');

            if (countdown) {
                var now = Math.floor(Date.now() / 1000);
                var remaining = {{ (int) ($flashSaleDeadline ?? 72101) }} - now;

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
               3. FLASH SALE SWIPE ON MOBILE + DESKTOP NAV
               ===================================================== */
            var flashSaleWrapper = document.querySelector('.flash-sale-scroll-wrapper');
            var flashSaleScroll = document.querySelector('.flash-sale-scroll');
            var flashSalePrev = document.querySelector('.flash-sale-prev');
            var flashSaleNext = document.querySelector('.flash-sale-next');

            if (flashSaleWrapper && flashSaleScroll) {
                var startX = 0;
                var currentTranslate = 0;
                var prevTranslate = 0;
                var isDragging = false;

                function getPositionX(event) {
                    return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
                }

                function setPositionByIndex() {
                    currentTranslate = prevTranslate;
                }

                function scrollByAmount(amount) {
                    var maxScroll = flashSaleScroll.scrollWidth - flashSaleScroll.clientWidth;
                    prevTranslate = Math.max(-maxScroll, Math.min(0, prevTranslate + amount));
                    flashSaleScroll.scrollTo({
                        left: -prevTranslate,
                        behavior: 'smooth'
                    });
                    updateArrowVisibility();
                }

                function updateArrowVisibility() {
                    if (!flashSalePrev || !flashSaleNext) return;
                    var maxScroll = flashSaleScroll.scrollWidth - flashSaleScroll.clientWidth;
                    flashSalePrev.style.opacity = prevTranslate < 0 ? '1' : '0.3';
                    flashSalePrev.style.pointerEvents = prevTranslate < 0 ? 'auto' : 'none';
                    flashSaleNext.style.opacity = Math.abs(prevTranslate) < maxScroll - 5 ? '1' : '0.3';
                    flashSaleNext.style.pointerEvents = Math.abs(prevTranslate) < maxScroll - 5 ? 'auto' : 'none';
                }

                function touchStart(event) {
                    startX = getPositionX(event);
                    isDragging = true;
                }

                function touchMove(event) {
                    if (!isDragging) return;
                    var currentPosition = getPositionX(event);
                    var diff = currentPosition - startX;
                    currentTranslate = prevTranslate + diff;
                }

                function touchEnd() {
                    isDragging = false;
                    var movedBy = currentTranslate - prevTranslate;

                    if (movedBy < -50) {
                        prevTranslate = Math.min(0, prevTranslate - 120);
                    }

                    if (movedBy > 50) {
                        prevTranslate = Math.max(prevTranslate + 120, -flashSaleScroll.scrollWidth + flashSaleScroll.clientWidth);
                    }

                    setPositionByIndex();
                    flashSaleScroll.scrollTo({
                        left: -prevTranslate,
                        behavior: 'smooth'
                    });
                    updateArrowVisibility();
                }

                // Desktop arrow navigation
                if (flashSalePrev) {
                    flashSalePrev.addEventListener('click', function() {
                        scrollByAmount(200); // Scroll left
                    });
                }
                if (flashSaleNext) {
                    flashSaleNext.addEventListener('click', function() {
                        scrollByAmount(-200); // Scroll right
                    });
                }

                // Touch events for mobile
                flashSaleScroll.addEventListener('touchstart', touchStart, { passive: true });
                flashSaleScroll.addEventListener('touchmove', touchMove, { passive: true });
                flashSaleScroll.addEventListener('touchend', touchEnd);

                // Scroll event to update arrows
                flashSaleScroll.addEventListener('scroll', function() {
                    prevTranslate = -flashSaleScroll.scrollLeft;
                    updateArrowVisibility();
                });

                // Initial arrow state
                updateArrowVisibility();
            }

            /* =====================================================
               4. MOBILE SEARCH
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

            window.openBundleModal = function (bundleId) {
                var bundle = bundlesData.find(function (b) { return b.id == bundleId; });
                if (!bundle) return;

                document.getElementById('bundle-modal-title').textContent = bundle.name;
                document.getElementById('bundle-modal-desc').textContent = bundle.description || '';

                var price = Number(bundle.bundle_price || 0);
                var original = Number(bundle.original_price || 0);
                document.getElementById('bundle-modal-price').textContent = CURRENCY_SYMBOL + price.toLocaleString();
                document.getElementById('bundle-modal-original').textContent = original > 0 ? (CURRENCY_SYMBOL + original.toLocaleString()) : '';

                var itemsContainer = document.getElementById('bundle-modal-items');
                itemsContainer.innerHTML = '';
                var itemList = (bundle.items || []).slice(0, 4);
                (bundle.items || []).slice(0, 4).forEach(function (item) {
                    var product = item.product || {};
                    var image = product.image_url || '';
                    if (!image && product.images && product.images.length) {
                        image = product.images[0].url || product.images[0].image || '';
                    }
                    if (!image) {
                        image = 'https://placehold.co/600x600/1E2125/FFFFFF?text=' + encodeURIComponent(product.name || 'Product');
                    }
                    var name = product.name || 'Product';
                    var quantity = item.quantity || 1;
                    var itemPrice = Number(product.base_price || product.effective_price || 0);

                    var el = document.createElement('div');
                    el.className = 'flex items-center gap-3';
                    el.innerHTML = '<img src="' + image + '" alt="' + name + '" class="h-12 w-12 rounded object-cover"><div class="flex-1"><div class="text-sm font-medium text-gray-900">' + name + '</div><div class="text-xs text-gray-500">Qty: ' + quantity + '</div></div><div class="text-sm font-medium text-gray-900">' + CURRENCY_SYMBOL + (itemPrice * quantity).toLocaleString() + '</div>';
                    itemsContainer.appendChild(el);
                });
                if ((bundle.items || []).length > 4) {
                    var moreEl = document.createElement('div');
                    moreEl.className = 'text-xs text-gray-500 mt-1';
                    moreEl.textContent = '+ ' + ((bundle.items || []).length - 4) + ' more items';
                    itemsContainer.appendChild(moreEl);
                }

                var cta = document.getElementById('bundle-modal-cta');
                cta.href = 'https://wa.me/{{ config('services.whatsapp.number') }}?text=' + encodeURIComponent('Hello, I am interested in ' + bundle.name + ' bundle.');

                document.getElementById('bundle-modal').classList.remove('hidden');
            };

            document.getElementById('bundle-modal-close').addEventListener('click', function () {
                document.getElementById('bundle-modal').classList.add('hidden');
            });
            document.getElementById('bundle-modal').addEventListener('click', function (e) {
                if (e.target.id === 'bundle-modal') {
                    document.getElementById('bundle-modal').classList.add('hidden');
                }
            });

            document.querySelectorAll('.bundle-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    var id = card.getAttribute('data-bundle-id');
                    if (id) window.openBundleModal(id);
                });
            });

            /* =====================================================
               5. PROMO BANNER SLIDER
               ===================================================== */
            var promoTrack = document.getElementById('promo-banner-track');
            var promoPrev = document.getElementById('promo-prev');
            var promoNext = document.getElementById('promo-next');
            var promoIndex = 0;

            if (promoTrack && promoPrev && promoNext) {
                var promoSlides = promoTrack.children;
                var promoTotal = promoSlides.length;

                function updatePromo() {
                    promoTrack.style.transform = 'translateX(-' + (promoIndex * 100) + '%)';
                }

                promoPrev.addEventListener('click', function () {
                    promoIndex = (promoIndex - 1 + promoTotal) % promoTotal;
                    updatePromo();
                });

                promoNext.addEventListener('click', function () {
                    promoIndex = (promoIndex + 1) % promoTotal;
                    updatePromo();
                });
            }
        });
    </script>

    <div id="bundle-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="w-full max-w-2xl rounded-lg bg-white p-6 shadow-xl">
            <div class="flex items-start justify-between">
                <div>
                    <h2 id="bundle-modal-title" class="text-xl font-bold text-gray-900"></h2>
                    <p id="bundle-modal-desc" class="mt-1 text-sm text-gray-600"></p>
                </div>
                <button id="bundle-modal-close" class="text-gray-500 hover:text-gray-700">Close</button>
            </div>
            <div id="bundle-modal-items" class="mt-4 space-y-3"></div>
            <div class="mt-4 flex items-center gap-3">
                <span id="bundle-modal-price" class="text-lg font-bold text-gray-900"></span>
                <span id="bundle-modal-original" class="text-sm text-gray-500 line-through"></span>
            </div>
            <a id="bundle-modal-cta" href="#" target="_blank" rel="noopener" class="mt-4 inline-flex w-full items-center justify-center rounded bg-yellow-400 px-4 py-2 text-sm font-bold text-black hover:bg-yellow-300">Order Bundle</a>
        </div>
    </div>
@endsection
