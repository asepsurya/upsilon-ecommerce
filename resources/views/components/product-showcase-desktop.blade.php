<div class="w-full">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" id="desktop-showcase">
        @foreach($products->take(4) as $product)
            <div class="group relative bg-surface-container-low rounded-2xl overflow-hidden hover:bg-surface-container transition-all duration-500 shadow-sm hover:shadow-xl">
                <div class="flex flex-col md:flex-row h-full">
                    <!-- Product Image - 4:5 Aspect Ratio -->
                    <div class="showcase-card-image relative w-full md:w-1/2">
                        @php
                            $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                        @endphp

                        @if($product->is_new_arrival)
                            <span class="absolute top-4 left-4 z-10 px-3 py-1.5 text-xs font-bold tracking-widest uppercase bg-surface-container-highest text-primary-fixed rounded-lg">
                                NEW
                            </span>
                        @elseif($product->sale_price && $product->sale_price < $product->base_price)
                            <span class="absolute top-4 left-4 z-10 px-3 py-1.5 text-xs font-bold tracking-widest uppercase bg-primary-container text-on-primary-container rounded-lg">
                                SALE {{ $product->discount_percent }}%
                            </span>
                        @endif

                        <button aria-label="Add to wishlist"
                            class="absolute top-4 right-4 z-10 w-10 h-10 rounded-lg bg-surface/70 backdrop-blur-md flex items-center justify-center text-on-surface-variant hover:text-primary-fixed transition-all duration-300 opacity-0 group-hover:opacity-100">
                            <span class="material-symbols-outlined text-[20px]">favorite</span>
                        </button>

                        <a href="{{ route('product.show', $product) }}" class="block w-full h-full">
                            @if($primaryImage)
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                src="{{ $primaryImage->url }}" alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-outline-variant text-sm uppercase tracking-wider">No Image</span>
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Product Details -->
                    <div class="flex flex-col justify-between p-6 md:p-8 w-full md:w-1/2">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-label-tech text-label-tech text-xs uppercase tracking-widest text-primary-fixed font-semibold">
                                    {{ $product->category->name ?? 'UPSILON' }}
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-primary-fixed" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="font-label-tech text-label-tech text-sm font-bold text-primary-fixed">{{ number_format($product->rating ?? 4.8, 1) }}</span>
                                    <span class="font-label-tech text-label-tech text-xs text-on-surface-variant">({{ $product->reviews_count ?? 0 }})</span>
                                </div>
                            </div>

                            <h3 class="font-headline-lg text-headline-lg text-primary group-hover:text-primary-fixed transition-colors duration-300 mb-3 leading-tight">
                                <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                            </h3>

                            @if($product->description)
                                <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-6 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-end justify-between mb-6">
                                <div class="flex items-baseline gap-3">
                                    @if($product->sale_price && $product->sale_price < $product->base_price)
                                        <span class="font-label-price text-label-price text-2xl text-primary">${{ number_format($product->sale_price, 2) }}</span>
                                        <span class="font-label-tech text-label-tech text-base text-on-surface-variant line-through">${{ number_format($product->base_price, 2) }}</span>
                                    @else
                                        <span class="font-label-price text-label-price text-2xl text-primary">${{ number_format($product->base_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <a
                                href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Buy Product: I would like to buy ' . $product->name . ' priced at $' . number_format($product->sale_price ?? $product->base_price, 2) . '. Please provide details.') }}"
                                class="w-full bg-primary hover:bg-primary/90 text-on-primary font-headline-md text-body-sm font-semibold px-6 py-3.5 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 group/btn"
                                target="_blank" rel="noopener">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                                Buy Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
