@extends("layouts.app")


@section("content")
    <!-- Sub-Header / Breadcrumb & Editorial Header Context -->
    <section class="w-full px-grid-margin-mobile lg:px-grid-margin-desktop max-w-7xl mx-auto pt-space-md pb-space-lg">
        <div class="flex flex-col gap-space-xs">
            <div class="flex items-center gap-space-xs font-label-tech text-label-tech text-on-surface-variant">
                <a class="hover:text-primary transition-colors uppercase tracking-wider" data-path="catalog"
                    href="#">INDEX</a>
                <span>/</span>
                <a class="hover:text-primary transition-colors uppercase tracking-wider" data-path="bestsellers"
                    href="#">STORE</a>
                <span>/</span>
                <span class="text-primary-fixed uppercase tracking-wider font-semibold">CATALOG [REF. 2025]</span>
            </div>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mt-space-2xs">
                <div>
                    <h1
                        class="font-headline-xl text-headline-xl text-primary tracking-tight uppercase flex items-center gap-space-sm">
                        Shop All
                        <span
                            class="font-label-tech text-label-tech px-space-xs py-0.5 rounded bg-surface-container-high text-primary-fixed border-0 font-medium">{{ $products->total() }}
                            UNITS</span>
                    </h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 max-w-xl">
                        High-velocity acoustic monitors, cybernetic chassis wearables, and performance nocturnal tactical
                        gear. Engineered with uncompromising tactile tolerances.
                    </p>
                </div>
                <div class="hidden lg:flex items-center gap-space-md bg-surface-container-low px-space-md py-2 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                        <span class="font-label-tech text-label-tech text-on-surface uppercase">FEED: REALTIME</span>
                    </div>
                    <span class="font-label-tech text-label-tech text-on-surface-variant">|</span>
                    <span class="font-label-tech text-label-tech text-on-surface-variant">LOGISTICS: CONTINENTAL US
                        [ONLINE]</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Catalog Workspace: Sidebar Filters + Product Matrix -->
    <section class="w-full px-grid-margin-mobile lg:px-grid-margin-desktop max-w-7xl mx-auto pb-space-3xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl">
            <!-- LEFT SIDEBAR / FILTER DRAWER (Col 1-3) -->
            <aside class="lg:col-span-3 flex flex-col gap-space-lg">
                <!-- Active Quick Filter Tags & Reset -->
                <div class="bg-surface-container-low p-space-md rounded-xl flex flex-col gap-space-sm shadow-sm">
                    <div class="flex items-center justify-between">
                        <span
                            class="font-label-tech text-label-tech uppercase text-primary tracking-widest font-semibold">Active
                            Matrix</span>
                        <button
                            class="flex items-center gap-1 font-label-tech text-label-tech text-on-surface-variant hover:text-primary-fixed transition-colors"
                            id="reset-filters" type="button">
                            <span class="material-symbols-outlined text-[14px]">restart_alt</span>
                            <span>Reset</span>
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1" id="active-tag-cloud">
                        @if(request()->hasAny(['category', 'size', 'color', 'min_price', 'max_price', 'in_stock']))
                            @foreach(request()->only(['category', 'size', 'color', 'min_price', 'max_price', 'in_stock']) as $key => $value)
                                @if($value)
                                    <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                                        class="inline-flex items-center gap-1 bg-surface-container-high text-on-surface font-label-tech text-label-tech px-2.5 py-1 rounded-md group hover:bg-surface-bright transition-colors">
                                        <span>{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                        <span
                                            class="material-symbols-outlined text-[12px] text-on-surface-variant group-hover:text-primary">close</span>
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <span class="font-label-tech text-label-tech text-on-surface-variant italic">No filters
                                active</span>
                        @endif
                    </div>
                </div>

                <!-- Unified Filter Form: Price + Category + Size + Color + Stock -->
                @php
                    $filterMin = (int) request('min_price', 0);
                    $filterMax = (int) request('max_price', $maxPrice);
                    $rangeSpan = $maxPrice > 0 ? $maxPrice : 1;
                    $fillLeftPct = max(0, min(100, ($filterMin / $rangeSpan) * 100));
                    $fillWidthPct = max(0, min(100 - $fillLeftPct, (($filterMax - $filterMin) / $rangeSpan) * 100));
                @endphp
                <form method="GET" action="{{ route('shop') }}" class="flex flex-col gap-space-lg" id="filter-form">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Filter Accordion 1: Price Scope -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm accordion-section">
                        <button type="button" class="accordion-toggle flex items-center justify-between cursor-pointer group w-full text-left">
                            <span class="font-headline-md text-headline-md text-primary tracking-tight">Price Range</span>
                            <span
                                class="material-symbols-outlined accordion-icon text-on-surface-variant group-hover:text-primary transition-colors text-[20px]">expand_less</span>
                        </button>
                        <div class="accordion-content flex flex-col gap-space-sm">
                            <div class="flex items-center justify-between font-label-tech text-label-tech text-on-surface-variant pt-2">
                                <span>${{ number_format($filterMin) }}</span>
                                <span class="text-primary-fixed font-bold">${{ number_format($filterMax) }} MAX</span>
                            </div>
                            <div class="relative w-full h-1.5 bg-surface-container-high rounded-full overflow-hidden my-1">
                                <div class="absolute top-0 h-full bg-primary-container rounded-full"
                                    style="left: {{ $fillLeftPct }}%; width: {{ $fillWidthPct }}%;"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-1">
                                <div
                                    class="bg-surface-container px-2.5 py-1.5 rounded-lg flex items-center justify-between font-label-tech text-label-tech">
                                    <span class="text-on-surface-variant">MIN</span>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                                        class="w-full bg-transparent text-on-surface text-right focus:outline-none">
                                </div>
                                <div
                                    class="bg-surface-container px-2.5 py-1.5 rounded-lg flex items-center justify-between font-label-tech text-label-tech">
                                    <span class="text-on-surface-variant">MAX</span>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ $maxPrice }}"
                                        class="w-full bg-transparent text-on-surface text-right focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Accordion 2: Categories Matrix -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm accordion-section">
                        <button type="button" class="accordion-toggle flex items-center justify-between cursor-pointer group w-full text-left">
                            <span class="font-headline-md text-headline-md text-primary tracking-tight">Category</span>
                            <span
                                class="material-symbols-outlined accordion-icon text-on-surface-variant group-hover:text-primary transition-colors text-[20px]">expand_less</span>
                        </button>
                        <div class="accordion-content space-y-2 pt-1">
                            @foreach($categories as $category)
                                <label class="flex items-center justify-between cursor-pointer group select-none">
                                    <div class="flex items-center gap-2.5">
                                        <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }}
                                            class="accent-primary-container w-4 h-4 cursor-pointer">
                                        <span
                                            class="font-body-md text-body-md {{ request('category') == $category->slug ? 'text-primary font-medium' : 'text-on-surface-variant group-hover:text-on-surface transition-colors' }}">{{ $category->name }}</span>
                                    </div>
                                    <span
                                        class="font-label-tech text-label-tech text-on-surface-variant">{{ $category->products_count ?? 0 }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Accordion 3: Sizes -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm accordion-section">
                        <button type="button" class="accordion-toggle flex items-center justify-between cursor-pointer group w-full text-left">
                            <span class="font-headline-md text-headline-md text-primary tracking-tight">Size</span>
                            <span
                                class="material-symbols-outlined accordion-icon text-on-surface-variant group-hover:text-primary transition-colors text-[20px]">expand_less</span>
                        </button>
                        <div class="accordion-content flex flex-wrap gap-2 pt-1">
                            @foreach($sizes as $size)
                                <label class="cursor-pointer">
                                    <input type="radio" name="size" value="{{ $size->slug }}" {{ request('size') == $size->slug ? 'checked' : '' }} class="sr-only peer">
                                    <span
                                        class="inline-block border border-outline-variant/50 px-3 py-1 text-xs tracking-wider peer-checked:bg-surface-container-lowest peer-checked:text-tertiary peer-checked:border-outline-variant transition-colors">{{ $size->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Accordion 4: Colors -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm accordion-section">
                        <button type="button" class="accordion-toggle flex items-center justify-between cursor-pointer group w-full text-left">
                            <span class="font-headline-md text-headline-md text-primary tracking-tight">Color</span>
                            <span
                                class="material-symbols-outlined accordion-icon text-on-surface-variant group-hover:text-primary transition-colors text-[20px]">expand_less</span>
                        </button>
                        <div class="accordion-content flex flex-wrap gap-3 pt-1">
                            @foreach($colors as $color)
                                <label class="cursor-pointer relative" title="{{ $color->name }}">
                                    <input type="radio" name="color" value="{{ $color->slug }}" {{ request('color') == $color->slug ? 'checked' : '' }} class="sr-only peer">
                                    <span
                                        class="inline-block w-7 h-7 rounded-full border-2 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-primary-container transition-all"
                                        style="background-color: {{ $color->hex_code ?? '#000' }}"></span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Accordion 5: Stock -->
                    <div class="bg-surface-container-low p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm accordion-section">
                        <button type="button" class="accordion-toggle flex items-center justify-between cursor-pointer group w-full text-left">
                            <span class="font-headline-md text-headline-md text-primary tracking-tight">Availability</span>
                            <span
                                class="material-symbols-outlined accordion-icon text-on-surface-variant group-hover:text-primary transition-colors text-[20px]">expand_less</span>
                        </button>
                        <div class="accordion-content space-y-2 pt-1">
                            <label class="flex items-center justify-between cursor-pointer select-none">
                                <div class="flex items-center gap-2.5">
                                    <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}
                                        class="accent-primary-container w-4 h-4 rounded cursor-pointer">
                                    <span class="font-body-md text-body-md text-on-surface">In Stock Only</span>
                                </div>
                                <span class="font-label-tech text-label-tech text-primary-fixed">FAST-TRACK</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary-container text-on-primary-container font-headline-md text-body-sm font-semibold px-space-md py-2 rounded-lg hover:bg-primary-fixed transition-colors">
                        Apply Filters
                    </button>
                </form>

                <!-- Editorial Banner Promo in Sidebar -->
                <div
                    class="relative rounded-xl overflow-hidden bg-surface-container p-space-md flex flex-col justify-between h-48">
                    <div class="z-10 flex flex-col">
                        <span class="font-label-tech text-label-tech uppercase text-primary-fixed tracking-widest">EDITION
                            ZERO</span>
                        <span class="font-headline-md text-headline-md text-primary mt-1">Modular Sound Bar</span>
                        <span class="font-body-sm text-body-sm text-on-surface-variant mt-1">Bespoke CNC milled aircraft
                            aluminum.</span>
                    </div>
                    <div class="z-10">
                        <a class="inline-flex items-center gap-1 font-label-tech text-label-tech text-primary hover:text-primary-fixed font-bold uppercase transition-colors"
                            data-path="catalog" href="#">
                            Inspect Spec <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                    <div
                        class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-primary-container/10 blur-xl pointer-events-none">
                    </div>
                </div>
            </aside>

            <!-- RIGHT PRODUCT LIST & TOP INTERACTIVE CONTROLS (Col 4-12) -->
            <main class="lg:col-span-9 flex flex-col gap-space-lg">
                <!-- Top Toolbar: Pill Filters + Sort Selector -->
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-space-sm bg-surface-container-low p-2 rounded-xl">
                    <!-- Category Tabs Horizontal Stream -->
                    <div class="flex items-center gap-1 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0 scrollbar-hide"
                        id="category-pills">
                        <a href="{{ route('shop') }}"
                            class="category-pill {{ !request('category') ? 'bg-primary-container text-on-primary-container font-headline-md text-body-sm px-space-md py-1.5 rounded-lg transition-all font-semibold whitespace-nowrap shadow-sm' : 'bg-surface-container-high hover:bg-surface-bright text-on-surface font-body-sm text-body-sm px-space-md py-1.5 rounded-lg transition-all whitespace-nowrap' }}">
                            All Items
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}"
                                class="category-pill {{ request('category') == $category->slug ? 'bg-primary-container text-on-primary-container font-headline-md text-body-sm px-space-md py-1.5 rounded-lg transition-all font-semibold whitespace-nowrap shadow-sm' : 'bg-surface-container-high hover:bg-surface-bright text-on-surface font-body-sm text-body-sm px-space-md py-1.5 rounded-lg transition-all whitespace-nowrap' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Sorting Selector Dropdown Button -->
                    <div class="flex items-center gap-2 self-end sm:self-auto shrink-0">
                        <div class="relative inline-block text-left" id="sort-dropdown-container">
                            <button
                                class="flex items-center gap-2 bg-surface-container-high hover:bg-surface-bright text-on-surface px-space-md py-1.5 rounded-lg font-label-tech text-label-tech transition-colors"
                                id="sort-button" type="button">
                                <span class="material-symbols-outlined text-[16px] text-primary-fixed">tune</span>
                                <span id="sort-current-label">{{ strtoupper(str_replace('_', ' ', request('sort', 'top rated'))) }}</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_drop_down</span>
                            </button>
                            <!-- Popover Menu -->
                            @php
                                $sortOptions = [
                                    '' => 'Top Rated (Default)',
                                    'price_high' => 'Price: High to Low',
                                    'price_low' => 'Price: Low to High',
                                    'newest' => 'Newest Releases',
                                ];
                                $currentSort = request('sort', '');
                            @endphp
                            <div class="hidden absolute right-0 mt-2 w-48 rounded-lg bg-surface-container shadow-xl py-1 z-30 ring-1 ring-white/10"
                                id="sort-menu">
                                @foreach($sortOptions as $sortValue => $sortLabel)
                                    <a class="block px-4 py-2 font-label-tech text-label-tech {{ $currentSort === $sortValue ? 'text-primary-fixed bg-surface-container-high' : 'text-on-surface hover:bg-surface-container-high' }}"
                                        href="{{ $sortValue ? route('shop', array_merge(request()->except('sort'), ['sort' => $sortValue])) : route('shop', request()->except('sort')) }}">{{ $sortLabel }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Matrix Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 w-full" id="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    @forelse($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-24">
                            <p class="text-on-surface-variant">No products found matching your criteria.</p>
                        </div>
                    @endforelse
                </div>

                @if($products->hasPages())
                    <!-- Technical Telemetry Pagination -->
                    <div
                        class="mt-space-lg pt-space-md flex flex-col sm:flex-row items-center justify-between gap-space-md bg-surface-container-low p-space-md rounded-xl">
                        <div class="flex items-center gap-2 font-label-tech text-label-tech text-on-surface-variant">
                            <span>DISPLAYING</span>
                            <span
                                class="text-primary font-bold">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span>
                            <span>OF</span>
                            <span class="text-primary font-bold">{{ $products->total() }} ITEMS</span>
                        </div>
                        <div class="flex items-center gap-1">
                            {{ $products->links() }}
                        </div>
                        <div class="font-label-tech text-label-tech text-on-surface-variant flex items-center gap-1">
                            <span>TERMINAL VERIFIED</span>
                            <span class="material-symbols-outlined text-[14px] text-primary-fixed">verified</span>
                        </div>
                    </div>
                @endif

                <!-- Editorial Lookbook Inset -->
                <div class="mt-space-xl p-space-xl bg-surface-container rounded-2xl relative overflow-hidden">
                    <div class="relative z-10 max-w-2xl flex flex-col gap-space-sm">
                        <div class="flex items-center gap-space-xs">
                            <span class="w-2 h-2 rounded-full bg-primary-fixed"></span>
                            <span
                                class="font-label-tech text-label-tech uppercase tracking-widest text-primary-fixed">PHILOSOPHY
                                // EDITION 04</span>
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-primary uppercase tracking-tight">
                            Designed with Intention
                        </h2>
                        <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            Each hardware artifact and tailored garment is formulated as part of a wider modular ecosystem.
                            Designed through radical reduction, defined by industrial proportion, material integrity, and
                            tonal resonance.
                        </p>
                        <div class="pt-space-xs flex items-center gap-space-md">
                            <a class="bg-primary-container text-on-primary-container font-headline-md text-body-sm font-semibold px-space-lg py-2.5 rounded-lg hover:bg-primary-fixed transition-all shadow-sm"
                                data-path="editions" href="#">
                                Explore The Archive
                            </a>
                            <span class="font-label-tech text-label-tech text-on-surface-variant">SYSTEM SPEC 2.4.1</span>
                        </div>
                    </div>
                    <div
                        class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-primary-container/5 blur-3xl pointer-events-none">
                    </div>
                </div>
            </main>
        </div>
    </section>

    <!-- Interactive Logic Micro-script -->
    <script>
        (function () {
            // Sorting dropdown toggle
            const sortBtn = document.getElementById('sort-button');
            const sortMenu = document.getElementById('sort-menu');

            if (sortBtn && sortMenu) {
                sortBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    sortMenu.classList.toggle('hidden');
                });

                sortMenu.querySelectorAll('a').forEach(function (item) {
                    item.addEventListener('click', function () {
                        sortMenu.classList.add('hidden');
                    });
                });

                document.addEventListener('click', function () {
                    sortMenu.classList.add('hidden');
                });
            }

            // Reset filters button
            const resetBtn = document.getElementById('reset-filters');
            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    const url = new URL(window.location.href);
                    url.search = '';
                    window.location.href = url.toString();
                });
            }

            // Filter accordion expand/collapse
            document.querySelectorAll('.accordion-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const content = toggle.nextElementSibling;
                    const icon = toggle.querySelector('.accordion-icon');
                    if (!content) return;
                    content.classList.toggle('hidden');
                    if (icon) {
                        icon.textContent = content.classList.contains('hidden') ? 'expand_more' : 'expand_less';
                    }
                });
            });
        })();
    </script>
@endsection