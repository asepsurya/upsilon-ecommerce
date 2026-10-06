@extends('layouts.home')

@section('title', 'About Us — Upsilon Atelier')
@section('description', 'Discover Upsilon — where minimalist elegance meets master craftsmanship in luxury embroidered apparel.')
@section('ogUrl', url()->current())
@section('ogImage', asset('images/about/hero-banner.jpg'))

@section('content')
    @include('components.promo-bar')

    <main class="w-full bg-white text-neutral-900 antialiased selection:bg-neutral-900 selection:text-white">
        <div class="flex flex-col w-full">

            {{-- 1. HERO SECTION --}}
            <section class="relative w-full pt-12 pb-16 lg:pt-16 lg:pb-24 bg-gradient-to-b from-neutral-50 to-white overflow-hidden">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    {{-- Top Meta Badge --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-4 border-b border-neutral-200/80">
                        <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-white border border-neutral-200 shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neutral-900 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-neutral-900"></span>
                            </span>
                            <span class="text-xs font-semibold tracking-wider text-neutral-900 uppercase">UPSILON ATELIER // EST. 2025</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-semibold tracking-widest text-neutral-500 uppercase">
                            <span>MINIMALIST ELEGANCE</span>
                            <span class="text-neutral-300">•</span>
                            <span>EMBROIDERED CRAFTSMANSHIP</span>
                        </div>
                    </div>

                    {{-- Hero Headline Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-12">
                        <div class="lg:col-span-8 space-y-4">
                            <span class="text-xs font-bold tracking-[0.2em] text-neutral-500 uppercase">OUR MANIFESTO</span>
                            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold uppercase tracking-tight text-neutral-950 leading-[1.05]">
                                Engineered With<br />
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-neutral-900 via-neutral-700 to-neutral-500">Radical Precision</span><br />
                                Defined By Form
                            </h1>
                        </div>
                        <div class="lg:col-span-4 bg-white p-6 sm:p-8 rounded-2xl border border-neutral-200/90 shadow-xl shadow-neutral-100 flex flex-col justify-between">
                            <p class="text-sm text-neutral-600 leading-relaxed mb-6">
                                Upsilon was founded on a singular principle: to redefine everyday essential wear through uncompromising fabric selection, ergonomic silhouette engineering, and intricate computer-embroidered details.
                            </p>
                            <a href="{{ route('home') }}" class="inline-flex items-center justify-between bg-neutral-950 hover:bg-neutral-800 text-white px-6 py-3.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-200 group shadow-md hover:shadow-lg">
                                <span>Explore Collection</span>
                                <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    {{-- Hero Banner Image --}}
                    <div class="relative w-full rounded-3xl overflow-hidden border border-neutral-200/80 shadow-2xl group">
                        <img src="{{ asset('images/about/hero-banner.jpg') }}" alt="Upsilon Craftsmanship Atelier" class="w-full h-[340px] sm:h-[480px] lg:h-[580px] object-cover group-hover:scale-[1.01] transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/80 via-neutral-950/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 sm:bottom-10 sm:left-10 right-6 sm:right-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4 text-white">
                            <div>
                                <span class="inline-block px-3 py-1 bg-amber-400 text-neutral-950 font-bold text-[10px] uppercase tracking-widest rounded-md mb-2">Inside The Atelier</span>
                                <h3 class="text-xl sm:text-3xl font-extrabold tracking-tight">Master Craftsmanship & Precision Threadwork</h3>
                            </div>
                            <div class="flex items-center gap-6 text-neutral-300 text-xs sm:text-sm font-medium">
                                <div><strong class="text-white block text-base sm:text-xl font-bold">100%</strong> Pure Cotton</div>
                                <div class="w-px h-8 bg-white/20"></div>
                                <div><strong class="text-white block text-base sm:text-xl font-bold">200+</strong> Stitch Density</div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- 2. PHILOSOPHY & BRAND STORY --}}
            <section class="w-full py-20 sm:py-28 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 sm:gap-16 items-center">
                        
                        {{-- Left Column Text --}}
                        <div class="lg:col-span-6 space-y-6">
                            <div class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-3 py-1 rounded-md border border-amber-200">
                                <span>The Brand Identity</span>
                            </div>
                            <h2 class="text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-neutral-950 leading-tight">
                                The Philosophy Behind The <span class="underline decoration-amber-400 decoration-4 underline-offset-4">Upsilon</span> Symbol
                            </h2>
                            <p class="text-base sm:text-lg text-neutral-600 leading-relaxed">
                                The Greek letter Upsilon (<span class="font-serif font-bold text-neutral-900">Υ</span>) represents branching paths, decision points, and the pursuit of excellence. In our garment design, it symbolizes the choice to reject disposable fast fashion in favor of timeless structural integrity and refined aesthetics.
                            </p>
                            <p class="text-sm sm:text-base text-neutral-600 leading-relaxed">
                                Every piece crafted under the Upsilon emblem is built to empower individuals who navigate life with intention, quiet confidence, and unyielding self-expression.
                            </p>

                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-neutral-100">
                                <div class="p-4 rounded-xl bg-neutral-50 border border-neutral-200/60">
                                    <div class="text-2xl font-black text-neutral-900 mb-1">Zero Compromise</div>
                                    <div class="text-xs text-neutral-500 font-medium">Hand-selected combed cotton fibers for skin comfort.</div>
                                </div>
                                <div class="p-4 rounded-xl bg-neutral-50 border border-neutral-200/60">
                                    <div class="text-2xl font-black text-neutral-900 mb-1">Long Lasting</div>
                                    <div class="text-xs text-neutral-500 font-medium">Fade-resistant embroidery that withstands 100+ washes.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column Image Card --}}
                        <div class="lg:col-span-6 relative">
                            <div class="relative rounded-3xl overflow-hidden border border-neutral-200 shadow-xl">
                                <img src="{{ asset('storage/images/sample/editorial-craft.jpg') }}" alt="Upsilon Embroidery Detail" class="w-full h-[420px] sm:h-[500px] object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/70 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6 p-6 bg-white/95 backdrop-blur-md rounded-2xl border border-white/40 shadow-lg">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                        <span class="text-xs font-bold uppercase tracking-wider text-neutral-900">Signature Emblem Detail</span>
                                    </div>
                                    <p class="text-xs text-neutral-600 leading-relaxed">
                                        High-density computerized stitching creates a raised 3D tactile experience, setting our apparel apart from standard screen-printed garments.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {{-- 3. CRAFTSMANSHIP & MATERIAL PILLARS --}}
            <section class="w-full py-20 sm:py-28 bg-neutral-50 border-y border-neutral-200/80">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Uncompromising Standards</span>
                        <h2 class="text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-neutral-950">Three Pillars Of Excellence</h2>
                        <p class="text-sm sm:text-base text-neutral-600">Why Upsilon garments deliver unparalleled comfort, drape, and durability.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        {{-- Pillar 1 --}}
                        <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="w-14 h-14 rounded-2xl bg-neutral-900 text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.38 3.46L16 2a4 4 0 0 0-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold uppercase text-neutral-950 mb-3">100% Combed Cotton</h3>
                                <p class="text-sm text-neutral-600 leading-relaxed mb-6">
                                    Meticulously combed to remove short fibers and impurities, resulting in an ultra-soft texture that breathes naturally with optimal sweat absorption.
                                </p>
                            </div>
                            <ul class="space-y-2 text-xs font-semibold text-neutral-700 border-t border-neutral-100 pt-4">
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Breathable natural fibers</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Optimal fabric weight & drape</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Pillar 2 --}}
                        <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="w-14 h-14 rounded-2xl bg-neutral-900 text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold uppercase text-neutral-950 mb-3">High-Precision Embroidery</h3>
                                <p class="text-sm text-neutral-600 leading-relaxed mb-6">
                                    Executed on advanced computerized embroidery machinery using multi-filament high-tenacity thread. Stays vibrant and crisp wash after wash.
                                </p>
                            </div>
                            <ul class="space-y-2 text-xs font-semibold text-neutral-700 border-t border-neutral-100 pt-4">
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Zero cracking or fading</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Rich 3D textured emblem</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Pillar 3 --}}
                        <div class="bg-white p-8 rounded-2xl border border-neutral-200 shadow-sm hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between group">
                            <div>
                                <div class="w-14 h-14 rounded-2xl bg-neutral-900 text-amber-400 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                    {{-- Hanger / Checkroom SVG Icon --}}
                                    <svg class="w-7 h-7 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2a3 3 0 0 0-3 3c0 1.3.8 2.4 2 2.8L3.5 14.5A2 2 0 0 0 5 18h14a2 2 0 0 0 1.5-3.5L13 7.8A3 3 0 0 0 12 2z"/>
                                        <line x1="12" y1="18" x2="12" y2="22"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold uppercase text-neutral-950 mb-3">Ergonomic Fit & Stitch</h3>
                                <p class="text-sm text-neutral-600 leading-relaxed mb-6">
                                    Tailored with distro-standard chain stitching across shoulder seams and a reinforced ribbed collar that maintains shape over time.
                                </p>
                            </div>
                            <ul class="space-y-2 text-xs font-semibold text-neutral-700 border-t border-neutral-100 pt-4">
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Chain stitched shoulder seams</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                                    <span>Tailored regular fit silhouette</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </section>

            {{-- 4. BRAND METRICS HIGHLIGHT (DARK SECTION) --}}
            <section class="w-full py-16 bg-neutral-950 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x-0 md:divide-x divide-neutral-800">
                        <div class="p-4">
                            <div class="text-3xl sm:text-5xl font-black text-amber-400 tracking-tight mb-1">100%</div>
                            <div class="text-xs font-semibold uppercase tracking-widest text-neutral-400">Authentic Materials</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl sm:text-5xl font-black text-amber-400 tracking-tight mb-1">12K+</div>
                            <div class="text-xs font-semibold uppercase tracking-widest text-neutral-400">Satisfied Clients</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl sm:text-5xl font-black text-amber-400 tracking-tight mb-1">200+</div>
                            <div class="text-xs font-semibold uppercase tracking-widest text-neutral-400">Stitch Density</div>
                        </div>
                        <div class="p-4">
                            <div class="text-3xl sm:text-5xl font-black text-amber-400 tracking-tight mb-1">4.9★</div>
                            <div class="text-xs font-semibold uppercase tracking-widest text-neutral-400">Customer Rating</div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- 5. MEET THE TEAM --}}
            <section class="w-full py-20 sm:py-28 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                        <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">The People Behind Upsilon</span>
                        <h2 class="text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-neutral-950">Leadership & Visionaries</h2>
                        <p class="text-sm sm:text-base text-neutral-600">A dedicated team driven by passion for design, garment engineering, and customer satisfaction.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        
                        {{-- Member 1 --}}
                        <div class="group rounded-2xl border border-neutral-200 bg-white overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square overflow-hidden bg-neutral-100">
                                <img src="{{ asset('images/about/team-ceo.jpg') }}" alt="Ahmad Rizky - CEO & Founder" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 text-center">
                                <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-2">Founder & CEO</span>
                                <h3 class="text-lg font-bold text-neutral-950">Ahmad Rizky</h3>
                                <p class="text-xs text-neutral-500 mt-1">Driving brand vision and uncompromising quality standards.</p>
                            </div>
                        </div>

                        {{-- Member 2 --}}
                        <div class="group rounded-2xl border border-neutral-200 bg-white overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square overflow-hidden bg-neutral-100">
                                <img src="{{ asset('images/about/team-cto.jpg') }}" alt="Diana Putri - CTO" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 text-center">
                                <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-2">Chief Technology Officer</span>
                                <h3 class="text-lg font-bold text-neutral-950">Diana Putri</h3>
                                <p class="text-xs text-neutral-500 mt-1">Architecting seamless digital commerce & platform tech.</p>
                            </div>
                        </div>

                        {{-- Member 3 --}}
                        <div class="group rounded-2xl border border-neutral-200 bg-white overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square overflow-hidden bg-neutral-100">
                                <img src="{{ asset('images/about/team-product.jpg') }}" alt="Bima Saputra - Head of Product" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 text-center">
                                <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-2">Head of Product</span>
                                <h3 class="text-lg font-bold text-neutral-950">Bima Saputra</h3>
                                <p class="text-xs text-neutral-500 mt-1">Overseeing textile sourcing and garment silhouette engineering.</p>
                            </div>
                        </div>

                        {{-- Member 4 --}}
                        <div class="group rounded-2xl border border-neutral-200 bg-white overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square overflow-hidden bg-neutral-100">
                                <img src="{{ asset('images/about/team-marketing.jpg') }}" alt="Siti Nurhaliza - Marketing Lead" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 text-center">
                                <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-2">Marketing Lead</span>
                                <h3 class="text-lg font-bold text-neutral-950">Siti Nurhaliza</h3>
                                <p class="text-xs text-neutral-500 mt-1">Connecting Upsilon with style enthusiasts nationwide.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {{-- 6. CALL TO ACTION (CTA) --}}
            <section class="w-full py-20 bg-neutral-50 border-t border-neutral-200/80">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
                    <span class="inline-block px-3 py-1 bg-amber-400 text-neutral-950 font-bold text-xs uppercase tracking-widest rounded-md">Experience Simplicity</span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold uppercase tracking-tight text-neutral-950">Elevate Your Daily Style</h2>
                    <p class="text-base sm:text-lg text-neutral-600 max-w-2xl mx-auto leading-relaxed">
                        Discover the difference of precision embroidery and 100% combed cotton. Step out in confidence with Upsilon.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-neutral-950 hover:bg-neutral-800 text-white px-8 py-4 rounded-xl text-sm font-bold uppercase tracking-widest transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                            <span>Explore Collection</span>
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </main>
@endsection
