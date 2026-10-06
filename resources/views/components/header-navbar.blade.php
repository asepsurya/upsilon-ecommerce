<header class="sticky top-0 z-40 bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-3.5 lg:px-8">
        <div class="flex items-center justify-between gap-4">

            {{-- Hamburger (mobile) --}}
            <button type="button" id="mobile-menu-btn" class="text-gray-800 md:hidden" aria-label="Open navigation menu"
                aria-expanded="false" aria-controls="mobile-menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0" aria-label="Upsilon — Home">
                <img src="{{ asset('storage/images/sample/logo-black.png') }}" alt="Upsilon"
                    class="h-8 w-auto object-contain lg:h-9">
            </a>

            {{-- Search (desktop) --}}
            <div class="hidden max-w-xl flex-1 md:block">
                <form action="{{ route('shop') }}" method="GET" class="relative w-full" role="search">
                    <label for="desktop-search" class="sr-only">Search products</label>
                    <input id="desktop-search" type="text" name="search"
                        class="w-full rounded-full border border-transparent bg-[#f4f4f4] py-2 pl-4 pr-10 text-xs placeholder-gray-500 transition focus:border-black focus:bg-white focus:outline-none"
                        placeholder="Search products, categories, or brands">
                    <button type="submit"
                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-black"
                        aria-label="Search">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </button>
                </form>

            </div>


            {{-- Ikon cepat --}}
            <div class="flex items-center gap-5">
                @auth
                    {{-- Cart & Wishlist (Midtrans / Both mode) --}}
                    @if(($siteSettings['checkout_mode'] ?? 'midtrans') !== 'whatsapp')
                        <a href="{{ route('cart') }}" class="hidden md:block relative text-gray-800 hover:text-black transition-colors"
                            aria-label="Shopping cart">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </a>
                        <a href="{{ route('wishlist') }}" class="hidden md:block relative text-gray-800 hover:text-black transition-colors"
                            aria-label="Wishlist">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>
                    @endif
                    <div class="relative" id="user-dropdown">
                        <button type="button" id="user-dropdown-btn"
                            class="flex items-center gap-2 px-2 py-1.5 rounded-full hover:bg-gray-100 transition-colors"
                            aria-expanded="false" aria-haspopup="true" aria-label="User menu">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar"
                                    class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-black text-white flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif

                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
<div id="user-dropdown-menu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 hidden z-50">
                            <a href="{{ route('account.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard</a>
                            <a href="{{ route('account.orders') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Orders</a>
                            <a href="{{ route('account.profile') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile</a>
                            <a href="{{ route('account.addresses') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Addresses</a>
                            @if(($siteSettings['checkout_mode'] ?? 'midtrans') !== 'whatsapp')
                                <a href="{{ route('cart') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Cart</a>
                            @endif
                            <a href="{{ route('wishlist') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                Wishlist</a>
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-medium text-brand-orange">
                                    <svg class="h-4 w-4 text-brand-orange" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Admin Dashboard</a>
                            @endif
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-black rounded-full shadow-sm hover:bg-gray-800 hover:shadow-md hover:scale-105 transition-all duration-200">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Get Started
                    </a>
                @endauth
                {{-- Mobile search --}}
                <button type="button" id="mobile-search-btn" class="text-gray-800 md:hidden" aria-label="Open search">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile search --}}
        <div id="mobile-search" class="hidden border-t border-gray-100 pt-3 md:hidden">
            <form action="{{ route('shop') }}" method="GET" class="relative w-full" role="search">
                <label for="mobile-search-input" class="sr-only">Search products</label>
                <input id="mobile-search-input" type="text" name="search"
                    class="w-full rounded-full border border-transparent bg-[#f4f4f4] py-2 pl-4 pr-10 text-xs placeholder-gray-500 focus:border-black focus:bg-white focus:outline-none"
                    placeholder="Search products, categories, or brands">
                <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-600 hover:text-black"
                    aria-label="Search">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Main navigation (desktop) --}}
        <nav class="mt-2.5 hidden items-center justify-center gap-8 border-t border-gray-100 pt-3 text-xs font-bold uppercase tracking-wider text-black md:flex"
            aria-label="Main navigation">
            <a href="{{ route('home') }}" class="transition hover:text-brand-orange">Home</a>
            <a href="{{ route('shop') }}" class="transition hover:text-brand-orange">Shop</a>
            <a href="{{ route('about') }}" class="transition hover:text-brand-orange">About</a>
            <a href="{{ route('how.to.order') }}" class="transition hover:text-brand-orange">How to Order</a>
            <a href="{{ route('contact') }}" class="transition hover:text-brand-orange">Contact</a>
        </nav>

        {{-- Menu mobile --}}
        <div id="mobile-menu" class="hidden border-t border-gray-100 pb-2 pt-3 md:hidden">
            <nav class="flex flex-col gap-1 text-sm font-semibold" aria-label="Mobile navigation">
                <a href="{{ route('home') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Home</a>
                <a href="{{ route('shop') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Shop</a>
                <a href="{{ route('about') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">About</a>
                <a href="{{ route('how.to.order') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">How to Order</a>
                <a href="{{ route('contact') }}" class="rounded px-3 py-2.5 hover:bg-gray-50">Contact</a>
                @auth
                    @if(($siteSettings['checkout_mode'] ?? 'midtrans') !== 'whatsapp')
                        <a href="{{ route('cart') }}"
                            class="rounded px-3 py-2.5 hover:bg-gray-50">Cart</a>
                        <a href="{{ route('wishlist') }}"
                            class="rounded px-3 py-2.5 hover:bg-gray-50">Wishlist</a>
                    @endif
                @endauth
                <a href="{{ route('login') }}"
                    class="mt-1 rounded bg-black px-3 py-2.5 text-center text-white">Login</a>
            </nav>
        </div>
    </div>
</header>

@push('scripts')
    <script>
        (function () {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileSearchBtn = document.getElementById('mobile-search-btn');
            const mobileSearch = document.getElementById('mobile-search');
            const userDropdownBtn = document.getElementById('user-dropdown-btn');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

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

            if (mobileSearchBtn && mobileSearch) {
                mobileSearchBtn.addEventListener('click', function () {
                    const isHidden = mobileSearch.classList.contains('hidden');
                    if (isHidden) {
                        mobileSearch.classList.remove('hidden');
                    } else {
                        mobileSearch.classList.add('hidden');
                    }
                });
            }

            if (userDropdownBtn && userDropdownMenu) {
                userDropdownBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isHidden = userDropdownMenu.classList.contains('hidden');
                    if (isHidden) {
                        userDropdownMenu.classList.remove('hidden');
                        userDropdownBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        userDropdownMenu.classList.add('hidden');
                        userDropdownBtn.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function (e) {
                    if (!userDropdownBtn.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        userDropdownMenu.classList.add('hidden');
                        userDropdownBtn.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close dropdown on Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !userDropdownMenu.classList.contains('hidden')) {
                        userDropdownMenu.classList.add('hidden');
                        userDropdownBtn.setAttribute('aria-expanded', 'false');
                        userDropdownBtn.focus();
                    }
                });
            }
        })();
    </script>
@endpush