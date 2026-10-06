<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Upsilon Store')</title>
    <meta name="description"
        content="@yield('description', 'Sneakers, clothing, and accessories from Nike, adidas, New Balance, Puma, and more. Free shipping nationwide.')">
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
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet">

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
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
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

        .bg-brand-yellow {
            background-color: rgba(255, 214, 0, 0.99);
        }
    </style>

    @stack('meta')
    @stack('head')
</head>

<body class="antialiased selection:bg-black selection:text-white">
    @include('components.header-navbar')
    @yield('content')
    {{-- ============================================================
    13. FOOTER
    ============================================================ --}}
    <footer class="bg-white text-neutral-900">
        <div class="mx-auto max-w-7xl px-4 pb-5 lg:px-8">


            {{-- Bottom bar --}}
            <div
                class="flex flex-col items-center justify-between gap-3 border-t border-neutral-200 pt-6 text-[11px] text-neutral-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} Upsilon. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-neutral-900">Terms &amp; Conditions</a>
                    <a href="#" class="hover:text-neutral-900">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    @include('components.search-modal')

    @stack('scripts')
</body>

</html>