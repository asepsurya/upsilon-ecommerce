<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication - ' . config('app.name', 'Upsilon'))</title>
    <meta name="description" content="{{ $description ?? 'Sign in to your account' }}">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;500;600;700;800;900&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --auth-bg: #f8fafc;
            --auth-card-bg: #ffffff;
            --auth-border: #e2e8f0;
            --auth-border-focus: #111827;
            --auth-text: #0f172a;
            --auth-text-muted: #64748b;
            --auth-accent: #111827;
            --auth-accent-hover: #1f2937;
            --auth-orange: #ff5000;
            --auth-error: #ef4444;
            --auth-error-bg: #fef2f2;
            --auth-success: #10b981;
            --auth-success-bg: #ecfdf5;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--auth-bg);
            color: var(--auth-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Centered Shell & Ambient Gradient */
        .auth-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 1rem;
            background: radial-gradient(circle at 50% 15%, rgba(245, 228, 0, 0.07) 0%, rgba(248, 250, 252, 0) 65%),
                        radial-gradient(circle at 80% 85%, rgba(255, 80, 0, 0.04) 0%, rgba(248, 250, 252, 0) 50%),
                        #f8fafc;
        }

        #auth-particles {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .auth-container > *:not(#auth-particles) {
            position: relative;
            z-index: 1;
        }

        /* Top Navigation Header */
        .auth-header {
            width: 100%;
            max-width: 1140px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 0.5rem 1rem;
        }

        .auth-back-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--auth-text-muted);
            text-decoration: none;
            transition: color 0.2s, transform 0.2s;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
        }

        .auth-back-home:hover {
            color: var(--auth-text);
            background: rgba(0, 0, 0, 0.03);
            transform: translateX(-2px);
        }

        .auth-brand-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .auth-brand-logo img {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        .auth-header-right {
            width: 100px;
            text-align: right;
        }

        /* Main Form Area (Centered) */
        .auth-main {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            margin: 1rem 0 2rem;
        }

        .auth-card-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: var(--auth-card-bg);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08),
                        0 1px 3px 0 rgba(15, 23, 42, 0.04);
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 2rem 1.35rem;
                border-radius: 16px;
            }
            .auth-header {
                padding: 0.25rem 0.25rem 0.75rem;
            }
        }

        .auth-card__head {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .auth-card__step {
            display: inline-block;
            font-family: 'Oswald', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--auth-orange);
            background: rgba(255, 80, 0, 0.08);
            padding: 4px 12px;
            border-radius: 100px;
            margin-bottom: 0.75rem;
        }

        .auth-card__title {
            font-family: 'Anton', sans-serif;
            font-size: 2.1rem;
            font-weight: 400;
            color: var(--auth-text);
            margin: 0 0 0.5rem;
            line-height: 1.15;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .auth-card__desc {
            font-size: 0.875rem;
            color: var(--auth-text-muted);
            line-height: 1.6;
            margin: 0;
        }

        /* Form Inputs & Controls */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.15rem;
        }

        .auth-field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .auth-label {
            font-family: 'Oswald', sans-serif;
            font-size: 0.725rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--auth-text);
        }

        .auth-input-wrap {
            position: relative;
        }

        .auth-input {
            width: 100%;
            background: #f8fafc;
            border: 1px solid var(--auth-border);
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
            color: var(--auth-text);
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            outline: none;
        }

        .auth-input::placeholder {
            color: #94a3b8;
        }

        .auth-input:hover {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        .auth-input:focus {
            border-color: var(--auth-border-focus);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(17, 24, 39, 0.08);
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
            font-size: 0.775rem;
            color: var(--auth-error);
            margin-top: 0.25rem;
        }

        .auth-field-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-link {
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--auth-text);
            text-decoration: underline;
            text-underline-offset: 3px;
            transition: color 0.15s;
        }

        .auth-link:hover {
            color: var(--auth-orange);
        }

        .auth-check-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .auth-checkbox {
            width: 17px;
            height: 17px;
            border-radius: 4px;
            accent-color: #111827;
            cursor: pointer;
            flex-shrink: 0;
        }

        .auth-check-label {
            font-size: 0.825rem;
            color: var(--auth-text-muted);
        }

        .auth-check-label a {
            color: var(--auth-text);
            font-weight: 600;
            text-decoration: underline;
        }

        .auth-check-label a:hover {
            color: var(--auth-orange);
        }

        /* Buttons */
        .auth-btn {
            width: 100%;
            padding: 0.9rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-family: 'Oswald', sans-serif;
            font-size: 0.925rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-btn--primary {
            background: #111827;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
        }

        .auth-btn--primary:hover {
            background: #1f2937;
            box-shadow: 0 6px 16px rgba(17, 24, 39, 0.22);
            transform: translateY(-1px);
        }

        .auth-btn--primary:active {
            transform: translateY(0);
        }

        .auth-btn--secondary {
            background: #ffffff;
            color: var(--auth-text);
            border: 1px solid var(--auth-border);
        }

        .auth-btn--secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--auth-text-muted);
            font-family: 'Oswald', sans-serif;
            font-size: 0.675rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin: 0.4rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--auth-border);
        }

        /* Alerts */
        .auth-alert {
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.825rem;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .auth-alert--error {
            background: var(--auth-error-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: var(--auth-error);
        }

        .auth-alert--success {
            background: var(--auth-success-bg);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--auth-success);
        }

        /* Strength indicator */
        .auth-strength {
            display: flex;
            gap: 4px;
            margin-top: 0.4rem;
        }

        .auth-strength__bar {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: var(--auth-border);
            transition: background 0.3s;
        }

        /* Footer inside card */
        .auth-footer-text {
            text-align: center;
            font-size: 0.825rem;
            color: var(--auth-text-muted);
            margin-top: 1.75rem;
        }

        .auth-footer-text a {
            color: var(--auth-text);
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .auth-footer-text a:hover {
            color: var(--auth-orange);
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--auth-text);
            text-decoration: underline;
            transition: color 0.15s;
        }

        .auth-back:hover {
            color: var(--auth-orange);
        }

        /* Page Footer */
        .auth-page-footer {
            text-align: center;
            font-size: 0.775rem;
            color: #94a3b8;
            padding-top: 1rem;
        }

        .auth-page-footer a {
            color: var(--auth-text-muted);
            text-decoration: none;
            margin: 0 0.5rem;
        }

        .auth-page-footer a:hover {
            color: var(--auth-text);
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-anim {
            animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .auth-anim--1 { animation-delay: 0.04s; }
        .auth-anim--2 { animation-delay: 0.08s; }
        .auth-anim--3 { animation-delay: 0.12s; }
        .auth-anim--4 { animation-delay: 0.16s; }
        .auth-anim--5 { animation-delay: 0.20s; }
        .auth-anim--6 { animation-delay: 0.24s; }
    </style>
</head>

<body>
    <div class="auth-container">
        <canvas id="auth-particles"></canvas>
        {{-- Header Bar --}}
        <header class="auth-header">
            <a href="{{ route('home') }}" class="auth-back-home">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Store</span>
            </a>

            <a href="{{ route('home') }}" class="auth-brand-logo">
                <img src="{{ asset('storage/images/sample/logo-black.png') }}" alt="{{ config('app.name', 'Upsilon') }}"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span style="display:none; font-family:'Anton', sans-serif; font-size:1.5rem; letter-spacing:0.05em; color:#111;">
                    {{ strtoupper(config('app.name', 'UPSILON')) }}
                </span>
            </a>

            <div class="auth-header-right"></div>
        </header>

        {{-- Main Centered Form Shell --}}
        <main class="auth-main">
            <div class="auth-card-wrapper">
                <div class="auth-card">
                    @yield('content')
                </div>
            </div>
        </main>

        {{-- Page Footer --}}
        <footer class="auth-page-footer">
            <p style="margin: 0 0 0.4rem 0;">&copy; {{ date('Y') }} {{ config('app.name', 'Upsilon') }}. All rights reserved.</p>
            <div>
                <a href="#">Privacy Policy</a> &bull; <a href="#">Terms of Service</a> &bull; <a href="#">Support</a>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <script>
        (function () {
            const canvas = document.getElementById('auth-particles');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let particles = [];
            let time = 0;

            function resize() {
                canvas.width = canvas.offsetWidth;
                canvas.height = canvas.offsetHeight;
            }

            function init() {
                particles = [];
                const spacing = 32;
                const cols = Math.ceil(canvas.width / spacing);
                const rows = Math.ceil(canvas.height / spacing);

                for (let x = 0; x < cols; x++) {
                    particles[x] = [];
                    for (let y = 0; y < rows; y++) {
                        particles[x][y] = {
                            baseX: x * spacing + spacing / 2,
                            baseY: y * spacing + spacing / 2,
                            x: x * spacing + spacing / 2,
                            y: y * spacing + spacing / 2,
                            r: 2.2,
                            phase: (x + y) * 0.5,
                            amp: 10 + (x * y) % 14,
                            speed: 0.012 + ((x * 7 + y * 3) % 10) * 0.004
                        };
                    }
                }
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                time += 0.016;

                for (let x = 0; x < particles.length; x++) {
                    for (let y = 0; y < particles[x].length; y++) {
                        const p = particles[x][y];
                        const waveX = Math.sin(time * p.speed + p.phase) * p.amp;
                        const waveY = Math.cos(time * p.speed * 0.7 + p.phase) * p.amp * 0.5;

                        p.x = p.baseX + waveX;
                        p.y = p.baseY + waveY;

                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                        ctx.fillStyle = 'rgba(255, 80, 0, 0.55)';
                        ctx.fill();

                        // Connect horizontal neighbors
                        if (x < particles.length - 1 && particles[x + 1][y]) {
                            const q = particles[x + 1][y];
                            const dx = q.x - p.x;
                            const dy = q.y - p.y;
                            const dist = Math.sqrt(dx * dx + dy * dy);
                            if (dist < spacing * 1.8) {
                                ctx.beginPath();
                                ctx.moveTo(p.x, p.y);
                                ctx.lineTo(q.x, q.y);
                                ctx.strokeStyle = 'rgba(255, 80, 0, ' + (0.18 - dist / 200) + ')';
                                ctx.lineWidth = 1.2;
                                ctx.stroke();
                            }
                        }
                    }
                }

                requestAnimationFrame(draw);
            }

            window.addEventListener('resize', function () {
                resize();
                init();
            });

            resize();
            init();
            draw();
        })();
    </script>
</body>

</html>