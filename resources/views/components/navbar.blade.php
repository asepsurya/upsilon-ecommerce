<header id="navbar"
    class="fixed top-0 left-0 w-full z-50  backdrop-blur-xl border-b border-[#383838] shadow-[0_4px_20px_rgba(0,0,0,0.5)] ">
    @php
        $categories = \App\Models\Category::active()->sorted()->get();
        $isHome = true;
    @endphp

    <!-- Top Bar -->
    <div class="w-full bg-[#040A12] text-white border-b border-white/10">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8 h-11 flex items-center justify-between">

            <!-- Pilihan Bahasa & Mata Uang -->
            <div class="hidden md:flex items-center gap-5">
                <div class="flex items-center gap-1.5 cursor-pointer">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/80 hover:text-white transition-colors">English</span>
                    <span class="material-symbols-outlined text-sm text-white/50">expand_more</span>
                </div>
                <span class="w-px h-3.5 bg-white/15"></span>
                <div class="flex items-center gap-1.5 cursor-pointer">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/80 hover:text-white transition-colors">$ Dollar (US)</span>
                    <span class="material-symbols-outlined text-sm text-white/50">expand_more</span>
                </div>
            </div>

            @php
                $announcements = \App\Models\Announcement::active()->get();
            @endphp

            <!-- Pengumuman (Desktop) -->
            @if($announcements->isNotEmpty())
                <div class="hidden md:flex flex-1 min-w-0 justify-center items-center overflow-hidden relative h-11 text-white" id="announcement-bar">
                    @foreach($announcements as $index => $announcement)
                        <div class="announcement-item flex items-center justify-center gap-2 absolute inset-0 transition-all duration-500 ease-out {{ $index === 0 ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-full' }}"
                            data-index="{{ $index }}"
                            data-duration="{{ $announcement->duration }}"
                            data-animation="{{ $announcement->animation }}">

                            @if($announcement->title)
                                <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/70">{{ $announcement->title }}:</span>
                            @endif

                            <span class="announcement-text font-label-caps text-[11px] tracking-widest uppercase text-white">{{ $announcement->message }}</span>

                            @if($announcement->code)
                                <span class="inline-block border border-dashed border-primary/50 text-primary bg-primary/10 px-2.5 py-0.5 font-label-caps text-[11px] tracking-widest uppercase whitespace-nowrap">{{ $announcement->code }}</span>
                            @endif

                            @if($announcement->link && $announcement->link_text)
                                <a href="{{ $announcement->link }}" target="_blank" rel="noopener"
                                    class="text-primary hover:underline font-label-caps text-[11px] tracking-widest uppercase whitespace-nowrap ml-1">{{ $announcement->link_text }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="hidden md:flex items-center gap-2">
                    <span class="font-label-caps text-[11px] tracking-widest uppercase text-white/70">Boost Your Daily Routine! Use Code:</span>
                    <span class="inline-block border border-dashed border-primary/50 text-primary bg-primary/10 px-2.5 py-0.5 font-label-caps text-[11px] tracking-widest uppercase">HEALTH10</span>
                </div>
            @endif

            <!-- Pengumuman (Mobile) -->
            <div class="flex md:hidden items-center">
                <span class="font-label-caps text-[10px] tracking-widest uppercase text-white/70">Code: <span class="text-primary font-bold">HEALTH10</span></span>
            </div>

            <!-- Media Sosial -->
            <div class="hidden md:flex items-center gap-4">
                <a href="#" class="text-white/60 hover:text-white transition-colors" aria-label="Twitter">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="#" class="text-white/60 hover:text-white transition-colors" aria-label="YouTube">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
            </div>

        </div>
    </div>

    <!-- Main Header -->
    <div class="w-full max-w-[1600px] mx-auto px-4 lg:px-8 h-20 flex items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <button id="mobile-menu-btn"
                class="lg:hidden flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white' : 'text-navy' }} hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
            <a class="flex items-center gap-2.5" data-path="home" href="{{ route('home') }}">
                @if($isHome)
                    <img alt="Vitalis Labs" class="h-9 w-auto object-contain brightness-200"
                        src="{{ asset('storage/images/sample/logo.png') }}">
                @else
                    <img alt="Vitalis Labs" class="h-9 w-auto object-contain"
                        src="{{ asset('storage/images/sample/logo.png') }}">
                @endif
            </a>
        </div>

        <!-- Search Bar -->
        <form class="hidden lg:flex flex-1 max-w-2xl mx-8" action="{{ route('shop') }}" method="GET">
            <div
                class="flex items-center w-full bg-[#040A12] rounded-full relative shadow-inner border border-[#383838]">
                <button type="button" id="category-dropdown-btn"
                    class="flex items-center bg-[#040A12] text-white px-5 h-12 cursor-pointer hover:bg-black/40 transition-colors font-label-caps text-xs uppercase tracking-widest border-none outline-none whitespace-nowrap rounded-l-full border-r border-[#383838]">
                    <span>All Categories</span>
                    <span class="material-symbols-outlined text-sm ml-2 text-white/60">expand_more</span>
                </button>
                <input name="search"
                    class="flex-1 px-5 h-12 bg-transparent border-0 outline-none ring-0 focus:border-0 focus:outline-none focus:ring-0 font-body-sm text-sm text-white placeholder:text-white/30"
                    placeholder="Search products..." type="text">
                <button type="submit" class="px-5 h-12 text-white/80 hover:text-white transition-colors rounded-r-full">
                    <span class="material-symbols-outlined text-xl">search</span>
                </button>

                <!-- Dropdown -->
                <div id="category-dropdown"
                    class="hidden absolute top-full left-0 mt-1 w-64 bg-black rounded-xl shadow-xl border border-[#999999]/20 z-50 py-2">
                    <div class="px-4 py-2">
                        <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant">Shop
                            By Categories</span>
                    </div>
                    <div class="divide-y divide-[#999999]/10">
                        @foreach($categories as $category)
                            <a href="{{ route('shop.category', $category->slug) }}"
                                class="flex items-center justify-between px-4 py-2.5 hover:bg-surface-container transition-colors group">
                                <span
                                    class="font-body-sm text-sm text-on-surface group-hover:text-primary transition-colors">{{ $category->name }}</span>
                                <span
                                    class="material-symbols-outlined text-sm text-outline-variant group-hover:text-primary transition-colors">chevron_right</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>

        <div class="flex items-center gap-1 md:gap-2">
            <div
                class="hidden lg:flex items-center gap-2.5 pr-3 border-r {{ $isHome ? 'border-white/10' : 'border-[#999999]/20' }}">
                <span class="material-symbols-outlined text-xl text-primary">support_agent</span>
                <div>
                    <span
                        class="block font-label-caps text-[10px] uppercase tracking-widest {{ $isHome ? 'text-white/50' : 'text-navy/60' }}">Need
                        Help:</span>
                    <span
                        class="block font-body-sm text-sm {{ $isHome ? 'text-white' : 'text-navy' }} font-medium">(+01)
                        9876 5555</span>
                </div>
            </div>
            <a class="hidden md:flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors"
                data-path="account" href="{{ route('account.dashboard') }}">
                <span class="material-symbols-outlined text-xl">person</span>
            </a>
            {{-- <a
                class="hidden md:flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors"
                data-path="wishlist" href="{{ route('wishlist') }}">
                <span class="material-symbols-outlined text-xl">favorite</span>
            </a>
            <a class="flex items-center justify-center w-10 h-10 {{ $isHome ? 'text-white/80' : 'text-navy' }} hover:text-primary transition-colors relative"
                data-path="bag" href="{{ route('cart') }}">
                <span class="material-symbols-outlined text-xl">shopping_bag</span>
                <span
                    class="absolute -top-0.5 -right-0.5 bg-primary text-on-primary font-label-caps text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
            </a> --}}
        </div>
    </div>

    <!-- Mobile Search -->
    <div class="md:hidden px-4 pb-3">
        <form action="{{ route('shop') }}" method="GET"
            class="flex items-center bg-[#040A12] rounded-full overflow-hidden shadow-inner border border-[#383838]">
            <input name="search"
                class="flex-1 px-4 py-2.5 bg-transparent font-body-sm text-sm text-white placeholder:text-white/30 focus:outline-none"
                placeholder="Search wellness..." type="text">
            <button type="submit" class="px-4 py-2.5 text-white/70 hover:text-white transition-colors">
                <span class="material-symbols-outlined text-xl">search</span>
            </button>
        </form>
    </div>

    <!-- Navigation Links -->
    <nav class="border-t border-[#999999]/20 {{ $isHome ? 'bg-transparent' : 'bg-white' }}">
        <div class="max-w-[1600px] mx-auto px-4 lg:px-8">
            <div class="hidden lg:flex items-center justify-center">
                <div class="flex items-center">
                    @php
                        $navClass = $isHome ? 'text-white hover:text-white/80' : 'text-navy hover:text-primary';
                    @endphp
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('home') }}">Home</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('shop') }}">Shop</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('about') }}">About</a>
                    <a class="{{ $navClass }} flex items-center gap-1.5 px-4 h-12 font-label-caps text-xs uppercase tracking-widest transition-colors"
                        href="{{ route('contact') }}">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden lg:hidden border-t {{ $isHome ? 'border-white/10 bg-[#071324]' : 'border-[#999999]/20 bg-white' }}">
        <div class="px-4 py-3 space-y-1">
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="home" href="{{ route('home') }}">Home</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="shop" href="{{ route('shop') }}">Shop</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="supplements" href="#">Supplements</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl border-b {{ $isHome ? 'border-white/5' : 'border-[#999999]/10' }}"
                data-path="science-lab" href="#">Science & Lab</a>
            <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl"
                data-path="journal" href="#">Journal</a>
            <div class="border-t {{ $isHome ? 'border-white/10' : 'border-[#999999]/20' }} pt-2 mt-2">
                <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest text-primary hover:bg-primary/10 transition-colors rounded-xl"
                    data-path="order-tracking" href="#">Order Tracking</a>
                <a class="flex items-center justify-between px-4 py-3.5 font-label-caps text-xs uppercase tracking-widest {{ $isHome ? 'text-white/90 hover:bg-white/5' : 'text-navy hover:bg-surface-container' }} hover:text-primary transition-colors rounded-xl"
                    data-path="recently-viewed" href="#">Recently Viewed</a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const announcementBar = document.getElementById('announcement-bar');
            if (!announcementBar) return;

            const items = announcementBar.querySelectorAll('.announcement-item');
            if (items.length <= 1) return;

            let currentIndex = 0;
            let intervalId = null;
            let isAnimating = false;

            function typeWriter(element, text, speed = 30) {
                return new Promise(resolve => {
                    element.textContent = '';
                    let i = 0;
                    (function type() {
                        if (i < text.length) {
                            element.textContent += text.charAt(i++);
                            setTimeout(type, speed);
                        } else {
                            resolve();
                        }
                    })();
                });
            }

            function slideUp(current, next) {
                return new Promise(resolve => {
                    current.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
                    current.style.transform = 'translateY(-100%)';
                    current.style.opacity = '0';
                    next.style.transition = 'transform 0.5s ease-out, opacity 0.5s ease-out';
                    next.style.transform = 'translateY(0)';
                    next.style.opacity = '1';
                    setTimeout(resolve, 500);
                });
            }

            async function showNext() {
                if (isAnimating) return;
                isAnimating = true;

                const current = items[currentIndex];
                const nextIndex = (currentIndex + 1) % items.length;
                const next = items[nextIndex];
                const animation = current.dataset.animation || 'slide';
                const duration = parseInt(current.dataset.duration) || 5000;

                if (animation === 'typewriter') {
                    const textEl = next.querySelector('.announcement-text');
                    if (textEl && textEl.dataset.fullText) {
                        await typeWriter(textEl, textEl.dataset.fullText, 30);
                    }
                    current.style.transition = 'opacity 0.3s ease-out';
                    current.style.opacity = '0';
                    next.style.transition = 'opacity 0.3s ease-out';
                    next.style.opacity = '1';
                } else {
                    await slideUp(current, next);
                }

                currentIndex = nextIndex;
                isAnimating = false;
                intervalId = setTimeout(showNext, duration);
            }

            // Cache text for typewriter animation
            items.forEach(item => {
                const textEl = item.querySelector('.announcement-text');
                if (textEl) {
                    textEl.dataset.fullText = textEl.textContent.trim();
                    if (item.dataset.animation === 'typewriter') textEl.textContent = '';
                }
            });

            // Ensure first item visible
            items[0].style.opacity = '1';
            items[0].style.transform = 'translateY(0)';

            intervalId = setTimeout(showNext, parseInt(items[0].dataset.duration) || 5000);

            announcementBar.addEventListener('mouseenter', () => clearTimeout(intervalId));
            announcementBar.addEventListener('mouseleave', () => {
                if (!isAnimating) {
                    intervalId = setTimeout(showNext, parseInt(items[currentIndex].dataset.duration) || 5000);
                }
            });
        });
    </script>
    @endpush

</header>