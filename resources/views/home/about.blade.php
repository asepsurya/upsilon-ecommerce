@extends('layouts.home')

@section('title', 'About Us | Upsilon')
@section('description', 'Learn more about Upsilon — premium embroidered t-shirts with minimalist elegance and uncompromising quality.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    @include('components.site-header')

    <main class="w-full bg-white text-black">
        <div class="flex flex-col w-full">
            <!-- HERO STAGE SECTION -->
            <section class="relative w-full overflow-hidden bg-white -mt-20 pt-28 pb-12">
                <div class="max-w-7xl mx-auto px-4 lg:px-8">
                    <!-- Top Meta Bar / Overline -->
                    <div class="flex flex-wrap items-center justify-between gap-4 pb-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-black animate-pulse"></span>
                            <span class="text-xs font-medium text-black uppercase tracking-widest">ABOUT UPSILON // EST. 2025</span>
                        </div>
                        <div class="flex items-center gap-4 text-xs font-medium text-gray-600">
                            <span>PREMIUM APPAREL</span>
                            <span class="text-gray-300">/</span>
                            <span>EMBROIDERED T-SHIRTS</span>
                        </div>
                    </div>
                    <!-- Main Brutalist Editorial Hero Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-12">
                        <!-- Huge Editorial Title Typography -->
                        <div class="lg:col-span-8 flex flex-col justify-end">
                            <p class="text-xs font-medium text-black uppercase tracking-[0.25em] mb-2">OUR MANIFESTO</p>
                            <h1 class="text-5xl lg:text-7xl uppercase tracking-tighter text-black leading-none select-none">
                                BUILT WITH<br/>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-black via-gray-800 to-gray-600">RADICAL INTENTION</span><br/>
                                <span class="text-gray-900">FUTURE FORM</span>
                            </h1>
                        </div>
                        <!-- Hero Side Editorial Narrative & Action Box -->
                        <div class="lg:col-span-4 flex flex-col justify-between bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200">
                            <div class="mb-4">
                                <span class="text-xs font-medium text-gray-500 uppercase">ABOUT SPECIFICATION</span>
                                <p class="text-base text-gray-700 mt-2">
                                    Welcome to a world where minimalist elegance meets the highest standards of comfort. The Upsilon Series presents a premium collection of t-shirts featuring an iconic embroidered Upsilon emblem, specially designed for those who appreciate detail, aesthetics, and uncompromising quality.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-2 pt-4">
                                <a class="flex items-center justify-between bg-black hover:bg-gray-800 text-white px-4 py-3 rounded-lg text-base font-bold uppercase transition-all shadow-md group" data-path="catalog" href="{{ route('home') }}">
                                    <span>EXPLORE COLLECTION</span>
                                    <span class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ABOUT CONTENT -->
            <section class="w-full bg-white py-24">
                <div class="max-w-5xl mx-auto px-4 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                        <div>
                            <span class="text-xs font-medium text-black uppercase tracking-widest">About Us</span>
                            <h2 class="text-4xl lg:text-5xl text-gray-900 uppercase tracking-tight mt-2 mb-6">Upsilon</h2>
                            <p class="text-lg text-gray-600 leading-relaxed">
                                Welcome to a world where minimalist elegance meets the highest standards of comfort. The Upsilon Series presents a premium collection of t-shirts featuring an iconic embroidered Upsilon emblem, specially designed for those who appreciate detail, aesthetics, and uncompromising quality.
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                            <h3 class="text-2xl text-gray-900 font-bold mb-4">The Philosophy Behind the Upsilon Symbol</h3>
                            <p class="text-gray-600 leading-relaxed">
                                The Upsilon symbol represents branching points, the journey of life, and choosing the best path forward. We weave this philosophy into every garment: a representation for individuals who dare to direct their lives with confidence, conviction, and classy style.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="w-full bg-gray-50 py-24">
                <div class="max-w-5xl mx-auto px-4 lg:px-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-xl text-gray-900 font-bold mb-3">Premium Material Commitment</h3>
                            <p class="text-gray-600 leading-relaxed mb-4">
                                We believe the finest apparel begins with the finest materials. Every t-shirt in the Upsilon collection is crafted from selected fabrics built to high-quality standards:
                            </p>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li>
                                    <span class="font-semibold text-gray-900">100% Premium Cotton Combed:</span> Made from handpicked natural cotton fibers processed through meticulous combing, resulting in an exceptionally smooth, soft, and breathable fabric against the skin.
                                </li>
                                <li>
                                    <span class="font-semibold text-gray-900">Optimal Sweat Absorption:</span> Comfortable for all-day wear, whether for casual outdoor activities or high-mobility schedules.
                                </li>
                                <li>
                                    <span class="font-semibold text-gray-900">Ideal Thickness:</span> Provides a great drape on the body without feeling overly heavy or sheer.
                                </li>
                            </ul>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-xl text-gray-900 font-bold mb-3">Exclusive Embroidery Details</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Unlike regular screen printing, the Upsilon emblem on every t-shirt is crafted using high-precision computerized embroidery. Selected tight and durable threads create an elegant textured effect that is long-lasting, fade-resistant, and stays neat even after repeated washing.
                            </p>
                        </div>
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-xl text-gray-900 font-bold mb-3">Comfort & Stitching Standards</h3>
                            <p class="text-gray-600 leading-relaxed mb-3">
                                <span class="font-semibold text-gray-900">Distro-Standard Chain Stitching:</span> Strong, neat, and durable shoulder and neck construction.
                            </p>
                            <p class="text-gray-600 leading-relaxed">
                                <span class="font-semibold text-gray-900">Modern Regular Fit:</span> Ergonomically tailored cutting designed to offer freedom of movement while presenting a neat, well-proportioned silhouette.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="w-full bg-white py-24">
                <div class="max-w-6xl mx-auto px-4 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="text-xs font-medium text-black uppercase tracking-widest">Our Team</span>
                        <h2 class="text-4xl lg:text-5xl text-gray-900 uppercase tracking-tight mt-2">Meet the People Behind Upsilon</h2>
                        <p class="text-lg text-gray-600 mt-4 max-w-3xl mx-auto">A small team with one shared mission: bring well-made, comfortable apparel with meaning and identity.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="aspect-square bg-gray-100">
                                <img src="https://placehold.co/600x600/f3f4f6/111111?text=CEO" alt="CEO" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold text-gray-900">Ahmad Rizky</h3>
                                <p class="text-sm text-gray-600">CEO</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="aspect-square bg-gray-100">
                                <img src="https://placehold.co/600x600/f3f4f6/111111?text=CTO" alt="CTO" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold text-gray-900">Diana Putri</h3>
                                <p class="text-sm text-gray-600">CTO</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="aspect-square bg-gray-100">
                                <img src="https://placehold.co/600x600/f3f4f6/111111?text=Head+of+Product" alt="Head of Product" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold text-gray-900">Bima Saputra</h3>
                                <p class="text-sm text-gray-600">Head of Product</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="aspect-square bg-gray-100">
                                <img src="https://placehold.co/600x600/f3f4f6/111111?text=Marketing+Lead" alt="Marketing Lead" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold text-gray-900">Siti Nurhaliza</h3>
                                <p class="text-sm text-gray-600">Marketing Lead</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="w-full bg-white py-24">
                <div class="max-w-5xl mx-auto px-4 lg:px-8 text-center">
                    <h2 class="text-3xl lg:text-4xl text-gray-900 uppercase tracking-tight mb-6">Experience luxury in simplicity</h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-8">
                        Step out in confidence with a strong identity. Experience luxury in simplicity with Upsilon Embroidered T-Shirts.
                    </p>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-lg text-sm font-bold uppercase tracking-wider transition-colors">
                        <span>Explore Collection</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </section>
        </div>
    </main>
@endsection
