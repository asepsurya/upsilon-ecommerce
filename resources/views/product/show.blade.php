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
            "priceCurrency": "IDR",
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
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
                    <div class="space-y-4">
                        <div class="relative aspect-[3/4] bg-surface-container overflow-hidden" x-data="{ zoomed: false }" @mouseenter="zoomed = true" @mouseleave="zoomed = false">
                            <img src="{{ asset($product->images->first()?->image ?? 'https://placehold.co/600x800/stone-200/stone-500?text=No+Image') }}" alt="{{ $product->name }}" class="w-full h-full object-cover" :class="zoomed ? 'scale-110' : 'scale-100'" style="transition: transform 0.5s ease;">
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $image)
                                <button class="aspect-square bg-surface-container overflow-hidden border-2 border-outline-variant">
                                    <img src="{{ asset($image->image) }}" alt="" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="lg:py-8">
                        <div class="mb-6">
                            <h1 class="text-3xl md:text-4xl font-headline-md mb-3">{{ $product->name }}</h1>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= 4 ? 'text-on-surface' : 'text-outline-variant' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-on-surface-variant">({{ $reviewStats['count'] }} reviews)</span>
                            </div>
                        </div>

                        <div class="flex items-baseline gap-4 mb-8">
                            @if($product->sale_price)
                                <span class="text-2xl font-headline-md">$ {{ number_format($product->sale_price, 0, '.', ',') }}</span>
                                <span class="text-lg text-on-surface-variant line-through">$ {{ number_format($product->base_price, 0, '.', ',') }}</span>
                                <span class="text-sm font-semibold text-on-surface bg-surface-container px-2 py-1">-{{ round((($product->base_price - $product->sale_price) / $product->base_price) * 100) }}%</span>
                            @else
                                <span class="text-2xl font-headline-md">$ {{ number_format($product->base_price, 0, '.', ',') }}</span>
                            @endif
                        </div>

                        <p class="text-on-surface-variant leading-relaxed mb-8">{{ $product->description }}</p>

                        <div class="space-y-6 mb-10">
                            <div>
                                <span class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-3">Color</span>
                                <div class="flex gap-3">
                                    @foreach($product->variants->unique('color')->pluck('color') as $color)
                                        <button class="w-8 h-8 rounded-full border-2 border-outline-variant" style="background-color: {{ $color }}"></button>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-semibold tracking-widest uppercase text-on-surface">Size</span>
                                    <a href="#" class="text-xs text-on-surface-variant underline hover:text-on-surface">Size Guide</a>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($product->variants->unique('size') as $variant)
                                        @if($variant->stock > 0)
                                            <button class="border border-outline-variant/50 px-4 py-2 text-sm hover:border-outline-variant hover:text-on-surface transition-colors">{{ $variant->size }}</button>
                                        @else
                                            <button disabled class="border border-outline-variant/40 px-4 py-2 text-sm text-outline-variant line-through cursor-not-allowed">{{ $variant->size }}</button>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mb-8">
                            <div class="flex items-center border border-outline-variant/50">
                                <button class="px-4 py-3 hover:bg-surface-container-high transition-colors">-</button>
                                <span class="px-4 py-3 text-sm border-x border-outline-variant/50">1</span>
                                <button class="px-4 py-3 hover:bg-surface-container-high transition-colors">+</button>
                            </div>
                            <span class="text-sm text-on-surface-variant">In Stock</span>
                        </div>

                        <div class="flex gap-3 mb-6">
                            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Quick Reserve: I would like to reserve ' . $product->name . ' priced at $ ' . number_format($product->sale_price ?? $product->base_price, 0, '.', ',') . '. Please confirm availability.') }}"
                                class="flex-1 bg-navy text-white py-4 text-sm tracking-widest uppercase hover:bg-navy/90 transition-colors duration-300 text-center block"
                                target="_blank" rel="noopener">
                                Quick Reserve
                            </a>
                            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I would like to order ' . $product->name . ' priced at $ ' . number_format($product->sale_price ?? $product->base_price, 0, '.', ',') . '. Please provide more information.') }}"
                                class="flex-1 border border-outline-variant text-on-surface py-4 text-sm tracking-widest uppercase hover:bg-surface-container-lowest hover:text-tertiary transition-all duration-300 text-center block"
                                target="_blank" rel="noopener">
                                Buy Now
                            </a>
                        </div>
                        <button class="text-sm text-on-surface-variant hover:text-on-surface flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            Add to Wishlist
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 border-t border-outline-variant/40">
            <div class="max-w-4xl mx-auto px-6 md:px-12 lg:px-24">
                <div class="border-t border-outline-variant/40">
                    <button x-data="{ open: true }" @click="open = !open" class="w-full py-6 flex items-center justify-between text-left">
                        <span class="font-headline-md text-lg">Description</span>
                        <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6 text-on-surface-variant text-sm leading-relaxed">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
                <div class="border-t border-outline-variant/40">
                    <button x-data="{ open: false }" @click="open = !open" class="w-full py-6 flex items-center justify-between text-left">
                        <span class="font-headline-md text-lg">Material</span>
                        <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6 text-on-surface-variant text-sm leading-relaxed">
                        <p>Premium materials sourced for durability and comfort.</p>
                    </div>
                </div>
                <div class="border-t border-outline-variant/40">
                    <button x-data="{ open: false }" @click="open = !open" class="w-full py-6 flex items-center justify-between text-left">
                        <span class="font-headline-md text-lg">Size & Fit</span>
                        <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6 text-on-surface-variant text-sm leading-relaxed">
                        <p>Regular fit. Model is 175cm and wears size M.</p>
                    </div>
                </div>
                <div class="border-t border-outline-variant/40">
                    <button x-data="{ open: false }" @click="open = !open" class="w-full py-6 flex items-center justify-between text-left">
                        <span class="font-headline-md text-lg">Shipping</span>
                        <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6 text-on-surface-variant text-sm leading-relaxed">
                        <p>Free shipping on orders over $500. Estimated delivery 3-5 business days.</p>
                    </div>
                </div>
                <div class="border-t border-b border-outline-variant/40">
                    <button x-data="{ open: false }" @click="open = !open" class="w-full py-6 flex items-center justify-between text-left">
                        <span class="font-headline-md text-lg">Returns</span>
                        <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pb-6 text-on-surface-variant text-sm leading-relaxed">
                        <p>30-day return policy. Items must be unworn with original tags attached.</p>
                    </div>
                </div>
            </div>
        </section>

        @if($related->count() > 0)
            <section class="py-24 bg-surface">
                <div class="px-6 md:px-12 lg:px-24">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-2xl md:text-3xl font-headline-md text-center mb-12">You May Also Like</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-12">
                            @foreach($related as $product)
                                @include('components.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if($recentlyViewed->count() > 0)
            <section class="py-24">
                <div class="px-6 md:px-12 lg:px-24">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="text-2xl md:text-3xl font-headline-md text-center mb-12">Recently Viewed</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-12">
                            @foreach($recentlyViewed as $product)
                                @include('components.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="py-24 bg-surface">
            <div class="max-w-4xl mx-auto px-6 md:px-12 lg:px-24">
                <h2 class="text-2xl md:text-3xl font-headline-md text-center mb-12">Customer Reviews</h2>
                <div class="flex items-center gap-8 mb-12">
                    <div class="text-center">
                        <div class="text-5xl font-headline-md">{{ number_format($reviewStats['average'], 1) }}</div>
                        <div class="flex items-center gap-1 mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($reviewStats['average']) ? 'text-on-surface' : 'text-outline-variant' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <div class="text-sm text-on-surface-variant mt-1">{{ $reviewStats['count'] }} reviews</div>
                    </div>
                    <div class="flex-1">
                        <form method="POST" action="{{ route('reviews.store', $product) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Your Rating</label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" class="text-outline-variant hover:text-on-surface transition-colors">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        </button>
                                    @endfor
                                </div>
                            </div>
                            <textarea required rows="4" placeholder="Write your review..." class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent"></textarea>
                            <button type="submit" class="bg-surface-container-lowest text-tertiary px-8 py-3 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection
