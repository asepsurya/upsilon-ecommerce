<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Upsilon Store')</title>
    <meta name="description" content="@yield('description', 'Sneakers, clothing, and accessories from Nike, adidas, New Balance, Puma, and more. Free shipping nationwide.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="@yield('title', 'Upsilon Store')">
    <meta property="og:description" content="@yield('description', 'Sneakers & streetwear. Free shipping nationwide.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('ogUrl', url()->current())">
    <meta property="og:image" content="@yield('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))">

 <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            yellow: '#F5E400',
                            orange: '#FF5000',
                            darkorange: '#E04400',
                            black: '#111111',
                            dark: '#1A1A1A',
                            cardbg: '#252525'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Oswald', 'sans-serif'],
                        impact: ['Anton', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #111111;
            background-color: #FFFFFF;
            overflow-x: hidden;
        }

        html {
            scroll-behavior: smooth;
        }

        .font-condensed {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .font-impact {
            font-family: 'Anton', sans-serif;
        }

        @keyframes promo-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-promo-scroll {
            animation: promo-scroll 35s linear infinite;
        }

        .animate-promo-scroll:hover {
            animation-play-state: paused;
        }

        .flash-sale-scroll-wrapper {
            overflow-x: hidden;
        }

        .flash-sale-scroll {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 8px;
        }

        .flash-sale-scroll::-webkit-scrollbar {
            display: none;
        }

        .flash-sale-scroll-item {
            scroll-snap-align: start;
        }
        .bg-brand-yellow{
            background-color: rgba(255, 214, 0, 0.99);
        }
    </style>

    @stack('meta')
    @stack('head')
</head>

<body class="antialiased selection:bg-black selection:text-white">
    @yield('content')
   {{-- ============================================================
    13. FOOTER
    ============================================================ --}}
    <footer class="bg-white text-neutral-900">
        <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-5">

                {{-- Brand --}}
                <div class="col-span-2 md:col-span-1 lg:col-span-2">
                    <a href="{{ route('home') }}" class="inline-block" aria-label="Upsilon — Home">
                        {{-- Adjust to match your white logo version --}}
                        <img src="{{ asset('storage/images/sample/logo-black.png') }}" alt="Upsilon"
                            class="h-8 w-auto" onerror="this.style.display='none'">
                    </a>
                    <p class="mt-4 max-w-xs text-xs leading-relaxed text-neutral-600">
                        Upsilon — your premier destination for original sneakers and streetwear
                        from the world's biggest brands.
                    </p>

                    {{-- Social media --}}
                    <div class="mt-4 flex items-center gap-3">
                        <a href="#" class="text-neutral-500 transition hover:text-neutral-900" aria-label="Instagram">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2" />
                                <circle cx="12" cy="12" r="4" stroke-width="2" />
                                <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-500 transition hover:text-neutral-900" aria-label="Facebook">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M14 8h2.5V5H14a4 4 0 00-4 4v2H7.5v3H10v7h3v-7h2.5l.5-3H13V9a1 1 0 011-1z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-500 transition hover:text-neutral-900" aria-label="X">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L2.8 2h6.4l4.4 5.9L18.9 2z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-500 transition hover:text-neutral-900" aria-label="YouTube">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="4" stroke-width="2" />
                                <path d="M10 9l6 3-6 3V9z" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Help --}}
                <nav aria-label="Help">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-neutral-900">Help</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="#" class="hover:text-neutral-900">Track Order</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Delivery</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Returns &amp; Refund</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Size Guide</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-neutral-900">Contact Us</a></li>
                    </ul>
                </nav>

                {{-- About --}}
                <nav aria-label="About Upsilon">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-neutral-900">About Upsilon</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="{{ route('about') }}" class="hover:text-neutral-900">About Us</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Careers</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Store Locator</a></li>
                        <li><a href="#" class="hover:text-neutral-900">Loyalty Program</a></li>
                    </ul>
                </nav>

                {{-- Shop --}}
                <nav aria-label="Shop">
                    <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-neutral-900">Shop</h3>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li><a href="{{ route('shop', ['gender' => 'men']) }}" class="hover:text-neutral-900">Men</a></li>
                        <li><a href="{{ route('shop', ['gender' => 'women']) }}" class="hover:text-neutral-900">Women</a>
                        </li>
                        <li><a href="{{ route('shop', ['gender' => 'kids']) }}" class="hover:text-neutral-900">Kids</a></li>
                        <li><a href="{{ route('shop') }}" class="hover:text-neutral-900">All Products</a></li>
                    </ul>
                </nav>
            </div>

            {{-- Payment methods --}}
            <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-neutral-200 pt-6">
                <span class="mr-2 text-[10px] font-semibold uppercase tracking-wider text-neutral-500">Payment
                    Methods</span>
                @foreach (['Visa', 'Mastercard', 'Apple Pay', 'Google Pay', 'PayPal', 'American Express'] as $payment)
                    <span
                        class="rounded border border-neutral-200 px-2.5 py-1 text-[10px] font-semibold text-neutral-600">{{ $payment }}</span>
                @endforeach
            </div>

            {{-- Bottom bar --}}
            <div
                class="mt-6 flex flex-col items-center justify-between gap-3 border-t border-neutral-200 pt-6 text-[11px] text-neutral-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} Upsilon. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-neutral-900">Terms &amp; Conditions</a>
                    <a href="#" class="hover:text-neutral-900">Privacy Policy</a>
                </div>
            </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>
