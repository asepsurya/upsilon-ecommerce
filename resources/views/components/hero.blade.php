<!-- Hero Slider Section -->
<section class="relative h-screen min-h-[650px] overflow-hidden bg-surface-container-lowest select-none">
    <div id="hero-slider" class="relative h-full w-full">

        <!-- Slide 1 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-100 scale-100"
            data-index="0">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/hero-bg.jpg') }}')"></div>
            <!-- Gradasi kiri ke kanan -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.15),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.08),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]">
            </div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span
                                class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Autumn
                                / Winter 2025</span>
                        </div>
                        <h1
                            class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            The Couture<br><span class="text-white/90">Collection</span>
                        </h1>
                        <p
                            class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Sculptural silhouettes meticulously crafted from double-faced Italian cashmere and
                            structured silk-twill.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="{{ route('shop') }}"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Discover Collection
                                    <span
                                        class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                            <a href="#"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white/5 backdrop-blur-md border border-white/15 text-white font-label-caps text-xs tracking-widest uppercase hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                                Book Atelier Fitting
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105"
            data-index="1">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/banner-bespoke.jpg') }}')"></div>
            <!-- Gradasi kiri ke kanan -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.12),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.06),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]">
            </div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span
                                class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Bespoke
                                Tailoring</span>
                        </div>
                        <h1
                            class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            Made-To-<br><span class="text-white/90">Measure</span>
                        </h1>
                        <p
                            class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Individual measurements taken in private salon suites. Cut, constructed, and hand-canvassed
                            by three generations of Milanese artisans.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Explore Service
                                    <span
                                        class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105"
            data-index="2">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/banner-evening.jpg') }}')"></div>
            <!-- Gradasi kiri ke kanan -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.15),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.08),transparent_60%)]">
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]">
            </div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span
                                class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Evening
                                Capsule</span>
                        </div>
                        <h1
                            class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            The Nocturne<br><span class="text-white/90">Series</span>
                        </h1>
                        <p
                            class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Architectural draping and hand-embroidered Czech glass beads. Silhouettes engineered for
                            majestic nocturnal presence.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Shop Eveningwear
                                    <span
                                        class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>