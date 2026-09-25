<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Authentication - ' . config('app.name', 'Upsilon') }}</title>
    <meta name="description" content="{{ $description ?? 'Sign in to your account' }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Auth Design Tokens ─────────────────────────────── */
        :root {
            --auth-bg: #0b0c10;
            --auth-surface: #13141a;
            --auth-surface-raised: #1a1b22;
            --auth-border: rgba(255, 255, 255, 0.07);
            --auth-border-focus: rgba(242, 202, 80, 0.5);
            --auth-text: #e8e6ea;
            --auth-text-muted: rgba(232, 230, 234, 0.45);
            --auth-gold: #f2ca50;
            --auth-gold-dim: rgba(242, 202, 80, 0.12);
            --auth-gold-glow: rgba(242, 202, 80, 0.25);
            --auth-error: #ff6b6b;
            --auth-error-bg: rgba(255, 107, 107, 0.08);
            --auth-success: #6bcb77;
            --auth-success-bg: rgba(107, 203, 119, 0.08);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .auth-form-panel {
            overflow-x: hidden;
            box-sizing: border-box;
            /* Agar padding tidak menambah total lebar */
            width: 100%;
        }

        /* Pastikan elemen di dalam tidak keluar batas */
        .auth-form-panel * {
            max-width: 100%;
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            overflow: hidden auto;
            max-width: 100%;
        }

        body {
            background-color: var(--auth-bg);
            color: var(--auth-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        /* ── Split Layout ───────────────────────────────────── */
        .auth-shell {
            display: flex;
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            overflow: hidden;
        }

        /* ── Brand Panel (Left) ─────────────────────────────── */
        .auth-brand {
            position: relative;
            flex: 0 0 42%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
            background: #080a0d;
        }

        @media (max-width: 1023px) {
            .auth-brand {
                display: none;
            }
        }

        .auth-brand__bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 30%, rgba(242, 202, 80, 0.18) 0%, transparent 70%),
                radial-gradient(ellipse 60% 70% at 10% 80%, rgba(180, 120, 20, 0.12) 0%, transparent 60%),
                linear-gradient(160deg, #0d0e14 0%, #080a0d 100%);
        }

        /* Animated golden orbs */
        .auth-brand__orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: orbFloat 8s ease-in-out infinite;
        }

        .auth-brand__orb--1 {
            width: 380px;
            height: 380px;
            top: -80px;
            left: -60px;
            background: rgba(242, 202, 80, 0.12);
            animation-duration: 9s;
        }

        .auth-brand__orb--2 {
            width: 280px;
            height: 280px;
            bottom: 20%;
            right: -40px;
            background: rgba(200, 150, 40, 0.10);
            animation-duration: 11s;
            animation-delay: -3s;
        }

        .auth-brand__orb--3 {
            width: 200px;
            height: 200px;
            top: 40%;
            left: 30%;
            background: rgba(242, 202, 80, 0.07);
            animation-duration: 7s;
            animation-delay: -5s;
        }

        @keyframes orbFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        /* Grid overlay */
        .auth-brand__grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(242, 202, 80, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(242, 202, 80, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Diagonal accent lines */
        .auth-brand__lines {
            position: absolute;
            inset: 0;
            overflow: hidden;
        }

        .auth-brand__lines::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 1px;
            height: 200%;
            background: linear-gradient(to bottom, transparent, rgba(242, 202, 80, 0.15) 30%, rgba(242, 202, 80, 0.3) 50%, rgba(242, 202, 80, 0.15) 70%, transparent);
            transform: rotate(-20deg);
        }

        .auth-brand__lines::after {
            content: '';
            position: absolute;
            top: -50%;
            left: 40%;
            width: 1px;
            height: 200%;
            background: linear-gradient(to bottom, transparent, rgba(242, 202, 80, 0.08) 40%, rgba(242, 202, 80, 0.18) 50%, rgba(242, 202, 80, 0.08) 60%, transparent);
            transform: rotate(-20deg);
        }

        /* Brand content */
        .auth-brand__content {
            position: relative;
            z-index: 10;
            padding: 3rem;
        }

        .auth-brand__badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border: 1px solid rgba(242, 202, 80, 0.25);
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--auth-gold);
            background: rgba(242, 202, 80, 0.06);
            margin-bottom: 1.5rem;
        }

        .auth-brand__headline {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 300;
            line-height: 1.25;
            color: #fff;
            margin: 0 0 1rem;
        }

        .auth-brand__headline em {
            font-style: italic;
            color: var(--auth-gold);
        }

        .auth-brand__sub {
            font-size: 0.8125rem;
            color: var(--auth-text-muted);
            line-height: 1.7;
            max-width: 26ch;
            margin: 0 0 2.5rem;
        }

        /* Testimonial block */
        .auth-brand__quote {
            border-left: 2px solid rgba(242, 202, 80, 0.4);
            padding: 0.75rem 1.25rem;
            background: rgba(242, 202, 80, 0.04);
            border-radius: 0 8px 8px 0;
        }

        .auth-brand__quote p {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.95rem;
            color: rgba(232, 230, 234, 0.75);
            margin: 0 0 0.5rem;
        }

        .auth-brand__quote cite {
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            color: var(--auth-gold);
            text-transform: uppercase;
            font-style: normal;
        }

        /* Stats row */
        .auth-brand__stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .auth-brand__stat-num {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--auth-gold);
            line-height: 1;
        }

        .auth-brand__stat-label {
            display: block;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--auth-text-muted);
            margin-top: 3px;
        }

        /* Top logo on brand panel */
        .auth-brand__logo-wrap {
            position: absolute;
            top: 3rem;
            left: 3rem;
            z-index: 10;
        }

        /* ── Form Panel (Right) ─────────────────────────────── */
        .auth-form-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            overflow-y: auto;
            background: var(--auth-surface);
            position: relative;
        }

        /* Mobile top bar */
        .auth-mobile-bar {
            display: none;
            width: 100%;
            max-width: 460px;
            margin-bottom: 2rem;
        }

        @media (max-width: 1023px) {
            .auth-mobile-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
        }

        /* Form card */
        .auth-card {
            width: 100%;
            max-width: 420px;
        }

        .auth-card__head {
            margin-bottom: 2rem;
        }

        .auth-card__step {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--auth-gold);
            margin-bottom: 0.6rem;
        }

        .auth-card__title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--auth-text);
            margin: 0 0 0.4rem;
            line-height: 1.2;
        }

        .auth-card__desc {
            font-size: 0.825rem;
            color: var(--auth-text-muted);
            line-height: 1.65;
            margin: 0;
        }

        /* ── Form Elements ──────────────────────────────────── */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .auth-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: rgba(232, 230, 234, 0.6);
        }

        .auth-input-wrap {
            position: relative;
        }

        .auth-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--auth-border);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            color: var(--auth-text);
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }

        .auth-input::placeholder {
            color: var(--auth-text-muted);
        }

        .auth-input:hover {
            border-color: rgba(255, 255, 255, 0.12);
            background: rgba(255, 255, 255, 0.04);
        }

        .auth-input:focus {
            border-color: var(--auth-border-focus);
            background: rgba(242, 202, 80, 0.03);
            box-shadow: 0 0 0 3px rgba(242, 202, 80, 0.10);
        }

        .auth-input--has-icon {
            padding-right: 3rem;
        }

        .auth-input-icon {
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--auth-text-muted);
            cursor: pointer;
            border: none;
            background: transparent;
            transition: color 0.15s;
        }

        .auth-input-icon:hover {
            color: var(--auth-text);
        }

        .auth-error {
            font-size: 0.75rem;
            color: var(--auth-error);
            margin-top: 0.2rem;
        }

        /* ── Row: label + link ──────────────────────────────── */
        .auth-field-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-link {
            font-size: 0.75rem;
            color: var(--auth-gold);
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .auth-link:hover {
            opacity: 0.75;
            text-decoration: underline;
        }

        /* ── Checkbox row ───────────────────────────────────── */
        .auth-check-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .auth-checkbox {
            width: 16px;
            height: 16px;
            accent-color: var(--auth-gold);
            cursor: pointer;
            flex-shrink: 0;
        }

        .auth-check-label {
            font-size: 0.8125rem;
            color: var(--auth-text-muted);
        }

        .auth-check-label a {
            color: var(--auth-gold);
            text-decoration: none;
        }

        .auth-check-label a:hover {
            text-decoration: underline;
        }

        /* ── Primary button ─────────────────────────────────── */
        .auth-btn {
            width: 100%;
            padding: 0.9rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-family: inherit;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .auth-btn--primary {
            background: linear-gradient(135deg, #f2ca50 0%, #e8b830 100%);
            color: #0d0e14;
            box-shadow: 0 4px 24px rgba(242, 202, 80, 0.20);
        }

        .auth-btn--primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(242, 202, 80, 0.35);
        }

        .auth-btn--primary:active {
            transform: translateY(0);
        }

        .auth-btn--primary::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.15) 50%, transparent 100%);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .auth-btn--primary:hover::after {
            transform: translateX(100%);
        }

        .auth-btn--secondary {
            background: rgba(255, 255, 255, 0.04);
            color: var(--auth-text);
            border: 1px solid var(--auth-border);
        }

        .auth-btn--secondary:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.12);
        }

        /* ── Divider ────────────────────────────────────────── */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--auth-text-muted);
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0.25rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--auth-border);
        }

        /* ── Alert ──────────────────────────────────────────── */
        .auth-alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
        }

        .auth-alert--error {
            background: var(--auth-error-bg);
            border: 1px solid rgba(255, 107, 107, 0.2);
            color: var(--auth-error);
        }

        .auth-alert--success {
            background: var(--auth-success-bg);
            border: 1px solid rgba(107, 203, 119, 0.2);
            color: var(--auth-success);
        }

        /* ── Footer text ────────────────────────────────────── */
        .auth-footer-text {
            text-align: center;
            font-size: 0.8125rem;
            color: var(--auth-text-muted);
            margin-top: 1.75rem;
        }

        .auth-footer-text a {
            color: var(--auth-gold);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer-text a:hover {
            text-decoration: underline;
        }

        /* ── Back link ──────────────────────────────────────── */
        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8125rem;
            color: var(--auth-gold);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.15s;
        }

        .auth-back:hover {
            opacity: 0.75;
        }

        /* ── Progress dots ──────────────────────────────────── */
        .auth-progress {
            display: flex;
            gap: 6px;
            margin-bottom: 2rem;
        }

        .auth-progress__dot {
            height: 3px;
            border-radius: 99px;
            background: var(--auth-border);
            transition: all 0.3s;
        }

        .auth-progress__dot--active {
            background: var(--auth-gold);
            flex: 2;
        }

        .auth-progress__dot {
            flex: 1;
        }

        /* ── Floating particles ─────────────────────────────── */
        .auth-form-panel::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(242, 202, 80, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Animations ─────────────────────────────────────── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-anim {
            animation: fadeSlideUp 0.5s ease both;
        }

        .auth-anim--1 {
            animation-delay: 0.05s;
        }

        .auth-anim--2 {
            animation-delay: 0.12s;
        }

        .auth-anim--3 {
            animation-delay: 0.19s;
        }

        .auth-anim--4 {
            animation-delay: 0.26s;
        }

        .auth-anim--5 {
            animation-delay: 0.33s;
        }

        .auth-anim--6 {
            animation-delay: 0.40s;
        }

        /* Password strength indicator */
        .auth-strength {
            display: flex;
            gap: 4px;
            margin-top: 0.4rem;
        }

        .auth-strength__bar {
            flex: 1;
            height: 3px;
            border-radius: 99px;
            background: var(--auth-border);
            transition: background 0.3s;
        }
    </style>
</head>

<body>
    <div class="auth-shell">

        {{-- ── Brand Panel ── --}}
        <aside class="auth-brand">
            <div class="auth-brand__bg"></div>
            <div class="auth-brand__orb auth-brand__orb--1"></div>
            <div class="auth-brand__orb auth-brand__orb--2"></div>
            <div class="auth-brand__orb auth-brand__orb--3"></div>
            <div class="auth-brand__grid"></div>
            <div class="auth-brand__lines"></div>

            {{-- Logo top-left --}}
            <div class="auth-brand__logo-wrap">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name', 'Upsilon') }}"
                        style="height:36px;width:auto;filter:brightness(1.2) drop-shadow(0 0 16px rgba(242,202,80,0.35));">
                </a>
            </div>

            {{-- Brand content bottom --}}
            <div class="auth-brand__content">
                <div class="auth-brand__badge">
                    <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                        <circle cx="4" cy="4" r="3" fill="currentColor" opacity="0.8" />
                        <circle cx="4" cy="4" r="4" stroke="currentColor" stroke-width="0.5" fill="none" />
                    </svg>
                    Luxury Atelier
                </div>

                <h2 class="auth-brand__headline">
                    Where <em>elegance</em><br>meets authenticity
                </h2>

                <p class="auth-brand__sub">
                    Curated collections, private sales, and personalized concierge service — all in one place.
                </p>

                <div class="auth-brand__quote">
                    <p>"Upsilon redefined how I experience luxury fashion online."</p>
                    <cite>— Amara S., Member since 2023</cite>
                </div>

                <div class="auth-brand__stats">
                    <div>
                        <span class="auth-brand__stat-num">12K+</span>
                        <span class="auth-brand__stat-label">Members</span>
                    </div>
                    <div>
                        <span class="auth-brand__stat-num">4.9★</span>
                        <span class="auth-brand__stat-label">Avg Rating</span>
                    </div>
                    <div>
                        <span class="auth-brand__stat-num">200+</span>
                        <span class="auth-brand__stat-label">Collections</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ── Form Panel ── --}}
        <main class="auth-form-panel">

            {{-- Mobile: show logo --}}
            <div class="auth-mobile-bar">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name', 'Upsilon') }}"
                        style="height:32px;width:auto;filter:brightness(1.2);">
                </a>
            </div>

            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>

</html>