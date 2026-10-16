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
            'title' => 'Upsilon',
            'heading' => 'King of Trainers',
            'description' => 'Sneakers, clothing, and accessories from Nike, adidas, New Balance, Puma, and more.',
            'image_url' => asset('storage/images/upsilon/hero-banner.jpg'),
            'image_mobile_url' => asset('storage/images/upsilon/hero-banner.jpg'),
            'link' => route('shop'),
            'link_text' => 'Shop Now',
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
                                    <h2 class="text-3xl font-black tracking-wide md:text-5xl drop-shadow-md">
                                        {{ $slider->heading ?? $slider->title }}
                                    </h2>
                                    @if($slider->description)
                                        <p class="mt-3 text-sm text-gray-200 md:text-base drop-shadow-sm">{{ $slider->description }}
                                        </p>
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
                    <a id="hero-cta" href="#"
                        class="bg-white px-6 py-2 font-condensed text-xs font-bold tracking-wider text-black shadow-md transition hover:bg-gray-100 md:text-sm">
                        Shop Now
                    </a>
                </div>
            </div>
        </section>

        @php
            $aboutSlidesFallback = collect([
                [
                    'title' => 'Engineered With Radical Precision',
                    'subtitle' => 'Our Manifesto',
                    'description' => 'Upsilon was founded on a singular principle: to redefine everyday essential wear through uncompromising fabric selection, ergonomic silhouette engineering, and intricate computer-embroidered details.',
                    'image' => 'about-slide-1.jpg',
                    'link_text' => 'Shop Now',
                ],
                [
                    'title' => 'Our Factory',
                    'subtitle' => 'State-of-the-Art Manufacturing',
                    'description' => 'We blend tradition with cutting-edge technology in our state-of-the-art manufacturing facility. Every garment is crafted with meticulous attention to detail.',
                    'image' => 'about-slide-2.jpg',
                    'link_text' => 'Shop Now',
                ],
                [
                    'title' => 'The Upsilon Symbol',
                    'subtitle' => 'Brand Philosophy',
                    'description' => 'The Greek letter Upsilon represents branching paths, decision points, and the pursuit of excellence. Built for those who navigate life with intention.',
                    'image' => 'about-slide-3.jpg',
                    'link_text' => 'Shop Now',
                ],
                [
                    'title' => 'Three Pillars Of Excellence',
                    'subtitle' => 'Uncompromising Standards',
                    'description' => '100% combed cotton, high-precision embroidery, and ergonomic fit. Why Upsilon garments deliver unparalleled comfort, drape, and durability.',
                    'image' => 'about-slide-4.jpg',
                    'link_text' => 'Shop Now',
                ],
            ])->map(function ($s) {
                return (object) array_merge($s, [
                    'image_url' => asset('storage/images/upsilon/' . $s['image']),
                    'link' => route('shop'),
                ]);
            });

            $aboutSlidesList = isset($aboutSlides) && $aboutSlides->isNotEmpty()
                ? $aboutSlides
                : $aboutSlidesFallback;
        @endphp

        <section class="bg-white py-12" aria-labelledby="about-slides-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 id="about-slides-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        About Upsilon
                    </h2>
                    <div class="flex items-center gap-2">
                        <button type="button" id="about-prev" aria-label="Previous about slide"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-neutral-200 text-neutral-800 transition hover:bg-neutral-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                        <button type="button" id="about-next" aria-label="Next about slide"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-neutral-200 text-neutral-800 transition hover:bg-neutral-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="about-slider" class="overflow-hidden" aria-roledescription="carousel" aria-label="About Upsilon">
                    <div id="about-track" class="flex transition-transform duration-500 ease-in-out">
                        @foreach ($aboutSlidesList as $aIndex => $slide)
                            <div class="w-full flex-shrink-0" role="group" aria-roledescription="slide"
                                aria-label="{{ $aIndex + 1 }} of {{ $aboutSlidesList->count() }}">
                                <div class="grid items-center gap-6 md:grid-cols-2 md:gap-10">
                                    <div class="relative aspect-[4/3] w-full overflow-hidden rounded shadow">
                                        <img src="{{ $slide->image_url ?: 'https://placehold.co/800x600/1E2125/FFFFFF?text=' . urlencode($slide->title) }}"
                                            alt="{{ $slide->title }} about" loading="lazy"
                                            class="h-full w-full object-cover object-center transition duration-500 hover:scale-[1.03]">
                                    </div>
                                    <div class="px-2 md:px-0">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider text-[#F25C19]">{{ $slide->subtitle }}</span>
                                        <h3 class="mt-2 font-impact text-3xl tracking-wider md:text-5xl">{{ $slide->title }}
                                        </h3>
                                        <p class="mt-4 max-w-md text-sm leading-relaxed text-neutral-600 md:text-base">
                                            {{ $slide->description }}
                                        </p>
                                        <a href="{{ $slide->link ?? '#' }}"
                                            class="mt-6 inline-block bg-black px-6 py-2.5 font-condensed text-xs font-bold tracking-wider text-white transition hover:bg-neutral-800">
                                            {{ $slide->link_text ?? 'Shop Now' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dot indicators (generated by JavaScript) --}}
                <div id="about-dots" class="mt-6 flex items-center justify-center gap-2"></div>
            </div>
        </section>

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
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums" data-h>20</span>
                                <span aria-hidden="true">:</span>
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums" data-m>01</span>
                                <span aria-hidden="true">:</span>
                                <span class="rounded bg-red-600 px-2 py-0.5 font-bold text-white tabular-nums" data-s>41</span>
                            </div>
                        </div>
                        <a href="{{ route('flash.sale') }}"
                            class="text-xs font-semibold text-gray-300 underline hover:text-white">View all</a>
                    </div>
                </div>

                {{-- Produk + banner FINAL CALL (full width) --}}
                <div class="flash-sale-scroll-wrapper relative">
                    {{-- Desktop Navigation Arrows --}}
                    <button type="button"
                        class="flash-sale-prev hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors absolute left-4 top-1/2 -translate-y-1/2 z-10"
                        aria-label="Previous">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button"
                        class="flash-sale-next hidden md:flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors absolute right-4 top-1/2 -translate-y-1/2 z-10"
                        aria-label="Next">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div class="flash-sale-scroll
                                                                   flex gap-3
                                                                   overflow-x-auto
                                                                   snap-x snap-mandatory
                                                                   md:overflow-x-hidden
                                                                   md:flex md:justify-center
                                                                   px-4 md:px-8 lg:px-8">
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
        10. THE BRANDS YOU LOVE
        ============================================================ --}}
        <section class="py-8 text-white" aria-labelledby="brands-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h2 id="brands-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl" style="
                        color: black;
                    ">
                            Top Upsilon Bundle
                        </h2>
                        @if($bundles->count() > 3)
                            <span
                                class="text-xs font-bold uppercase tracking-wider text-neutral-500 hover:underline cursor-pointer"
                                onclick="location.href='{{ route('bundles') }}'">See More</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                    @foreach ($bundles->take(3) as $bundle)
                        <button type="button" class="bundle-card group block w-full text-left"
                            data-bundle-id="{{ $bundle->id }}">
                            <div class="relative aspect-square w-full overflow-hidden rounded shadow">
                                @if($bundle->thumbnail)
                                    <img src="{{ asset('storage/' . $bundle->thumbnail) }}" alt="{{ $bundle->name }}" loading="lazy"
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
        6. SHOP BY LABELS
        ============================================================ --}}
        @if($labels->isNotEmpty())
            <section class="bg-white py-8 text-neutral-900" aria-labelledby="labels-heading">
                <div class="mx-auto max-w-7xl px-4 lg:px-8">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 id="labels-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">Shop
                            The Labels</h2>
                        <a href="{{ route('shop') }}" class="text-xs font-bold uppercase tracking-wider hover:underline">Shop
                            All</a>
                    </div>

                    {{-- Label tiles --}}
                    <div class="mb-6 grid grid-cols-2 gap-4 md:grid-cols-4">
                        @foreach ($labels as $label)
                            <a href="{{ route('shop', ['label' => $label->slug]) }}"
                                class="flex aspect-[4/3] items-start justify-center rounded-sm p-4 text-center transition hover:scale-[1.02] relative overflow-hidden"
                                style="@if($label->image) background-image: url('{{ $label->image_url }}'); background-size: cover; background-position: center; @endif background-color: {{ $label->color ?? '#3b434a' }}; color: {{ $label->text_color ?? '#ffffff' }};">
                                @if($label->image)
                                    <span
                                        class="absolute inset-x-0 top-0 h-2/3 bg-gradient-to-b from-black/70 via-black/40 to-transparent"></span>
                                @endif
                                <span class="relative z-10 pt-2">
                                    <span class="block font-impact text-xl tracking-wider md:text-2xl">{{ $label->name }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>


                </div>
            </section>
        @endif
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
                            $isLocked = isset($category->is_active) && !$category->is_active;
                            $categoryUrl = isset($category->id)
                                ? route('shop.category', $category->slug)
                                : route('shop');
                        @endphp
                        <div class="flex flex-col">
                            <a href="{{ $categoryUrl }}" class="group block" @if($isLocked)
                            aria-label="{{ $category->name }} - coming soon" @endif>
                                <div class="relative aspect-[3/4] w-full overflow-hidden rounded shadow-lg">
                                    <img src="{{ $category->image_url }}" alt="Category {{ $category->name }}" loading="lazy"
                                        class="h-full w-full object-cover object-center transition-transform duration-500 {{ $isLocked ? 'grayscale opacity-50' : 'group-hover:scale-105' }}">
                                    <div
                                        class="absolute inset-0 flex items-end justify-center bg-gradient-to-t from-black/80 via-transparent to-transparent pb-8">
                                        <h3 class="font-impact text-3xl tracking-wider text-white md:text-4xl">
                                            {{ strtoupper($category->name) }}
                                        </h3>
                                    </div>
                                    @if($isLocked)
                                        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-black/50">
                                            <span
                                                class="rounded bg-brand-yellow px-3 py-1 font-condensed text-xs font-bold uppercase tracking-wider text-black">
                                                Coming Soon
                                            </span>
                                            <span
                                                class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-widest text-white/90">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                </svg>
                                                Locked
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============================================================
        7B. MATERIAL SPOTLIGHT (SLIDER)
        ============================================================ --}}
        @php
            $fallbackMaterials = collect([
                [
                    'title' => 'Premium Leather',
                    'subtitle' => 'Crafted to Last',
                    'description' => 'Full-grain leather that molds to your feet over time. Durable, breathable, and always in style — built for daily wear.',
                    'image' => 'material-leather.jpg',
                    'link_text' => 'Shop Leather',
                ],
                [
                    'title' => 'Engineered Mesh',
                    'subtitle' => 'Breathe Easy',
                    'description' => 'Lightweight engineered mesh keeps your feet cool on the move. Flexible, airy, and perfect for warm days.',
                    'image' => 'material-mesh.jpg',
                    'link_text' => 'Shop Mesh',
                ],
                [
                    'title' => 'Knit & Textile',
                    'subtitle' => 'Flexible Fit',
                    'description' => 'Soft knit uppers wrap around your foot for a sock-like feel. Stretch where you need it, support where it counts.',
                    'image' => 'material-knit.jpg',
                    'link_text' => 'Shop Knit',
                ],
                [
                    'title' => 'Classic Suede',
                    'subtitle' => 'Retro Touch',
                    'description' => 'Timeless suede with a velvety finish. A premium texture that instantly upgrades any casual outfit.',
                    'image' => 'material-suede.jpg',
                    'link_text' => 'Shop Suede',
                ],
            ])->map(function ($m) {
                return (object) array_merge($m, [
                    'image_url' => asset('storage/images/upsilon/' . $m['image']),
                    'link' => route('shop'),
                ]);
            });

            $materialSlides = $materials->isNotEmpty() ? $materials : $fallbackMaterials;
        @endphp

        <section class="bg-white py-12" aria-labelledby="materials-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-6 flex items-center justify-between">
                    <h2 id="materials-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Material Spotlight
                    </h2>
                    <div class="flex items-center gap-2">
                        <button type="button" id="material-prev" aria-label="Previous material"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-neutral-200 text-neutral-800 transition hover:bg-neutral-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                        <button type="button" id="material-next" aria-label="Next material"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-neutral-200 text-neutral-800 transition hover:bg-neutral-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div id="material-slider" class="overflow-hidden" aria-roledescription="carousel"
                    aria-label="Material spotlight">
                    <div id="material-track" class="flex transition-transform duration-500 ease-in-out">
                        @foreach ($materialSlides as $mIndex => $material)
                            <div class="w-full flex-shrink-0" role="group" aria-roledescription="slide"
                                aria-label="{{ $mIndex + 1 }} of {{ $materialSlides->count() }}">
                                <div class="grid items-center gap-6 md:grid-cols-2 md:gap-10">
                                    <div class="relative aspect-[4/3] w-full overflow-hidden rounded shadow">
                                        <img src="{{ $material->image_url ?: 'https://placehold.co/800x600/1E2125/FFFFFF?text=' . urlencode($material->title) }}"
                                            alt="{{ $material->title }} material" loading="lazy"
                                            class="h-full w-full object-cover object-center transition duration-500 hover:scale-[1.03]">
                                    </div>
                                    <div class="px-2 md:px-0">
                                        <span
                                            class="text-xs font-bold uppercase tracking-wider text-[#F25C19]">{{ $material->subtitle }}</span>
                                        <h3 class="mt-2 font-impact text-3xl tracking-wider md:text-5xl">{{ $material->title }}
                                        </h3>
                                        <p class="mt-4 max-w-md text-sm leading-relaxed text-neutral-600 md:text-base">
                                            {{ $material->description }}
                                        </p>
                                        <a href="{{ $material->link ?? '#' }}"
                                            class="mt-6 inline-block bg-black px-6 py-2.5 font-condensed text-xs font-bold tracking-wider text-white transition hover:bg-neutral-800">
                                            {{ $material->link_text ?? 'Shop Now' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dot indicators (generated by JavaScript) --}}
                <div id="material-dots" class="mt-6 flex items-center justify-center gap-2"></div>
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
            $activePromoBanners = collect($promoBanners ?? [])->filter(fn($b) => !empty($b->image_url))->values();
        @endphp
        @if($activePromoBanners->isNotEmpty())
            <section class="bg-[#F25C19] " aria-label="Seasonal promotions">
                <div class="mx-auto max-w-7xl px-4 lg:px-8 pb-5">
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
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
                                    </button>
                                    <button type="button" id="promo-next" aria-label="Next banner"
                                        class="absolute right-4 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-black/40 px-3 py-2 text-white transition hover:bg-black/70 md:flex items-center justify-center">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                        </svg>
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
            11. DISCOVER JD STYLE (EDITORIAL)
            ============================================================ --}}
            <section class="pb-12  mt-5" aria-labelledby="editorial-heading">
                <div class="mx-auto max-w-7xl px-4 lg:px-8">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 id="editorial-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                            Discover Upsilon Style
                        </h2>
                        <a href="{{ route('discover-upsilon-style') }}"
                            class="text-xs font-bold uppercase tracking-wider hover:underline">View All</a>
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
            12. CONTACT US
            ============================================================ --}}
            <section class="bg-black py-12 text-white" aria-labelledby="contact-heading">
                <div class="mx-auto max-w-7xl px-4 lg:px-8">
                    <div class="flex flex-col items-center text-center">
                        <h2 id="contact-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                            Contact Us
                        </h2>
                        <p class="mt-2 max-w-xl text-sm text-gray-400">
                            Have a question about sizing, stock, or orders? Reach us directly on our contact page.
                        </p>
                        <a href="{{ route('contact') }}"
                            class="mt-6 inline-block rounded-full bg-brand-yellow px-6 py-2.5 font-condensed text-xs font-bold tracking-wider text-black transition hover:bg-yellow-300">
                            Go to Contact Us
                        </a>
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
                        flashSalePrev.addEventListener('click', function () {
                            scrollByAmount(200); // Scroll left
                        });
                    }
                    if (flashSaleNext) {
                        flashSaleNext.addEventListener('click', function () {
                            scrollByAmount(-200); // Scroll right
                        });
                    }

                    // Touch events for mobile
                    flashSaleScroll.addEventListener('touchstart', touchStart, { passive: true });
                    flashSaleScroll.addEventListener('touchmove', touchMove, { passive: true });
                    flashSaleScroll.addEventListener('touchend', touchEnd);

                    // Scroll event to update arrows
                    flashSaleScroll.addEventListener('scroll', function () {
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
                    var discount = Number(bundle.discount_percent || 0);
                    document.getElementById('bundle-modal-price').textContent = CURRENCY_SYMBOL + price.toLocaleString();
                    document.getElementById('bundle-modal-original').textContent = original > 0 && original > price ? (CURRENCY_SYMBOL + original.toLocaleString()) : '';

                    var discountEl = document.getElementById('bundle-modal-discount');
                    if (discount > 0) {
                        discountEl.classList.remove('hidden');
                        discountEl.textContent = 'Save ' + discount + '%';
                    } else {
                        discountEl.classList.add('hidden');
                        discountEl.textContent = '';
                    }

                    var itemsContainer = document.getElementById('bundle-modal-items');
                    itemsContainer.innerHTML = '';

                    var subBundles = bundle.sub_bundles || [];
                    var totalItemCount = 0;
                    var hasItems = false;

                    subBundles.forEach(function (sb) {
                        var sbItems = (sb.items || []).map(function (i) { i._fromCatalog = true; return i; });
                        var sbManual = (sb.manual_items || []).map(function (i) { i._fromManual = true; return i; });
                        var allSbItems = sbItems.concat(sbManual);

                        if (allSbItems.length === 0) return;

                        hasItems = true;
                        totalItemCount += allSbItems.length;

                        // Sub-bundle accordion item
                        var sbWrapper = document.createElement('div');
                        sbWrapper.className = 'sb-accordion-item pb-2';

                        var sbHeader = document.createElement('button');
                        sbHeader.type = 'button';
                        sbHeader.className = 'sb-accordion-toggle w-full flex items-center justify-between text-left py-2 text-xs font-bold uppercase tracking-tighter text-neutral-500 hover:text-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-neutral-300 rounded';
                        sbHeader.setAttribute('aria-expanded', 'false');
                        sbHeader.innerHTML = '<span class="min-w-0 truncate">' + (sb.name || 'Sub-Bundle') + '</span>' +
                            '<svg class="sb-modal-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';

                        var sbBody = document.createElement('div');
                        sbBody.className = 'sb-accordion-body mt-2 space-y-2 hidden';
                        sbBody.setAttribute('aria-hidden', 'true');

                        allSbItems.forEach(function (item) {
                            var product = item.product || {};
                            var name = product.name || (item.product_name || 'Product');
                            var quantity = item.quantity || 1;

                            // Determine image: use catalog product image if available, otherwise text placeholder
                            var imageHtml;
                            if (product.images && product.images.length) {
                                var image = product.images[0].url || product.images[0].image || '';
                                if (image) {
                                    imageHtml = '<img src="' + image + '" alt="' + name + '" class="h-12 w-12 rounded object-cover">';
                                } else {
                                    imageHtml = '<div class="h-12 w-12 rounded bg-neutral-200 flex items-center justify-center text-neutral-500 text-sm font-bold">' + name.charAt(0).toUpperCase() + '</div>';
                                }
                            } else {
                                imageHtml = '<div class="h-12 w-12 rounded bg-neutral-200 flex items-center justify-center text-neutral-500 text-sm font-bold">' + name.charAt(0).toUpperCase() + '</div>';
                            }

                            var el = document.createElement('div');
                            el.className = 'flex items-center gap-3';
                            el.innerHTML = imageHtml + '<div class="flex-1"><div class="text-sm font-medium text-gray-900">' + name + '</div><div class="text-xs text-gray-500">Qty: ' + quantity + '</div></div>';
                            sbBody.appendChild(el);
                        });

                        sbWrapper.appendChild(sbHeader);
                        sbWrapper.appendChild(sbBody);
                        itemsContainer.appendChild(sbWrapper);

                        sbHeader.addEventListener('click', function () {
                            var expanded = sbHeader.getAttribute('aria-expanded') === 'true';

                            itemsContainer.querySelectorAll('.sb-accordion-toggle').forEach(function (t) {
                                var chev = t.querySelector('.sb-modal-chevron');
                                t.setAttribute('aria-expanded', 'false');
                                t.classList.remove('is-expanded');
                                t.nextElementSibling.classList.add('hidden');
                                if (chev) chev.style.transform = '';
                            });

                            if (!expanded) {
                                sbHeader.setAttribute('aria-expanded', 'true');
                                sbHeader.classList.add('is-expanded');
                                sbBody.classList.remove('hidden');
                                var chev = sbHeader.querySelector('.sb-modal-chevron');
                                if (chev) chev.style.transform = 'rotate(180deg)';
                            }
                        });
                    });

                    if (!hasItems) {
                        itemsContainer.innerHTML = '<div class="text-center text-sm text-neutral-400 py-4">No items</div>';
                    }

                    var firstToggle = itemsContainer.querySelector('.sb-accordion-toggle');
                    if (firstToggle && hasItems) firstToggle.click();

                    if (totalItemCount > 12) {
                        var moreEl = document.createElement('div');
                        moreEl.className = 'text-xs text-gray-500 mt-3';
                        moreEl.textContent = '+ ' + (totalItemCount - 12) + ' more items';
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
                    7. ABOUT SLIDER
                    ===================================================== */
                var aboutTrack = document.getElementById('about-track');
                var aboutPrev = document.getElementById('about-prev');
                var aboutNext = document.getElementById('about-next');
                var aboutDotsBox = document.getElementById('about-dots');

                if (aboutTrack && aboutPrev && aboutNext) {
                    var aboutSlides = aboutTrack.children;
                    var aboutTotal = aboutSlides.length;
                    var aboutIndex = 0;
                    var aboutDots = [];

                    function updateAbout() {
                        aboutTrack.style.transform = 'translateX(-' + (aboutIndex * 100) + '%)';
                        aboutDots.forEach(function (dot, i) {
                            dot.classList.toggle('bg-black', i === aboutIndex);
                            dot.classList.toggle('w-6', i === aboutIndex);
                            dot.classList.toggle('bg-gray-300', i !== aboutIndex);
                            dot.classList.toggle('w-2.5', i !== aboutIndex);
                        });
                    }

                    if (aboutDotsBox) {
                        for (var ai = 0; ai < aboutTotal; ai++) {
                            (function (idx) {
                                var dot = document.createElement('button');
                                dot.type = 'button';
                                dot.className = 'h-2.5 w-2.5 rounded-full bg-gray-300 transition-all duration-300';
                                dot.setAttribute('aria-label', 'Go to about slide ' + (idx + 1));
                                dot.addEventListener('click', function () {
                                    aboutIndex = idx;
                                    updateAbout();
                                });
                                aboutDotsBox.appendChild(dot);
                                aboutDots.push(dot);
                            })(ai);
                        }
                    }

                    aboutPrev.addEventListener('click', function () {
                        aboutIndex = (aboutIndex - 1 + aboutTotal) % aboutTotal;
                        updateAbout();
                    });

                    aboutNext.addEventListener('click', function () {
                        aboutIndex = (aboutIndex + 1) % aboutTotal;
                        updateAbout();
                    });

                    // Touch swipe support
                    var aboutStartX = 0;
                    aboutTrack.addEventListener('touchstart', function (e) {
                        aboutStartX = e.touches[0].clientX;
                    }, { passive: true });
                    aboutTrack.addEventListener('touchend', function (e) {
                        var diff = e.changedTouches[0].clientX - aboutStartX;
                        if (diff < -50) {
                            aboutIndex = (aboutIndex + 1) % aboutTotal;
                            updateAbout();
                        } else if (diff > 50) {
                            aboutIndex = (aboutIndex - 1 + aboutTotal) % aboutTotal;
                            updateAbout();
                        }
                    });

                    updateAbout();
                }

                /* =====================================================
                    8. PROMO BANNER SLIDER
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

                /* =====================================================
                    9. MOBILE PROMO BANNER SLIDER
                    ===================================================== */
                var promoMobileTrack = document.getElementById('promo-mobile-banner-track');
                var promoMobilePrev = document.getElementById('promo-mobile-prev');
                var promoMobileNext = document.getElementById('promo-mobile-next');
                var promoMobileIndex = 0;

                if (promoMobileTrack && promoMobilePrev && promoMobileNext) {
                    var promoMobileSlides = promoMobileTrack.children;
                    var promoMobileTotal = promoMobileSlides.length;

                    function updatePromoMobile() {
                        promoMobileTrack.style.transform = 'translateX(-' + (promoMobileIndex * 100) + '%)';
                    }

                    promoMobilePrev.addEventListener('click', function () {
                        promoMobileIndex = (promoMobileIndex - 1 + promoMobileTotal) % promoMobileTotal;
                        updatePromoMobile();
                    });

                    promoMobileNext.addEventListener('click', function () {
                        promoMobileIndex = (promoMobileIndex + 1) % promoMobileTotal;
                        updatePromoMobile();
                    });

                    // Touch swipe support
                    var promoMobileStartX = 0;
                    promoMobileTrack.addEventListener('touchstart', function (e) {
                        promoMobileStartX = e.touches[0].clientX;
                    }, { passive: true });
                    promoMobileTrack.addEventListener('touchend', function (e) {
                        var diff = e.changedTouches[0].clientX - promoMobileStartX;
                        if (diff < -50) {
                            promoMobileIndex = (promoMobileIndex + 1) % promoMobileTotal;
                            updatePromoMobile();
                        } else if (diff > 50) {
                            promoMobileIndex = (promoMobileIndex - 1 + promoMobileTotal) % promoMobileTotal;
                            updatePromoMobile();
                        }
                    });
                }

                /* =====================================================
                   6. MATERIAL SLIDER
                   ===================================================== */
                var materialTrack = document.getElementById('material-track');
                var materialPrev = document.getElementById('material-prev');
                var materialNext = document.getElementById('material-next');
                var materialDotsBox = document.getElementById('material-dots');

                if (materialTrack && materialPrev && materialNext) {
                    var materialSlides = materialTrack.children;
                    var materialTotal = materialSlides.length;
                    var materialIndex = 0;
                    var materialDots = [];

                    function updateMaterial() {
                        materialTrack.style.transform = 'translateX(-' + (materialIndex * 100) + '%)';
                        materialDots.forEach(function (dot, i) {
                            dot.classList.toggle('bg-black', i === materialIndex);
                            dot.classList.toggle('w-6', i === materialIndex);
                            dot.classList.toggle('bg-gray-300', i !== materialIndex);
                            dot.classList.toggle('w-2.5', i !== materialIndex);
                        });
                    }

                    if (materialDotsBox) {
                        for (var mi = 0; mi < materialTotal; mi++) {
                            (function (idx) {
                                var dot = document.createElement('button');
                                dot.type = 'button';
                                dot.className = 'h-2.5 w-2.5 rounded-full bg-gray-300 transition-all duration-300';
                                dot.setAttribute('aria-label', 'Go to material ' + (idx + 1));
                                dot.addEventListener('click', function () {
                                    materialIndex = idx;
                                    updateMaterial();
                                });
                                materialDotsBox.appendChild(dot);
                                materialDots.push(dot);
                            })(mi);
                        }
                    }

                    materialPrev.addEventListener('click', function () {
                        materialIndex = (materialIndex - 1 + materialTotal) % materialTotal;
                        updateMaterial();
                    });

                    materialNext.addEventListener('click', function () {
                        materialIndex = (materialIndex + 1) % materialTotal;
                        updateMaterial();
                    });

                    // Touch swipe support
                    var materialStartX = 0;
                    materialTrack.addEventListener('touchstart', function (e) {
                        materialStartX = e.touches[0].clientX;
                    }, { passive: true });
                    materialTrack.addEventListener('touchend', function (e) {
                        var diff = e.changedTouches[0].clientX - materialStartX;
                        if (diff < -50) {
                            materialIndex = (materialIndex + 1) % materialTotal;
                            updateMaterial();
                        } else if (diff > 50) {
                            materialIndex = (materialIndex - 1 + materialTotal) % materialTotal;
                            updateMaterial();
                        }
                    });

                    updateMaterial();
                }
            });
        </script>

        <style>
            .sb-modal-chevron {
                transition: transform 0.2s ease;
                color: #6b7280;
                flex-shrink: 0;
            }

            /* Mobile promo banner */
            #promo-mobile-banner-slider {
                width: 100%;
            }

            #promo-mobile-banner-track {
                width: 100%;
            }

            #promo-mobile-banner-slider img {
                width: 100%;
                height: auto;
                display: block;
            }
        </style>

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
                <div id="bundle-modal-discount"
                    class="mt-2 inline-block text-xs font-bold uppercase tracking-tighter px-2 py-0.5 rounded bg-yellow-50 text-yellow-700 hidden">
                </div>
                <div class="mt-4 flex items-center gap-3">
                    <span id="bundle-modal-price" class="text-lg font-bold text-gray-900"></span>
                    <span id="bundle-modal-original" class="text-sm text-gray-500 line-through"></span>
                </div>
                <a id="bundle-modal-cta" href="#" target="_blank" rel="noopener"
                    class="mt-4 inline-flex w-full items-center justify-center rounded bg-yellow-400 px-4 py-2 text-sm font-bold text-black hover:bg-yellow-300">Order
                    Bundle</a>
            </div>
        </div>
@endsection