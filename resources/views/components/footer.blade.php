<footer class="w-full bg-surface-container-lowest border-t border-outline-variant/30 text-on-surface-variant">
    <div class="w-full max-w-[1600px] mx-auto px-4 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
            <div class="lg:col-span-2 pr-0 lg:pr-6">
                <span class="font-headline-sm text-base tracking-tight text-on-surface uppercase block mb-4">{{ $siteSettings['app_name'] }}</span>
                <p class="font-body-md text-sm text-on-surface-variant mb-6 max-w-md font-light">An architectural synthesis of haute couture precision, enigmatic obsidian aesthetics, and deliberate bespoke craftsmanship.</p>
                <div class="mb-6">
                    <span class="font-label-caps text-xs uppercase tracking-widest text-primary block mb-2">Subscribe to the Private Gazette</span>
                    <div class="flex w-full max-w-sm">
                        <input class="bg-surface-container border border-outline-variant px-4 py-2 font-body-sm text-sm text-on-surface placeholder:text-outline focus:border-primary focus:outline-none flex-1" placeholder="Enter your email address" type="email">
                        <button class="bg-primary-container hover:bg-primary text-on-primary-container font-label-caps text-xs uppercase tracking-widest px-4 py-2 transition-colors" type="button">Acquire</button>
                    </div>
                </div>
                <p class="font-body-sm text-xs text-outline">Discreet releases, bespoke salon invitations, and archival reveals.</p>
            </div>
            <div>
                <span class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-4">Client Services</span>
                <ul class="space-y-2">
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Bespoke Concierge</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Complimentary Global Express</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">White-Glove Returns & Exchanges</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Garment Care & Restoration</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Security & Authenticity Verification</li>
                </ul>
            </div>
            <div>
                <span class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-4">Atelier & Maison</span>
                <ul class="space-y-2">
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Book Private Salon Appointment</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Place Vendôme Flagship</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">The Craftsmanship & Provenance</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Private Client Guild</li>
                    <li class="font-body-sm text-sm hover:text-primary transition-colors cursor-pointer">Archival Collections</li>
                </ul>
            </div>
            <div>
                <span class="font-label-caps text-xs uppercase tracking-widest text-on-surface block mb-4">Contact</span>
                <ul class="space-y-2 font-body-sm text-sm">
                    @if($siteSettings['contact_email'])
                        <li class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:{{ $siteSettings['contact_email'] }}" class="hover:text-primary transition-colors">{{ $siteSettings['contact_email'] }}</a>
                        </li>
                    @endif
                    @if($siteSettings['contact_phone'])
                        <li class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $siteSettings['contact_phone'] }}
                        </li>
                    @endif
                    @if($siteSettings['contact_address'])
                        <li class="flex items-start gap-2 text-on-surface-variant">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-xs leading-relaxed">{{ $siteSettings['contact_address'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="pt-6 border-t border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-wrap">
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-outline">Accepted Instruments:</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant border border-outline-variant px-2 py-0.5">Visa Infinite</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant border border-outline-variant px-2 py-0.5">Mastercard World Elite</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant border border-outline-variant px-2 py-0.5">American Express Centurion</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant border border-outline-variant px-2 py-0.5">Apple Pay</span>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant border border-outline-variant px-2 py-0.5">Cryptocurrency (BTC/ETH)</span>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-4">
                <span class="font-body-sm text-xs text-outline">© {{ date('Y') }} {{ $siteSettings['app_name'] }}. All rights reserved.</span>
                <div class="flex items-center gap-4">
                    @if($siteSettings['social_instagram'])
                        <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="Instagram">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($siteSettings['social_facebook'])
                        <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($siteSettings['social_twitter'])
                        <a href="{{ $siteSettings['social_twitter'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="Twitter">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    @endif
                    @if($siteSettings['social_tiktok'])
                        <a href="{{ $siteSettings['social_tiktok'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="TikTok">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.517 0C5.614 0 .006 5.58.032 12.477c0 2.49.532 4.898 1.561 6.954 3.814-.16 6.802-2.597 7.56-6.227-.546-2.472-.777-4.512-1.15-7.185h2.643c.63 2.771 1.991 5.217 3.28 6.593.23.247.501.434.815.434.334 0 .646-.21.754-.492.382-1.077.856-2.577 1.015-4.16.138-1.256-.064-2.49-.408-3.411-1.534-.872-3.358-1.294-5.488-1.503-.335-.04-.647-.15-.862-.361 2.272-2.59 3.521-6.008 3.521-10.134zM6.842 12.823c-.504-2.68.543-4.743 2.772-4.88.23-.015.46-.025.69-.025.52 0 1.02.02 1.45.07 1.55.16 3.11 2.143 3.425 4.83h-1.98c-.19-1.218-.58-2.283-1.29-2.71-.7-.41-1.49-.48-2.08-.27-.46.15-.82.39-1.03.71-1.25 1.98-1.55 4.645-1.2 7.011.1 1.55 2.1 2.815 3.87 2.815 2.03 0 3.395-1.778 3.44-3.92.02-1.08-.17-2.02-.84-2.63-.34-.25-.7-.47-1.06-.62-2.52-1.04-4.9-2.35-6.81-4.36v-.08z"/></svg>
                        </a>
                    @endif
                    @if($siteSettings['social_youtube'])
                        <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="YouTube">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    @endif
                    @if($siteSettings['social_linkedin'])
                        <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank" rel="noopener" class="text-outline hover:text-primary transition-colors" aria-label="LinkedIn">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
