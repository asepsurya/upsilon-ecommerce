import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    const handleScroll = () => {
        if (window.scrollY > 10) {
            navbar?.classList.add('shadow-soft');
        } else {
            navbar?.classList.remove('shadow-soft');
        }
    };
    window.addEventListener('scroll', handleScroll);

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('hidden');
    });

    // Close mobile menu when clicking a link inside it
    mobileMenu?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu?.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
            mobileMenu?.classList.add('hidden');
        }
    });

    // Category dropdown toggle
    const categoryDropdownBtn = document.getElementById('category-dropdown-btn');
    const categoryDropdown = document.getElementById('category-dropdown');

    categoryDropdownBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        categoryDropdown?.classList.toggle('hidden');
    });

    // Close category dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!categoryDropdown?.contains(e.target) && !categoryDropdownBtn?.contains(e.target)) {
            categoryDropdown?.classList.add('hidden');
        }
    });

    // Close category dropdown when clicking a link inside it
    categoryDropdown?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            categoryDropdown.classList.add('hidden');
        });
    });

    // Hero slider
    const slides = document.querySelectorAll('.hero-slide');
    const dotsContainer = document.getElementById('hero-dots');
    const heroSection = document.querySelector('[data-purpose="hero-banner"]');
    let currentSlide = 0;
    let slideInterval;

    const createDots = () => {
        if (!dotsContainer || slides.length <= 1) return;
        dotsContainer.innerHTML = '';
        slides.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.dataset.dot = index;
            dot.className = 'hero-dot w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white/60 transition-all duration-300';
            if (index === 0) dot.classList.add('bg-white', 'w-6');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });
    };

    const updateDots = () => {
        const dots = dotsContainer?.querySelectorAll('.hero-dot');
        if (!dots) return;
        dots.forEach((dot, index) => {
            dot.classList.toggle('bg-white', index === currentSlide);
            dot.classList.toggle('w-6', index === currentSlide);
            dot.classList.toggle('bg-white/30', index !== currentSlide);
            dot.classList.toggle('w-2.5', index !== currentSlide);
        });
    };

    const showSlide = (index) => {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('scale-100', i === index);
            slide.classList.toggle('scale-105', i !== index);
        });
        currentSlide = index;
        updateDots();
    };

    const nextSlide = () => {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    };

    const prevSlide = () => {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    };

    const goToSlide = (index) => {
        showSlide(index);
        resetAutoSlide();
    };

    const resetAutoSlide = () => {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 6000);
    };

    const startAutoSlide = () => {
        slideInterval = setInterval(nextSlide, 6000);
    };

    if (slides.length > 0) {
        createDots();
        showSlide(0);
        startAutoSlide();

        document.getElementById('hero-prev')?.addEventListener('click', () => {
            prevSlide();
            resetAutoSlide();
        });

        document.getElementById('hero-next')?.addEventListener('click', () => {
            nextSlide();
            resetAutoSlide();
        });

        heroSection?.addEventListener('mouseenter', () => clearInterval(slideInterval));
        heroSection?.addEventListener('mouseleave', startAutoSlide);
    }

    // Cart count update
    const updateCartCount = () => {
        fetch('/cart/count')
            .then(r => r.json())
            .then(data => {
                const countEl = document.getElementById('cart-count');
                if (countEl) {
                    if (data.count > 0) {
                        countEl.textContent = data.count;
                        countEl.classList.remove('hidden');
                    } else {
                        countEl.classList.add('hidden');
                    }
                }
            });
    };

    // Quick add to cart
    document.addEventListener('quick-add', (e) => {
        const variantId = e.detail.variantId;
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            },
            body: JSON.stringify({ product_variant_id: variantId, quantity: 1 }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                showToast('success', data.message || 'Added to cart');
            } else {
                showToast('error', data.error || 'Failed to add');
            }
        })
        .catch(() => showToast('error', 'Something went wrong'));
    });

    // Toast notifications
    window.addEventListener('show-toast', (e) => {
        showToast(e.detail.type, e.detail.message);
    });

    // Initial cart count
    updateCartCount();
});

// Toast function
function showToast(type, message) {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    const colors = {
        success: 'bg-green-600',
        error: 'bg-red-600',
        warning: 'bg-yellow-600',
        info: 'bg-charcoal-800',
    };
    toast.className = `${colors[type] || colors.info} text-white px-4 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform translate-x-full opacity-0 transition-all duration-300`;
    toast.innerHTML = `
        <span class="text-sm font-medium">${message}</span>
        <button class="ml-2 text-white/70 hover:text-white" onclick="this.parentElement.remove()">&times;</button>
    `;
    container.appendChild(toast);
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    }, 10);
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Back to top button
const backToTop = document.getElementById('back-to-top');
window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
        backToTop?.classList.remove('opacity-0', 'pointer-events-none');
        backToTop?.classList.add('opacity-100');
    } else {
        backToTop?.classList.add('opacity-0', 'pointer-events-none');
        backToTop?.classList.remove('opacity-100');
    }
});

// Initialize Alpine
Alpine.start();