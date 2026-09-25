<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Upsilon' }}</title>
    <meta name="description" content="{{ $description ?? 'Upsilon - Modern fashion e-commerce' }}">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $title ?? 'Upsilon' }}">
    <meta property="og:description" content="{{ $description ?? 'Upsilon - Modern fashion e-commerce' }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        .border-t {
            border-top: 1px solid #383838
        }

        .border-b {
            border-bottom: 1px solid #383838
        }

        .border {
            border: 1px solid #383838
        }

        .bg-black {
            background-color: #000000 !important;
        }
    </style>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        input:where([type=text]),
        input:where(:not([type])),
        input:where([type=email]),
        input:where([type=url]),
        input:where([type=password]),
        input:where([type=number]),
        input:where([type=date]),
        input:where([type=datetime-local]),
        input:where([type=month]),
        input:where([type=search]),
        input:where([type=tel]),
        input:where([type=time]),
        input:where([type=week]),
        select:where([multiple]),
        textarea,
        select {
            appearance: none;
            --tw-shadow: 0 0 #0000;
            background-color: #fff;
            border-width: 1px;
            border-color: #202020;
            border-radius: 0;
            padding: .5rem .75rem;
            font-size: 1rem;
            line-height: 1.5rem;
        }
    </style>
    @stack('meta')
</head>

<body class="min-h-full bg-surface text-tertiary font-body-md antialiased">
    <!-- Skip to content -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-2 focus:bg-surface-container-lowest focus:text-tertiary focus:rounded-md focus:outline-none">
        Skip to content
    </a>

    <!-- Toast notifications -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-2"></div>

    <!-- Main content -->
    <div id="main-content" class="main-content">
        @include('components.navbar')
        @yield('content')

        @include('components.footer')
    </div>

    <!-- Back to top -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 w-12 h-12 bg-surface-container-lowest text-tertiary rounded-full shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:bg-surface-container-high"
        aria-label="Back to top">
        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    @include('components.whatsapp-chat')

    @stack('scripts')
</body>

</html>