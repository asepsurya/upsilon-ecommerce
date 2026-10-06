@extends('layouts.home')

@section('title', 'Upsilon Store')
@section('description', 'T-shirts from top brands. Free shipping nationwide.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))
@section('content')
    @include('components.promo-bar')

    {{-- Breadcrumb --}}
    <div class="border-b border-neutral-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-3 text-[11px] text-neutral-500 sm:px-8">
            <nav class="flex items-center flex-wrap gap-2" aria-label="Breadcrumb">
                <a class="hover:text-black hover:underline" href="{{ route('home') }}">Home</a>
                <span class="text-neutral-300">/</span>
                <span class="text-neutral-900 font-semibold">Contact Us</span>
            </nav>
        </div>
    </div>

    {{-- Flash status --}}
    @if(session('success'))
        <div class="mx-auto max-w-7xl px-4 pt-4 sm:px-8">
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="text-emerald-600 hover:text-emerald-900 font-bold ml-4">✕</button>
            </div>
        </div>
    @endif

    <main class="px-4 py-10 sm:px-8 lg:py-14">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">

                {{-- LEFT: Contact info --}}
                <div class="lg:col-span-4 space-y-6">
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 sm:text-3xl">Contact Us</h1>
                        <p class="mt-2 text-sm text-neutral-600">Have a question about sizing, stock, or orders? Fill the
                            form or reach us directly.</p>
                    </div>

                    <div class="space-y-4">
                        @if($siteSettings['contact_email'])
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">Email</p>
                                <a href="mailto:{{ $siteSettings['contact_email'] }}" class="text-sm text-neutral-700 hover:text-primary">{{ $siteSettings['contact_email'] }}</a>
                            </div>
                        </div>
                        @endif

                        @if($siteSettings['contact_phone'])
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $siteSettings['contact_phone']) }}?text={{ urlencode($siteSettings['whatsapp_default_message']) }}" target="_blank" rel="noopener" class="text-sm text-neutral-700 hover:text-primary">{{ $siteSettings['contact_phone'] }}</a>
                            </div>
                        </div>
                        @endif

                        @if($siteSettings['contact_address'])
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex p-2 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">Address</p>
                                <p class="text-sm text-neutral-700">{{ $siteSettings['contact_address'] }}</p>
                            </div>
                        </div>
                        @endif

                        
                    </div>

                    <div class="border-t border-neutral-200 pt-5">
                        @if($siteSettings['social_instagram'] || $siteSettings['social_tiktok'] || $siteSettings['social_facebook'])
                        <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900 mb-2">Follow us</p>
                        @endif
                        <div class="flex items-center gap-3">
                            @if($siteSettings['social_instagram'])
                            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="Instagram">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2"></rect>
                                    <circle cx="12" cy="12" r="4" stroke-width="2"></circle>
                                    <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"></circle>
                                </svg>
                            </a>
                            @endif
                            @if($siteSettings['social_facebook'])
                            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="Facebook">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 8h2.5V5H14a4 4 0 00-4 4v2H7.5v3H10v7h3v-7h2.5l.5-3H13V9a1 1 0 011-1z"></path>
                                </svg>
                            </a>
                            @endif
                            @if($siteSettings['social_twitter'])
                            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="X">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L2.8 2h6.4l4.4 5.9L18.9 2z">
                                    </path>
                                </svg>
                            </a>
                            @endif
                            @if($siteSettings['social_tiktok'])
                            <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="TikTok">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.517 0C5.614 0 .006 5.58.032 12.477c0 2.49.532 4.898 1.561 6.954 3.814-.16 6.802-2.597 7.56-6.227-.546-2.472-.777-4.512-1.15-7.185h2.643c.63 2.771 1.991 5.217 3.28 6.593.23.247.501.434.815.434.334 0 .646-.21.754-.492.382-1.077.856-2.577 1.015-4.16.138-1.256-.064-2.49-.408-3.411-1.534-.872-3.358-1.294-5.488-1.503-.335-.04-.647-.15-.862-.361 2.272-2.59 3.521-6.008 3.521-10.134zM6.842 12.823c-.504-2.68.543-4.743 2.772-4.88.23-.015.46-.025.69-.025.52 0 1.02.02 1.45.07 1.55.16 3.11 2.143 3.425 4.83h-1.98c-.19-1.218-.58-2.283-1.29-2.71-.7-.41-1.49-.48-2.08-.27-.46.15-.82.39-1.03.71-1.25 1.98-1.55 4.645-1.2 7.011.1 1.55 2.1 2.815 3.87 2.815 2.03 0 3.395-1.778 3.44-3.92.02-1.08-.17-2.02-.84-2.63-.34-.25-.7-.47-1.06-.62-2.52-1.04-4.9-2.35-6.81-4.36v-.08z"/></svg>
                            </a>
                            @endif
                            @if($siteSettings['social_youtube'])
                            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="YouTube">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            @endif
                            @if($siteSettings['social_linkedin'])
                            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" class="text-neutral-500 hover:text-black" aria-label="LinkedIn">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Contact form --}}
                <div class="lg:col-span-8">
                    <div class="rounded-sm border border-neutral-200 bg-white p-6 shadow-xs sm:p-8">
                        <h2 class="text-lg font-extrabold uppercase tracking-tight text-neutral-900">Send us a message</h2>
                        <p class="mt-1 text-xs text-neutral-500">We usually reply within 1 business day.</p>

                        <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="contact-name"
                                        class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Full
                                        Name</label>
                                    <input type="text" id="contact-name" name="name" value="{{ old('name') }}" required
                                        class="mt-1.5 w-full rounded-sm border border-neutral-300 bg-neutral-50 px-3 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-black focus:bg-white focus:outline-none"
                                        placeholder="Your name">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact-email"
                                        class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Email</label>
                                    <input type="email" id="contact-email" name="email" value="{{ old('email') }}" required
                                        class="mt-1.5 w-full rounded-sm border border-neutral-300 bg-neutral-50 px-3 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-black focus:bg-white focus:outline-none"
                                        placeholder="you@example.com">
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="contact-message"
                                    class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Message</label>
                                <textarea id="contact-message" name="message" rows="6" required
                                    class="mt-1.5 w-full rounded-sm border border-neutral-300 bg-neutral-50 px-3 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-black focus:bg-white focus:outline-none"
                                    placeholder="Tell us how we can help...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="inline-flex items-center justify-center bg-black px-6 py-3 text-xs font-bold uppercase tracking-wider text-white hover:bg-neutral-800">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

{{-- Full-width map --}}
        @php
            $mapSrc = $siteSettings['google_maps_embed'] ?? '';
            $lat = $siteSettings['contact_latitude'] ?? '';
            $lng = $siteSettings['contact_longitude'] ?? '';
            if ($lat !== '' && $lng !== '' && !str_contains($mapSrc, 'center=')) {
                $mapSrc = 'https://www.google.com/maps/embed/v1/place?key=&q=' . urlencode($lat . ',' . $lng) . '&zoom=16&maptype=roadmap';
            }
        @endphp
        @if($mapSrc)
        <div class="mt-8 h-[300px] w-full">
            <iframe
                src="{{ $mapSrc }}"
                style="width: 100%; height: 100%; border: 0; filter: grayscale(100%) contrast(110%);"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                title="{{ $siteSettings['app_name'] }} Location">
            </iframe>
        </div>
        @endif
    </main>
@endsection