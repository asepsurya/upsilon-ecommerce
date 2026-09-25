@extends('layouts.auth')

@section('title', 'Forgot Password — ' . config('app.name', 'Upsilon'))

@section('content')
    <div class="auth-card">

        {{-- Icon --}}
        <div class="auth-anim auth-anim--1" style="margin-bottom:1.5rem;">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(242,202,80,0.10);border:1px solid rgba(242,202,80,0.2);display:flex;align-items:center;justify-content:center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f2ca50" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
        </div>

        {{-- Head --}}
        <div class="auth-card__head auth-anim auth-anim--1" style="margin-bottom:1.5rem;">
            <p class="auth-card__step">Account recovery</p>
            <h1 class="auth-card__title">Forgot your password?</h1>
            <p class="auth-card__desc">No worries — enter your email and we'll send you a secure reset link instantly.</p>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="auth-alert auth-alert--success auth-anim auth-anim--1" style="margin-bottom:1.25rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="auth-alert auth-alert--error auth-anim auth-anim--1" style="margin-bottom:1.25rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="auth-form" novalidate>
            @csrf

            {{-- Email --}}
            <div class="auth-field auth-anim auth-anim--2">
                <label class="auth-label" for="fp-email">Email address</label>
                <div class="auth-input-wrap">
                    <input id="fp-email" type="email" name="email" value="{{ old('email') }}"
                        class="auth-input" placeholder="you@example.com" required autofocus autocomplete="email">
                </div>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="auth-anim auth-anim--3" style="margin-top:0.4rem;">
                <button type="submit" class="auth-btn auth-btn--primary">Send reset link</button>
            </div>
        </form>

        {{-- Back link --}}
        <div style="text-align:center;margin-top:1.75rem;" class="auth-anim auth-anim--4">
            <a href="{{ route('login') }}" class="auth-back">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to sign in
            </a>
        </div>
    </div>
@endsection