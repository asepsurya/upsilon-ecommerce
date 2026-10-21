<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $orgName = $siteSettings['app_name'] ?? config('app.name', 'Upsilon Store');
        $tagline = $siteSettings['tagline'] ?? '';
        $siteTitle = $tagline ? "{$tagline} | {$orgName}" : $orgName;
        $orgUrl = config('app.url', url()->to('/'));
        $orgLogo = asset('storage/images/upsilon/hero-banner.jpg');
        $orgEmail = $siteSettings['contact_email'] ?? null;
        $orgPhone = $siteSettings['contact_phone'] ?? null;
        $orgAddress = $siteSettings['contact_address'] ?? null;

        $socialLinks = array_values(array_filter([
            $siteSettings['social_instagram'] ?? null,
            $siteSettings['social_facebook'] ?? null,
            $siteSettings['social_twitter'] ?? null,
            $siteSettings['social_tiktok'] ?? null,
            $siteSettings['social_youtube'] ?? null,
            $siteSettings['social_linkedin'] ?? null,
        ]));
    @endphp

    <title>@yield('title', $siteTitle)</title>
    <meta name="description"
        content="@yield('description', $tagline ?: 'Sneakers, clothing, and accessories. Free shipping nationwide.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <meta name="theme-color" content="#111111">

    <meta property="og:title" content="@yield('title', $siteTitle)">
    <meta property="og:description"
        content="@yield('description', $tagline ?: 'Sneakers & streetwear. Free shipping nationwide.')">
    <meta property="og:type" content="@yield('ogType', 'website')">
    <meta property="og:url" content="@yield('ogUrl', url()->current())">
    <meta property="og:image" content="@yield('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))">
    <meta property="og:image:alt" content="@yield('ogImageAlt', $siteTitle)">
    <meta property="og:site_name" content="{{ $orgName }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $siteTitle)">
    <meta name="twitter:description"
        content="@yield('description', $tagline ?: 'Sneakers & streetwear. Free shipping nationwide.')">
    <meta name="twitter:image" content="@yield('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))">
    <meta name="twitter:image:alt" content="@yield('ogImageAlt', $siteTitle)">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $orgName,
            'url' => $orgUrl,
            'logo' => $orgLogo,
            'description' => $tagline,
            'sameAs' => $socialLinks,
            'contactPoint' => $orgEmail || $orgPhone || $orgAddress ? [
                [
                    '@type' => 'ContactPoint',
                    'email' => $orgEmail,
                    'telephone' => $orgPhone,
                    'address' => $orgAddress,
                    'contactType' => 'customer service',
                ],
            ] : [],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $orgName,
            'url' => $orgUrl,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('shop') . '?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

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
                    <a href="{{ route('terms.conditions') }}" class="hover:text-neutral-900">Terms &amp; Conditions</a>
                    <a href="{{ route('privacy.policy') }}" class="hover:text-neutral-900">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    @include('components.search-modal')

    {{-- Floating WhatsApp contact button --}}
    <a href="https://wa.me/{{ config('services.whatsapp.number') }}" target="_blank" rel="noopener"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 rounded-full bg-[#25D366] text-white shadow-lg hover:scale-110 transition-transform"
        aria-label="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.52-8.413Z" />
        </svg>
    </a>

    @stack('scripts')
</body>

</html>