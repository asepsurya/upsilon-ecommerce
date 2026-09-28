@extends('layouts.home')

@section('title', 'Contact Us | Upsilon')
@section('description', 'Get in touch with Upsilon Store. We\'re here to help with orders, sizing, and anything else.')

@section('content')
    @include('components.site-header')

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
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold ml-4">✕</button>
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
                        <p class="mt-2 text-sm text-neutral-600">Have a question about sizing, stock, or orders? Fill the form or reach us directly.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">Email</p>
                                <p class="text-sm text-neutral-700">support@upsilon-store.com</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">WhatsApp</p>
                                <p class="text-sm text-neutral-700">+62 812 3456 7890</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-sm border border-neutral-200 bg-neutral-50">
                                <svg class="h-4 w-4 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900">Hours</p>
                                <p class="text-sm text-neutral-700">Mon - Sat, 09:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-neutral-200 pt-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-neutral-900 mb-2">Follow us</p>
                        <div class="flex items-center gap-3">
                            <a href="#" class="text-neutral-500 hover:text-black" aria-label="Instagram">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2"></rect>
                                    <circle cx="12" cy="12" r="4" stroke-width="2"></circle>
                                    <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"></circle>
                                </svg>
                            </a>
                            <a href="#" class="text-neutral-500 hover:text-black" aria-label="Facebook">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 8h2.5V5H14a4 4 0 00-4 4v2H7.5v3H10v7h3v-7h2.5l.5-3H13V9a1 1 0 011-1z"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-neutral-500 hover:text-black" aria-label="X">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L2.8 2h6.4l4.4 5.9L18.9 2z"></path>
                                </svg>
                            </a>
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
                                    <label for="contact-name" class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Full Name</label>
                                    <input type="text" id="contact-name" name="name" value="{{ old('name') }}" required
                                        class="mt-1.5 w-full rounded-sm border border-neutral-300 bg-neutral-50 px-3 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-black focus:bg-white focus:outline-none"
                                        placeholder="Your name">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact-email" class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Email</label>
                                    <input type="email" id="contact-email" name="email" value="{{ old('email') }}" required
                                        class="mt-1.5 w-full rounded-sm border border-neutral-300 bg-neutral-50 px-3 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-black focus:bg-white focus:outline-none"
                                        placeholder="you@example.com">
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="contact-message" class="block text-xs font-bold uppercase tracking-wider text-neutral-700">Message</label>
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
        <div class="mt-12">
            <div class="overflow-hidden rounded-sm border border-neutral-200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.3772858743!2d106.79969555!3d-6.22924995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14c6c4d59b9%3A0x5b9ab6a7d3c4e8f1!2sJakarta%2C%20Indonesia!5e0!3m2!1sen!2sid!4v1696000000000"
                    width="100%"
                    height="420"
                    style="border:0; display:block; filter: grayscale(100%) contrast(110%);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Upsilon Store Location">
                </iframe>
            </div>
        </div>
    </main>
@endsection
