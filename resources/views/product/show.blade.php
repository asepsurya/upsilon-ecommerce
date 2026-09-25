@extends("layouts.app")

@section("title")
{{ $product->name }} - {{ config('app.name', 'Upsilon') }}
@endsection

@push("head")
<script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Product",
        "name": {{ json_encode($product->name) }},
        "description": {{ json_encode($product->description) }},
        "brand": {
            "@type": "Brand",
            "name": {{ json_encode(config('app.name', 'Upsilon')) }}
        },
        "offers": {
            "@type": "Offer",
            "price": {{ $product->sale_price ?? $product->base_price }},
            "priceCurrency": "USD",
            "availability": "https://schema.org/InStock"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": {{ number_format($reviewStats['average'], 1) }},
            "reviewCount": {{ $reviewStats['count'] }}
        }
    }
    </script>
@endpush

@section("content")
<!-- Product Gallery -->
<section class="w-full bg-surface py-space-xl border-b border-outline-variant/20">
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-xl lg:gap-3xl">
            <!-- Main Image -->
            <div class="relative">
                <div class="relative aspect-[3/4] bg-surface-container-low overflow-hidden rounded-2xl">
                    @php
                        $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                    @endphp
                    @if($primaryImage)
                        <img src="{{ $primaryImage->url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 hover:scale-[1.02]">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-outline text-xs uppercase tracking-wider">No Image</span>
                        </div>
                    @endif

                    @if($product->badge)
                        <span class="absolute top-4 left-4 bg-surface-container-lowest/90 backdrop-blur-md px-3 py-1 text-primary border border-primary/20 font-label-caps text-[10px] uppercase tracking-widest">
                            {{ $product->badge }}
                        </span>
                    @endif

                    @if($product->discount_percent > 0)
                        <span class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 font-label-caps text-[10px] uppercase tracking-widest">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif
                </div>

                <!-- Thumbnails -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-3 mt-4" id="product-thumbnails">
                        @foreach($product->images as $index => $image)
                            <button type="button"
                                class="thumbnail-btn relative aspect-square overflow-hidden bg-surface-container-low rounded-xl border-2 transition-all duration-300 {{ $index === 0 ? 'border-primary' : 'border-outline-variant/30' }}"
                                data-index="{{ $index }}"
                                aria-label="View image {{ $index + 1 }}">
                                <img src="{{ $image->url }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="lg:py-2xl space-y-6">
                <!-- Category & Title -->
                <div class="space-y-3">
                    <span class="font-label-caps text-xs uppercase tracking-widest text-primary block">{{ $product->category->name ?? 'Atelier' }}</span>
                    <h1 class="font-headline-lg text-3xl lg:text-4xl text-on-surface tracking-tight leading-[1.1]">{{ $product->name }}</h1>

                    <!-- Rating -->
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($reviewStats['average']) ? 'text-primary' : 'text-outline-variant' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <span class="font-body-sm text-sm text-on-surface-variant">({{ $reviewStats['count'] }} reviews)</span>
                    </div>
                </div>

                <!-- Price -->
                @php
                    // Calculate price range from variants
                    $variantPrices = $product->variants->filter(fn($v) => $v->is_active)->map(function($v) {
                        return $v->effective_price;
                    })->filter()->unique()->sort()->values();

                    $variantBasePrices = $product->variants->filter(fn($v) => $v->is_active)->map(function($v) {
                        return $v->effective_base_price;
                    })->filter()->unique()->sort()->values();

                    $minPrice = $variantPrices->first();
                    $maxPrice = $variantPrices->last();
                    $minBasePrice = $variantBasePrices->first();
                    $maxBasePrice = $variantBasePrices->last();

                    $showPriceRange = $minPrice && $maxPrice && $minPrice != $maxPrice;
                    $hasSale = $minBasePrice && $minPrice && $minPrice < $minBasePrice;
                @endphp

                <div class="flex flex-col sm:flex-row items-baseline gap-4 pt-2 price-display">
                    @if($showPriceRange)
                        <span class="font-headline-lg text-2xl lg:text-3xl text-primary font-semibold">${{ number_format($minPrice, 0) }} - ${{ number_format($maxPrice, 0) }}</span>
                        @if($hasSale)
                            <span class="font-body-lg text-lg text-on-surface-variant line-through">${{ number_format($minBasePrice, 0) }} - ${{ number_format($maxBasePrice, 0) }}</span>
                            @php
                                $avgDiscount = round((1 - ($minPrice / $minBasePrice)) * 100);
                            @endphp
                            <span class="font-label-caps text-xs uppercase tracking-widest bg-red-600 text-white px-3 py-1">-{{ $avgDiscount }}%</span>
                        @endif
                    @elseif($minPrice)
                        @if($hasSale)
                            <span class="font-headline-lg text-2xl lg:text-3xl text-primary font-semibold">${{ number_format($minPrice, 0) }}</span>
                            <span class="font-body-lg text-lg text-on-surface-variant line-through">${{ number_format($minBasePrice, 0) }}</span>
                            <span class="font-label-caps text-xs uppercase tracking-widest bg-red-600 text-white px-3 py-1">-{{ $product->discount_percent }}%</span>
                        @else
                            <span class="font-headline-lg text-2xl lg:text-3xl text-on-surface font-semibold">${{ number_format($minPrice, 0) }}</span>
                        @endif
                    @else
                        @if($product->sale_price && $product->sale_price < $product->base_price)
                            <span class="font-headline-lg text-2xl lg:text-3xl text-primary font-semibold">${{ number_format($product->sale_price, 0) }}</span>
                            <span class="font-body-lg text-lg text-on-surface-variant line-through">${{ number_format($product->base_price, 0) }}</span>
                            <span class="font-label-caps text-xs uppercase tracking-widest bg-red-600 text-white px-3 py-1">-{{ $product->discount_percent }}%</span>
                        @else
                            <span class="font-headline-lg text-2xl lg:text-3xl text-on-surface font-semibold">${{ number_format($product->base_price, 0) }}</span>
                        @endif
                    @endif
                </div>

                <!-- Description -->
                <p class="font-body-md text-base text-on-surface-variant leading-relaxed border-t border-outline-variant/20 pt-6">
                    {{ $product->description }}
                </p>

                <!-- Options -->
                <div class="space-y-8 border-t border-outline-variant/20 pt-6">
                    <!-- Color -->
                    @if($product->variants->unique('color_id')->pluck('color')->isNotEmpty())
                        <div>
                            <span class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-3">Color</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->variants->unique('color_id') as $variant)
                                    @if($variant->color && $variant->color->hex_code)
                                        <button type="button"
                                            class="color-swatch w-10 h-10 rounded-full border-2 border-outline-variant/30 transition-all duration-200 hover:border-primary hover:scale-105"
                                            style="background-color: {{ $variant->color->hex_code }}"
                                            data-color-id="{{ $variant->color_id }}"
                                            data-color="{{ $variant->color->hex_code }}"
                                            aria-label="Color {{ $variant->color->name }}"></button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Size -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-label-caps text-xs uppercase tracking-widest text-on-surface">Size</span>
                            <a href="#" class="font-body-sm text-xs text-primary hover:underline">Size Guide</a>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->variants->unique('size_id') as $variant)
                                @if($variant->stock > 0 || $variant->unlimited_stock)
                                    <button type="button"
                                        class="size-btn px-4 py-2.5 text-sm font-medium border border-outline-variant/30 bg-surface-container-low rounded-lg text-on-surface hover:border-primary hover:bg-surface-container transition-all duration-200"
                                        data-size-id="{{ $variant->size_id }}"
                                        data-size="{{ $variant->size->name ?? $variant->size }}"
                                        data-stock="{{ $variant->stock }}"
                                        data-unlimited-stock="{{ $variant->unlimited_stock ? 'true' : 'false' }}"
                                        data-price="{{ $variant->effective_price }}"
                                        data-base-price="{{ $variant->effective_base_price }}"
                                        data-has-sale="{{ ($variant->effective_price < $variant->effective_base_price) ? 'true' : 'false' }}"
                                        data-discount="{{ $variant->discount_percent }}">{{ $variant->size->name ?? $variant->size }}</button>
                                @else
                                    <button type="button" disabled
                                        class="px-4 py-2.5 text-sm font-medium border border-outline-variant/20 bg-surface-container-low/50 rounded-lg text-outline-variant line-through cursor-not-allowed"
                                        title="Out of stock">{{ $variant->size->name ?? $variant->size }}</button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quantity & Stock -->
                <div class="flex items-center gap-4 border-t border-outline-variant/20 pt-6">
                    <div class="flex items-center border border-outline-variant/30 rounded-lg overflow-hidden">
                        <button type="button" id="qty-minus"
                            class="px-5 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors">−</button>
                        <input type="number" id="qty-input" value="1" min="1" max="99"
                            class="w-16 text-center py-3 text-sm font-medium text-on-surface border-x border-outline-variant/30 bg-transparent focus:outline-none appearance-none">
                        <button type="button" id="qty-plus"
                            class="px-5 py-3 text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors">+</button>
                    </div>
                    <span class="font-body-sm text-sm text-primary font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        In Stock
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2 border-t border-outline-variant/20">
                    @php
                        $whatsappPrice = $minPrice ?? ($product->sale_price ?? $product->base_price);
                    @endphp
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Buy Product: I would like to buy ' . $product->name . ' priced at $ ' . number_format($whatsappPrice, 0, '.', ',') . '. Please provide details.') }}"
                        class="flex-1 group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300"
                        target="_blank" rel="noopener">
                        <span class="relative z-10 flex items-center gap-2">
                            Buy Product
                            <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                        </span>
                    </a>
                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I would like to order ' . $product->name . ' priced at $ ' . number_format($whatsappPrice, 0, '.', ',') . '. Please provide more information.') }}"
                        class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-surface-container-low border border-outline-variant/30 text-on-surface font-label-caps text-xs tracking-widest uppercase hover:bg-surface-container hover:border-primary/30 transition-all duration-300"
                        target="_blank" rel="noopener">
                        <span class="material-symbols-outlined text-sm">chat</span>
                        Inquire
                    </a>
                </div>

                <!-- Wishlist -->
                <button type="button" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-on-surface-variant hover:text-primary transition-colors border border-outline-variant/30 rounded-lg hover:border-primary/30"
                    aria-label="Add to wishlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Add to Wishlist
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Reviews -->
<section class="w-full bg-surface py-space-3xl border-y border-outline-variant/20">
    <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-space-xl">
                <span class="font-label-caps text-xs uppercase tracking-widest text-primary block mb-space-xs">Customer Reviews</span>
                <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Reviews</h2>
            </div>

            <div class="flex flex-col lg:flex-row gap-space-xl mb-space-xl">
                <!-- Rating Summary -->
                <div class="lg:w-1/4 flex flex-col items-center text-center p-space-lg bg-surface-container rounded-2xl border border-outline-variant/30">
                    <div class="font-display-hero text-5xl lg:text-6xl text-primary font-bold">{{ number_format($reviewStats['average'], 1) }}</div>
                    <div class="flex items-center justify-center gap-1 mt-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($reviewStats['average']) ? 'text-primary' : 'text-outline-variant' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <div class="font-body-sm text-sm text-on-surface-variant mt-2">{{ $reviewStats['count'] }} reviews</div>
                </div>

                <!-- Write Review Form -->
                <div class="lg:w-3/4">
                    <form method="POST" action="{{ route('reviews.store', $product) }}" class="space-y-6 p-space-lg bg-surface-container rounded-2xl border border-outline-variant/30">
                        @csrf
                        <h3 class="font-headline-sm text-lg text-on-surface">Write a Review</h3>

                        <div>
                            <label class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-3">Your Rating</label>
                            <div class="flex gap-2" id="rating-input">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="rating-star text-outline-variant hover:text-primary transition-colors"
                                        data-value="{{ $i }}"
                                        aria-label="{{ $i }} stars">
                                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="rating-value" required>
                            </div>
                        </div>

                        <div>
                            <label for="review-content" class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-3">Your Review</label>
                            <textarea name="content" id="review-content" required rows="5"
                                placeholder="Share your experience..."
                                class="w-full bg-surface-container-low border border-outline-variant/30 px-4 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all duration-200 resize-y"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full sm:w-auto px-8 py-3.5 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase hover:bg-primary/90 hover:shadow-[0_10px_30px_rgba(242,202,80,0.3)] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-2 focus:ring-offset-surface">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reviews List -->
            @if(isset($reviews) && $reviews->count() > 0)
                <div class="space-y-6 mt-space-xl">
                    @foreach($reviews as $review)
                        <div class="p-space-lg bg-surface-container rounded-2xl border border-outline-variant/30">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-on-primary font-semibold">
                                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-body-sm text-sm font-medium text-on-surface">{{ $review->user->name ?? 'Anonymous' }}</div>
                                        <div class="font-body-sm text-xs text-on-surface-variant">{{ $review->created_at->format('F d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-primary' : 'text-outline-variant' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="font-body-md text-base text-on-surface-variant leading-relaxed">{{ $review->content }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thumbnail switching
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    const mainImage = document.querySelector('.aspect-\\[3\\/4\\] img');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbnails.forEach(t => t.classList.remove('border-primary', 'border-outline-variant/30'));
            this.classList.add('border-primary');
            this.classList.remove('border-outline-variant/30');

            const newSrc = this.querySelector('img').src;
            if (mainImage && newSrc !== mainImage.src) {
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = newSrc;
                    mainImage.style.opacity = '1';
                }, 150);
            }
        });
    });

    // Color selection
    const colorSwatches = document.querySelectorAll('.color-swatch');
    let selectedColorId = null;
    let selectedSizeId = null;

    // Build variant price map
    const variantPriceMap = {};
    @foreach($product->variants as $variant)
        variantPriceMap['{{ $variant->color_id }}_{{ $variant->size_id }}'] = {
            price: {{ $variant->effective_price }},
            basePrice: {{ $variant->effective_base_price }},
            hasSale: {{ ($variant->effective_price < $variant->effective_base_price) ? 'true' : 'false' }},
            discount: {{ $variant->discount_percent }},
            stock: {{ $variant->stock }},
            unlimitedStock: {{ $variant->unlimited_stock ? 'true' : 'false' }}
        };
    @endforeach

    function updatePriceDisplay(colorId, sizeId) {
        const key = colorId + '_' + sizeId;
        const variant = variantPriceMap[key];
        const priceContainer = document.querySelector('.price-display');
        const buyBtn = document.querySelector('a[href*="wa.me"]');
        const inquireBtn = document.querySelector('a[href*="wa.me"]:nth-of-type(2)');

        if (variant) {
            // Update price display
            let priceHtml = '';
            if (variant.hasSale) {
                priceHtml = '<span class="font-headline-lg text-2xl lg:text-3xl text-primary font-semibold">$' + variant.price.toLocaleString() + '</span>' +
                    '<span class="font-body-lg text-lg text-on-surface-variant line-through">$' + variant.basePrice.toLocaleString() + '</span>' +
                    '<span class="font-label-caps text-xs uppercase tracking-widest bg-red-600 text-white px-3 py-1">-' + variant.discount + '%</span>';
            } else {
                priceHtml = '<span class="font-headline-lg text-2xl lg:text-3xl text-on-surface font-semibold">$' + variant.price.toLocaleString() + '</span>';
            }
            priceContainer.innerHTML = priceHtml;

            // Update WhatsApp links
            const whatsappPrice = variant.price.toLocaleString();
            const productName = '{{ $product->name }}';
            const whatsappNumber = '{{ config("services.whatsapp.number") }}';
            if (buyBtn) {
                buyBtn.href = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent("Buy Product: I would like to buy " + productName + " priced at $ " + whatsappPrice + ". Please provide details.");
            }
            if (inquireBtn) {
                inquireBtn.href = "https://wa.me/" + whatsappNumber + "?text=" + encodeURIComponent("Hello, I would like to order " + productName + " priced at $ " + whatsappPrice + ". Please provide more information.");
            }

            // Update stock indicator
            const stockEl = document.querySelector('.font-body-sm.text-primary');
            if (stockEl) {
                if (variant.unlimitedStock || variant.stock > 0) {
                    stockEl.innerHTML = '<span class="material-symbols-outlined text-sm">check_circle</span> In Stock';
                    stockEl.classList.remove('text-destructive');
                    stockEl.classList.add('text-primary');
                } else {
                    stockEl.innerHTML = '<span class="material-symbols-outlined text-sm">cancel</span> Out of Stock';
                    stockEl.classList.remove('text-primary');
                    stockEl.classList.add('text-destructive');
                }
            }
        }
    }

    function checkAndUpdatePrice() {
        if (selectedColorId && selectedSizeId) {
            updatePriceDisplay(selectedColorId, selectedSizeId);
        }
    }

    colorSwatches.forEach(swatch => {
        swatch.addEventListener('click', function() {
            colorSwatches.forEach(s => s.classList.remove('border-primary', 'scale-105'));
            this.classList.add('border-primary', 'scale-105');
            selectedColorId = this.dataset.colorId;
            checkAndUpdatePrice();
        });
    });

    // Size selection
    const sizeButtons = document.querySelectorAll('.size-btn');
    sizeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            sizeButtons.forEach(b => b.classList.remove('border-primary', 'bg-primary', 'text-on-primary'));
            this.classList.add('border-primary', 'bg-primary', 'text-on-primary');
            selectedSizeId = this.dataset.sizeId;
            checkAndUpdatePrice();
        });
    });

    // Quantity
    const qtyInput = document.getElementById('qty-input');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');

    if (qtyMinus && qtyInput) {
        qtyMinus.addEventListener('click', () => {
            const val = parseInt(qtyInput.value) || 1;
            if (val > 1) qtyInput.value = val - 1;
        });
    }
    if (qtyPlus && qtyInput) {
        qtyPlus.addEventListener('click', () => {
            const val = parseInt(qtyInput.value) || 1;
            if (val < 99) qtyInput.value = val + 1;
        });
    }

    // Rating stars
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            ratingInput.value = value;

            stars.forEach(s => {
                const val = parseInt(s.dataset.value);
                s.classList.toggle('text-primary', val <= value);
                s.classList.toggle('text-outline-variant', val > value);
            });
        });

        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach(s => {
                const val = parseInt(s.dataset.value);
                s.classList.toggle('text-primary', val <= value);
                s.classList.toggle('text-outline-variant', val > value);
            });
        });

        star.addEventListener('mouseleave', function() {
            const currentValue = parseInt(ratingInput.value) || 0;
            stars.forEach(s => {
                const val = parseInt(s.dataset.value);
                s.classList.toggle('text-primary', val <= currentValue);
                s.classList.toggle('text-outline-variant', val > currentValue);
            });
        });
    });
});
</script>
@endpush