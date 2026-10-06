@extends("layouts.home")

@php
    $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
    $pageTitle = $product->name . ' - ' . config('app.name', 'Upsilon Store');
    $pageDescription = Str::limit(strip_tags($product->description ?? 'Sneakers, apparel, and accessories from Upsilon Store.'), 160);
    $pageImage = $primaryImage?->url ?? asset('storage/images/sample/prod-trench.jpg');

    // Calculate variant price range
    $activeVariants = $product->variants->filter(fn($v) => $v->is_active);
    $variantPrices = $activeVariants->map(fn($v) => $v->effective_price)->filter()->unique()->sort()->values();
    $variantBasePrices = $activeVariants->map(fn($v) => $v->effective_base_price)->filter()->unique()->sort()->values();

    $minPrice = $variantPrices->first() ?? $product->sale_price ?? $product->base_price;
    $maxPrice = $variantPrices->last() ?? $product->base_price;
    $minBasePrice = $variantBasePrices->first() ?? $product->base_price;
    $maxBasePrice = $variantBasePrices->last() ?? $product->base_price;

    $showPriceRange = $variantPrices->count() > 1 && $minPrice != $maxPrice;
    $hasOverallDiscount = ($product->sale_price && $product->sale_price < $product->base_price) || ($minBasePrice && $minPrice < $minBasePrice);
    $baseDiscountPercent = $product->discount_percent > 0 ? $product->discount_percent : (
        ($minBasePrice > $minPrice && $minBasePrice > 0) ? round((($minBasePrice - $minPrice) / $minBasePrice) * 100) : 0
    );

    $colorsList = $product->variants->filter(fn($v) => $v->color !== null)->unique('color_id')->values();
    $sizesList = $product->variants->filter(fn($v) => $v->size !== null)->unique('size_id')->values();
    $reviewsList = $product->approvedReviews ?? collect();
    $hasReviews = $reviewsList->count() > 0;
    $avgRating = $product->average_rating ? round($product->average_rating, 1) : 0;
    $reviewCount = $product->review_count ?? 0;

    $variantData = $product->variants->map(function ($v) {
        return [
            'id' => $v->id,
            'color_id' => $v->color_id,
            'size_id' => $v->size_id,
            'price' => $v->effective_price ?? $v->price ?? null,
            'base_price' => $v->effective_base_price ?? $v->base_price ?? null,
            'stock' => $v->unlimited_stock ? 9999 : ($v->stock ?? 0),
            'sku' => $v->sku ?? null,
        ];
    })->values();
@endphp

@section("title", $pageTitle)
@section("description", $pageDescription)
@section("ogUrl", url()->current())
@section("ogImage", $pageImage)

    @push("head")
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => $pageDescription,
    'image' => [$pageImage],
    'brand' => [
        '@type' => 'Brand',
        'name' => $product->subtitle ?? config('app.name', 'Upsilon Store'),
    ],
    'offers' => [
        '@type' => 'Offer',
        'price' => $minPrice,
        'priceCurrency' => 'USD',
        'availability' => 'https://schema.org/InStock',
        'url' => url()->current(),
    ],
    'aggregateRating' => $reviewCount > 0 ? [
        '@type' => 'AggregateRating',
        'ratingValue' => $avgRating,
        'reviewCount' => $reviewCount,
    ] : null,
]), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@push('scripts')
<script>
    var CURRENCY_SYMBOL = @json($siteSettings['currency_symbol'] ?: '$');
    var CURRENCY_DECIMALS = @json($siteSettings['currency_decimals'] ?? 2);
    window.productVariantData = @json($variantData);
</script>
@endpush

