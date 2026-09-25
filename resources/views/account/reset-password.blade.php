@extends('layouts.auth')

@section('title', 'Reset Password — ' . config('app.name', 'Upsilon'))

@section('content')
    <div class="auth-card">

        {{-- Icon --}}
        <div class="auth-anim auth-anim--1" style="margin-bottom:1.5rem;">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(242,202,80,0.10);border:1px solid rgba(242,202,80,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f2ca50" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
        </div>

        {{-- Head --}}
        <div class="auth-card__head auth-anim auth-anim--1" style="margin-bottom:1.5rem;">
            <p class="auth-card__step">New credentials</p>
            <h1 class="auth-card__title">Set a new password</h1>
            <p class="auth-card__desc">Choose a strong password to keep your account secure.</p>
        </div>

        {{-- Alerts --}}
        @if (session('error'))
            <div class="auth-alert auth-alert--error auth-anim auth-anim--1" style="margin-bottom:1.25rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.update') }}" class="auth-form" novalidate>
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div class="auth-field auth-anim auth-anim--2">
                <label class="auth-label" for="rp-email">Email address</label>
                <div class="auth-input-wrap">
                    <input id="rp-email" type="email" name="email" value="{{ old('email') }}"
                        class="auth-input" placeholder="you@example.com" required autofocus autocomplete="email">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="auth-field auth-anim auth-anim--3">
                <label class="auth-label" for="rp-password">New password</label>
                <div class="auth-input-wrap">
                    <input id="rp-password" type="password" name="password"
                        class="auth-input auth-input--has-icon"
                        placeholder="Min. 8 characters" required autocomplete="new-password"
                        oninput="updateStrengthRp(this.value)">
                    <button type="button" id="rp-toggle-password" class="auth-input-icon" aria-label="Toggle password visibility">
                        <svg id="rp-eye-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="rp-eye-off-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                {{-- Strength bars --}}
                <div class="auth-strength" id="rp-strength-bars" style="opacity:0;transition:opacity 0.3s;">
                    <div class="auth-strength__bar" id="rp-strength-bar-1"></div>
                    <div class="auth-strength__bar" id="rp-strength-bar-2"></div>
                    <div class="auth-strength__bar" id="rp-strength-bar-3"></div>
                    <div class="auth-strength__bar" id="rp-strength-bar-4"></div>
                </div>
                @error('password')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="auth-field auth-anim auth-anim--4">
                <label class="auth-label" for="rp-password-confirm">Confirm new password</label>
                <div class="auth-input-wrap">
                    <input id="rp-password-confirm" type="password" name="password_confirmation"
                        class="auth-input auth-input--has-icon"
                        placeholder="••••••••" required autocomplete="new-password">
                    <button type="button" id="rp-toggle-confirm" class="auth-input-icon" aria-label="Toggle password visibility">
                        <svg id="rp-confirm-eye-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg id="rp-confirm-eye-off-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="auth-anim auth-anim--5" style="margin-top:0.4rem;">
                <button type="submit" class="auth-btn auth-btn--primary">Update password</button>
            </div>
        </form>

        {{-- Back link --}}
        <div style="text-align:center;margin-top:1.75rem;" class="auth-anim auth-anim--6">
            <a href="{{ route('login') }}" class="auth-back">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to sign in
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function setupToggle(btnId, inputId, eyeId, eyeOffId) {
            const btn    = document.getElementById(btnId);
            const input  = document.getElementById(inputId);
            const eye    = document.getElementById(eyeId);
            const eyeOff = document.getElementById(eyeOffId);
            if (!btn) return;
            btn.addEventListener('click', function () {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                eye.style.display    = isPassword ? 'none' : '';
                eyeOff.style.display = isPassword ? ''     : 'none';
            });
        }
        setupToggle('rp-toggle-password', 'rp-password',        'rp-eye-icon',        'rp-eye-off-icon');
        setupToggle('rp-toggle-confirm',  'rp-password-confirm','rp-confirm-eye-icon','rp-confirm-eye-off-icon');

        function updateStrengthRp(value) {
            const bars = document.getElementById('rp-strength-bars');
            const b    = [1,2,3,4].map(i => document.getElementById('rp-strength-bar-' + i));
            bars.style.opacity = value.length ? '1' : '0';

            let score = 0;
            if (value.length >= 8)             score++;
            if (/[A-Z]/.test(value))           score++;
            if (/[0-9]/.test(value))           score++;
            if (/[^A-Za-z0-9]/.test(value))   score++;

            const colors = ['#ff6b6b','#ffa94d','#ffe066','#6bcb77'];
            b.forEach((bar, i) => {
                bar.style.background = i < score ? colors[score - 1] : 'rgba(255,255,255,0.07)';
            });
        }
    </script>
@endpush