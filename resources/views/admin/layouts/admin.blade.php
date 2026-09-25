<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" id="html-document">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Geist', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' -25, 'opsz' 24; }

        :root {
            --background: #ffffff;
            --foreground: 0 0% 4%;
            --card: 0 0% 100%;
            --card-foreground: 0 0% 4%;
            --popover: #ffffff;
            --popover-foreground: #0a0a0a;
            --primary: #0a0a0a;
            --primary-foreground: #fafafa;
            --secondary: #f5f5f5;
            --secondary-foreground: #0a0a0a;
            --muted: 0 0% 96%;
            --muted-foreground: 0 0% 45%;
            --accent: #f5f5f5;
            --accent-foreground: #0a0a0a;
            --destructive: 0 84% 60%;
            --destructive-foreground: 0 0% 100%;
            --border: 0 0% 90%;
            --input: #e5e5e5;
            --ring: 0 0% 64%;
            --radius: 0.625rem;
        }

        .dark {
            color-scheme: dark;
            --background: #09090b;
            --foreground: 0 0% 98%;
            --card: 240 6% 10%;
            --card-foreground: 0 0% 98%;
            --popover: #18181b;
            --popover-foreground: #fafafa;
            --primary: #fafafa;
            --primary-foreground: #18181b;
            --secondary: #27272a;
            --secondary-foreground: #fafafa;
            --muted: 240 4% 16%;
            --muted-foreground: 240 5% 65%;
            --accent: #27272a;
            --accent-foreground: #fafafa;
            --destructive: 0 63% 31%;
            --destructive-foreground: 0 0% 100%;
            --border: 240 5% 26%;
            --input: #3f3f46;
            --ring: 240 4% 46%;
            --radius: 0.625rem;
        }

        .dark body {
            background: var(--background);
            color: hsl(var(--foreground));
        }

        .dark .admin-sidebar {
            background: hsl(var(--card));
            border-color: hsl(var(--border));
        }

        .dark .admin-header,
        .dark .admin-content,
        .dark .admin-footer,
        .dark .admin-card,
        .dark .admin-card-footer {
            background: hsl(var(--card));
            border-color: hsl(var(--border));
            color: hsl(var(--card-foreground));
        }

        .dark .admin-stat-icon {
            background: var(--secondary) !important;
            color: var(--secondary-foreground) !important;
        }

        .dark .admin-table th,
        .dark .admin-table td {
            border-color: hsl(var(--border));
            color: hsl(var(--card-foreground));
        }

        .dark .admin-table tr:hover {
            background: var(--secondary);
        }

        .dark .admin-badge-success {
            background: #14532d;
            color: #86efac;
        }

        .dark .admin-badge-warning {
            background: #713f12;
            color: #fde68a;
        }

        .dark .admin-badge-info {
            background: #1e3a5f;
            color: #93c5fd;
        }

        .dark .admin-badge-danger {
            background: #7f1d1d;
            color: #fecaca;
        }

        .dark .admin-form-input {
            background: hsl(var(--card));
            border-color: var(--input);
            color: hsl(var(--card-foreground));
        }

        .dark .admin-form-input:focus {
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.05);
        }

        .dark .bg-white {
            background-color: hsl(var(--card)) !important;
        }

        .dark .border-gray-200 {
            border-color: hsl(var(--border)) !important;
        }

        .dark .text-muted {
            color: hsl(var(--muted-foreground)) !important;
        }

        .dark .text-warning {
            color: #facc15 !important;
        }

        .admin-wrapper { min-height: 100vh; display: flex; }
        .admin-sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid hsl(var(--border));
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }
        .admin-sidebar-header {
            height: 64px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid hsl(var(--border));
        }
        .admin-sidebar-brand {
            display: inline-flex;
            align-items: center;
        }
        .admin-sidebar-brand img {
            height: 28px;
        }
        .admin-sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
        }
        .admin-sidebar-nav-group {
            margin-bottom: 16px;
        }
        .admin-sidebar-nav-group-title {
            font-size: 0.75rem;
            font-weight: 500;
            color: hsl(var(--muted-foreground));
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 12px;
            margin-bottom: 8px;
        }
        .admin-sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius);
            color: hsl(var(--foreground));
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s;
            margin-bottom: 4px;
        }
        .admin-sidebar-nav-item:hover {
            background-color: var(--secondary);
        }
        .admin-sidebar-nav-item.active {
            background-color: var(--secondary);
            color: var(--primary);
        }
        .admin-sidebar-nav-item .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: hsl(var(--muted-foreground));
        }
        .admin-sidebar-nav-item.active .nav-icon {
            color: var(--primary);
        }

        .admin-main {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .admin-header {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid hsl(var(--border));
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 30;
        }
        .admin-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .admin-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-header-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: hsl(var(--foreground));
        }
        .admin-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
        }
        .admin-breadcrumb a {
            color: hsl(var(--muted-foreground));
            text-decoration: none;
        }
        .admin-breadcrumb a:hover {
            color: hsl(var(--foreground));
        }
        .admin-breadcrumb-separator {
            color: hsl(var(--border));
        }
        .admin-breadcrumb-current {
            color: hsl(var(--foreground));
            font-weight: 500;
        }
        .admin-content {
            flex: 1;
            padding: 24px;
            background: #ffffff;
        }
        .admin-footer {
            padding: 16px 24px;
            border-top: 1px solid hsl(var(--border));
            background: #ffffff;
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
        }

        .admin-card {
            background: #ffffff;
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 24px;
        }
        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .admin-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: hsl(var(--foreground));
        }
        .admin-card-description {
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
        }

        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }
        .admin-stat-card {
            background: #ffffff;
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .admin-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .admin-stat-content {
            flex: 1;
        }
        .admin-stat-label {
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
            margin-bottom: 4px;
        }
        .admin-stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: hsl(var(--foreground));
        }
        .admin-stat-change {
            font-size: 0.875rem;
            margin-top: 4px;
        }
        .admin-stat-change.positive {
            color: #16a34a;
        }
        .admin-stat-change.negative {
            color: #dc2626;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        .admin-table th {
            text-align: left;
            padding: 12px 16px;
            font-weight: 500;
            color: hsl(var(--muted-foreground));
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid hsl(var(--border));
        }
        .admin-table td {
            padding: 16px;
            border-bottom: 1px solid hsl(var(--border));
            color: hsl(var(--foreground));
        }
        .admin-table tr:hover {
            background-color: var(--secondary);
        }
        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .admin-btn-primary {
            background: var(--primary);
            color: var(--primary-foreground);
        }
        .admin-btn-primary:hover {
            background: #262626;
        }
        .admin-btn-secondary {
            background: var(--secondary);
            color: var(--secondary-foreground);
        }
        .admin-btn-secondary:hover {
            background: #e5e5e5;
        }
        .admin-btn-sm {
            padding: 4px 12px;
            font-size: 0.75rem;
        }
        .admin-btn-danger {
            background: hsl(var(--destructive));
            color: #ffffff;
        }
        .admin-btn-danger:hover {
            background: #dc2626;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .admin-badge-success {
            background: #dcfce7;
            color: #166534;
        }
        .admin-badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        .admin-badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        .admin-badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .admin-form-group {
            margin-bottom: 16px;
        }
        .admin-form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: hsl(var(--foreground));
            margin-bottom: 6px;
        }
        .admin-form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--input);
            border-radius: var(--radius);
            font-size: 0.875rem;
            background: #ffffff;
            color: hsl(var(--foreground));
        }
        .admin-form-input:focus {
            outline: none;
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        .admin-card-footer {
            padding: 16px 24px;
            border-top: 1px solid hsl(var(--border));
            background: #ffffff;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        @media (max-width: 1023px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-main {
                margin-left: 0;
            }
        }

        .admin-dropdown {
            position: relative;
            display: inline-block;
        }
        .admin-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 100;
            min-width: 160px;
            background: var(--popover);
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            padding: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .admin-dropdown-item {
            display: block;
            width: 100%;
            padding: 8px 12px;
            border-radius: var(--radius);
            color: var(--popover-foreground);
            text-decoration: none;
            font-size: 0.875rem;
            text-align: left;
            cursor: pointer;
            transition: background-color 0.15s;
            border: none;
            background: none;
            font-family: inherit;
        }
        .admin-dropdown-item:hover {
            background: var(--accent);
            color: var(--accent-foreground);
        }
        .admin-dropdown-item.active {
            background: var(--secondary);
            color: var(--secondary-foreground);
        }
        .admin-dropdown-form {
            margin: 0;
        }
        .admin-dropdown-divider {
            height: 1px;
            background: hsl(var(--border));
            margin: 4px 0;
        }

        .hidden {
            display: none !important;
        }

        /* Notifications */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 4px;
            min-width: 320px;
            max-width: 420px;
        }

        .notification {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: var(--radius);
            border: 1px solid;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: notification-slide-in 0.3s ease-out;
            backdrop-filter: blur(4px);
        }

        @keyframes notification-slide-in {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes notification-slide-out {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }

        .notification.closing {
            animation: notification-slide-out 0.3s ease-out forwards;
        }

        .notification-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            font-size: 1.25rem;
            line-height: 1;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.25;
            margin-bottom: 2px;
        }

        .notification-message {
            font-size: 0.875rem;
            line-height: 1.4;
            word-break: break-word;
        }

        .notification-close {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            line-height: 1;
            transition: background-color 0.15s;
        }

        .notification-close:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .notification-success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        .notification-success .notification-icon {
            color: #16a34a;
        }

        .notification-error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .notification-error .notification-icon {
            color: #dc2626;
        }

        .notification-warning {
            background: #fffbeb;
            border-color: #fed7aa;
            color: #92400e;
        }

        .notification-warning .notification-icon {
            color: #f59e0b;
        }

        .notification-info {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #1e40af;
        }

        .notification-info .notification-icon {
            color: #3b82f6;
        }

        .dark .notification-success {
            background: rgba(20, 83, 49, 0.9);
            border-color: #14532d;
            color: #86efac;
        }

        .dark .notification-error {
            background: rgba(127, 29, 29, 0.9);
            border-color: #7f1d1d;
            color: #fecaca;
        }

        .dark .notification-warning {
            background: rgba(113, 63, 18, 0.9);
            border-color: #713f12;
            color: #fde68a;
        }

        .dark .notification-info {
            background: rgba(30, 58, 95, 0.9);
            border-color: #1e3a5f;
            color: #93c5fd;
        }

        .dark .notification-close:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>
    @stack('head')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button id="sidebar-toggle" class="admin-btn admin-btn-secondary" style="padding: 8px;">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div>
                        <h1 class="admin-header-title">@yield('page-title', 'Dashboard')</h1>
                        @yield('breadcrumb')
                    </div>
                </div>
                <div class="admin-header-right" style="gap: 8px;">
                    <button id="theme-toggle" class="admin-btn admin-btn-secondary" style="padding: 8px; width: 40px;" aria-label="Toggle dark mode">
                        <span class="material-symbols-outlined text-lg" id="theme-icon">light_mode</span>
                    </button>

                    <div class="admin-dropdown">
                        <button type="button" id="lang-toggle" class="admin-btn admin-btn-secondary" style="padding: 8px; width: 40px;" aria-label="Language">
                            <span class="material-symbols-outlined text-lg">language</span>
                        </button>
                        <div id="lang-dropdown" class="admin-dropdown-menu hidden">
                            <a href="#" class="admin-dropdown-item active">English</a>
                            <a href="#" class="admin-dropdown-item">Bahasa Indonesia</a>
                            <a href="#" class="admin-dropdown-item">Français</a>
                        </div>
                    </div>

                    @php
                        $user = auth()->user();
                        $initials = '';
                        if ($user) {
                            $nameParts = explode(' ', $user->name);
                            $initials = collect($nameParts)->take(2)->map(fn($p) => strtoupper(substr($p, 0, 1)))->implode('');
                        }
                    @endphp

                    <div class="admin-dropdown">
                        <button type="button" id="user-toggle" class="admin-btn admin-btn-secondary" style="padding: 4px; width: 44px; height: 44px; border-radius: 9999px;" aria-label="User menu">
                            @if ($user && $user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full rounded-full bg-primary flex items-center justify-center text-xs font-bold" style="background: var(--primary); color: var(--primary-foreground);">
                                    {{ $initials ?: 'U' }}
                                </div>
                            @endif
                        </button>
                        <div id="user-dropdown" class="admin-dropdown-menu hidden">
                            <a href="{{ route('account.profile') }}" class="admin-dropdown-item">Profile</a>
                            <a href="{{ route('account.dashboard') }}" class="admin-dropdown-item">Account</a>
                            <div class="admin-dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" class="admin-dropdown-form">
                                @csrf
                                <button type="submit" class="admin-dropdown-item">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Notifications -->
            <div id="notification-container" class="notification-container">
                @if (session('success'))
                    <div class="notification notification-success" data-notification>
                        <div class="notification-icon">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Success</div>
                            <div class="notification-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="notification-close" data-notification-close>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="notification notification-error" data-notification>
                        <div class="notification-icon">
                            <span class="material-symbols-outlined">error</span>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Error</div>
                            <div class="notification-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="notification-close" data-notification-close>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="notification notification-warning" data-notification>
                        <div class="notification-icon">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Warning</div>
                            <div class="notification-message">{{ session('warning') }}</div>
                        </div>
                        <button type="button" class="notification-close" data-notification-close>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="notification notification-info" data-notification>
                        <div class="notification-icon">
                            <span class="material-symbols-outlined">info</span>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Info</div>
                            <div class="notification-message">{{ session('info') }}</div>
                        </div>
                        <button type="button" class="notification-close" data-notification-close>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <main class="admin-content">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="admin-footer">
                Copyright &copy; {{ date('Y') }} {{ config('app.name', 'Upsilon') }}. All rights reserved.
            </footer>
        </div>
    </div>

     @stack('scripts')
     @include('components.whatsapp-chat')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.getElementById('html-document');
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');
            const currentTheme = localStorage.getItem('theme');
            if (currentTheme === 'light') {
                html.classList.remove('dark');
                themeIcon.textContent = 'dark_mode';
            } else {
                html.classList.add('dark');
                themeIcon.textContent = 'light_mode';
            }
            themeToggle.addEventListener('click', function() {
                html.classList.toggle('dark');
                if (html.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                    themeIcon.textContent = 'light_mode';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeIcon.textContent = 'dark_mode';
                }
            });

            function setupDropdown(toggleId, dropdownId) {
                const toggle = document.getElementById(toggleId);
                const dropdown = document.getElementById(dropdownId);
                if (!toggle || !dropdown) return;
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target) && !toggle.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
            setupDropdown('lang-toggle', 'lang-dropdown');
            setupDropdown('user-toggle', 'user-dropdown');

            // Auto-generate slug for all forms that have a slug field
            const slugInput = document.querySelector('input[name="slug"]');
            if (slugInput) {
                const sourceInput = document.querySelector('input[name="name"]') || document.querySelector('input[name="title"]');
                if (sourceInput) {
                    // Update slug on input (real-time) if user hasn't manually edited the slug
                    sourceInput.addEventListener('input', function() {
                        if (slugInput.dataset.manuallyEdited !== 'true') {
                            const slug = this.value
                                .toLowerCase()
                                .trim()
                                .replace(/[^a-z0-9]+/g, '-')
                                .replace(/^-+|-+$/g, '');
                            slugInput.value = slug;
                        }
                    });
                    
                    // Mark slug as manually edited if user types in it
                    slugInput.addEventListener('input', function() {
                        this.dataset.manuallyEdited = 'true';
                    });
                }
            }

            // Notifications
            const notifications = document.querySelectorAll('[data-notification]');
            const notificationContainer = document.getElementById('notification-container');

            notifications.forEach(function(notification) {
                const dismiss = function() {
                    notification.classList.add('closing');
                    notification.addEventListener('transitionend', function() {
                        notification.remove();
                    });
                };

                const closeBtn = notification.querySelector('[data-notification-close]');
                if (closeBtn) {
                    closeBtn.addEventListener('click', dismiss);
                }

                const timeout = setTimeout(dismiss, 5000);

                notification.addEventListener('mouseenter', function() {
                    clearTimeout(timeout);
                });
                notification.addEventListener('mouseleave', function() {
                    setTimeout(dismiss, 2000);
                });
            });
        });
    </script>
</body>
</html>
