@extends('layouts.home')

@section('title', 'Upsilon Store')
@section('description', 'T-shirts from top brands. Free shipping nationwide.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    @include('components.promo-bar')

    @php
        $activeFilterCount = collect([
            request('category'),
            request('sizes') ? count((array) request('sizes')) : null,
            request('colors') ? count((array) request('colors')) : null,
            request('price_max') && request('price_max') < $maxPrice ? 1 : null,
        ])->filter()->count();
    @endphp

    <main id="main-content">

        <!-- BEGIN: Catalog Controls / Toolbar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-8 mt-5">
            <div class="flex flex-wrap items-center justify-between border-b border-neutral-200 pb-3 mb-6 gap-3">
                <div class="flex items-center gap-3">
                    {{-- Mobile Filter Toggle Button --}}
                    <button type="button" id="mobile-filter-btn"
                        class="lg:hidden flex items-center gap-2 border border-neutral-300 rounded-sm px-3 py-1.5 text-xs font-bold uppercase tracking-wide bg-white hover:bg-black hover:text-white hover:border-black transition-colors relative">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                        </svg>
                        Filter
                        @if($activeFilterCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-black text-white text-[9px] font-black rounded-full flex items-center justify-center">{{ $activeFilterCount }}</span>
                        @endif
                    </button>

                    <label class="text-neutral-500 font-medium text-xs hidden sm:block" for="sort-select">Urutkan:</label>
                    <select class="border border-neutral-300 rounded px-3 py-1.5 text-xs bg-white focus:ring-0 focus:border-black cursor-pointer" id="sort-select">
                        <option value="{{ route('shop', request()->except('sort')) }}" {{ !request('sort') ? 'selected' : '' }}>Rekomendasi</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ route('shop', array_merge(request()->except('sort'), ['sort' => 'bestseller'])) }}" {{ request('sort') == 'bestseller' ? 'selected' : '' }}>Diskon Terbesar</option>
                    </select>
                </div>
                <div class="text-neutral-600 text-xs font-medium">
                    <span>{{ $products->total() }} Produk</span>
                </div>
            </div>
        </div>
        <!-- END: Catalog Controls / Toolbar -->

        {{-- ========================================================= --}}
        {{-- MOBILE FILTER DRAWER (hidden by default, slide up on open) --}}
        {{-- ========================================================= --}}

        {{-- Overlay --}}
        <div id="filter-overlay"
            class="fixed inset-0 z-40 bg-black/50 hidden lg:hidden"
            aria-hidden="true"></div>

        {{-- Drawer panel --}}
        <div id="mobile-filter-drawer"
            class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-2xl shadow-2xl transform translate-y-full transition-transform duration-300 ease-in-out lg:hidden"
            style="max-height: 85vh; overflow-y: auto;"
            aria-label="Filter produk">

            {{-- Drawer Header --}}
            <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-neutral-200 sticky top-0 bg-white z-10">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    <span class="text-sm font-extrabold uppercase tracking-wide text-neutral-900">Filter Produk</span>
                    @if($activeFilterCount > 0)
                        <span class="text-[10px] bg-black text-white font-bold px-2 py-0.5 rounded-full">{{ $activeFilterCount }} aktif</span>
                    @endif
                </div>
                <button type="button" id="close-filter-btn"
                    class="w-8 h-8 flex items-center justify-center text-neutral-500 hover:text-black rounded-full hover:bg-neutral-100 transition-colors"
                    aria-label="Tutup filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Drawer Filter Form --}}
            <form method="GET" action="{{ route('shop') }}" id="mobile-filter-form" class="px-5 py-4 space-y-5 divide-y divide-neutral-100">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                {{-- Category --}}
                <div class="pt-1">
                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-3">Kategori</p>
                    <div class="space-y-2 text-neutral-600">
                        @foreach($categories as $category)
                            <label class="flex items-center justify-between cursor-pointer hover:text-black">
                                <span class="flex items-center gap-2.5 text-sm">
                                    <input type="radio" name="category" value="{{ $category->slug }}"
                                        {{ request('category') == $category->slug ? 'checked' : '' }}
                                        class="rounded border-neutral-300 text-black focus:ring-0 w-4 h-4"/>
                                    {{ $category->name }}
                                </span>
                                <span class="text-neutral-400 text-xs">{{ $category->products_count ?? 0 }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Size --}}
                @if($sizes->isNotEmpty())
                    <div class="pt-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-3">Ukuran</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($sizes as $size)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="sizes[]" value="{{ $size->id }}"
                                        {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'checked' : '' }}
                                        class="sr-only peer"/>
                                    <span class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold border border-neutral-300 rounded-sm peer-checked:bg-black peer-checked:text-white peer-checked:border-black hover:border-black transition-colors">
                                        {{ $size->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Color --}}
                @if($colors->where('variants_count', '>', 0)->isNotEmpty())
                    <div class="pt-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-3">Warna</p>
                        <div class="flex flex-wrap gap-2  p-4">
                            @foreach($colors->where('variants_count', '>', 0) as $color)
                                <label class="relative cursor-pointer group mt-4">
                                    <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                        {{ is_array(request('colors')) && in_array($color->id, request('colors')) ? 'checked' : '' }}
                                        class="sr-only peer"/>
                                    <span class="inline-block w-8 h-8 rounded-full border-2 border-neutral-300 transition-all
                                        bg-[{{ $color->hex_code ?? '#ccc' }}]
                                        peer-checked:ring-2 peer-checked:ring-black peer-checked:ring-offset-2
                                        hover:ring-2 hover:ring-neutral-500"
                                        title="{{ $color->name }}"
                                        style="{{ $color->hex_code ? 'background-color: ' . $color->hex_code : '' }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Price --}}
                <div class="pt-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-3">Harga Maksimum</p>
                    <input type="range" class="w-full" max="{{ $maxPrice }}" min="0" name="price_max"
                        value="{{ request('price_max', $maxPrice) }}"
                        oninput="document.getElementById('m-price-max-display').textContent = CURRENCY_SYMBOL + new Intl.NumberFormat('en-US', {minimumFractionDigits: CURRENCY_DECIMALS, maximumFractionDigits: CURRENCY_DECIMALS}).format(this.value)"/>
                    <div class="text-xs text-neutral-500 mt-2">
                        Hingga <span class="font-semibold text-black" id="m-price-max-display">{{ currency_format(request('price_max', $maxPrice)) }}</span>
                    </div>
                    <input type="hidden" name="price_min" value="{{ request('price_min', 0) }}">
                </div>

                {{-- Actions --}}
                <div class="pt-4 flex gap-3 pb-2">
                    <a href="{{ route('shop') }}"
                        class="flex-1 text-center border border-neutral-300 text-xs font-bold uppercase tracking-wide py-3 rounded-sm hover:border-black hover:text-black transition-colors">
                        Reset
                    </a>
                    <button type="submit"
                        class="flex-1 bg-black text-white text-xs font-bold uppercase tracking-wider py-3 rounded-sm hover:bg-neutral-800 transition-colors">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- BEGIN: Two-Column Product & Filter Layout -->
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pb-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- BEGIN: Left Filter Sidebar (desktop only) -->
                <aside class="hidden lg:block lg:col-span-3 space-y-5 divide-y divide-neutral-200">
                    <form method="GET" action="{{ route('shop') }}" id="filter-form">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <!-- Filter: Category -->
                        <div class="pt-2">
                            <p class="text-xs font-bold uppercase tracking-wide py-2 text-neutral-900">Category</p>
                            <div class="mt-2 space-y-1.5 text-neutral-600">
                                @foreach($categories as $category)
                                    <label class="flex items-center justify-between cursor-pointer hover:text-black">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} class="rounded border-neutral-300 text-black focus:ring-0 w-3.5 h-3.5"/>
                                            {{ $category->name }}
                                        </span>
                                        <span class="text-neutral-400 text-[10px]">{{ $category->products_count ?? 0 }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter: Size -->
                        <div class="pt-4">
                            <p class="text-xs font-bold uppercase tracking-wide py-1 text-neutral-900">Size</p>
                            <div class="mt-2 space-y-1 text-neutral-600 max-h-36 overflow-y-auto">
                                @foreach($sizes as $size)
                                    <label class="flex items-center justify-between cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="checkbox" name="sizes[]" value="{{ $size->id }}" {{ is_array(request('sizes')) && in_array($size->id, request('sizes')) ? 'checked' : '' }} class="rounded border-neutral-300 text-black focus:ring-0 w-3.5 h-3.5"/>
                                            {{ $size->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter: Color -->
                        <div class="pt-4">
                            <p class="text-xs font-bold uppercase tracking-wide py-1 text-neutral-900">Color</p>
                            <div class="mt-2 pt-4 flex flex-wrap gap-2 max-h-40 overflow-y-auto pr-1">
@foreach($colors->where('variants_count', '>', 0) as $color)
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="colors[]" value="{{ $color->id }}" {{ is_array(request('colors')) && in_array($color->id, request('colors')) ? 'checked' : '' }} class="sr-only peer"/>
                                        <span class="inline-block w-7 h-7 rounded-full border-2 border-neutral-300 transition-all
                                            bg-[{{ $color->hex_code ?? '#ccc' }}]
                                            peer-checked:ring-2 peer-checked:ring-black peer-checked:ring-offset-2
                                            hover:ring-2 hover:ring-neutral-500"
                                            title="{{ $color->name }}"
                                            style="{{ $color->hex_code ? 'background-color: ' . $color->hex_code : '' }}"></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter: Harga Slider -->
                        <div class="pt-4">
                            <p class="text-xs font-bold uppercase tracking-wide py-1 text-neutral-900">Harga</p>
                            <div class="mt-3">
                                <input type="range" class="w-full" max="{{ $maxPrice }}" min="0" name="price_max" value="{{ request('price_max', $maxPrice) }}" oninput="document.getElementById('price-max-display').textContent = CURRENCY_SYMBOL + new Intl.NumberFormat('en-US', {minimumFractionDigits: CURRENCY_DECIMALS, maximumFractionDigits: CURRENCY_DECIMALS}).format(this.value)"/>
                                <div class="text-[11px] text-neutral-500 mt-2">
                                    From <span class="font-semibold text-black">{{ currency_format(0) }}</span> - To <span class="font-semibold text-black" id="price-max-display">{{ currency_format(request('price_max', $maxPrice)) }}</span>
                                </div>
                                <input type="hidden" name="price_min" value="{{ request('price_min', 0) }}">
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('shop') }}"
                                class="flex-1 text-center border border-neutral-300 text-xs font-bold uppercase tracking-wide py-2.5 rounded-sm hover:border-black hover:text-black transition-colors">
                                Reset
                            </a>
                            <button type="submit"
                                class="flex-1 bg-neutral-900 text-white text-xs font-bold uppercase tracking-wider py-2.5 rounded-sm hover:bg-neutral-800 transition-colors">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </aside>
                <!-- END: Left Filter Sidebar -->

             <!-- BEGIN: Product Grid -->
    <section class="lg:col-span-9">
         @php
             $shopSliders = $sliders ?? collect();
             $shopPromoBanners = $promoBanners ?? collect();
             $activeShopBanner = $shopSliders->first() ?? $shopPromoBanners->first();
             $labelSlug = request('label');
             $labelsList = $labels ?? collect();
             $activeLabel = $labelSlug ? $labelsList->firstWhere('slug', $labelSlug) : null;

             $bannerHeading = $activeShopBanner->heading ?? $activeShopBanner->title ?? 'SALE UP TO 50%';
             $bannerDescription = $activeShopBanner->description ?? 'Belanja di Upsilon Indonesia dan temukan koleksi t-shirt premium dari top brand favorit. Nikmati Gratis Ongkir* T&C apply.';
             $bannerLink = $activeShopBanner->link ?? '#';

             if ($activeLabel) {
                 $bannerHeading = $activeLabel->name ?? $bannerHeading;
                 $bannerDescription = $activeLabel->name ?? $bannerDescription;
                 $bannerImage = $activeLabel->image_url ?? $bannerImage;
                 $bannerLink = route('shop', ['label' => $activeLabel->slug]);
             } else {
                 $bannerImage = $activeShopBanner->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBqa9m3lb9KcsVzCYZK_d6f8NWkO8oTp-gjtxFrYl-hOqNJmjVs-gmhLJnrs4EZimhXcr95IcI_9hZhePlDkI7xToE0nDXUzgp5D77n-eqscfnk9sWczc81OrzmVPe5mHY1_AjxRfOIcVxEH4ze5IiOZ-2vhpgAwWNxdGBIvCr-uOe4wCdnzXxm2qn6BZhhVUMQPi0QByaizlPFFHUnEbncAUdACNtF9-TqWRbPdOU06vAe9NQ8png-';
             }
         @endphp

         @if(request('label'))
             <a href="{{ $bannerLink }}" class="block rounded-sm overflow-hidden mb-6">
                 <section class="bg-[#4d5156] text-white rounded-sm overflow-hidden relative">
                     <!-- Menggunakan Flexbox agar Kiri Konten & Kanan Gambar konsisten berdampingan -->
                     <div class="flex flex-row items-center justify-between p-6 md:p-8 gap-4">
                         
                         <!-- KIRI: Konten Teks -->
                         <div class="flex-1 min-w-0 z-10">
                             <h1 class="text-2xl md:text-4xl font-extrabold uppercase tracking-tight mb-2 truncate">{{ $bannerHeading }}</h1>
                             <p class="text-xs text-neutral-300 max-w-xl leading-relaxed mb-4 line-clamp-3">
                                 {{ $bannerDescription }}
                             </p>
<div class="flex flex-wrap gap-2 text-[11px]">
    <span class="border border-white/80 px-3 py-1 rounded-sm font-medium">T-Shirts Up To 50% Off</span>
    <span class="border border-white/80 px-3 py-1 rounded-sm font-medium">New Arrivals Daily</span>
</div>
                         </div>

                         <!-- KANAN: Gambar -->
                         <div class="w-1/3 md:w-5/12 flex-shrink-0 flex justify-end">
                             <img alt="Great Deals Up to 50% Off" class="max-h-32 md:max-h-44 object-contain" src="{{ $bannerImage }}"/>
                         </div>

                     </div>
                 </section>
             </a>
         @endif

         <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-8">
             @forelse($products as $product)
                 <x-product-card :product="$product" />
             @empty
                 <div class="col-span-full text-center py-20">
                     <p class="text-neutral-500">Tidak ada produk ditemukan.</p>
                 </div>
             @endforelse
         </div>

        <!-- BEGIN: Pagination Section -->
        @if($products->hasPages())
            <div class="mt-12 flex flex-wrap items-center justify-between border-t border-neutral-200 pt-6">
                <div class="flex items-center space-x-1">
                    {{ $products->links('components.pagination', ['paginator' => $products]) }}
                </div>
                <div class="text-neutral-500 text-xs">
                    {{ $products->total() }} Produk | <a class="font-bold text-black hover:underline" href="#">Lihat Lebih Banyak</a>
                </div>
            </div>
        @endif
        <!-- END: Pagination Section -->
    </section>
    <!-- END: Product Grid -->

            </div>
        </div>
        <!-- END: Two-Column Product & Filter Layout -->

<!-- BEGIN: SEO Informational Footer Content -->
       {{-- ============================================================
        9. SEASONAL SPOTLIGHT BANNERS
        ============================================================ --}}
        @php
            $activePromoBanners = collect($promoBanners ?? [])->filter(fn ($b) => !empty($b->image_url))->values();
        @endphp
        @if($activePromoBanners->isNotEmpty())
            <section class="py-4" aria-label="Seasonal promotions">
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

        <!-- END: SEO Informational Footer Content -->
    </main>

  

    <!-- END: Sticky Cookie Consent Banner -->

    <!-- Script Section -->
    <script>
        var CURRENCY_SYMBOL = @json($siteSettings['currency_symbol'] ?: '$');
        var CURRENCY_DECIMALS = @json($siteSettings['currency_decimals'] ?? 2);

        (function () {
            // Sort select redirect
            const sortSelect = document.getElementById('sort-select');
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    window.location.href = this.value;
                });
            }

            // Mobile filter drawer
            const filterBtn    = document.getElementById('mobile-filter-btn');
            const closeBtn     = document.getElementById('close-filter-btn');
            const drawer       = document.getElementById('mobile-filter-drawer');
            const overlay      = document.getElementById('filter-overlay');

            function openDrawer() {
                if (!drawer || !overlay) return;
                overlay.classList.remove('hidden');
                // Force reflow so transition plays
                drawer.getBoundingClientRect();
                drawer.classList.remove('translate-y-full');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                if (!drawer || !overlay) return;
                drawer.classList.add('translate-y-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }

            if (filterBtn) filterBtn.addEventListener('click', openDrawer);
            if (closeBtn)  closeBtn.addEventListener('click', closeDrawer);
            if (overlay)   overlay.addEventListener('click', closeDrawer);

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeDrawer();
            });
        })();
    </script>
@endsection