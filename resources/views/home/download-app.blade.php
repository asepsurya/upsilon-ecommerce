@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Hero Section --}}
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-navy mb-6">Download the Upsilon App</h1>
            <p class="text-xl text-navy/60 max-w-2xl mx-auto mb-8">Shop faster, track orders in real-time, get exclusive app-only deals, and enjoy a seamless shopping experience on the go.</p>
            
            {{-- Download Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#" class="flex items-center gap-4 px-8 py-4 bg-black text-white rounded-xl hover:bg-gray-900 transition-colors w-full sm:w-auto min-w-[280px]">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.93 6.76c-.59-.34-1.27-.34-1.87 0L3.21 12.48c-.51.29-.65.95-.35 1.48.17.3.45.5.77.5H8v6h8v-6h2.38c.32 0 .6-.2.77-.5.3-.53.16-1.19-.35-1.48L12.93 6.76zM4 8.23l7.07-4.04 7.07 4.04v11.54H4V8.23z"/>
                    </svg>
                    <div class="text-left">
                        <span class="text-xs font-medium uppercase tracking-wider">Download on the</span>
                        <span class="block text-lg font-bold">App Store</span>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-4 px-8 py-4 bg-black text-white rounded-xl hover:bg-gray-900 transition-colors w-full sm:w-auto min-w-[280px]">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.14 5.94c-1.17 0-2.1.95-2.1 2.1 0 .75.4 1.39 1 1.73v2.9h-2.84c-.59 0-1.08.48-1.08 1.08 0 .39.2.73.5.9.47.26 1.07.13 1.46-.32.37-.44.47-1.1.27-1.62l-.63-1.6c-.06-.14-.03-.3.06-.41.37-.42 1.07-1.16 1.07-2.09 0-1.41-1.14-2.56-2.56-2.56zm5.9 7.46c-.51.75-1.6 1.34-2.9 1.34-1.78 0-3.22-1.39-3.47-3.26h-2.04v-.96c0-.72.36-1.44 1-1.83.64-.39 1.5-.2 2.04.46v2.61h1.85c.2 0 .39-.13.44-.32.05-.19.03-.4-.06-.56l-.63-1.6c-.44-1.15 1.29-1.52 1.6-1.52.6 0 1.32.38 1.55 1.02.12.33.02.68-.27.88l-.63.52c-.32.26-.87.38-1.27.38-.83 0-1.5-.75-1.5-1.62 0-.62.4-1.22 1.2-1.34 1.05-.16 1.75.4 2.27 1.24.34.55.2 1.23-.35 1.62-.56.39-1.41.57-2.2.57-1.17 0-2.1-.95-2.1-2.1 0-.75.4-1.39 1-1.73V4.6h2.84c.59 0 1.08-.48 1.08-1.08 0-.39-.2-.73-.5-.9-.47-.26-1.07-.13-1.46.32-.37.44-.47 1.1-.27 1.62l.63 1.6c.06.14.03.3-.06.41-.37.42-1.07 1.16-1.07 2.09 0 1.41 1.14 2.56 2.56 2.56 1.59 0 2.91-1.18 3.27-2.6.32-1.27 1.65-2.14 3.07-2.14 1.41 0 2.56 1.14 2.56 2.56 0 .58-.24 1.1-.62 1.47.76.3 1.34 1.02 1.34 1.89 0 .67-.4 1.3-.88 1.57-.43.24-1.04.2-1.38-.18-.3-.33-.17-.83.27-1.1.44-.26 1.18-.42 1.83-.42 1.12 0 2.03.85 2.03 1.9 0 1.05-.9 1.9-2.03 1.9-.86 0-1.62-.5-1.88-1.2l-.63-.52c-.43-.36-.47-1.05-.07-1.38.47-.38 1.26-.4 1.7-.12.4.24.63.66.63 1.12 0 .65-.54 1.18-1.2 1.18-.4 0-.76-.16-1-.41l-.63.52c-.3.27-.4.67-.32 1.1.1.55.58.98 1.12.98.77 0 1.45-.7 1.45-1.56 0-.68-.33-1.27-.86-1.63-.33-.23-.77-.14-1.07.18-.28.3-.37.8-.23 1.21.23.68 1.13 1.09 1.88 1.09 1.05 0 1.9-.8 1.9-1.77 0-.75-.4-1.39-1-1.73v-2.9h2.84c.59 0 1.08-.48 1.08-1.08 0-.39-.2-.73-.5-.9-.47-.26-1.07-.13-1.46.32-.37.44-.47 1.1-.27 1.62l.63 1.6c.06.14.03.3-.06.41-.37.42-1.07 1.16-1.07 2.09 0 1.41 1.14 2.56 2.56 2.56 1.59 0 2.91-1.18 3.27-2.6.32-1.27 1.65-2.14 3.07-2.14 1.41 0 2.56 1.14 2.56 2.56 0 .58-.24 1.1-.62 1.47.76.3 1.34 1.02 1.34 1.89 0 .67-.4 1.3-.88 1.57-.43.24-1.04.2-1.38-.18-.3-.33-.17-.83.27-1.1.44-.26 1.18-.42 1.83-.42 1.12 0 2.03.85 2.03 1.9 0 1.05-.9 1.9-2.03 1.9-.86 0-1.62-.5-1.88-1.2l-.63-.52c-.43-.36-.47-1.05-.07-1.38.47-.38 1.26-.4 1.7-.12.4.24.63.66.63 1.12 0 .65-.54 1.18-1.2 1.18-.4 0-.76-.16-1-.41l-.63.52c-.3.27-.4.67-.32 1.1.1.55.58.98 1.12.98.77 0 1.45-.7 1.45-1.56 0-.68-.33-1.27-.86-1.63-.33-.23-.77-.14-1.07.18-.28.3-.37.8-.23 1.21.23.68 1.13 1.09 1.88 1.09 1.05 0 1.9-.8 1.9-1.77z"/>
                    </svg>
                    <div class="text-left">
                        <span class="text-xs font-medium uppercase tracking-wider">Get it on</span>
                        <span class="block text-lg font-bold">Google Play</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- QR Code Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12 mb-16 text-center">
            <h2 class="text-2xl font-bold text-navy mb-4">Or scan to download</h2>
            <p class="text-navy/60 mb-8">Scan the QR code with your phone camera</p>
            
            <div class="inline-flex items-center justify-center gap-12">
                <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-primary/20"></div>
                        <svg class="w-24 h-24 text-primary/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 11l3 3L22 4M9 11l3 3L2 22m0 0l3-3m-3 3h18M9 11h18"/>
                        </svg>
                    </div>
                    <p class="text-sm text-navy/60 mt-4">App Store QR</p>
                </div>
                <div class="p-6 bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-primary/20"></div>
                        <svg class="w-24 h-24 text-primary/30 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 11l3 3L22 4M9 11l3 3L2 22m0 0l3-3m-3 3h18M9 11h18"/>
                        </svg>
                    </div>
                    <p class="text-sm text-navy/60 mt-4">Google Play QR</p>
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-navy text-center mb-12">Why Download the App?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy mb-2">Faster Checkout</h3>
                    <p class="text-navy/60">Save payment methods and addresses for lightning-fast checkout</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy mb-2">Real-time Tracking</h3>
                    <p class="text-navy/60">Get push notifications for order updates and delivery status</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy mb-2">Exclusive Deals</h3>
                    <p class="text-navy/60">Access app-only discounts, early access sales, and loyalty rewards</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-navy mb-2">Secure Account</h3>
                    <p class="text-navy/60">Biometric login, order history, and easy returns management</p>
                </div>
            </div>
        </div>

        {{-- App Screenshots/Preview --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-16">
            <div class="p-8 md:p-12 text-center">
                <h2 class="text-3xl font-bold text-navy mb-4">Seamless Shopping Experience</h2>
                <p class="text-navy/60 max-w-2xl mx-auto mb-8">Browse, shop, and manage your orders with an intuitive interface designed for mobile</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    <div class="aspect-[9/19] bg-gray-100 rounded-xl overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-navy/60">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-lg font-medium">Home & Discovery</span>
                        </div>
                    </div>
                    <div class="aspect-[9/19] bg-gray-100 rounded-xl overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-navy/60">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="text-lg font-medium">Product Details</span>
                        </div>
                    </div>
                    <div class="aspect-[9/19] bg-gray-100 rounded-xl overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-primary/10"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center h-full text-navy/60">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-lg font-medium">Order Tracking</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="bg-navy rounded-2xl p-8 md:p-12 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Ready to shop smarter?</h2>
            <p class="text-navy-200 max-w-xl mx-auto mb-8">Join thousands of happy customers. Download the app today and get 10% off your first order.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#" class="px-8 py-4 bg-white text-navy rounded-xl font-medium hover:bg-gray-100 transition-colors">Download for iOS</a>
                <a href="#" class="px-8 py-4 border-2 border-white text-white rounded-xl font-medium hover:bg-white/10 transition-colors">Download for Android</a>
            </div>
        </div>
    </div>
</div>
@endsection