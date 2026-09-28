<footer class="bg-jd-dark text-gray-300">
    <div class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4 lg:grid-cols-5">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-1 lg:col-span-2">
                <a href="{{ route('home') }}" class="inline-block" aria-label="Upsilon — Home">
                    {{-- Adjust to match your white logo version --}}
                    <img src="{{ asset('storage/images/sample/logo-white.png') }}" alt="Upsilon"
                        class="h-8 w-auto" onerror="this.style.display='none'">
                </a>
                <p class="mt-4 max-w-xs text-xs leading-relaxed text-gray-400">
                    Upsilon — your premier destination for original sneakers and streetwear
                    from the world's biggest brands.
                </p>

                {{-- Social media --}}
                <div class="mt-4 flex items-center gap-3">
                    <a href="#" class="text-gray-400 transition hover:text-white" aria-label="Instagram">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <rect x="3" y="3" width="18" height="18" rx="5" stroke-width="2" />
                            <circle cx="12" cy="12" r="4" stroke-width="2" />
                            <circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 transition hover:text-white" aria-label="Facebook">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M14 8h2.5V5H14a4 4 0 00-4 4v2H7.5v3H10v7h3v-7h2.5l.5-3H13V9a1 1 0 011-1z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 transition hover:text-white" aria-label="X">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.3-8.3L2.8 2h6.4l4.4 5.9L18.9 2z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 transition hover:text-white" aria-label="YouTube">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <rect x="2" y="5" width="20" height="14" rx="4" stroke-width="2" />
                            <path d="M10 9l6 3-6 3V9z" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Help --}}
            <nav aria-label="Help">
                <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">Help</h3>
                <ul class="mt-3 space-y-2 text-xs">
                    <li><a href="#" class="hover:text-white">Track Order</a></li>
                    <li><a href="#" class="hover:text-white">Delivery</a></li>
                    <li><a href="#" class="hover:text-white">Returns &amp; Refund</a></li>
                    <li><a href="#" class="hover:text-white">Size Guide</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact Us</a></li>
                </ul>
            </nav>

            {{-- About --}}
            <nav aria-label="About JD">
                <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">About JD</h3>
                <ul class="mt-3 space-y-2 text-xs">
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="#" class="hover:text-white">Careers</a></li>
                    <li><a href="#" class="hover:text-white">Store Locator</a></li>
                    <li><a href="#" class="hover:text-white">Loyalty Program</a></li>
                </ul>
            </nav>

            {{-- Shop --}}
            <nav aria-label="Shop">
                <h3 class="font-condensed text-xs font-bold uppercase tracking-wider text-white">Shop</h3>
                <ul class="mt-3 space-y-2 text-xs">
                    <li><a href="{{ route('shop', ['gender' => 'men']) }}" class="hover:text-white">Men</a></li>
                    <li><a href="{{ route('shop', ['gender' => 'women']) }}" class="hover:text-white">Women</a>
                    </li>
                    <li><a href="{{ route('shop', ['gender' => 'kids']) }}" class="hover:text-white">Kids</a></li>
                    <li><a href="{{ route('shop') }}" class="hover:text-white">All Products</a></li>
                </ul>
            </nav>
        </div>

        {{-- Payment methods --}}
        <div class="mt-10 flex flex-wrap items-center gap-2 border-t border-white/10 pt-6">
            <span class="mr-2 text-[10px] font-semibold uppercase tracking-wider text-gray-500">Payment
                Methods</span>
            @foreach (['Visa', 'Mastercard', 'Apple Pay', 'Google Pay', 'PayPal', 'American Express'] as $payment)
                <span
                    class="rounded border border-white/10 px-2.5 py-1 text-[10px] font-semibold text-gray-400">{{ $payment }}</span>
            @endforeach
        </div>

        {{-- Bottom bar --}}
        <div
            class="mt-6 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-[11px] text-gray-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} Upsilon. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-gray-300">Terms &amp; Conditions</a>
                <a href="#" class="hover:text-gray-300">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>
