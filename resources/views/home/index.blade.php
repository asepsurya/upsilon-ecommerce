@extends('layouts.app')

@section('content')
    @include('components.hero')

    <!-- 2. Category Circles Showcase -->
    <section class="w-full bg-surface-container-low py-space-xl border-y border-outline-variant/20">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg">
                <div>
                    <span
                        class="font-label-caps text-label-caps uppercase tracking-widest text-primary block mb-space-xs">Archival
                        Categorization</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Curated Universes
                    </h2>
                </div>
                <p class="font-body-sm text-body-sm text-outline max-w-sm mt-2 md:mt-0">
                    Tailored structures, fluid evening drapery, and fine leather crafted with mathematical equilibrium.
                </p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-space-md">
                @foreach($categories as $category)
                    <a class="group flex flex-col items-center text-center"
                        href="{{ route('shop.category', $category->slug) }}">
                        <div
                            class="relative w-28 h-28 sm:w-32 sm:h-32 rounded-full p-1 bg-gradient-to-b from-primary/30 to-transparent group-hover:from-primary transition-all duration-500 mb-space-sm overflow-hidden">
                            <div class="w-full h-full rounded-full overflow-hidden bg-surface-container-high relative">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="{{ $category->image_url }}" alt="{{ $category->name }}">
                                <div class="absolute inset-0 bg-surface/20 group-hover:bg-transparent transition-colors"></div>
                            </div>
                        </div>
                        <span
                            class="font-headline-sm text-base text-on-surface group-hover:text-primary transition-colors uppercase tracking-tight">{{ $category->name }}</span>
                        <span
                            class="font-label-caps text-[10px] uppercase tracking-widest text-outline">{{ $category->product_count }}
                            {{ $category->count_label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. Curated Atelier Pieces / Garment Grid -->
    <section class="w-full bg-surface py-space-xl" id="curated-collection">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between pb-space-lg">
                <div>
                    <span
                        class="font-label-caps text-label-caps uppercase tracking-widest text-primary block mb-space-xs">Seasonal
                        Archival Release</span>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface uppercase tracking-tight">Curated Atelier
                        Pieces</h2>
                </div>
                <div class="flex items-center gap-2 overflow-x-auto pt-4 md:pt-0 scrollbar-hide" id="collection-filters">
                    <button
                        class="filter-pill active px-4 py-2 bg-primary text-on-primary font-label-caps text-label-caps uppercase tracking-widest transition-all">All
                        Pieces</button>
                    <button
                        class="filter-pill px-4 py-2 bg-surface-container-high text-on-surface-variant hover:text-primary hover:bg-surface-variant border border-outline-variant/40 font-label-caps text-label-caps uppercase tracking-widest transition-all">Tailored
                        Suits</button>
                    <button
                        class="filter-pill px-4 py-2 bg-surface-container-high text-on-surface-variant hover:text-primary hover:bg-surface-variant border border-outline-variant/40 font-label-caps text-label-caps uppercase tracking-widest transition-all">Silk
                        Gowns</button>
                    <button
                        class="filter-pill px-4 py-2 bg-surface-container-high text-on-surface-variant hover:text-primary hover:bg-surface-variant border border-outline-variant/40 font-label-caps text-label-caps uppercase tracking-widest transition-all">Cashmere
                        Knitwear</button>
                    <button
                        class="filter-pill px-4 py-2 bg-surface-container-high text-on-surface-variant hover:text-primary hover:bg-surface-variant border border-outline-variant/40 font-label-caps text-label-caps uppercase tracking-widest transition-all">Outerwear</button>
                    <button
                        class="filter-pill px-4 py-2 bg-surface-container-high text-on-surface-variant hover:text-primary hover:bg-surface-variant border border-outline-variant/40 font-label-caps text-label-caps uppercase tracking-widest transition-all">Fine
                        Leather</button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                @foreach($featuredProducts as $product)
                    @php
                        $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                    @endphp
                    <div
                        class="group relative bg-surface-container flex flex-col justify-between border border-outline-variant/30 hover:border-primary/50 transition-all duration-500 shadow-md">
                        <div class="relative w-full aspect-[3/4] overflow-hidden bg-surface-container-highest">
                            @if($primaryImage)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    src="{{ $primaryImage->url }}" alt="{{ $product->name }}">
                            @endif
                            @if($product->badge)
                                <span
                                    class="absolute top-3 left-3 bg-surface-container-lowest/90 backdrop-blur-md px-2.5 py-1 text-primary border border-primary/20 font-label-caps text-[10px] uppercase tracking-widest">
                                    {{ $product->badge }}
                                </span>
                            @endif
                            <button aria-label="Add to wishlist"
                                class="absolute top-3 right-3 w-8 h-8 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center text-on-surface hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <div
                                class="absolute inset-x-0 bottom-0 p-space-sm bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/90 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2">
                                <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Buy Product: I would like to buy ' . $product->name . ' priced at $' . number_format($product->sale_price ?? $product->base_price, 2) . '. Please provide details.') }}"
                                    class="flex-1 py-2.5 bg-primary text-on-primary font-label-caps text-[11px] tracking-widest uppercase hover:bg-primary/90 transition-colors font-semibold text-center"
                                    target="_blank" rel="noopener">
                                    Buy Product
                                </a>
                            </div>
                        </div>
                        <div class="p-space-md flex flex-col gap-1.5">
                            <div class="flex items-center justify-between text-outline text-[11px]">
                                <span
                                    class="font-label-caps tracking-widest uppercase text-primary">{{ $product->subtitle ?? ($product->category->name ?? 'Atelier') }}</span>
                                <span class="font-body-sm">{{ $product->edition ?? '' }}</span>
                            </div>
                            <h3
                                class="font-title-editorial text-title-editorial text-on-surface group-hover:text-primary transition-colors leading-tight">
                                <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant font-light line-clamp-1">
                                {{ $product->material }}
                            </p>
                            <div class="flex items-center justify-between pt-space-xs border-t border-outline-variant/20 mt-1">
                                <div class="flex flex-col">
                                    @if($product->sale_price && $product->sale_price < $product->base_price)
                                        <span class="font-label-sm text-base text-primary font-semibold">${{ number_format($product->sale_price, 0) }}</span>
                                        <span class="text-xs text-on-surface-variant line-through">${{ number_format($product->base_price, 0) }}</span>
                                    @else
                                        <span class="font-label-sm text-base text-on-surface font-semibold">${{ number_format($product->base_price, 0) }}</span>
                                    @endif
                                </div>
                                <span
                                    class="font-label-caps text-[10px] {{ $product->bottom_label == 'Immediate Dispatch' ? 'text-tertiary' : 'text-primary' }} tracking-widest uppercase">
                                    {{ $product->bottom_label ?? 'Includes Fitting' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full flex justify-center pt-space-xl">
                <button
                    class="px-10 py-3.5 bg-transparent border border-outline hover:border-primary text-on-surface hover:text-primary font-label-caps text-label-caps uppercase tracking-widest transition-all">
                    Explore All 142 Runway Artefacts
                </button>
            </div>
        </div>
    </section>

    <!-- 4. Featured Editorial Duet / Dual Promotional Banners -->
    <section class="w-full bg-surface-container-lowest py-space-xl">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg">
                <div
                    class="relative min-h-[500px] lg:min-h-[560px] flex flex-col justify-end p-space-lg lg:p-space-xl overflow-hidden group border border-outline-variant/30">
                    <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-1000"
                        style="background-image: url('{{ asset('storage/images/sample/banner-bespoke.jpg') }}')">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/70 to-transparent">
                    </div>
                    <div class="relative z-10 flex flex-col gap-space-sm max-w-md">
                        <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary">Made-to-Measure
                            Guild</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Bespoke
                            Tailoring Services</h3>
                        <p class="font-body-md text-body-md text-tertiary font-light">
                            Individual measurements taken in private salon suites. Cut, constructed, and hand-canvassed by
                            three generations of Milanese artisans.
                        </p>
                        <div class="pt-space-xs">
                            <a class="inline-flex items-center gap-2 text-primary font-label-caps text-label-caps uppercase tracking-widest group-hover:translate-x-1 transition-transform"
                                href="#">
                                <span>Explore Made-to-Measure</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="relative min-h-[500px] lg:min-h-[560px] flex flex-col justify-end p-space-lg lg:p-space-xl overflow-hidden group border border-outline-variant/30">
                    <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-1000"
                        style="background-image: url('{{ asset('storage/images/sample/banner-evening.jpg') }}')">
                    </div>
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/70 to-transparent">
                    </div>
                    <div class="relative z-10 flex flex-col gap-space-sm max-w-md">
                        <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary">Nocturne
                            Series</span>
                        <h3 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">The Evening
                            Capsule</h3>
                        <p class="font-body-md text-body-md text-tertiary font-light">
                            Architectural draping and hand-embroidered Czech glass beads. Silhouettes engineered for
                            majestic nocturnal presence and absolute stillness.
                        </p>
                        <div class="pt-space-xs">
                            <a class="inline-flex items-center gap-2 text-primary font-label-caps text-label-caps uppercase tracking-widest group-hover:translate-x-1 transition-transform"
                                href="#">
                                <span>Shop Eveningwear Capsule</span>
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Editorial Story & Craftsmanship Feature -->
    <section class="w-full bg-surface-container py-space-xl lg:py-24 border-y border-outline-variant/20">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
                <div class="lg:col-span-6 relative">
                    <div
                        class="relative z-10 w-full aspect-[4/5] bg-surface-container-highest overflow-hidden border border-outline-variant/40 shadow-2xl">
                        <img class="w-full h-full object-cover"
                            src="{{ asset('storage/images/sample/editorial-craft.jpg') }}" alt="Craftsmanship">
                    </div>
                    <div
                        class="hidden sm:block absolute -bottom-8 -right-8 z-20 w-64 bg-surface-container-lowest/95 backdrop-blur-xl p-space-md border border-primary/30 shadow-2xl">
                        <div class="flex items-center gap-2 text-primary mb-1">
                            <span class="material-symbols-outlined text-lg">verified</span>
                            <span class="font-label-caps text-[10px] uppercase tracking-widest">Guaranteed Provenance</span>
                        </div>
                        <p class="font-body-sm text-xs text-on-surface-variant font-light">
                            Every garment carries an engraved serial hallmark and encrypted NFC passport.
                        </p>
                    </div>
                </div>
                <div class="lg:col-span-6 flex flex-col gap-space-md">
                    <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary">The Atelier
                        Philosophy</span>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface uppercase tracking-tight leading-tight">
                        Monolithic Permanence<br>
                        <span class="font-display-hero italic font-normal text-secondary">Over Obsolescence</span>
                    </h2>
                    <blockquote
                        class="border-l-2 border-primary pl-space-md my-space-xs font-title-editorial text-title-editorial text-on-surface italic font-normal">
                        "Elegance is not about being noticed, it is about being remembered."
                        <footer
                            class="font-label-caps text-label-caps uppercase tracking-widest text-primary not-italic mt-2 block">
                            — Alessandro DeLuca, Master Head of Atelier
                        </footer>
                    </blockquote>
                    <p class="font-body-md text-body-md text-on-surface-variant font-light leading-relaxed">
                        In an era of disposable velocity, Atelier Noir operates under the discipline of permanence. We
                        reject seasonal trends in favor of structural authority. Our garments are engineered in Biella and
                        Lyon using zero synthetics, harvested ethically with full regenerative certification.
                    </p>
                    <div class="grid grid-cols-3 gap-space-md pt-space-md border-t border-outline-variant/30">
                        <div>
                            <span
                                class="font-headline-lg text-headline-md lg:text-headline-lg text-primary block leading-none">38</span>
                            <span
                                class="font-label-caps text-[10px] uppercase tracking-widest text-outline mt-1 block">Hand-Stitched
                                Hours Per Suit</span>
                        </div>
                        <div>
                            <span
                                class="font-headline-lg text-headline-md lg:text-headline-lg text-primary block leading-none">100%</span>
                            <span
                                class="font-label-caps text-[10px] uppercase tracking-widest text-outline mt-1 block">Organic
                                Silk & Cashmere</span>
                        </div>
                        <div>
                            <span
                                class="font-headline-lg text-headline-md lg:text-headline-lg text-primary block leading-none">0%</span>
                            <span
                                class="font-label-caps text-[10px] uppercase tracking-widest text-outline mt-1 block">Synthetic
                                Blends</span>
                        </div>
                    </div>
                    <div class="pt-space-sm">
                        <button
                            class="px-8 py-3.5 bg-primary-container hover:bg-primary text-on-primary-container font-label-caps text-label-caps uppercase tracking-widest transition-colors">
                            Read The Manifesto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How to Order Section -->
    <section
        class="w-full bg-surface-container-lowest py-20 lg:py-32 border-b border-outline-variant/20 relative overflow-hidden">
        <div class="max-w-[1600px] mx-auto px-6 lg:px-12 " style="margin-top:50px;margin-bottom:50px">

            <!-- Section Header -->
            <div class="text-center mb-20" style="margin-bottom: 100px">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <span class="block w-8 h-px bg-primary/40"></span>
                    <span class="font-label-caps text-xs tracking-[0.3em] uppercase text-primary font-medium">Ordering
                        Guide</span>
                    <span class="block w-8 h-px bg-primary/40"></span>
                </div>
                <h2 class="font-headline-md text-3xl md:text-4xl text-on-surface uppercase tracking-tight mb-4">How to Order
                </h2>
                <p class="font-body-sm text-base text-outline max-w-md mx-auto font-light">
                    Secure your desired pieces effortlessly via WhatsApp in three seamless steps.
                </p>
            </div>

            <!-- Steps Container -->
            <div class="relative max-w-5xl mx-auto">

                <!-- Connecting Line (Hanya tampil di Desktop) -->
                <div
                    class="hidden md:block absolute top-[2.5rem] left-[15%] right-[15%] h-px bg-gradient-to-r from-transparent via-primary/30 to-transparent z-0">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">

                    <!-- Step 1 -->
                    <div class="text-center group cursor-default">
                        <div
                            class="relative w-20 h-20 mx-auto mb-8 rounded-full bg-surface border border-outline-variant/30 flex items-center justify-center group-hover:border-primary/50 group-hover:shadow-2xl group-hover:shadow-primary/10 transition-all duration-500 z-10">
                            <span
                                class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary transition-colors duration-500">search</span>
                            <!-- Step Indicator Badge -->

                        </div>
                        <h3 class="font-headline-sm text-lg text-on-surface mb-3 tracking-wide">Choose Your Product</h3>
                        <p class="font-body-sm text-sm text-on-surface-variant/80 font-light leading-relaxed px-4">
                            Explore our curated collection and select the pieces that define your style.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center group cursor-default">
                        <div
                            class="relative w-20 h-20 mx-auto mb-8 rounded-full bg-surface border border-outline-variant/30 flex items-center justify-center group-hover:border-primary/50 group-hover:shadow-2xl group-hover:shadow-primary/10 transition-all duration-500 z-10">
                            <span
                                class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary transition-colors duration-500">chat</span>
                            <!-- Step Indicator Badge -->

                        </div>
                        <h3 class="font-headline-sm text-lg text-on-surface mb-3 tracking-wide">Connect via WhatsApp</h3>
                        <p class="font-body-sm text-sm text-on-surface-variant/80 font-light leading-relaxed px-4">
                            Click the inquiry button on your chosen product to connect with our atelier.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center group cursor-default">
                        <div
                            class="relative w-20 h-20 mx-auto mb-8 rounded-full bg-surface border border-outline-variant/30 flex items-center justify-center group-hover:border-primary/50 group-hover:shadow-2xl group-hover:shadow-primary/10 transition-all duration-500 z-10">
                            <span
                                class="material-symbols-outlined text-3xl text-on-surface-variant group-hover:text-primary transition-colors duration-500">check_circle</span>

                        </div>
                        <h3 class="font-headline-sm text-lg text-on-surface mb-3 tracking-wide">Confirm Order</h3>
                        <p class="font-body-sm text-sm text-on-surface-variant/80 font-light leading-relaxed px-4">
                            Finalize your measurements and details directly with our style advisors.
                        </p>
                    </div>

                </div>
            </div>

            <!-- Action Button -->
            <div class="text-center" style="margin-top:50px">
                <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I would like to inquire about your products.') }}"
                    class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-[0.2em] uppercase overflow-hidden shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all duration-300"
                    target="_blank" rel="noopener">
                    <span class="relative z-10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">forum</span>
                        Contact Our Atelier
                    </span>
                </a>
            </div>

        </div>
    </section>

    <!-- Product Bundling Section -->
    <section class="w-full bg-surface py-space-xl border-t border-outline-variant/20">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="text-center mb-space-lg">
                <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary block mb-space-xs">Exclusive Offers</span>
                <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Product Bundles</h2>
                <p class="font-body-sm text-body-sm text-outline max-w-md mx-auto mt-2">Complete your wardrobe with our curated bundles at exceptional value</p>
            </div>

            @if($bundles->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($bundles as $bundle)
                        <div class="group bg-surface-container border border-outline-variant/30 hover:border-primary/40 transition-all duration-300 rounded-2xl overflow-hidden relative">
                            <div class="aspect-square bg-surface-container-high relative overflow-hidden">
                                @if($bundle->thumbnail)
                                    <img src="{{ asset('storage/' . $bundle->thumbnail) }}" alt="{{ $bundle->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <img src="https://placehold.co/600x600/0B1F3A/FFFFFF?text={{ urlencode($bundle->name) }}" alt="{{ $bundle->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @endif
                                @if($bundle->discount_percent > 0)
                                    <div class="absolute top-4 left-4 bg-primary text-on-primary px-3 py-1 font-label-caps text-[10px] uppercase tracking-widest">Save {{ $bundle->discount_percent }}%</div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="font-headline-sm text-base text-on-surface mb-2">{{ $bundle->name }}</h3>
                                <p class="font-body-sm text-sm text-on-surface-variant mb-4">{{ $bundle->items_count }} products</p>
                                
                                @if($bundle->items->isNotEmpty())
                                    <div class="mb-4 space-y-2 max-h-32 overflow-y-auto">
                                        @foreach($bundle->items->take(5) as $item)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="font-body-sm text-on-surface-variant">{{ $item->product->name ?? 'Product' }} × {{ $item->quantity }}</span>
                                                <span class="font-body-sm text-on-surface">${{ number_format(($item->product->base_price ?? 0) * $item->quantity, 0) }}</span>
                                            </div>
                                        @endforeach
                                        @if($bundle->items->count() > 5)
                                            <div class="text-xs text-muted">+{{ $bundle->items->count() - 5 }} more items</div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="flex items-center gap-3 mb-4">
                                    @if($bundle->bundle_price)
                                        <span class="font-label-price text-xl text-primary">${{ number_format($bundle->bundle_price, 0) }}</span>
                                        @if($bundle->original_price > 0)
                                            <span class="font-body-sm text-sm text-on-surface-variant line-through">${{ number_format($bundle->original_price, 0) }}</span>
                                        @endif
                                    @endif
                                </div>
                                <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I am interested in ' . $bundle->name . ' bundle.') }}"
                                    class="w-full bg-primary-container hover:bg-primary-fixed text-on-primary-container font-headline-md text-body-sm font-semibold px-6 py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2"
                                    target="_blank" rel="noopener">
                                    <span class="material-symbols-outlined text-[18px]">chat</span>
                                    Order Bundle
                                </a>
                            </div>
                            @if($bundle->description)
                                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/95 via-surface-container-lowest/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6 pointer-events-none">
                                    <div class="w-full bg-surface-container-lowest/90 backdrop-blur-md rounded-xl p-4 text-sm text-on-surface font-light leading-relaxed border border-outline-variant/20 max-h-[200px] overflow-y-auto">
                                        {{ $bundle->description }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted">No bundles available at the moment.</p>
            @endif
        </div>
    </section>

    <!-- 6. VIP Client Reviews & Press Accolades -->
    <section class="w-full bg-surface-container-lowest py-space-xl">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="text-center max-w-xl mx-auto mb-space-xl">
                <span
                    class="font-label-caps text-label-caps uppercase tracking-widest text-primary block mb-space-xs">Critical
                    Acclaim & Patronage</span>
                <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">The Discourse of
                    Prestige</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg pt-space-xl">
                <div class="bg-surface-container p-space-lg border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-primary mb-space-sm">
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                        </div>
                        <p class="font-body-md text-body-md text-tertiary font-light leading-relaxed mb-space-md">
                            "The double-breasted wool blazer fits with the surgical balance of Savile Row, but possesses a
                            dark silhouette found nowhere else. The tactile sensation of the Loro Piana weave is
                            breathtaking."
                        </p>
                    </div>
                    <div class="border-t border-outline-variant/20 pt-space-sm flex items-center justify-between">
                        <div>
                            <span
                                class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider block">Lady
                                Genevieve M.</span>
                            <span class="font-body-sm text-[11px] text-outline">London • Private Client since 2021</span>
                        </div>
                        <span class="material-symbols-outlined text-primary text-lg">verified</span>
                    </div>
                </div>
                <div class="bg-surface-container p-space-lg border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-primary mb-space-sm">
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                        </div>
                        <p class="font-body-md text-body-md text-tertiary font-light leading-relaxed mb-space-md">
                            "The private salon appointment at Place Vendôme was utterly discreet and peerless. The silk
                            georgette gown moves like liquid obsidian under ballroom lights. An irreplaceable piece."
                        </p>
                    </div>
                    <div class="border-t border-outline-variant/20 pt-space-sm flex items-center justify-between">
                        <div>
                            <span
                                class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider block">Arthur
                                Vance</span>
                            <span class="font-body-sm text-[11px] text-outline">Paris • Guild Collector</span>
                        </div>
                        <span class="material-symbols-outlined text-primary text-lg">verified</span>
                    </div>
                </div>
                <div class="bg-surface-container p-space-lg border border-outline-variant/30 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-primary mb-space-sm">
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                            <span class="material-symbols-outlined text-base">star</span>
                        </div>
                        <p class="font-body-md text-body-md text-tertiary font-light leading-relaxed mb-space-md">
                            "I ordered the Florentine nappa overcoat bespoke. The white-glove courier delivery arrived in a
                            temperature-controlled cedar trunk. The level of uncompromising craft is deeply inspiring."
                        </p>
                    </div>
                    <div class="border-t border-outline-variant/20 pt-space-sm flex items-center justify-between">
                        <div>
                            <span
                                class="font-label-caps text-label-caps text-on-surface uppercase tracking-wider block">Kenji
                                Takahashi</span>
                            <span class="font-body-sm text-[11px] text-outline">Tokyo • Bespoke Patron</span>
                        </div>
                        <span class="material-symbols-outlined text-primary text-lg">verified</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Runway Journal & Style Insights -->
    <section class="w-full bg-surface py-space-xl border-t border-outline-variant/20">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-space-lg">
                <div>
                    <span
                        class="font-label-caps text-label-caps uppercase tracking-widest text-primary block mb-space-xs">The
                        Noir Gazette</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Runway Journal &
                        Insights</h2>
                </div>
                <a class="inline-flex items-center gap-2 text-primary font-label-caps text-label-caps uppercase tracking-widest hover:underline mt-2 md:mt-0"
                    href="https://instagram.com/ateliernoir" target="_blank" rel="noopener">
                    <span>View Our Instagram</span>
                    <span class="material-symbols-outlined text-base">north_east</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
                @foreach($articles as $article)
                    <article
                        class="group bg-surface-container flex flex-col border border-outline-variant/30 hover:border-primary/40 transition-colors">
                        <div class="relative aspect-[16/10] overflow-hidden bg-surface-container-highest">
                            @if($article['image'])
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                    src="{{ $article['image'] }}" alt="{{ $article['title'] }}">
                            @endif
                            <span
                                class="absolute top-3 left-3 bg-surface-container-lowest/90 px-2.5 py-1 text-primary font-label-caps text-[10px] uppercase tracking-widest">{{ $article['category'] }}</span>
                        </div>
                        <div class="p-space-md flex flex-col justify-between flex-1">
                            <div>
                                <div class="flex items-center gap-space-sm text-outline text-[11px] mb-space-xs">
                                    <span>{{ $article['date'] }}</span>
                                    <span>•</span>
                                    <span>{{ $article['reading_time'] }} min reading</span>
                                </div>
                                <h3
                                    class="font-title-editorial text-title-editorial text-on-surface group-hover:text-primary transition-colors leading-tight mb-space-xs">
                                    {{ $article['title'] }}
                                </h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant font-light line-clamp-2">
                                    {{ $article['excerpt'] }}
                                </p>
                            </div>
                            <div
                                class="pt-space-sm mt-space-sm border-t border-outline-variant/20 flex items-center justify-between text-primary font-label-caps text-[11px] tracking-widest uppercase">
                                <a href="{{ $article['permalink'] }}" target="_blank" rel="noopener">Read Chronicle</a>
                                <span
                                    class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>



    <!-- 8. Private Fitting Booking Modal -->
    <div class="hidden fixed inset-0 z-50 flex items-center justify-center p-space-md bg-surface-container-lowest/90 backdrop-blur-xl"
        id="booking-modal">
        <div class="relative w-full max-w-lg bg-surface-container p-space-lg border border-primary/40 shadow-2xl">
            <div class="flex items-center justify-between pb-space-sm border-b border-outline-variant/30 mb-space-md">
                <div>
                    <span class="font-label-caps text-[10px] uppercase tracking-widest text-primary block">Maison
                        Privée</span>
                    <h3 class="font-headline-sm text-headline-sm uppercase text-on-surface">Book Atelier Fitting</h3>
                </div>
                <button class="text-outline hover:text-on-surface transition-colors p-1"
                    onclick="document.getElementById('booking-modal').classList.add('hidden')">
                    <span class="material-symbols-outlined text-2xl">close</span>
                </button>
            </div>
            <form class="flex flex-col gap-space-sm"
                onsubmit="event.preventDefault(); alert('Appointment request transmitted to your private concierge.'); document.getElementById('booking-modal').classList.add('hidden');">
                <div>
                    <label
                        class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant block mb-1">Full
                        Name</label>
                    <input
                        class="w-full bg-surface-container-low border border-outline-variant p-2.5 text-on-surface font-body-sm focus:border-primary focus:outline-none"
                        placeholder="e.g. Eleanor Vance" required type="text">
                </div>
                <div>
                    <label
                        class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant block mb-1">Direct
                        Contact / Concierge Email</label>
                    <input
                        class="w-full bg-surface-container-low border border-outline-variant p-2.5 text-on-surface font-body-sm focus:border-primary focus:outline-none"
                        placeholder="e.g. client@private.com" required type="email">
                </div>
                <div>
                    <label
                        class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant block mb-1">Salon
                        Location</label>
                    <select
                        class="w-full bg-surface-container-low border border-outline-variant p-2.5 text-on-surface font-body-sm focus:border-primary focus:outline-none">
                        <option>Paris • Place Vendôme Salon Privé</option>
                        <option>Milan • Via Montenapoleone Atelier</option>
                        <option>London • Mayfair Guild Suite</option>
                        <option>New York • Madison Avenue Salon</option>
                        <option>Tokyo • Ginza Private Residence</option>
                    </select>
                </div>
                <div>
                    <label
                        class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant block mb-1">Sartorial
                        Interest</label>
                    <select
                        class="w-full bg-surface-container-low border border-outline-variant p-2.5 text-on-surface font-body-sm focus:border-primary focus:outline-none">
                        <option>Bespoke Suiting & Tailoring</option>
                        <option>Haute Couture Eveningwear</option>
                        <option>Custom Nappa Leather Outwear</option>
                        <option>Bridal & Gala Commission</option>
                    </select>
                </div>
                <div class="pt-space-sm">
                    <button
                        class="w-full py-3.5 bg-primary text-on-primary font-label-caps text-label-caps uppercase tracking-widest hover:bg-secondary transition-colors font-semibold"
                        type="submit">
                        Confirm Fitting Request
                    </button>
                </div>
                <p class="font-body-sm text-[10px] text-outline text-center mt-1">
                    A dedicated private atelier valet will contact your office within two hours.
                </p>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('#collection-filters .filter-pill').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#collection-filters .filter-pill').forEach(b => {
                    b.classList.remove('bg-primary', 'text-on-primary', 'active');
                    b.classList.add('bg-surface-container-high', 'text-on-surface-variant');
                });
                btn.classList.add('bg-primary', 'text-on-primary', 'active');
                btn.classList.remove('bg-surface-container-high', 'text-on-surface-variant');
            });
        });
    </script>
@endsection