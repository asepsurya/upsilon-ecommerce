<!-- Hero Slider Section -->
@if(isset($sliders) && $sliders->isNotEmpty())
<section class="relative h-screen min-h-[650px] overflow-hidden bg-surface-container-lowest select-none">
    <div id="hero-slider" class="relative h-full w-full">

        @foreach($sliders as $slider)
            @php
                $isFirst = $slider->is($sliders->first());
            @endphp
            <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out {{ $isFirst ? 'opacity-100 scale-100' : 'opacity-0 scale-105' }}"
                data-index="{{ $loop->index }}">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $slider->image_url }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.15),transparent_60%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.08),transparent_60%)]"></div>
                <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]"></div>

                <div class="relative z-10 h-full flex items-center">
                    <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                        <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                            @if($slider->title)
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="block w-10 h-px bg-primary"></span>
                                    <span class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">{{ $slider->title }}</span>
                                </div>
                            @endif

                            @if($slider->heading)
                                <h1 class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                                    {{ $slider->heading }}
                                </h1>
                            @endif

                            @if($slider->description)
                                <p class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                                    {{ $slider->description }}
                                </p>
                            @endif

                            @if($slider->link && $slider->link_text)
                                <div class="flex flex-wrap items-center gap-4">
                                    <a href="{{ $slider->link }}"
                                        class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                        <span class="relative z-10 flex items-center gap-2">
                                            {{ $slider->link_text }}
                                            <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                        </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($sliders->count() > 1)
        <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-3 z-20">
            @foreach($sliders as $slider)
                <button type="button"
                    class="slider-dot w-3 h-3 rounded-full bg-white/30 hover:bg-white transition-all duration-300 {{ $loop->first ? 'bg-primary w-6' : '' }}"
                    data-index="{{ $loop->index }}"></button>
            @endforeach
        </div>

        <button type="button" id="hero-prev"
            class="absolute left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center text-white hover:bg-primary transition-all duration-300">
            <span class="material-symbols-outlined text-xl">chevron_left</span>
        </button>
        <button type="button" id="hero-next"
            class="absolute right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center text-white hover:bg-primary transition-all duration-300">
            <span class="material-symbols-outlined text-xl">chevron_right</span>
        </button>
    @endif
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.getElementById('hero-slider');
    if (!slider) return;

    const slides = slider.querySelectorAll('.hero-slide');
    if (slides.length <= 1) return;

    let currentIndex = 0;
    let intervalId;
    const autoPlayDelay = 5000;

    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('hero-prev');
    const nextBtn = document.getElementById('hero-next');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.transform = i === index ? 'scale(1)' : 'scale(1.05)';
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('scale-100', i === index);
            slide.classList.toggle('scale-105', i !== index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-primary', i === index);
            dot.classList.toggle('w-6', i === index);
            dot.classList.toggle('w-3', i !== index);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    }

    function startAutoPlay() {
        intervalId = setInterval(nextSlide, autoPlayDelay);
    }

    function stopAutoPlay() {
        clearInterval(intervalId);
    }

    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoPlay();
        startAutoPlay();
    });

    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoPlay();
        startAutoPlay();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            currentIndex = i;
            showSlide(currentIndex);
            stopAutoPlay();
            startAutoPlay();
        });
    });

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);

    startAutoPlay();
});
</script>
@endpush

@else
<section class="relative h-screen min-h-[650px] overflow-hidden bg-surface-container-lowest select-none">
    <div id="hero-slider" class="relative h-full w-full">

        <!-- Slide 1 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-100 scale-100"
            data-index="0">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/hero-bg.jpg') }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.15),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.08),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]"></div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Autumn / Winter 2025</span>
                        </div>
                        <h1 class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            The Couture<br><span class="text-white/90">Collection</span>
                        </h1>
                        <p class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Sculptural silhouettes meticulously crafted from double-faced Italian cashmere and structured silk-twill.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="{{ route('shop') }}"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Discover Collection
                                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                            <a href="#"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white/5 backdrop-blur-md border border-white/15 text-white font-label-caps text-xs tracking-widest uppercase hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                                Book Atelier Fitting
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105"
            data-index="1">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/banner-bespoke.jpg') }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.12),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.06),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]"></div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Bespoke Tailoring</span>
                        </div>
                        <h1 class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            Made-To-<br><span class="text-white/90">Measure</span>
                        </h1>
                        <p class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Individual measurements taken in private salon suites. Cut, constructed, and hand-canvassed by three generations of Milanese artisans.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Explore Service
                                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="hero-slide absolute inset-0 transition-all duration-1000 ease-in-out opacity-0 scale-105"
            data-index="2">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('storage/images/sample/banner-evening.jpg') }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#000000]/95 via-[#000000]/75 to-transparent"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,175,55,0.15),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,rgba(212,175,55,0.08),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:100px_100px]"></div>

            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-[1600px] mx-auto px-6 sm:px-10 lg:px-20 w-full">
                    <div class="max-w-2xl transform transition-all duration-700 translate-y-0">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="block w-10 h-px bg-primary"></span>
                            <span class="inline-block font-label-caps text-[11px] tracking-[0.3em] uppercase text-primary font-medium">Evening Capsule</span>
                        </div>
                        <h1 class="font-headline-lg lg:font-display-hero text-4xl sm:text-5xl lg:text-7xl text-white tracking-tight leading-[1.05] mb-6">
                            The Nocturne<br><span class="text-white/90">Series</span>
                        </h1>
                        <p class="font-body-lg text-base sm:text-lg text-white/75 font-light leading-relaxed max-w-lg mb-10">
                            Architectural draping and hand-embroidered Czech glass beads. Silhouettes engineered for majestic nocturnal presence and absolute stillness.
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#"
                                class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-primary text-on-primary font-label-caps text-xs tracking-widest uppercase overflow-hidden shadow-xl shadow-primary/20 hover:shadow-primary/40 transition-all duration-300">
                                <span class="relative z-10 flex items-center gap-2">
                                    Shop Eveningwear
                                    <span class="material-symbols-outlined text-sm transition-transform duration-300 group-hover:translate-x-1.5">arrow_forward</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endif