@section("content")
    {{-- Breadcrumb --}}
    <div class="border-b border-neutral-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-3 text-[11px] text-neutral-500">
            <nav class="flex items-center flex-wrap gap-2" aria-label="Breadcrumb">
                <a class="hover:text-black hover:underline" href="{{ route('home') }}">Home</a>
                <span class="text-neutral-300">/</span>
                <a class="hover:text-black hover:underline" href="{{ route('shop') }}">Shop</a>
                @if($product->category)
                    <span class="text-neutral-300">/</span>
                    <a class="hover:text-black hover:underline" href="{{ route('shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                @endif
                <span class="text-neutral-300">/</span>
                <span class="text-neutral-900 font-semibold truncate max-w-xs sm:max-w-md">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    {{-- Flash Status Message --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold ml-4">✕</button>
            </div>
        </div>
    @endif

    {{-- Main Product Showcase Section --}}
    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-8 py-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            {{-- LEFT COLUMN: Gallery & Images --}}
            <div class="lg:col-span-7">
                <div class="sticky top-28 space-y-4">
                    {{-- Main Image Container --}}
                    <div id="zoom-container" class="relative bg-neutral-100 rounded-sm aspect-square sm:aspect-[4/5] overflow-hidden border border-neutral-200 flex items-center justify-center shadow-xs" style="cursor:zoom-in;">
                        @if($primaryImage)
                            <img id="main-product-image" src="{{ $primaryImage->url }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-opacity duration-200 ease-out select-none"
                                style="transform-origin:center center; transform:scale(1) translate(0px,0px); transition: opacity 0.2s ease, transform 0.15s ease; will-change:transform;"
                                draggable="false">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-neutral-100 text-neutral-400">
                                <svg class="w-12 h-12 mb-2 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-xs uppercase font-semibold tracking-wider">No Image Available</span>
                            </div>
                        @endif

                        {{-- Zoom Controls Overlay --}}
                        <div id="zoom-controls" class="absolute bottom-3 right-3 flex flex-col gap-1 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-200" style="opacity:0;">
                            <button type="button" id="zoom-in-btn" title="Zoom In"
                                class="w-8 h-8 rounded-sm bg-white/90 border border-neutral-200 shadow flex items-center justify-center text-neutral-700 hover:bg-black hover:text-white hover:border-black transition-colors text-base font-bold">
                                +
                            </button>
                            <button type="button" id="zoom-out-btn" title="Zoom Out"
                                class="w-8 h-8 rounded-sm bg-white/90 border border-neutral-200 shadow flex items-center justify-center text-neutral-700 hover:bg-black hover:text-white hover:border-black transition-colors text-base font-bold">
                                −
                            </button>
                            <button type="button" id="zoom-reset-btn" title="Reset Zoom"
                                class="w-8 h-8 rounded-sm bg-white/90 border border-neutral-200 shadow flex items-center justify-center text-neutral-700 hover:bg-black hover:text-white hover:border-black transition-colors" style="font-size:10px;font-weight:700;">
                                1:1
                            </button>
                        </div>

                        {{-- Top Left Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                            @if($product->category)
                                <span class="bg-black/90 text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-xs backdrop-blur-xs">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if($product->edition)
                                <span class="bg-neutral-800/80 text-neutral-100 text-[9px] font-medium tracking-wide px-2 py-0.5 rounded-xs">
                                    {{ $product->edition }}
                                </span>
                            @endif
                        </div>

                        {{-- Top Right Labels & Discount --}}
                        <div class="absolute top-3 right-3 flex flex-col items-end gap-1.5 z-10">
                            @if($product->labels->isNotEmpty())
                                @foreach($product->labels->take(2) as $label)
                                    @if($label->image)
                                        <img src="{{ $label->image_url }}" alt="{{ $label->name }}" class="h-5 w-auto object-contain drop-shadow">
                                    @else
                                        <span class="inline-block px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-xs shadow-xs" style="background-color: {{ $label->color ?? '#000' }}; color: {{ $label->text_color ?? '#fff' }};">
                                            {{ $label->name }}
                                        </span>
                                    @endif
                                @endforeach
                            @endif

                            <span id="badge-discount" class="{{ $baseDiscountPercent > 0 ? '' : 'hidden' }} bg-brand-orange text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-xs shadow-sm">
                                Save <span id="badge-discount-val">{{ $baseDiscountPercent }}</span>%
                            </span>
                        </div>
                    </div>

                    {{-- Thumbnails Row --}}
                    @if($product->images->count() > 1)
                        <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none" id="product-thumbnails">
                            @foreach($product->images as $index => $image)
                                <button type="button"
                                    class="thumbnail-btn shrink-0 w-16 h-16 sm:w-20 sm:h-20 aspect-square overflow-hidden bg-neutral-100 rounded-sm border-2 transition-all duration-200 cursor-pointer {{ $index === 0 ? 'border-black ring-1 ring-black' : 'border-neutral-200 hover:border-neutral-400 opacity-70 hover:opacity-100' }}"
                                    data-image-src="{{ $image->url }}"
                                    data-index="{{ $index }}"
                                    aria-label="Show image {{ $index + 1 }}">
                                    <img src="{{ $image->url }}" alt="{{ $product->name }} thumb {{ $index + 1 }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT COLUMN: Product Information & Controls --}}
            <div class="lg:col-span-5 flex flex-col justify-start">
                <div class="space-y-6">

                    {{-- Category / Subtitle & Title --}}
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-neutral-500 mb-1.5">
                            <span>{{ $product->subtitle ?? $product->category->name ?? 'Upsilon' }}</span>
                            @if($product->category)
                                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-black hover:underline normal-case text-[11px] font-medium text-neutral-400">
                                    {{ $product->category->name }}
                                </a>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 tracking-tight leading-tight">
                            {{ $product->name }}
                        </h1>

                        {{-- Rating Summary Row --}}
                        {{-- <div class="flex items-center gap-3 mt-3">
                            <div class="flex items-center gap-1 text-brand-orange">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-neutral-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                                    <span>{{ $avgRating > 0 ? number_format($avgRating, 1) : 'No reviews yet' }}</span>
                            <span class="text-neutral-300">|</span>
                            <a href="#reviews-section" class="text-xs text-neutral-500 hover:text-black hover:underline">
                                {{ $reviewCount }} Reviews
                            </a>
                        </div> --}}
                    </div>

                    {{-- Price Display --}}
                    <div class="border-y border-neutral-200 py-4" id="price-section">
                        <div class="flex items-baseline gap-3 flex-wrap" id="price-display-wrapper">
                            @if($showPriceRange)
                                <span class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight" id="main-price-val">
                                    {{ currency_format($minPrice) }} - {{ currency_format($maxPrice) }}
                                </span>
                                @if($hasOverallDiscount)
                                    <span class="text-sm text-neutral-400 line-through" id="main-base-price-val">
                                        {{ currency_format($minBasePrice) }} - {{ currency_format($maxBasePrice) }}
                                    </span>
                                @endif
                            @elseif($hasOverallDiscount)
                                <span class="text-2xl sm:text-3xl font-black text-brand-orange tracking-tight" id="main-price-val">
                                    {{ currency_format($minPrice) }}
                                </span>
                                <span class="text-sm text-neutral-400 line-through" id="main-base-price-val">
                                    {{ currency_format($minBasePrice) }}
                                </span>
                            @else
                                <span class="text-2xl sm:text-3xl font-black text-neutral-900 tracking-tight" id="main-price-val">
                                    {{ currency_format($minPrice) }}
                                </span>
                                <span class="text-sm text-neutral-400 line-through hidden" id="main-base-price-val"></span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-2 text-[11px] text-neutral-500 font-medium">
                            <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-xs font-semibold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                 100% Authentic &amp; Guaranteed
                            </span>
                            <span>•</span>
                                 <span>Free Shipping Indonesia-wide*</span>
                        </div>
                    </div>

                    {{-- Variant Selectors (Color & Size) --}}
                    <div class="space-y-5">

                        {{-- Color Swatches --}}
                        @if($colorsList->isNotEmpty())
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-neutral-800 mb-2">
                                    <span>Color Options: <span id="selected-color-label" class="text-neutral-500 font-normal">Select color</span></span>
                                </div>
                                <div class="flex flex-wrap gap-2.5">
                                    @foreach($colorsList as $variant)
                                        @if($variant->color)
                                            <button type="button"
                                                class="color-swatch-btn relative w-9 h-9 rounded-full border-2 border-neutral-300 hover:border-black transition-all duration-200 flex items-center justify-center p-0.5"
                                                style="background-color: {{ $variant->color->hex_code ?? '#111' }}"
                                                data-color-id="{{ $variant->color_id }}"
                                                data-color-name="{{ $variant->color->name }}"
                                                title="{{ $variant->color->name }}"
                                                aria-label="Select color {{ $variant->color->name }}">
                                                <span class="swatch-check hidden text-white text-xs drop-shadow">✓</span>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Size Selector --}}
                        @if($sizesList->isNotEmpty())
                            <div>
                                <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-neutral-800 mb-2">
                                    <span>Select Size: <span id="selected-size-label" class="text-neutral-500 font-normal">Select size</span></span>
                                    <button type="button" id="open-size-guide-btn" class="text-[11px] font-semibold text-neutral-600 hover:text-black underline flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                         Size Guide
                                    </button>
                                </div>
                                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2" id="size-options-grid">
                                    @foreach($sizesList as $variant)
                                        @php
                                            $sizeName = $variant->size->name ?? $variant->size;
                                            $hasStock = $variant->unlimited_stock || $variant->stock > 0;
                                        @endphp
                                        <button type="button"
                                            class="size-choice-btn py-2.5 px-2 text-xs font-bold rounded-sm border transition-all text-center {{ $hasStock ? 'border-neutral-300 text-neutral-800 hover:border-black bg-white cursor-pointer' : 'border-neutral-200 bg-neutral-100 text-neutral-300 line-through cursor-not-allowed' }}"
                                            data-size-id="{{ $variant->size_id }}"
                                            data-size-name="{{ $sizeName }}"
                                            data-available="{{ $hasStock ? '1' : '0' }}"
                                            {{ !$hasStock ? 'disabled' : '' }}>
                                            {{ $sizeName }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Quantity & Stock Indicator --}}
                        <div class="flex items-center justify-between gap-4 pt-2">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-800">Quantity:</span>
                                <div class="flex items-center border border-neutral-300 rounded-sm overflow-hidden bg-white">
                                    <button type="button" id="qty-minus" class="w-8 h-8 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 font-bold transition-colors">−</button>
                                    <input type="number" id="qty-input" value="1" min="1" max="99" class="w-12 h-8 text-center text-xs font-bold text-neutral-900 border-x border-neutral-300 focus:outline-none p-0">
                                    <button type="button" id="qty-plus" class="w-8 h-8 flex items-center justify-center text-neutral-600 hover:bg-neutral-100 font-bold transition-colors">+</button>
                                </div>
                            </div>

                            <div id="stock-status-badge" class="text-xs font-semibold flex items-center gap-1.5 text-emerald-600">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span id="stock-status-text">In Stock</span>
                            </div>
                        </div>

                    </div>

                    {{-- Action CTA Buttons --}}
                    <div class="space-y-2.5 pt-4 border-t border-neutral-200">
                        @php
                            $checkoutMode = $siteSettings['checkout_mode'] ?? 'midtrans';
                            $waNumber = config('services.whatsapp.number', '6281234567890');
                            $defaultWaText = urlencode("Hello Upsilon, I am interested in buying {$product->name} for " . currency_format($minPrice) . ". Please confirm stock and how to order.");
                        @endphp

                        {{-- Buy Now (Midtrans / Both mode) --}}
                        @if($checkoutMode !== 'whatsapp')
                            <button type="button" id="btn-buy-now"
                                class="w-full bg-black hover:bg-neutral-800 text-white font-bold text-xs uppercase tracking-wider py-3.5 px-6 rounded-sm flex items-center justify-center gap-2 shadow-sm hover:shadow transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Buy Now</span>
                            </button>
                        @endif

                        {{-- Order via WhatsApp (WhatsApp / Both mode) --}}
                        @if($checkoutMode !== 'midtrans')
                            <a id="btn-whatsapp-order"
                                href="https://wa.me/{{ $waNumber }}?text={{ $defaultWaText }}"
                                target="_blank" rel="noopener"
                                class="w-full bg-[#25D366] hover:bg-[#20ba59] text-white font-bold text-xs uppercase tracking-wider py-3.5 px-6 rounded-sm flex items-center justify-center gap-2 shadow-sm hover:shadow transition-all {{ $checkoutMode === 'both' ? 'order-2' : '' }}">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.58 1.961.902 3.018.902 3.182 0 5.768-2.587 5.768-5.767.001-3.182-2.585-5.768-5.768-5.768zm7.423 5.766c.002 4.093-3.329 7.425-7.424 7.425-1.258 0-2.493-.321-3.585-.931l-4.524 1.187 1.208-4.407c-.71-1.183-1.085-2.535-1.087-3.924.002-4.093 3.33-7.425 7.425-7.425 4.094 0 7.425 3.33 7.427 7.425z"></path>
                                </svg>
                                <span>{{ $checkoutMode === 'both' ? 'Order via WhatsApp' : 'Order Directly via WhatsApp' }}</span>
                            </a>
                        @endif

                        {{-- Add to Cart (Midtrans / Both mode) --}}
                        @if($checkoutMode !== 'whatsapp')
                            <button type="button" id="btn-add-to-cart"
                                class="w-full border border-neutral-800 hover:bg-neutral-50 text-neutral-900 font-bold text-xs uppercase tracking-wider py-3.5 px-6 rounded-sm flex items-center justify-center gap-2 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Add to Cart</span>
                            </button>
                        @endif
                    </div>

                    {{-- Retail USP Trust Pillars --}}
                    <div class="grid grid-cols-2 gap-3 pt-6 border-t border-neutral-200 text-neutral-600 text-[11px]">
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-900 font-bold text-base">🚚</span>
                            <div>
                                <strong class="block text-neutral-900 font-bold">Free Shipping</strong>
                                <span>Shipping across Indonesia</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-900 font-bold text-base">🛡️</span>
                            <div>
                                <strong class="block text-neutral-900 font-bold">100% Original</strong>
                                <span>Official authenticity guarantee</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-900 font-bold text-base">🔄</span>
                            <div>
                                <strong class="block text-neutral-900 font-bold">7-Day Return Guarantee</strong>
                                <span>Easy size exchange</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-neutral-900 font-bold text-base">💬</span>
                            <div>
                                <strong class="block text-neutral-900 font-bold">Customer Service</strong>
                                <span>Friendly chat support</span>
                            </div>
                        </div>
                    </div>

                    {{-- Description & Details Accordion --}}
                    <div class="border-t border-neutral-200 pt-6 space-y-4">
                        <div class="border-b border-neutral-200 pb-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-2">Product Description</h3>
                            <p class="text-xs text-neutral-600 leading-relaxed whitespace-pre-line">
                                {{ $product->description }}
                            </p>
                        </div>

                        @if($product->material || $product->size_fit)
                            <div class="border-b border-neutral-200 pb-3 space-y-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900">Specifications &amp; Material</h3>
                                @if($product->material)
                                    <div class="flex text-xs">
                                        <span class="w-28 text-neutral-400 font-medium shrink-0">Material:</span>
                                        <span class="text-neutral-800 font-medium">{{ $product->material }}</span>
                                    </div>
                                @endif
                                @if($product->size_fit)
                                    <div class="flex text-xs">
                                        <span class="w-28 text-neutral-400 font-medium shrink-0">Size &amp; Fit:</span>
                                        <span class="text-neutral-800 font-medium">{{ $product->size_fit }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        {{-- CUSTOMER REVIEWS SECTION --}}
        <section id="reviews-section" class="mt-16 pt-12 border-t border-neutral-200">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 pb-4 border-b border-neutral-200 gap-4">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-1">Customer Feedback</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold uppercase tracking-tight text-neutral-900">Customer Reviews</h2>
                </div>
                <div class="text-xs text-neutral-500">
                    Based on <span class="font-bold text-neutral-900">{{ $reviewCount }}</span> verified reviews
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
                {{-- Left: Rating Summary Card --}}
                <div class="lg:col-span-4 bg-neutral-50 border border-neutral-200 p-6 rounded-sm text-center flex flex-col justify-center items-center">
                    <span class="text-5xl font-black text-neutral-900">{{ $avgRating > 0 ? number_format($avgRating, 1) : '5.0' }}</span>
                    <div class="flex items-center gap-1 my-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($avgRating > 0 ? $avgRating : 5) ? 'text-yellow-400' : 'text-neutral-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs text-neutral-500 font-medium">{{ $reviewCount }} total reviews</span>

                    {{-- Distribution Bars --}}
                    @if($reviewCount > 0)
                        @php
                            $distribution = $reviewsList->groupBy('rating')->map->count();
                        @endphp
                        <div class="w-full mt-6 space-y-1.5 text-xs text-neutral-600">
                            @for($star = 5; $star >= 1; $star--)
                                @php
                                    $starCount = $distribution[$star] ?? 0;
                                    $starPercent = $reviewCount > 0 ? round(($starCount / $reviewCount) * 100) : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="w-6 text-right font-medium text-[11px]">{{ $star }}★</span>
                                    <div class="flex-1 h-2 bg-neutral-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-neutral-800 rounded-full" style="width: {{ $starPercent }}%"></div>
                                    </div>
                                    <span class="w-8 text-left text-[10px] text-neutral-400">{{ $starCount }}</span>
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>

                {{-- Right: Write Review Form --}}
                <div class="lg:col-span-8 bg-white border border-neutral-200 p-6 rounded-sm">
                    @auth
                        <h3 class="text-sm font-bold uppercase tracking-wider text-neutral-900 mb-1">Write a Product Review</h3>
                        <p class="text-xs text-neutral-500 mb-4">Share your experience about the quality, comfort, and sizing of this product.</p>

                        <form method="POST" action="{{ route('reviews.store', $product) }}" class="space-y-4">
                            @csrf

                            {{-- Rating Stars Selector --}}
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-neutral-700 mb-2">Your Rating*</label>
                                <div class="flex items-center gap-1.5" id="interactive-star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="review-star-btn text-neutral-300 transition-colors p-1 cursor-pointer"
                                            data-value="{{ $i }}"
                                            aria-label="{{ $i }} star">
                                            <svg class="w-6 h-6 fill-current pointer-events-none" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </button>
                                    @endfor
                                    <input type="hidden" name="rating" id="review-rating-value" value="5" required>
                                    <span id="rating-selected-text" class="text-xs font-bold text-neutral-700 ml-2">Very Satisfied (5/5)</span>
                                </div>
                            </div>

                            {{-- Review Content Textarea --}}
                            <div>
                                <label for="review-textarea" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 mb-2">Your Review*</label>
                                <textarea name="review" id="review-textarea" rows="4" required
                                    placeholder="How is the size and comfort? Tell other buyers..."
                                    class="w-full bg-neutral-50 border border-neutral-300 rounded-sm p-3 text-xs text-neutral-900 placeholder:text-neutral-400 focus:bg-white focus:border-black focus:ring-0 transition-colors"></textarea>
                            </div>

                            <button type="submit"
                                class="bg-black hover:bg-neutral-800 text-white text-xs font-bold uppercase tracking-wider py-2.5 px-6 rounded-sm transition-colors cursor-pointer">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <svg class="w-12 h-12 text-neutral-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h4 class="text-sm font-bold text-neutral-900 mb-1">Login to Write a Review</h4>
                            <p class="text-xs text-neutral-500 mb-4">You must be logged in to submit a review.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-black px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white hover:bg-neutral-800 rounded-sm">
                                Login
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Reviews List --}}
            @if($hasReviews)
                <div class="space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-900 mb-4">All Reviews ({{ $reviewsList->count() }})</h3>
                    @foreach($reviewsList as $review)
                        <div class="space-y-2">
                            <div class="p-4 sm:p-5 bg-white border border-neutral-200 rounded-sm">
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-neutral-900 text-white font-bold text-xs flex items-center justify-center">
                                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-xs font-bold text-neutral-900 flex items-center gap-1.5">
                                                <span>{{ $review->user->name ?? 'Upsilon Buyer' }}</span>
                                                @if($review->is_verified_purchase)
                                                    <span class="text-[9px] bg-emerald-100 text-emerald-800 font-semibold px-1.5 py-0.2 rounded-xs">Verified Buyer</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-neutral-400">{{ $review->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>

                                    {{-- Stars --}}
                                    <div class="flex items-center gap-0.5 text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-neutral-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-xs text-neutral-700 leading-relaxed mt-2">
                                    {{ $review->review }}
                                </p>
                            </div>

                            @if($review->replies->isNotEmpty())
                                <div class="ml-8 space-y-2">
                                    @foreach($review->replies as $reply)
                                        <div class="p-3 bg-neutral-50 border border-neutral-200 rounded-sm">
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="w-6 h-6 rounded-full bg-neutral-800 text-white font-bold text-[10px] flex items-center justify-center">
                                                    {{ strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                                                </div>
                                                <span class="text-xs font-bold text-neutral-900">{{ $reply->user->name ?? 'Admin' }}</span>
                                                <span class="text-[10px] text-neutral-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-neutral-700 leading-relaxed">
                                                {{ $reply->body }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- RELATED PRODUCTS --}}
        @if(isset($related) && $related->isNotEmpty())
            <section class="mt-20 pt-10 border-t border-neutral-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                                     <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-1">Recommended Picks</span>
                         <h2 class="text-xl sm:text-2xl font-extrabold uppercase tracking-tight text-neutral-900">Related Products</h2>
                    </div>
                         <a href="{{ route('shop', ['category' => $product->category->slug ?? '']) }}" class="text-xs font-bold text-neutral-900 hover:underline">
                             View All &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($related as $relatedItem)
                        <x-product-card :product="$relatedItem" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- RECENTLY VIEWED PRODUCTS --}}
        @if(isset($recentlyViewed) && $recentlyViewed->isNotEmpty())
            <section class="mt-16 pt-10 border-t border-neutral-200">
                <div class="mb-6">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-neutral-400 block mb-1">Your History</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold uppercase tracking-tight text-neutral-900">Recently Viewed</h2>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($recentlyViewed as $viewedItem)
                        <x-product-card :product="$viewedItem" />
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    {{-- SIZE GUIDE MODAL --}}
    <div id="size-guide-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white max-w-lg w-full rounded-sm shadow-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <button type="button" id="close-size-guide-btn" class="absolute top-4 right-4 text-neutral-400 hover:text-black font-bold text-lg">✕</button>
            <h3 class="text-base font-extrabold uppercase tracking-tight text-neutral-900 mb-2">Size Guide</h3>
            <p class="text-xs text-neutral-500 mb-4">Use the following size measurements to choose the best fit for you.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left border border-neutral-200">
                    <thead class="bg-neutral-100 text-neutral-800 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="p-2 border-b">Size</th>
                            <th class="p-2 border-b">Chest</th>
                            <th class="p-2 border-b">Waist</th>
                            <th class="p-2 border-b">Hip</th>
                            <th class="p-2 border-b">Length</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 text-neutral-600">
                        @if(isset($sizeGuides) && $sizeGuides->count() > 0)
                            @foreach($sizeGuides as $guide)
                                <tr>
                                    <td class="p-2 font-bold text-neutral-900">{{ $guide->size_label }}</td>
                                    <td class="p-2">{{ $guide->chest_cm ? $guide->chest_cm . ' cm' : '-' }}</td>
                                    <td class="p-2">{{ $guide->waist_cm ? $guide->waist_cm . ' cm' : '-' }}</td>
                                    <td class="p-2">{{ $guide->hip_cm ? $guide->hip_cm . ' cm' : '-' }}</td>
                                    <td class="p-2">{{ $guide->body_length_cm ? $guide->body_length_cm . ' cm' : '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="p-4 text-center text-neutral-500">No size guide available yet.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-3 bg-neutral-50 rounded-sm text-[11px] text-neutral-500">
                💡 <strong>Tip:</strong> If you are between two sizes, it is recommended to choose one size larger for maximum comfort.
            </div>
        </div>
    </div>

            <div class="mt-4 p-3 bg-neutral-50 rounded-sm text-[11px] text-neutral-500">
                💡 <strong>Tip:</strong> If you are between two sizes, it is recommended to choose one size larger for maximum sneaker comfort.
            </div>
        </div>
    </div>
@endsection


<script>
    /**
 * Product Detail Page Frontend Script
 * Modern Vanilla JavaScript (ES6+)
 */

(function () {
    'use strict';

    // Helper: Safe DOM ready executor
    function runWhenReady(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    runWhenReady(() => {
        // ==========================================
        // #1: Gallery & Thumbnail Switching
        // ==========================================
        const mainImage = document.getElementById('main-product-image');
        const thumbnails = document.querySelectorAll('.thumbnail-btn');

        if (mainImage && thumbnails.length > 0) {
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function () {
                    const newSrc = this.getAttribute('data-image-src') || this.src;
                    mainImage.src = newSrc;

                    thumbnails.forEach(t => t.classList.remove('ring-2', 'ring-primary', 'border-primary'));
                    this.classList.add('ring-2', 'ring-primary', 'border-primary');
                });
            });
        }

        // ==========================================
        // #2: Image Zoom & Pan (Touch & Desktop)
        // ==========================================
        const zoomContainer = document.getElementById('zoom-container');
        if (zoomContainer && mainImage) {
            zoomContainer.addEventListener('mousemove', (e) => {
                const rect = zoomContainer.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;
                
                mainImage.style.transformOrigin = `${x}% ${y}%`;
                mainImage.style.transform = 'scale(2)';
            });

            zoomContainer.addEventListener('mouseleave', () => {
                mainImage.style.transformOrigin = 'center center';
                mainImage.style.transform = 'scale(1)';
            });
        }

        // ==========================================
        // #3: Quantity Increment / Decrement
        // ==========================================
        const qtyMinus = document.getElementById('qty-minus');
        const qtyPlus = document.getElementById('qty-plus');
        const qtyInput = document.getElementById('qty-input');

        if (qtyInput) {
            qtyMinus?.addEventListener('click', () => {
                let val = parseInt(qtyInput.value) || 1;
                if (val > 1) {
                    qtyInput.value = val - 1;
                }
            });

            qtyPlus?.addEventListener('click', () => {
                let val = parseInt(qtyInput.value) || 1;
                qtyInput.value = val + 1;
            });
        }

        // ==========================================
        // #4: Interactive Review Star Rating
        // ==========================================
        const starContainer = document.getElementById('interactive-star-rating');
        const starButtons = starContainer ? starContainer.querySelectorAll('.review-star-btn') : [];
        const reviewRatingInput = document.getElementById('review-rating-value');
        const ratingSelectedText = document.getElementById('rating-selected-text');

        const ratingLabels = {
            1: 'Very Dissatisfied (1/5)',
            2: 'Dissatisfied (2/5)',
            3: 'Neutral (3/5)',
            4: 'Satisfied (4/5)',
            5: 'Very Satisfied (5/5)',
        };

        function updateStarRating(value) {
            if (!reviewRatingInput || !ratingSelectedText) return;

            reviewRatingInput.value = value;
            ratingSelectedText.textContent = ratingLabels[value] ?? `(${value}/5)`;

            starButtons.forEach(btn => {
                const btnValue = parseInt(btn.getAttribute('data-value') || '0', 10);
                if (btnValue <= value) {
                    btn.classList.add('!text-yellow-400');
                    btn.classList.remove('!text-neutral-300');
                } else {
                    btn.classList.remove('!text-yellow-400');
                    btn.classList.add('!text-neutral-300');
                }
            });
        }

        if (starContainer && starButtons.length > 0 && reviewRatingInput) {
            starContainer.addEventListener('mouseover', (e) => {
                const btn = e.target.closest('.review-star-btn');
                if (!btn) return;
                const value = parseInt(btn.getAttribute('data-value') || '0', 10);
                updateStarRating(value);
            });

            starContainer.addEventListener('mouseleave', () => {
                const currentValue = parseInt(reviewRatingInput.value || '5', 10);
                updateStarRating(currentValue);
            });

            starButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const value = parseInt(btn.getAttribute('data-value') || '0', 10);
                    updateStarRating(value);
                });
            });

            updateStarRating(parseInt(reviewRatingInput.value || '5', 10));
        }

        // ==========================================
        // #5: Variant Selection - Color & Size
        // ==========================================
        const colorButtons = document.querySelectorAll('.color-swatch-btn');
        const sizeButtons = document.querySelectorAll('.size-choice-btn');
        const selectedColorLabel = document.getElementById('selected-color-label');
        const selectedSizeLabel = document.getElementById('selected-size-label');
        const mainPriceVal = document.getElementById('main-price-val');
        const mainBasePriceVal = document.getElementById('main-base-price-val');
        const stockStatusText = document.getElementById('stock-status-text');
        const stockStatusBadge = document.getElementById('stock-status-badge');
        const btnWhatsappOrder = document.getElementById('btn-whatsapp-order');

        let selectedColorId = null;
        let selectedSizeId = null;

        const variantMap = new Map();
        if (Array.isArray(window.productVariantData)) {
            window.productVariantData.forEach(function (item) {
                if (!item || !item.color_id || !item.size_id) return;
                const key = item.color_id + '::' + item.size_id;
                variantMap.set(key, item);
            });
        }

        function formatPrice(value) {
            if (value === null || value === undefined || isNaN(value)) return null;
            return CURRENCY_SYMBOL + Number(value).toFixed(CURRENCY_DECIMALS);
        }

        function updateVariantUI() {
            const key = (selectedColorId ? selectedColorId : '') + '::' + (selectedSizeId ? selectedSizeId : '');
            const variant = variantMap.get(key) || null;

            if (selectedColorLabel) {
                selectedColorLabel.textContent = selectedColorId ? (document.querySelector('.color-swatch-btn[data-color-id="' + selectedColorId + '"]')?.getAttribute('data-color-name') || 'Selected') : 'Select color';
            }
            if (selectedSizeLabel) {
                selectedSizeLabel.textContent = selectedSizeId ? (document.querySelector('.size-choice-btn[data-size-id="' + selectedSizeId + '"]')?.getAttribute('data-size-name') || 'Selected') : 'Select size';
            }

            if (variant && mainPriceVal) {
                const newPrice = formatPrice(variant.price);
                const newBasePrice = formatPrice(variant.base_price);

                if (newPrice) {
                    mainPriceVal.textContent = newPrice;
                    mainPriceVal.classList.remove('hidden');
                }

                if (mainBasePriceVal) {
                    if (newBasePrice && newPrice && newBasePrice !== newPrice) {
                        mainBasePriceVal.textContent = newBasePrice;
                        mainBasePriceVal.classList.remove('hidden');
                    } else {
                        mainBasePriceVal.classList.add('hidden');
                    }
                }

                if (stockStatusText) {
                    if (variant.stock > 0) {
                        stockStatusText.textContent = variant.stock >= 9999 ? 'In Stock' : 'In Stock (' + variant.stock + ')';
                        if (stockStatusBadge) {
                            stockStatusBadge.className = 'text-xs font-semibold flex items-center gap-1.5 text-emerald-600';
                            stockStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span><span id="stock-status-text">' + stockStatusText.textContent + '</span>';
                        }
                    } else {
                        stockStatusText.textContent = 'Out of Stock';
                        if (stockStatusBadge) {
                            stockStatusBadge.className = 'text-xs font-semibold flex items-center gap-1.5 text-red-600';
                            stockStatusBadge.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-500"></span><span id="stock-status-text">Out of Stock</span>';
                        }
                    }
                }

                if (btnWhatsappOrder) {
                    const productName = document.querySelector('h1')?.textContent?.trim() || 'Product';
                    const priceText = newPrice || '';
                    const sizeText = selectedSizeId ? (document.querySelector('.size-choice-btn[data-size-id="' + selectedSizeId + '"]')?.getAttribute('data-size-name') || '') : '';
                    const colorText = selectedColorId ? (document.querySelector('.color-swatch-btn[data-color-id="' + selectedColorId + '"]')?.getAttribute('data-color-name') || '') : '';
                    const detail = [colorText, sizeText].filter(Boolean).join(' - ');
                    const orderText = encodeURIComponent('Hello Upsilon, I am interested in buying ' + productName + (detail ? ' (' + detail + ')' : '') + ' for ' + priceText + '. Please confirm stock and how to order.');
                    btnWhatsappOrder.href = 'https://wa.me/{{ $waNumber }}?text=' + orderText;
                }
            }
        }

        colorButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                colorButtons.forEach(function (b) {
                    b.classList.remove('border-black', 'ring-1', 'ring-black');
                    b.classList.add('border-neutral-300');
                    const check = b.querySelector('.swatch-check');
                    if (check) check.classList.add('hidden');
                });

                this.classList.remove('border-neutral-300');
                this.classList.add('border-black', 'ring-1', 'ring-black');
                const check = this.querySelector('.swatch-check');
                if (check) check.classList.remove('hidden');

                selectedColorId = this.getAttribute('data-color-id');
                updateVariantUI();
            });
        });

        sizeButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const available = btn.getAttribute('data-available') === '1';
                if (!available) return;

                sizeButtons.forEach(function (b) {
                    b.classList.remove('bg-black', 'text-white', 'border-black');
                    b.classList.add('bg-white', 'text-neutral-800', 'border-neutral-300');
                });

                btn.classList.remove('bg-white', 'text-neutral-800', 'border-neutral-300');
                btn.classList.add('bg-black', 'text-white', 'border-black');

                selectedSizeId = btn.getAttribute('data-size-id');
                updateVariantUI();
            });
        });

        // ==========================================
        // #6: Size Guide Modal
        // ==========================================
        const openSizeGuideBtn = document.getElementById('open-size-guide-btn');
        const sizeGuideModal = document.getElementById('size-guide-modal');
        const closeSizeGuideBtn = document.getElementById('close-size-guide-btn');

        if (openSizeGuideBtn && sizeGuideModal) {
            openSizeGuideBtn.addEventListener('click', function () {
                sizeGuideModal.classList.remove('hidden');
                sizeGuideModal.classList.add('flex');
            });
        }

        if (closeSizeGuideBtn && sizeGuideModal) {
            closeSizeGuideBtn.addEventListener('click', function () {
                sizeGuideModal.classList.add('hidden');
                sizeGuideModal.classList.remove('flex');
            });
        }

        if (sizeGuideModal) {
            sizeGuideModal.addEventListener('click', function (e) {
                if (e.target === sizeGuideModal) {
                    sizeGuideModal.classList.add('hidden');
                    sizeGuideModal.classList.remove('flex');
                }
            });
        }

        // ==========================================
        // #7: Buy Now & Add to Cart (Midtrans mode)
        // ==========================================
        function getSelectedVariantId() {
            const key = (selectedColorId ? selectedColorId : '') + '::' + (selectedSizeId ? selectedSizeId : '');
            const variant = variantMap.get(key);
            return variant ? variant.id : null;
        }

        function getSelectedQuantity() {
            const qtyInput = document.getElementById('qty-input');
            return qtyInput ? parseInt(qtyInput.value, 10) || 1 : 1;
        }

        function addToCart(variantId, quantity) {
            return fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    product_variant_id: variantId,
                    quantity: quantity
                })
            }).then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, data: data };
                });
            });
        }

        const btnBuyNow = document.getElementById('btn-buy-now');
        const btnAddToCart = document.getElementById('btn-add-to-cart');

        if (btnBuyNow) {
            btnBuyNow.addEventListener('click', function () {
                const variantId = getSelectedVariantId();

                if (!variantId) {
                    alert('Silakan pilih warna dan ukuran terlebih dahulu.');
                    return;
                }

                const quantity = getSelectedQuantity();

                btnBuyNow.disabled = true;
                btnBuyNow.querySelector('span').textContent = 'Processing...';

                addToCart(variantId, quantity).then(function (result) {
                    btnBuyNow.disabled = false;
                    btnBuyNow.querySelector('span').textContent = 'Buy Now';

                    if (result.ok && result.data.success) {
                        window.location.href = "{{ route('checkout') }}";
                    } else if (result.data && result.data.error) {
                        alert(result.data.error);
                    } else {
                        alert('Gagal menambahkan ke keranjang. Silakan coba lagi.');
                    }
                }).catch(function () {
                    btnBuyNow.disabled = false;
                    btnBuyNow.querySelector('span').textContent = 'Buy Now';
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        }

        if (btnAddToCart) {
            btnAddToCart.addEventListener('click', function () {
                const variantId = getSelectedVariantId();

                if (!variantId) {
                    alert('Silakan pilih warna dan ukuran terlebih dahulu.');
                    return;
                }

                const quantity = getSelectedQuantity();

                btnAddToCart.disabled = true;
                btnAddToCart.querySelector('span').textContent = 'Adding...';

                addToCart(variantId, quantity).then(function (result) {
                    btnAddToCart.disabled = false;
                    btnAddToCart.querySelector('span').textContent = 'Add to Cart';

                    if (result.ok && result.data.success) {
                        alert('Produk berhasil ditambahkan ke keranjang.');
                        const cartCountEls = document.querySelectorAll('[data-cart-count]');
                        cartCountEls.forEach(function (el) {
                            el.textContent = result.data.count;
                        });
                    } else if (result.data && result.data.error) {
                        alert(result.data.error);
                    } else {
                        alert('Gagal menambahkan ke keranjang. Silakan coba lagi.');
                    }
                }).catch(function () {
                    btnAddToCart.disabled = false;
                    btnAddToCart.querySelector('span').textContent = 'Add to Cart';
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            });
        }

    });
})();
</script>