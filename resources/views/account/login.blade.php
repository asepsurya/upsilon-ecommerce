@extends('layouts.auth')

@section('title', 'Sign In — ' . config('app.name', 'Upsilon'))

@section('content')
    <div class="auth-card">

        {{-- Head --}}
        <div class="auth-card__head auth-anim auth-anim--1">
            <p class="auth-card__step">Welcome back</p>
            <h1 class="auth-card__title">Sign in to your account</h1>
            <p class="auth-card__desc">Access your atelier profile, orders, and exclusive collections.</p>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="auth-alert auth-alert--success auth-anim auth-anim--1" style="margin-bottom:1rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="auth-alert auth-alert--error auth-anim auth-anim--1" style="margin-bottom:1rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
            @csrf

            {{-- Email --}}
            <div class="auth-field auth-anim auth-anim--2">
                <label class="auth-label" for="login-email">Email address</label>
                <div class="auth-input-wrap">
                    <input id="login-email" type="email" name="email" value="{{ old('email') }}"
                        class="auth-input" placeholder="you@example.com" required autofocus autocomplete="email">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="auth-field auth-anim auth-anim--3">
                <div class="auth-field-header">
                    <label class="auth-label" for="login-password">Password</label>
                    <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                </div>
                <div class="auth-input-wrap">
                    <input id="login-password" type="password" name="password"
                        class="auth-input auth-input--has-icon"
                        placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" id="login-toggle-password" class="auth-input-icon" aria-label="Toggle password visibility">
                        <svg id="login-eye-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="login-eye-off-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div class="auth-anim auth-anim--4" style="margin-top:-0.2rem;">
                <label class="auth-check-row" style="cursor:pointer;">
                    <input type="checkbox" name="remember" value="1" class="auth-checkbox">
                    <span class="auth-check-label">Remember me for 30 days</span>
                </label>
            </div>

            {{-- Submit --}}
            <div class="auth-anim auth-anim--5" style="margin-top:0.4rem;">
                <button type="submit" class="auth-btn auth-btn--primary">Sign in</button>
            </div>

            {{-- Divider --}}
            <div class="auth-divider auth-anim auth-anim--5">or</div>

            {{-- Google --}}
            <div class="auth-anim auth-anim--6">
                <button type="button" class="auth-btn auth-btn--secondary" style="display:flex;align-items:center;justify-content:center;gap:0.6rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC04" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Continue with Google
                </button>
            </div>
        </form>

        {{-- Footer --}}
        <p class="auth-footer-text auth-anim auth-anim--6">
            New to Upsilon?
            <a href="{{ route('register') }}">Create an account &rarr;</a>
        </p>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const btn   = document.getElementById('login-toggle-password');
            const input = document.getElementById('login-password');
            const eye   = document.getElementById('login-eye-icon');
            const eyeOff = document.getElementById('login-eye-off-icon');
            if (!btn) return;
            btn.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                eye.style.display    = isPassword ? 'none'  : '';
                eyeOff.style.display = isPassword ? ''      : 'none';
            });
        })();
    </script>
@endpush