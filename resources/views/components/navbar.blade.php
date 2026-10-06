<header id="navbar"
    class="fixed top-0 left-0 w-full z-50  backdrop-blur-xl border-b border-[#383838] shadow-[0_4px_20px_rgba(0,0,0,0.5)] ">
    @php
        $categories = \App\Models\Category::active()->sorted()->get();
        $isHome = request()->routeIs('home');
    @endphp

    <!-- Top Bar -->
    <div class="w-full bg-[#040A12] text-white border-b border-white/10">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 h-11 flex items-center justify-between">

            <!-- Pilihan Bahasa & Mata Uang -->
            <div class="hidden md:flex items-center gap-5">
                <div class="flex items-center gap-1.5 cursor-pointer">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/80 hover:text-white transition-colors">English</span>
                    <span class="material-symbols-outlined text-sm text-white/50">expand_more</span>
                </div>
                <span class="w-px h-3.5 bg-white/15"></span>
                <div class="flex items-center gap-1.5 cursor-pointer">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/80 hover:text-white transition-colors">$ Dollar (US)</span>
                    <span class="material-symbols-outlined text-sm text-white/50">expand_more</span>
                </div>
            </div>

            @php
                $announcements = \App\Models\Announcement::active()->get();
            @endphp

            <!-- Pengumuman (Desktop) -->
            @if($announcements->isNotEmpty())
                <div class="hidden md:flex flex-1 min-w-0 justify-center items-center overflow-hidden relative h-11 text-white" id="announcement-bar">
                    @foreach($announcements as $index => $announcement)
                        <div class="announcement-item flex items-center justify-center gap-2 absolute inset-0 transition-all duration-500 ease-out {{ $index === 0 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-full' }}"
                            data-index="{{ $index }}"
                            data-duration="{{ $announcement->duration }}"
                            data-animation="{{ $announcement->animation }}">

                            @if($announcement->title)
                                <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/70">{{ $announcement->title }}:</span>
                            @endif

                            <span class="announcement-text font-label-caps text-[11px] tracking-widest uppercase text-white">{{ $announcement->message }}</span>

                            @if($announcement->code)
                                <span class="inline-block border border-dashed border-primary/50 text-primary bg-primary/10 px-2.5 py-0.5 font-label-caps text-[11px] tracking-widest uppercase whitespace-nowrap">{{ $announcement->code }}</span>
                            @endif

                            @if($announcement->link && $announcement->link_text)
                                <a href="{{ $announcement->link }}" target="_blank" rel="noopener"
                                    class="text-primary hover:underline font-label-caps text-[11px] tracking-widest uppercase whitespace-nowrap ml-1">{{ $announcement->link_text }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="hidden md:flex items-center gap-2">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/70">Boost Your Daily Routine! Use Code:</span>
                    <span class="inline-block border border-dashed border-primary/50 text-primary bg-primary/10 px-2.5 py-0.5 font-label-caps text-[11px] tracking-widest uppercase">HEALTH10</span>
                </div>
            @endif

            <!-- Pengumuman (Mobile) -->
            <div class="flex md:hidden items-center">
                <span class="font-label-caps text-[10px] tracking-widest uppercase text-white/70">Code: <span class="text-primary font-bold">HEALTH10</span></span>
            </div>

            <!-- Media Sosial -->
            <div class="hidden md:flex items-center gap-4">
                @if($siteSettings['social_twitter'])
                    <a href="{{ $siteSettings['social_twitter'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="Twitter" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif
                @if($siteSettings['social_youtube'])
                    <a href="{{ $siteSettings['social_youtube'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="YouTube" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
                @if($siteSettings['social_instagram'])
                    <a href="{{ $siteSettings['social_instagram'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="Instagram" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if($siteSettings['social_facebook'])
                    <a href="{{ $siteSettings['social_facebook'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="Facebook" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
                @if($siteSettings['social_tiktok'])
                    <a href="{{ $siteSettings['social_tiktok'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="TikTok" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.517 0C5.614 0 .006 5.58.032 12.477c0 2.49.532 4.898 1.561 6.954 3.814-.16 6.802-2.597 7.56-6.227-.546-2.472-.777-4.512-1.15-7.185h2.643c.63 2.771 1.991 5.217 3.28 6.593.23.247.501.434.815.434.334 0 .646-.21.754-.492.382-1.077.856-2.577 1.015-4.16.138-1.256-.064-2.49-.408-3.411-1.534-.872-3.358-1.294-5.488-1.503-.335-.04-.647-.15-.862-.361 2.272-2.59 3.521-6.008 3.521-10.134zM6.842 12.823c-.504-2.68.543-4.743 2.772-4.88.23-.015.46-.025.69-.025.52 0 1.02.02 1.45.07 1.55.16 3.11 2.143 3.425 4.83h-1.98c-.19-1.218-.58-2.283-1.29-2.71-.7-.41-1.49-.48-2.08-.27-.46.15-.82.39-1.03.71-1.25 1.98-1.55 4.645-1.2 7.011.1 1.55 2.1 2.815 3.87 2.815 2.03 0 3.395-1.778 3.44-3.92.02-1.08-.17-2.02-.84-2.63-.34-.25-.7-.47-1.06-.62-2.52-1.04-4.9-2.35-6.81-4.36v-.08z"/></svg>
                    </a>
                @endif
                @if($siteSettings['social_linkedin'])
                    <a href="{{ $siteSettings['social_linkedin'] }}" class="text-white/60 hover:text-white transition-colors" aria-label="LinkedIn" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                @endif
            </div>

        </div>
    </div>

    <!-- Top Bar Menu -->
    <div class="w-full bg-[#040A12] border-b border-white/10 hidden md:block">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 h-10 flex items-center justify-between">
            <div class="flex items-center gap-4 font-label-caps text-[11px] tracking-widest uppercase text-white/80">
                <a href="{{ route('download.app') }}" class="hover:text-white transition-colors whitespace-nowrap">Download the App</a>
                <span class="w-px h-4 bg-white/15"></span>
                <a href="{{ route('contact') }}" class="hover:text-white transition-colors whitespace-nowrap">Help & Contact</a>
                <span class="w-px h-4 bg-white/15"></span>
                <a href="{{ route('track.order') }}" class="hover:text-white transition-colors whitespace-nowrap">Track Order</a>
                <span class="w-px h-4 bg-white/15"></span>
                <a href="{{ route('store.locator') }}" class="hover:text-white transition-colors whitespace-nowrap">Store Locator</a>
                <span class="w-px h-4 bg-white/15"></span>
                <a href="{{ route('deliver.to') }}" class="hover:text-white transition-colors whitespace-nowrap">Deliver To...</a>
                <span class="w-px h-4 bg-white/15"></span>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors whitespace-nowrap font-semibold">Login</a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="w-full max-w-[1600px] mx-auto px-4 lg:px-8 h-20 flex items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <button id="mobile-menu-btn"
                class="lg:hidden flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white' : 'text-navy' }} hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
            <a class="flex items-center gap-2.5" data-path="home" href="{{ route('home') }}">
                @if($isHome)
                    <img alt="Vitalis Labs" class="h-9 w-auto object-contain brightness-200"
                        src="{{ asset('storage/images/sample/logo-white.png') }}">
                @else
                    <img alt="Vitalis Labs" class="h-9 w-auto object-contain"
                        src="{{ asset('storage/images/sample/logo-black.png') }}">
                @endif
            </a>
        </div>

        <!-- Search Bar -->
        <form class="hidden lg:flex flex-1 max-w-2xl mx-8" action="{{ route('shop') }}" method="GET">
            <div
                class="flex items-center w-full bg-[#040A12] rounded-full relative shadow-inner border border-[#383838]">
                <button type="button" id="category-dropdown-btn"
                    class="flex items-center bg-[#040A12] text-white px-5 h-12 cursor-pointer hover:bg-black/40 transition-colors font-label-caps text-xs uppercase tracking-widest border-none outline-none whitespace-nowrap rounded-l-full border-r border-[#383838]">
                    <span>All Categories</span>
                    <span class="material-symbols-outlined text-sm ml-2 text-white/60">expand_more</span>
                </button>
                <input name="search"
                    class="flex-1 px-5 h-12 bg-transparent border-0 outline-none ring-0 focus:border-0 focus:outline-none focus:ring-0 font-body-sm text-sm text-white placeholder:text-white/30"
                    placeholder="Search products..." type="text">
                <button type="submit" class="px-5 h-12 text-white/80 hover:text-white transition-colors rounded-r-full">
                    <span class="material-symbols-outlined text-xl">search</span>
                </button>

                <!-- Dropdown -->
                <div id="category-dropdown"
                    class="hidden absolute top-full left-0 mt-1 w-64 bg-black rounded-xl shadow-xl border border-[#999999]/20 z-50 py-2">
                    <div class="px-4 py-2">
                        <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant">Shop
                            By Categories</span>
                    </div>
                    <div class="divide-y divide-[#999999]/10">
                        @foreach($categories as $category)
                            <a href="{{ route('shop.category', $category->slug) }}"
                                class="flex items-center justify-between px-4 py-2.5 hover:bg-surface-container transition-colors group">
                                <span
                                    class="font-body-sm text-sm text-on-surface group-hover:text-primary transition-colors">{{ $category->name }}</span>
                                <span
                                    class="material-symbols-outlined text-sm text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <div class="flex items-center gap-1 md:gap-2">
            <div
                class="hidden lg:flex items-center gap-2.5 pr-3 border-r {{ $isHome ? 'border-white/10' : 'border-[#999999]/20' }}">
                <span class="material-symbols-outlined text-xl text-primary">support_agent</span>
                <div>
                    <span
                        class="block font-label-caps text-[10px] uppercase tracking-widest {{ $isHome ? 'text-white/50' : 'text-navy/60' }}">Need
                        Help:</span>
                    <span
                        class="block font-body-sm text-sm {{ $isHome ? 'text-white' : 'text-navy' }} font-medium">{{ $siteSettings['contact_phone'] ?: '(+01) 9876 5555' }}</span>
                </div>
            </div>

            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 px-2 py-1.5 rounded-full hover:bg-white/10 transition-colors">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border-2 border-white/20">
                        @else
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="hidden md:block font-body-sm text-sm {{ $isHome ? 'text-white' : 'text-navy' }}">{{ Str::limit(auth()->user()->name, 15) }}</span>
                        <span class="material-symbols-outlined text-sm {{ $isHome ? 'text-white/60' : 'text-navy/60' }}">expand_more</span>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-[#999999]/20 py-2 hidden group-hover:block z-50">
                        <a href="{{ route('account.dashboard') }}" class="block px-4 py-2.5 text-sm text-navy hover:bg-surface-container transition-colors">Dashboard</a>
                        <a href="{{ route('account.orders') }}" class="block px-4 py-2.5 text-sm text-navy hover:bg-surface-container transition-colors">Orders</a>
                        <a href="{{ route('account.profile') }}" class="block px-4 py-2.5 text-sm text-navy hover:bg-surface-container transition-colors">Profile</a>
                        <a href="{{ route('account.addresses') }}" class="block px-4 py-2.5 text-sm text-navy hover:bg-surface-container transition-colors">Addresses</a>
                        <div class="border-t border-[#999999]/10 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a class="hidden md:flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors"
                    data-path="account" href="{{ route('login') }}">
                    <span class="material-symbols-outlined text-xl">person</span>
                </a>
            @endauth
            {{-- <a
                class="hidden md:flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors"
                data-path="wishlist" href="{{ route('wishlist') }}">
                <span class="material-symbols-outlined text-xl">favorite</span>
            </a>
            <a class="flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors relative"
                data-path="bag" href="{{ route('cart') }}">
                <span class="material-symbols-outlined text-xl">shopping_bag</span>
                <span
                    class="absolute -top-0.5 -right-0.5 bg-primary text-on-primary font-label-caps text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
            </a> --}}
        </div>
    </div>

    <!-- Mobile Search -->
    <div class="md:hidden px-4 pb-3">
        <form action="{{ route('shop') }}" method="GET"
            class="flex items-center bg-[#040A12] rounded-full overflow-hidden shadow-inner border border-[#383838]">
            <input name="search"
                class="flex-1 px-4 py-2.5 bg-transparent font-body-sm text-sm text-white placeholder:text-white/30 focus:outline-none"
                placeholder="Search wellness..." type="text">
            <button type="submit" class="px-4 py-2.5 text-white/70 hover:text-white transition-colors">
                <span class="material-symbols-outlined text-xl">search</span>
            </button>
        </form>
    </div>

    <!-- Navigation Links -->
    <nav class="border-t border-[#999999]/20 {{ $isHome ? 'bg-transparent' : 'bg-white' }}">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center">
                    @php
                        $navClass = $isHome ? 'text-white hover:text-white/80' : 'text-navy hover:text-primary';
                    @endphp
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('home') }}">Home</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('shop') }}">Shop</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('about') }}">About</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('how.to.order') }}">How To Order</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('contact') }}">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden lg:hidden border-t {{ $isHome ? 'border-white/10 bg-[#071324]' : 'border-[#999999]/20 bg-white' }}">
        <div class="px-4 py-3 space-y-1">
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="home" href="{{ route('home') }}">Home</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="shop" href="{{ route('shop') }}">Shop</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="how-to-order" href="{{ route('how.to.order') }}">How To Order</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="supplements" href="#">Supplements</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="science-lab" href="#">Science & Lab</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl"
                data-path="journal" href="#">Journal</a>
            <div class="border-t {{ $isHome ? 'border-white/10' : 'border-[#999999]/20' }} pt-2 mt-2">
                <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-primary/10 transition-colors rounded-xl"
                    data-path="order-tracking" href="#">Order Tracking</a>
                <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl"
                    data-path="recently-viewed" href="#">Recently Viewed</a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            function runWhenReady(fn) {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', fn);
                } else {
                    fn();
                }
            }

            runWhenReady(function () {
                const mobileMenuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');

                if (mobileMenuBtn && mobileMenu) {
                    mobileMenuBtn.addEventListener('click', function () {
                        const isHidden = mobileMenu.classList.contains('hidden');
                        if (isHidden) {
                            mobileMenu.classList.remove('hidden');
                        } else {
                            mobileMenu.classList.add('hidden');
                        }
                    });
                }

                const categoryDropdownBtn = document.getElementById('category-dropdown-btn');
                const categoryDropdown = document.getElementById('category-dropdown');

                if (categoryDropdownBtn && categoryDropdown) {
                    categoryDropdownBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        categoryDropdown.classList.toggle('hidden');
                    });

                    document.addEventListener('click', function (e) {
                        if (!categoryDropdown.contains(e.target) && !categoryDropdownBtn.contains(e.target)) {
                            categoryDropdown.classList.add('hidden');
                        }
                    });
                }

                const announcementBar = document.getElementById('announcement-bar');
                if (!announcementBar) return;

                const items = announcementBar.querySelectorAll('.announcement-item');
                if (items.length <= 1) return;

                let currentIndex = 0;
                let intervalId = null;
                let isAnimating = false;

                function typeWriter(element, text, speed = 30) {
                    return new Promise(resolve => {
                        element.textContent = '';
                        let i = 0;
                        (function type() {
                            if (i < text.length) {
                                element.textContent += text.charAt(i++);
                                setTimeout(type, speed);
                            } else {
                                resolve();
                            }
                        })();
                    });
                }

                function slideUp(current, next) {
                    return new Promise(resolve => {
                        current.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
                        current.style.transform = 'translateY(-100%)';
                        current.style.opacity = '0';
                        next.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
                        next.style.transform = 'translateY(0)';
                        next.style.opacity = '1';
                        setTimeout(resolve, 500);
                    });
                }

                async function showNext() {
                    if (isAnimating) return;
                    isAnimating = true;

                    const current = items[currentIndex];
                    const nextIndex = (currentIndex + 1) % items.length;
                    const next = items[nextIndex];
                    const animation = current.dataset.animation || 'slide';
                    const duration = parseInt(current.dataset.duration) || 5000;

                    if (animation === 'typewriter') {
                        const textEl = next.querySelector('.announcement-text');
                        if (textEl && textEl.dataset.fullText) {
                            await typeWriter(textEl, textEl.dataset.fullText, 30);
                        }
                        current.style.transition = 'opacity 0.3s ease-out';
                        current.style.opacity = '0';
                        next.style.transition = 'opacity 0.3s ease-out';
                        next.style.opacity = '1';
                    } else {
                        await slideUp(current, next);
                    }

                    currentIndex = nextIndex;
                    isAnimating = false;
                    intervalId = setTimeout(showNext, duration);
                }

                items.forEach(item => {
                    const textEl = item.querySelector('.announcement-text');
                    if (textEl) {
                        textEl.dataset.fullText = textEl.textContent.trim();
                        if (item.dataset.animation === 'typewriter') textEl.textContent = '';
                    }
                });

                items[0].style.opacity = '1';
                items[0].style.transform = 'translateY(0)';

                intervalId = setTimeout(showNext, parseInt(items[0].dataset.duration) || 5000);

                announcementBar.addEventListener('mouseenter', () => clearTimeout(intervalId));
                announcementBar.addEventListener('mouseleave', () => {
                    if (!isAnimating) {
                        intervalId = setTimeout(showNext, parseInt(items[currentIndex].dataset.duration) || 5000);
                    }
                });
            });
        })();
    </script>
    @endpush

</header>