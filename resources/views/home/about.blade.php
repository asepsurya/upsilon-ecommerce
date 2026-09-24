@extends('layouts.app')

@section('content')
    <main class="w-full pt-20 bg-background">
        <div class="flex flex-col w-full">
            <!-- HERO STAGE SECTION -->
            <section class="relative w-full overflow-hidden bg-surface-container-lowest -mt-20 pt-28 pb-space-2xl">
                <div class="max-w-7xl mx-auto px-grid-margin-mobile lg:px-grid-margin-desktop">
                    <!-- Top Meta Bar / Overline -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-md">
                        <div class="flex items-center gap-space-xs">
                            <span class="inline-block w-2 h-2 rounded-full bg-primary-container animate-pulse"></span>
                            <span class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-widest">ABOUT UPSILON // EST. 2025</span>
                        </div>
                        <div class="flex items-center gap-space-md font-label-tech text-label-tech text-on-surface-variant">
                            <span>PRECISION HARDWARE</span>
                            <span class="text-outline-variant">/</span>
                            <span>NOCTURNAL SYSTEMS</span>
                        </div>
                    </div>
                    <!-- Main Brutalist Editorial Hero Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-end mb-space-xl">
                        <!-- Huge Editorial Title Typography -->
                        <div class="lg:col-span-8 flex flex-col justify-end">
                            <p class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-[0.25em] mb-space-2xs">OUR MANIFESTO</p>
                            <h1 class="font-display-hero text-display-hero uppercase tracking-tighter text-tertiary leading-none select-none">
                                BUILT WITH<br/>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-secondary-fixed to-outline-variant">RADICAL INTENTION</span><br/>
                                <span class="text-primary-container">FUTURE FORM</span>
                            </h1>
                        </div>
                        <!-- Hero Side Editorial Narrative & Action Box -->
                        <div class="lg:col-span-4 flex flex-col justify-between bg-surface-container-low p-space-lg rounded-xl shadow-xl">
                            <div class="mb-space-md">
                                <span class="font-label-tech text-label-tech text-outline-variant uppercase">ABOUT SPECIFICATION</span>
                                <p class="font-body-md text-body-md text-on-surface mt-space-2xs">
                                    Upsilon is the antithesis to disposable consumer tech. Every contour is modeled according to aerodynamic velocity, ergonomic precision, and long-range durability.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-space-xs pt-space-sm">
                                <a class="flex items-center justify-between bg-primary-container hover:bg-primary-fixed-dim text-on-primary-container px-space-md py-3 rounded-lg font-headline-md text-body-md font-bold uppercase transition-all shadow-md group" data-path="catalog" href="{{ route('home') }}">
                                    <span>EXPLORE COLLECTION</span>
                                    <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                                <button class="flex items-center justify-center gap-space-xs bg-surface-container-high hover:bg-surface-bright text-on-surface px-space-md py-3 rounded-lg font-headline-md text-body-md font-medium transition-all" id="keynoteBtn" type="button">
                                    <span class="material-symbols-outlined text-[18px] text-primary-fixed">play_circle</span>
                                    <span>WATCH KEYNOTE 04</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Asymmetric Visual Showcase (Hero Imagery Trio) -->
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-space-md">
                        <!-- Main Prominent Centerpiece -->
                        <div class="md:col-span-7 relative h-[460px] rounded-xl overflow-hidden group shadow-2xl bg-surface-container">
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-105" data-alt="Editorial lookbook photograph of an avant-garde cybernetic model wearing matte dark tactical technical outerwear, minimalist bone conduction headpiece, moody neon chartreuse rim lights, futuristic Tokyo nocturnal vibe, shot on medium format 80mm lens." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA5h0RIclXiNEbr2zA7I9uMTdV_U_v3Nsw_MH3rBGG_IObcf64qJf4hD5shQno3UpqKDRAQIPZ4K8GYRLSRlSVJXmANr6SWwqtBf3naSUwn3boGCd1TGAmRFOy_ayhPaCxU21dMmVN_TwDEMeEfXzTh9-KsqStpuFRLzitold0aPKp4vshtddXLd7BT2Sk75pP2zJUmoy0-wprR69LLtGKEdaDX7oGZLyJ0vgE3GOfTuAEnhYJJthmSyw')"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/30 to-transparent"></div>
                            <div class="absolute top-space-md left-space-md">
                                <span class="bg-primary-container text-on-primary-container font-label-tech text-label-tech uppercase px-space-xs py-1 rounded font-bold tracking-wider">PRIMARY DROP</span>
                            </div>
                            <div class="absolute bottom-space-md left-space-md right-space-md flex items-end justify-between">
                                <div>
                                    <p class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-wider">MODULE / OMEGA-01</p>
                                    <h2 class="font-headline-lg text-headline-lg text-tertiary">Apex Hybrid Trench Coat</h2>
                                </div>
                                <div class="text-right">
                                    <span class="font-label-tech text-body-sm text-outline-variant line-through block">$820.00</span>
                                    <span class="font-headline-lg text-headline-lg text-primary-fixed">$690.00</span>
                                </div>
                            </div>
                        </div>
                        <!-- Side Stacked Tech Artifacts -->
                        <div class="md:col-span-5 grid grid-rows-2 gap-space-md">
                            <!-- Item 1: Audio Core -->
                            <div class="relative h-[220px] rounded-xl overflow-hidden group bg-surface-container shadow-xl">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Studio technical macro product shot of architectural matte obsidian wireless over-ear monitors with lime green circuit details, floating against atmospheric dark gradient backdrop with crisp volumetric studio lighting." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCTIik8cTzN0UiEisQKAOBD2Ta70-PAVGlOTSaFFs7EkHGaCtKbj4J9mpQgB9Ta4A1GxCoEDZgNihyTnVN-tKHPB66iFVdfGPoDbvkbuyHOOV53NP9Jfrp60tb-HLrHUbkwU25KbwzauFeF6ziccWM-Ha1MEpp6AtzDKl9y2-8boEgCvq3WnKuliL6i4QuGKpey0EwJNNvPsrD0W1s0k2t56PbJY7xWAPGOc8aDOTOGElnYkZ7hwRcYFQ')"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                                <div class="absolute top-space-sm left-space-sm">
                                    <span class="bg-surface-container-highest text-primary-fixed font-label-tech text-label-tech uppercase px-space-xs py-0.5 rounded tracking-wider">AUDIO MONITOR</span>
                                </div>
                                <div class="absolute bottom-space-sm left-space-sm right-space-sm flex justify-between items-center">
                                    <div>
                                        <h3 class="font-headline-md text-headline-md text-tertiary">Vector S1 Spatial Headset</h3>
                                        <p class="font-label-tech text-label-tech text-on-surface-variant">42HR • ULTRA-LOW LATENCY</p>
                                    </div>
                                    <span class="font-label-price text-label-price text-primary-fixed">$380.00</span>
                                </div>
                            </div>
                            <!-- Item 2: Smart Wearable HUD -->
                            <div class="relative h-[220px] rounded-xl overflow-hidden group bg-surface-container shadow-xl">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Close up architectural eyewear cybernetic smart glasses with translucent amber heads up display lenses, precision cut matte black titanium frame held against clean dark minimalist studio aesthetic." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDzPyiKeHgtvWlNOvR5IkRsVVWFzqtsZUxKjVO71JxL85w0CglLqsfJjmpCv9i2w70I7mlrDrnPoqlhb-sLstygHhCs8VBEzd2ZMetX8LwO1J4jTCNcAJdxFx7xkSQ_2fagu8PySIuOoMieJP0Re9IBlZNQ8yp_YWKMEFmTe4KtsA7zW3D9ta5RuqSgnmBmJAXWTH6li3jJXTc6pV0ZgZrykENGWz_ysSM-Xd24kmcJuHhsVmeNPp4P3w')"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/40 to-transparent"></div>
                                <div class="absolute top-space-sm left-space-sm">
                                    <span class="bg-surface-container-highest text-tertiary font-label-tech text-label-tech uppercase px-space-xs py-0.5 rounded tracking-wider">TITANIUM HUD</span>
                                </div>
                                <div class="absolute bottom-space-sm left-space-sm right-space-sm flex justify-between items-center">
                                    <div>
                                        <h3 class="font-headline-md text-headline-md text-tertiary">Aero Glass Telemetry Pro</h3>
                                        <p class="font-label-tech text-label-tech text-on-surface-variant">MICRO-OLED DISPLAY</p>
                                    </div>
                                    <span class="font-label-price text-label-price text-primary-fixed">$540.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- RUNNING INDUSTRIAL TICKER MARQUEE -->
            <section class="w-full bg-primary-container text-on-primary-container overflow-hidden py-3 select-none">
                <div class="flex whitespace-nowrap animate-marquee font-headline-md text-body-md uppercase font-bold tracking-widest gap-space-xl items-center">
                    <span>// ZERO LATENCY TELEMETRY</span>
                    <span>•</span>
                    <span>TITANIUM G5 EXOSKELETON</span>
                    <span>•</span>
                    <span>KINETIC ENERGY HARVESTING</span>
                    <span>•</span>
                    <span>ACOUSTIC RESONANCE SHIELD</span>
                    <span>•</span>
                    <span>ARCHIVAL MATTE TEXTILES</span>
                    <span>•</span>
                    <span>DIRECT SYSTEM TRANSMISSION</span>
                    <span>•</span>
                    <span>GLOBAL ENCRYPTED LOGISTICS</span>
                    <span>•</span>
                    <span>// ZERO LATENCY TELEMETRY</span>
                    <span>•</span>
                    <span>TITANIUM G5 EXOSKELETON</span>
                </div>
            </section>
            <!-- EDITORIAL STATEMENT & SYSTEM SPECIFICATIONS SPLIT -->
            <section class="w-full bg-surface-container-lowest py-space-3xl relative overflow-hidden">
                <div class="max-w-7xl mx-auto px-grid-margin-mobile lg:px-grid-margin-desktop">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-2xl items-center">
                        <!-- Left Side: Editorial Typography Impact -->
                        <div class="lg:col-span-6 flex flex-col justify-center">
                            <div class="flex items-center gap-space-xs mb-space-sm">
                                <span class="w-8 h-px bg-primary-fixed"></span>
                                <span class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-widest">MANIFESTO 2025</span>
                            </div>
                            <blockquote class="font-headline-xl text-headline-xl text-tertiary uppercase leading-tight tracking-tight mb-space-lg">
                                “DESIGNED WITH RADICAL INTENTION. BUILT FOR THE NOCTURNAL CITY.”
                            </blockquote>
                            <p class="font-body-lg text-body-lg text-on-surface-variant mb-space-lg leading-relaxed">
                                Upsilon is the antithesis to disposable consumer tech. Every contour is modeled according to aerodynamic velocity, ergonomic precision, and long-range durability. We do not design for trends; we assemble permanent fixtures for the human form.
                            </p>
                            <!-- Data telemetry spec row -->
                            <div class="grid grid-cols-3 gap-space-md pt-space-md border-t border-outline-variant/30">
                                <div>
                                    <p class="font-headline-lg text-headline-lg text-primary-fixed font-bold">0.02ms</p>
                                    <span class="font-label-tech text-label-tech text-on-surface-variant uppercase">RF RESPONSE</span>
                                </div>
                                <div>
                                    <p class="font-headline-lg text-headline-lg text-tertiary font-bold">100%</p>
                                    <span class="font-label-tech text-label-tech text-on-surface-variant uppercase">RECYCLED TI</span>
                                </div>
                                <div>
                                    <p class="font-headline-lg text-headline-lg text-primary-fixed font-bold">IP68</p>
                                    <span class="font-label-tech text-label-tech text-on-surface-variant uppercase">SUBMERSIBLE</span>
                                </div>
                            </div>
                        </div>
                        <!-- Right Side: Interactive Technical Telemetry Card -->
                        <div class="lg:col-span-6">
                            <div class="bg-surface-container-low rounded-xl p-space-lg shadow-2xl relative">
                                <div class="flex items-center justify-between pb-space-md border-b border-outline-variant/20 mb-space-md">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary-fixed text-[20px]">memory</span>
                                        <span class="font-label-tech text-label-tech text-tertiary uppercase">TELEMETRY & HARDWARE LEDGER</span>
                                    </div>
                                    <span class="font-label-tech text-label-tech text-primary-fixed">LIVE STATUS [STABLE]</span>
                                </div>
                                <!-- Visual Inline Performance Vector SVG Chart -->
                                <div class="mb-space-md bg-surface-container-lowest p-space-md rounded-lg">
                                    <div class="flex justify-between items-center mb-space-xs">
                                        <span class="font-label-tech text-label-tech text-on-surface-variant">FREQUENCY RESPONSE CURVE</span>
                                        <span class="font-label-tech text-label-tech text-primary-fixed">20Hz - 48kHz</span>
                                    </div>
                                    <svg class="w-full h-28 overflow-visible" fill="none" viewbox="0 0 500 100">
                                        <path d="M0,70 Q60,65 120,40 T240,30 T360,60 T450,20 L500,45" stroke="#cbf230" stroke-linecap="round" stroke-width="2.5"></path>
                                        <path d="M0,70 Q60,65 120,40 T240,30 T360,60 T450,20 L500,45 L500,100 L0,100 Z" fill="url(#neonGlow)" opacity="0.15"></path>
                                        <circle cx="120" cy="40" fill="#cbf230" r="4"></circle>
                                        <circle cx="240" cy="30" fill="#cbf230" r="4"></circle>
                                        <circle cx="450" cy="20" fill="#cbf230" r="4"></circle>
                                        <defs>
                                            <lineargradient id="neonGlow" x1="0" x2="0" y1="0" y2="1">
                                                <stop offset="0%" stop-color="#cbf230"></stop>
                                                <stop offset="100%" stop-color="#131317" stop-opacity="0"></stop>
                                            </lineargradient>
                                        </defs>
                                    </svg>
                                </div>
                                <!-- Technical Specification Table List -->
                                <div class="space-y-space-xs font-label-tech text-label-tech">
                                    <div class="flex justify-between py-2 border-b border-outline-variant/20">
                                        <span class="text-on-surface-variant">CHASSIS MATERIAL</span>
                                        <span class="text-tertiary">Anodized CNC Aircraft Aluminum 7075</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-outline-variant/20">
                                        <span class="text-on-surface-variant">ACOUSTIC DRIVER</span>
                                        <span class="text-tertiary">Custom 40mm Beryllium Transducer</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-outline-variant/20">
                                        <span class="text-on-surface-variant">WIRELESS PROTOCOL</span>
                                        <span class="text-primary-fixed">Bluetooth 5.4 LE Ultra Audio / LC3+</span>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-on-surface-variant">THERMAL TOLERANCE</span>
                                        <span class="text-tertiary">-20°C to +55°C Operational Range</span>
                                    </div>
                                </div>
                                <div class="mt-space-md pt-space-xs">
                                    <a class="inline-flex items-center gap-space-xs text-primary-fixed hover:text-primary font-headline-md text-body-sm font-semibold transition-colors" href="#">
                                        <span>DOWNLOAD SCHEMATICS & WHITEPAPER (PDF)</span>
                                        <span class="material-symbols-outlined text-[16px]">download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- CURATED DROPS SHOWCASE (FEATURED MATRICES) -->
            <section class="w-full bg-surface py-space-3xl">
                <div class="max-w-7xl mx-auto px-grid-margin-mobile lg:px-grid-margin-desktop">
                    <!-- Section Header with Editorial Alignment -->
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-space-xl gap-space-md">
                        <div>
                            <div class="flex items-center gap-space-xs mb-space-2xs">
                                <span class="material-symbols-outlined text-primary-fixed text-[20px]">verified</span>
                                <span class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-wider">HARDWARE REGISTRY</span>
                            </div>
                            <h2 class="font-headline-xl text-headline-xl text-tertiary uppercase tracking-tight">Curated Drops // <span class="text-primary-container">Selected Archive</span></h2>
                        </div>
                        <div class="flex items-center gap-space-md">
                            <span class="font-body-sm text-body-sm text-on-surface-variant hidden md:inline">SORTING BY HIGHEST TELEMETRY SCORE</span>
                            <a class="flex items-center gap-space-xs bg-surface-container-high hover:bg-surface-bright text-on-surface px-space-md py-2.5 rounded-lg font-headline-md text-body-sm font-semibold transition-all" data-path="catalog" href="{{ route('home') }}">
                                <span>VIEW COMPLETE CATALOG</span>
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                        </div>
                    </div>
                    <!-- 4-Column High-Impact Product Matrix -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                        <!-- Product Card 1 -->
                        <div class="group flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1">
                            <!-- Image Container -->
                            <div class="relative h-80 bg-surface-container overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Industrial luxury matte black high fidelity over ear headphones angled on sleek volcanic rock plinth, neon chartreuse cable highlights, sharp contrast studio lighting." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBQbbPBVaWZCz6ABS1OHncFYOQVTg92xRVQeNvkEXDN-dn-iL-fQ4ZCetzepAhO1QtwwQuZXrR4k5XzvMpb0uFQw6qGkaFyKoLTSBe1FzGnrQwqNm41si5g_c0OK87gENTK8qJjlv-lvOgyvJIArpvb1utUcxQ7om4iF0PmfTlmY274_UzpebRGgqPhofgBxYa61GjpLQ0X6n2K6T3mTQnhqYW9MPvq1vr9bvMj5JPq9lR92BIDR8VqFg')"></div>
                                <div class="absolute top-space-sm left-space-sm flex flex-col gap-1">
                                    <span class="bg-primary-container text-on-primary-container font-label-tech text-label-tech font-bold uppercase px-2 py-0.5 rounded">NEW DROP</span>
                                    <span class="bg-surface-container-lowest/80 backdrop-blur-md text-tertiary font-label-tech text-label-tech px-2 py-0.5 rounded">RESTOCK: 14</span>
                                </div>
                                <button class="absolute top-space-sm right-space-sm w-9 h-9 rounded-lg bg-surface-container-lowest/70 backdrop-blur-md text-tertiary hover:text-primary-container flex items-center justify-center transition-colors" title="Add to Wishlist">
                                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                                </button>
                                <div class="absolute bottom-space-xs left-space-xs right-space-xs">
                                    <div class="bg-surface-container-lowest/80 backdrop-blur-md p-space-xs rounded-lg flex items-center justify-between text-body-sm">
                                        <span class="font-label-tech text-label-tech text-primary-fixed flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">star</span> 4.96 (128)
                                        </span>
                                        <span class="font-label-tech text-label-tech text-on-surface-variant">BERYLLIUM 40MM</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Details -->
                            <div class="p-space-md flex flex-col flex-1 justify-between gap-space-md">
                                <div>
                                    <p class="font-label-tech text-label-tech text-on-surface-variant uppercase tracking-wider mb-1">ACOUSTIC SERIES</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary group-hover:text-primary-fixed transition-colors">
                                        Krypton Over-Ear Monitor MK-IV
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                        Pure active noise mitigation with zero distortion beryllium drivers and forged aluminum armature.
                                    </p>
                                </div>
                                <div class="pt-space-xs flex items-center justify-between">
                                    <div>
                                        <span class="font-headline-lg text-label-price text-primary-fixed">$420.00</span>
                                        <span class="font-label-tech text-body-sm text-outline-variant line-through ml-2">$490.00</span>
                                    </div>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Krypton Over-Ear Monitor MK-IV seharga $420.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface p-2.5 rounded-lg flex items-center justify-center transition-all"
                                        target="_blank" rel="noopener">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Product Card 2 -->
                        <div class="group flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1">
                            <!-- Image Container -->
                            <div class="relative h-80 bg-surface-container overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Editorial look of an oversized structural high-neck technical storm jacket with weather-sealed seam taping in deep matte coal black, high contrast lighting." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB08aF-lgQ3wSrBMsX4bA6FcVnkIA4a7AooOUhsUlohA4lShG3rQYyw9qkovRivTdSeycQwPcQYI51WOZGgfT2lSSX9kHwhIUwsEreTR8OPH2ykEtwPFABaWk_-kzRCQBtpeuXwhcdi7602FzLE0nZLlJEmyJcezoDA1pMYpBFgNkHduoRU1WNUIK3fw5fapZZy7t_gNhkVQGlVDt7sIUDcdiXEORzVJARZ_siHfDSxCpqapbjp1iZ4MQ')"></div>
                                <div class="absolute top-space-sm left-space-sm flex flex-col gap-1">
                                    <span class="bg-surface-bright text-tertiary font-label-tech text-label-tech font-bold uppercase px-2 py-0.5 rounded">LIMITED // 100</span>
                                </div>
                                <button class="absolute top-space-sm right-space-sm w-9 h-9 rounded-lg bg-surface-container-lowest/70 backdrop-blur-md text-tertiary hover:text-primary-container flex items-center justify-center transition-colors" title="Add to Wishlist">
                                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                                </button>
                                <div class="absolute bottom-space-xs left-space-xs right-space-xs">
                                    <div class="bg-surface-container-lowest/80 backdrop-blur-md p-space-xs rounded-lg flex items-center justify-between text-body-sm">
                                        <span class="font-label-tech text-label-tech text-primary-fixed flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">star</span> 5.00 (64)
                                        </span>
                                        <span class="font-label-tech text-label-tech text-on-surface-variant">3-LAYER GORE PRO</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Details -->
                            <div class="p-space-md flex flex-col flex-1 justify-between gap-space-md">
                                <div>
                                    <p class="font-label-tech text-label-tech text-on-surface-variant uppercase tracking-wider mb-1">ARCHITECTURAL APPAREL</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary group-hover:text-primary-fixed transition-colors">
                                        Sub-Zero Shell Module 02
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                        Laser welded waterproof construction with integrated magnetic storm collar and breathable underarm ports.
                                    </p>
                                </div>
                                <div class="pt-space-xs flex items-center justify-between">
                                    <div>
                                        <span class="font-headline-lg text-label-price text-primary-fixed">$580.00</span>
                                    </div>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Sub-Zero Shell Module 02 seharga $580.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface p-2.5 rounded-lg flex items-center justify-center transition-all"
                                        target="_blank" rel="noopener">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Product Card 3 -->
                        <div class="group flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1">
                            <!-- Image Container -->
                            <div class="relative h-80 bg-surface-container overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Minimalist titanium smart ring device illuminated on geometric display stand with fine emerald laser light line, sleek dark luxury hardware." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDpKiTXPpSuC_V7jbQduarVbA7Jh5BM5U865z-_bMxyTQ992Gzz-YfTzN75jdl2Jy4N1cotpwuL0sMIzVSxBYltPkKM7Cbfv-omLdEDTPU9_LVFVNKwDPy-lgX4wbYp9Mzm34acz1FNVTaADF3WEXA2cb_9iJI1fI4b2-fpF03bCUAIvekpZfuw4lj97IuSF4yRQUZYmbGEUXgm2JPqqa8fjbptkyReB85-ZJwj0pdXfKpP47OYhcTFPw')"></div>
                                <div class="absolute top-space-sm left-space-sm flex flex-col gap-1">
                                    <span class="bg-primary-container text-on-primary-container font-label-tech text-label-tech font-bold uppercase px-2 py-0.5 rounded">NEW FORM</span>
                                </div>
                                <button class="absolute top-space-sm right-space-sm w-9 h-9 rounded-lg bg-surface-container-lowest/70 backdrop-blur-md text-tertiary hover:text-primary-container flex items-center justify-center transition-colors" title="Add to Wishlist">
                                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                                </button>
                                <div class="absolute bottom-space-xs left-space-xs right-space-xs">
                                    <div class="bg-surface-container-lowest/80 backdrop-blur-md p-space-xs rounded-lg flex items-center justify-between text-body-sm">
                                        <span class="font-label-tech text-label-tech text-primary-fixed flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">star</span> 4.88 (92)
                                        </span>
                                        <span class="font-label-tech text-label-tech text-on-surface-variant">BIO-HEART / SLEEP</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Details -->
                            <div class="p-space-md flex flex-col flex-1 justify-between gap-space-md">
                                <div>
                                    <p class="font-label-tech text-label-tech text-on-surface-variant uppercase tracking-wider mb-1">BIOMETRICS</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary group-hover:text-primary-fixed transition-colors">
                                        Pulse Neural Core Ring
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                        Medical grade grade-5 titanium smart sensor ring with continuous PPG sleep and HRV biometric telemetry.
                                    </p>
                                </div>
                                <div class="pt-space-xs flex items-center justify-between">
                                    <div>
                                        <span class="font-headline-lg text-label-price text-primary-fixed">$295.00</span>
                                    </div>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Pulse Neural Core Ring seharga $295.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface p-2.5 rounded-lg flex items-center justify-center transition-all"
                                        target="_blank" rel="noopener">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Product Card 4 -->
                        <div class="group flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1">
                            <!-- Image Container -->
                            <div class="relative h-80 bg-surface-container overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Futuristic cybernetic magnetic sling pouch in ultra lightweight grid ripstop fabric with anodized black cobrabuckle closure on dark grey studio background." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAdGvj9bDpvD5gtKQ43JTjedC3Zdfa3ACySmVYUd9b-Tw781odDjG18ROW14DJhT5oLL5rOYEIFv_XNpCJcyQFjaLqWROkUJ19CLdSDAiKOYy_EnJMG2VbwrU3ozO9HrkYtRaEqYoA3uj_2IDlQYcrq2_mGKkdALj8y7x3qplEoQyR2h7vtpc-iVNdt2j3tQZzBymWfAbWUG4wcoumdmoPh8i7RrsOfe9HWu4xF76ig_htBIUj9idCs9Q')"></div>
                                <div class="absolute top-space-sm left-space-sm flex flex-col gap-1">
                                    <span class="bg-surface-bright text-tertiary font-label-tech text-label-tech font-bold uppercase px-2 py-0.5 rounded">LOW STOCK</span>
                                </div>
                                <button class="absolute top-space-sm right-space-sm w-9 h-9 rounded-lg bg-surface-container-lowest/70 backdrop-blur-md text-tertiary hover:text-primary-container flex items-center justify-center transition-colors" title="Add to Wishlist">
                                    <span class="material-symbols-outlined text-[18px]">favorite</span>
                                </button>
                                <div class="absolute bottom-space-xs left-space-xs right-space-xs">
                                    <div class="bg-surface-container-lowest/80 backdrop-blur-md p-space-xs rounded-lg flex items-center justify-between text-body-sm">
                                        <span class="font-label-tech text-label-tech text-primary-fixed flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">star</span> 4.95 (210)
                                        </span>
                                        <span class="font-label-tech text-label-tech text-on-surface-variant">X-PAC COMPOSITE</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Info Details -->
                            <div class="p-space-md flex flex-col flex-1 justify-between gap-space-md">
                                <div>
                                    <p class="font-label-tech text-label-tech text-on-surface-variant uppercase tracking-wider mb-1">MODULAR CARRY</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary group-hover:text-primary-fixed transition-colors">
                                        Tactile Dyneema Crossbody
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                        Engineered for nocturnal transit with RFID blocking concealed compartments and swift deploy sling strap.
                                    </p>
                                </div>
                                <div class="pt-space-xs flex items-center justify-between">
                                    <div>
                                        <span class="font-headline-lg text-label-price text-primary-fixed">$210.00</span>
                                    </div>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Tactile Dyneema Crossbody seharga $210.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface p-2.5 rounded-lg flex items-center justify-center transition-all"
                                        target="_blank" rel="noopener">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- NEW ARRIVALS HORIZONTAL SCROLL CAROUSEL -->
            <section class="w-full bg-surface-container py-space-3xl">
                <div class="max-w-7xl mx-auto px-grid-margin-mobile lg:px-grid-margin-desktop">
                    <div class="flex items-center justify-between mb-space-xl">
                        <div>
                            <span class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-widest">SEASONAL RELEASES</span>
                            <h2 class="font-headline-xl text-headline-xl text-tertiary uppercase tracking-tight">New Arrivals</h2>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <button class="w-11 h-11 rounded-lg bg-surface-container-high hover:bg-surface-bright text-tertiary flex items-center justify-center transition-all" id="scrollLeft">
                                <span class="material-symbols-outlined">arrow_back</span>
                            </button>
                            <button class="w-11 h-11 rounded-lg bg-surface-container-high hover:bg-surface-bright text-tertiary flex items-center justify-center transition-all" id="scrollRight">
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                    <!-- Horizontal Carousel Container -->
                    <div class="flex gap-space-md overflow-x-auto pb-space-md scroll-smooth snap-x" id="carouselTrack">
                        <!-- Slide 1 -->
                        <div class="snap-start shrink-0 w-80 md:w-96 flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative h-72 bg-surface overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Editorial portrait of model wearing ultra minimalist structured carbon-fiber eyewear with reflective polarized surface, high key brutalist contrast." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBP8cgjnNHyI6XUWuuBg5lZp9RPc8G0fsSHx4gQQMlNldtTCBVJHWcE4ycEghZZSlejY3jjzzjgNj0PuYUCwiI6JeH2oCJYuezO3En_z03UTPoCDkEDcgsbA2PhP3hM8Sv9UbJPZwocCN5F_4TfcWGAS1965vbMVUA_I_FcPU60ulTwd7G9dtpQKR0Fs7yfkTmIgQH81y_2tux8hjTELVo5HnkKptDic2x7XzroUCuUU00pFZ-nG3ZKsw')"></div>
                                <span class="absolute top-space-sm left-space-sm bg-primary-container text-on-primary-container font-label-tech text-label-tech uppercase px-2 py-0.5 rounded font-bold">LIMITED DROP</span>
                            </div>
                            <div class="p-space-md flex flex-col justify-between flex-1">
                                <div>
                                    <p class="font-label-tech text-label-tech text-primary-fixed mb-1">OPTICS</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary">Hyperion Polarized Shade</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Lightweight Japanese zyl acetate frame with anti-glare hydrophobic coating.</p>
                                </div>
                                <div class="flex items-center justify-between pt-space-md">
                                    <span class="font-headline-lg text-label-price text-primary-fixed">$310.00</span>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Hyperion Polarized Shade seharga $310.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface px-space-md py-2 rounded-lg font-headline-md text-body-sm font-semibold transition-all"
                                        target="_blank" rel="noopener">
                                        Order via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="snap-start shrink-0 w-80 md:w-96 flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative h-72 bg-surface overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Technical apparel macro shot showing modular water-resistant cargo pants with magnetic pockets and ankle synch cords in deep matte stone grey." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBcE4KOHTG_oOiixzDZsNmiUFZUNTiABJbtMadTqCeyDx6eYKuuXmCoiq6Bi0qeLSZhRM5vc5o1HL_DGr8ar6-jt7TzRXNetfvwy6c7ysnE1zigaIFE63IvmeUstsvUKBCqTF0HStq4CSJonx-C1ZAc_eJpue1PsL9MCpmJzSVJB2inFe_QSolISkrHWNC990KHufCmo6poprk8jArZWOeXf-YCMjiw3Fav7676TpIYf-xyp9FUa8_gig')"></div>
                                <span class="absolute top-space-sm left-space-sm bg-surface-bright text-tertiary font-label-tech text-label-tech uppercase px-2 py-0.5 rounded font-bold">BEST SELLER</span>
                            </div>
                            <div class="p-space-md flex flex-col justify-between flex-1">
                                <div>
                                    <p class="font-label-tech text-label-tech text-primary-fixed mb-1">PANTS</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary">Modular Cargo Pant 04</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Four-way stretch cordura textile with articulated knee ergonomics.</p>
                                </div>
                                <div class="flex items-center justify-between pt-space-md">
                                    <span class="font-headline-lg text-label-price text-primary-fixed">$260.00</span>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Modular Cargo Pant 04 seharga $260.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface px-space-md py-2 rounded-lg font-headline-md text-body-sm font-semibold transition-all"
                                        target="_blank" rel="noopener">
                                        Order via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="snap-start shrink-0 w-80 md:w-96 flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative h-72 bg-surface overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Minimalist matte black metal water canteen and insulated technical flask with paracord clip attachment against sleek concrete surface." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCFVM1BrYiSi2QOPft5GxBsT_oQ7dsQNei4EFcl7vmA7bb4P-mCUNwhN7cOeTJSyzI3eVptK-FnJJA-8YPzc5IhtqN89jlu9dzkE2btm0AF3sYIL_wyM00UIrBvAUeuPXC7_ChGqBVCA2d5AHN_MF8fRAVfLKkQpK1FUDNZQCL5j_8pG2Tj-Dtpd3DGLLlir5Q99odO2KEXLZoRqeOcuJarfM41kE4D2Pp2O2XNskRwvs31AAeUJOP81w')"></div>
                                <span class="absolute top-space-sm left-space-sm bg-primary-container text-on-primary-container font-label-tech text-label-tech uppercase px-2 py-0.5 rounded font-bold">ACC</span>
                            </div>
                            <div class="p-space-md flex flex-col justify-between flex-1">
                                <div>
                                    <p class="font-label-tech text-label-tech text-primary-fixed mb-1">FIELD GEAR</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary">Thermal Flask 750ML</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Vacuum insulated food-grade titanium wall keeps liquids cold for 36 hours.</p>
                                </div>
                                <div class="flex items-center justify-between pt-space-md">
                                    <span class="font-headline-lg text-label-price text-primary-fixed">$95.00</span>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Thermal Flask 750ML seharga $95.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface px-space-md py-2 rounded-lg font-headline-md text-body-sm font-semibold transition-all"
                                        target="_blank" rel="noopener">
                                        Order via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 4 -->
                        <div class="snap-start shrink-0 w-80 md:w-96 flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-lg group">
                            <div class="relative h-72 bg-surface overflow-hidden">
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105" data-alt="Sleek biometric smart band with subtle lime glow interface display wrapped around dark mannequin wrist in atmospheric modern studio." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDZ9v4tvnqpVgYijzslT03JunxK7Z4j2OuW0RS-DDN0en_UtWVIBhwXCfuhRtSzi0s4v-bmbdloLVTjGA4zb6omGdOLEBELoHt2HpYMzsYMijL6E_WWCO0F4dwtdFeba4FBl8aX9lJld-rTFkCp4T712nAaBYPVzyDnNqF9SNXIPH79S6iUuVtOJv-3xDsz69j59LnYrI8WeqW1eDiBcnNHA_dCusO61aESNlMoSMsCP_hUy7U_-fQ_Og')"></div>
                                <span class="absolute top-space-sm left-space-sm bg-primary-container text-on-primary-container font-label-tech text-label-tech uppercase px-2 py-0.5 rounded font-bold">NEW TECH</span>
                            </div>
                            <div class="p-space-md flex flex-col justify-between flex-1">
                                <div>
                                    <p class="font-label-tech text-label-tech text-primary-fixed mb-1">BIOMETRICS</p>
                                    <h3 class="font-headline-md text-body-lg font-bold text-tertiary">Chronos Tracker Cuff</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Continuous oxygen saturation and stress telemetry with haptic motor alerts.</p>
                                </div>
                                <div class="flex items-center justify-between pt-space-md">
                                    <span class="font-headline-lg text-label-price text-primary-fixed">$340.00</span>
                                    <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk Chronos Tracker Cuff seharga $340.00. Apakah masih tersedia?') }}"
                                        class="add-to-bag bg-surface-container-highest hover:bg-primary-container hover:text-on-primary-container text-on-surface px-space-md py-2 rounded-lg font-headline-md text-body-sm font-semibold transition-all"
                                        target="_blank" rel="noopener">
                                        Order via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- EDITORIAL CTA BANNER -->
            <section class="w-full bg-surface-container-lowest py-space-2xl">
                <div class="max-w-7xl mx-auto px-grid-margin-mobile lg:px-grid-margin-desktop">
                    <div class="relative rounded-2xl overflow-hidden bg-surface-container p-space-xl lg:p-space-2xl shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-space-xl">
                        <div class="absolute inset-0 bg-cover bg-center opacity-25 mix-blend-luminosity" data-alt="Atmospheric nocturnal lookbook shot of dynamic urban models in technical apparel standing in a minimalist architecture concrete plaza lit with sharp studio lighting." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDXM8uVbrxTwFF9svmNpuvL-1yjxPOZtt54uJhXIhNoADnsrjJzbQwS2wvjGT0ZO6JGQgFfrWudJEQsV-SkyP_7WMj2YRVfImoqc0-uKXPL_4lFKxuDDW5a5U2XwWP-daWSfQwu6AFo2uAEcKWVSulhkSrLqX3MF4VVgERZLQ89d2_Y1DYgqHRWnGJaYv9mBTdT33QgtGGfgihEZCik6M6Q8FzWc_DDhxwm5Hn_kM06e9QTAzMPx5ZXlQ')"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-surface-container-lowest via-surface-container-lowest/80 to-transparent"></div>
                        <div class="relative z-10 max-w-xl">
                            <div class="flex items-center gap-space-xs mb-space-xs">
                                <span class="material-symbols-outlined text-primary-fixed text-[20px]">bolt</span>
                                <span class="font-label-tech text-label-tech text-primary-fixed uppercase tracking-wider">LIMITED ACCESS COHORT</span>
                            </div>
                            <h2 class="font-headline-xl text-headline-xl text-tertiary uppercase tracking-tight leading-none mb-space-sm">
                                EXPERIENCE RADICAL PRECISION FIRSTHAND.
                            </h2>
                            <p class="font-body-md text-body-md text-on-surface-variant">
                                Join the Upsilon Hardware Guild for early allocations, uncompressed firmware betas, and private warehouse drops.
                            </p>
                        </div>
                        <div class="relative z-10 w-full lg:w-auto flex flex-col sm:flex-row gap-space-sm">
                            <a class="bg-primary-container hover:bg-primary-fixed-dim text-on-primary-container px-space-xl py-4 rounded-lg font-headline-md text-body-lg font-bold uppercase transition-all shadow-xl text-center" data-path="catalog" href="{{ route('home') }}">
                                ACQUIRE SYSTEM PASS
                            </a>
                            <a class="bg-surface-container-highest hover:bg-surface-bright text-tertiary px-space-lg py-4 rounded-lg font-headline-md text-body-lg font-medium transition-all text-center" data-path="editions" href="#">
                                ARCHIVE LOGS
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Interactive Modal Container for Keynote Video Simulation -->
            <div class="fixed inset-0 z-50 hidden bg-surface-container-lowest/90 backdrop-blur-xl flex items-center justify-center p-grid-margin-mobile" id="videoModal">
                <div class="bg-surface-container-low max-w-3xl w-full rounded-2xl p-space-lg shadow-2xl relative">
                    <div class="flex items-center justify-between pb-space-sm border-b border-outline-variant/30 mb-space-md">
                        <div class="flex items-center gap-space-xs">
                            <span class="w-2 h-2 rounded-full bg-primary-container animate-ping"></span>
                            <span class="font-label-tech text-label-tech text-tertiary">TRANSMISSION STREAM // UPSILON KEYNOTE 04</span>
                        </div>
                        <button class="w-8 h-8 rounded-lg bg-surface-container-high hover:bg-surface-bright text-tertiary flex items-center justify-center transition-colors" id="closeModalBtn">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                    <div class="relative h-80 bg-surface-container-lowest rounded-xl overflow-hidden flex flex-col items-center justify-center text-center p-space-md">
                        <div class="absolute inset-0 bg-cover bg-center opacity-40" data-alt="Keynote presentation auditorium stage with futuristic cybernetic hardware projection display in dark atmospheric venue." style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBc40Vhd_AF5nn1CWTRDN17CIjK3vqIn5NjHL7fLbG2TjK8I2cxvc_D4n-ZSvWGNZ-QdLB8kuc2xjJJfBOWNG0WnDrxOcijqOL7e9o7CyPlZJg1QGSssF1J5uDitvWcRjV992GUayftEb-0Y2Q_iBe5miekWwD4Mi1mDu-NhLC_IUi8D5fdu7vwTcLqHAoaqyLfItY4EO5Mh5_6dMRKYqx4QVEIB1Fg3XKxCk5Ar9ERpGdIUlDcSl8dQQ')"></div>
                        <div class="relative z-10">
                            <span class="material-symbols-outlined text-[64px] text-primary-fixed mb-space-sm">full_hd</span>
                            <h3 class="font-headline-md text-headline-md text-tertiary mb-space-2xs">KEYNOTE TRANSMISSION READY</h3>
                            <p class="font-label-tech text-label-tech text-on-surface-variant">DURATION: 18M 42S • ULTRA HD 4K SPATIAL AUDIO</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    (function() {
        const catPills = document.querySelectorAll('.cat-pill');
        catPills.forEach(pill => {
            pill.addEventListener('click', function() {
                catPills.forEach(p => {
                    p.classList.remove('bg-primary-container', 'text-on-primary-container', 'active');
                    p.classList.add('bg-surface-container', 'text-on-surface');
                });
                this.classList.add('bg-primary-container', 'text-on-primary-container', 'active');
                this.classList.remove('bg-surface-container', 'text-on-surface');
            });
        });

        const track = document.getElementById('carouselTrack');
        const btnLeft = document.getElementById('scrollLeft');
        const btnRight = document.getElementById('scrollRight');

        if (track && btnLeft && btnRight) {
            btnLeft.addEventListener('click', () => {
                track.scrollBy({ left: -340, behavior: 'smooth' });
            });
            btnRight.addEventListener('click', () => {
                track.scrollBy({ left: 340, behavior: 'smooth' });
            });
        }

        const keynoteBtn = document.getElementById('keynoteBtn');
        const videoModal = document.getElementById('videoModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        if (keynoteBtn && videoModal && closeModalBtn) {
            keynoteBtn.addEventListener('click', () => {
                videoModal.classList.remove('hidden');
            });
            closeModalBtn.addEventListener('click', () => {
                videoModal.classList.add('hidden');
            });
            videoModal.addEventListener('click', (e) => {
                if (e.target === videoModal) {
                    videoModal.classList.add('hidden');
                }
            });
        }

    })();
</script>
@endpush
