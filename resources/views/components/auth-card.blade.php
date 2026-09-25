@props([
    'title' => null,
    'description' => null,
    'logo' => true,
    'maxWidth' => 'md',
])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp

<div class="{{ $maxWidthClass }} w-full animate-fade-up">
    <div class="auth-card rounded-2xl shadow-2xl shadow-black/40 border border-outline-variant/30 backdrop-blur-xl relative overflow-hidden">
        <!-- Top accent line -->
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary/50 to-transparent"></div>

        <div class="p-8 sm:p-10">
            @if ($logo)
                <div class="mb-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                        <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name', 'Upsilon') }}"
                            class="h-10 w-auto brightness-200 drop-shadow-[0_0_20px_rgba(242,202,80,0.3)]">
                    </a>
                </div>
            @endif

            @if ($title)
                <h1 class="font-headline-md text-headline-md text-on-surface text-center tracking-tight">{{ $title }}</h1>
            @endif

            @if ($description)
                <p class="mt-3 text-base text-on-surface-variant text-center font-light leading-relaxed max-w-md mx-auto">{{ $description }}</p>
            @endif

            @if (isset($slot))
                <div class="mt-8">
                    {{ $slot }}
                </div>
            @endif
        </div>

        @isset($footer)
            <div class="border-t border-outline-variant/20 px-8 py-6 bg-surface-container-low/50">
                {{ $footer }}
            </div>
        @endisset
    </div>
</div>