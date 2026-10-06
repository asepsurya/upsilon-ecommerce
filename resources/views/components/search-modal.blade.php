{{-- Modal Search Component (Inspired by Filllo search UX) --}}
@php
    $searchCategories = \App\Models\Category::active()->sorted()->get(['id', 'name', 'slug']);
@endphp

<div id="search-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-3 sm:p-6 sm:py-10 transition-all duration-200" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-search-title">
    {{-- Backdrop dark overlay --}}
    <div id="search-modal-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>

    {{-- Modal Content Window --}}
    <div id="search-modal-content" class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] z-10 transform transition-all duration-200 scale-95 opacity-0 text-neutral-900 border border-neutral-100">
        
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-3">
            <h2 id="modal-search-title" class="font-bold text-lg sm:text-xl text-neutral-900 tracking-tight flex items-center gap-2">
                Search at Upsilon
            </h2>
            <button type="button" id="close-search-modal" class="w-8 h-8 rounded-full border border-neutral-200 hover:bg-neutral-100 text-neutral-500 hover:text-neutral-900 flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-black" aria-label="Close search">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Search Input Form --}}
        <div class="px-6 py-2">
            <form action="{{ route('shop') }}" method="GET" id="search-modal-form">
                <div class="relative flex items-center w-full rounded-2xl border-2 border-blue-500/80 focus-within:border-blue-600 bg-white px-4 py-3 shadow-xs transition">
                    <svg class="w-5 h-5 text-neutral-400 shrink-0 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" id="modal-search-input" 
                           placeholder="Search item, sneakers, apparel..." 
                           class="w-full bg-transparent border-0 outline-none p-0 text-sm sm:text-base font-medium text-neutral-900 placeholder-neutral-400 focus:ring-0"
                           autocomplete="off">
                    <button type="button" id="clear-modal-search" class="hidden text-neutral-400 hover:text-neutral-700 p-1 transition" aria-label="Clear search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Scrollable Modal Body --}}
        <div class="flex-1 overflow-y-auto px-6 py-3 space-y-5 custom-scrollbar">
            
            {{-- "I'm looking for..." Filter Chips --}}
            <div>
                <p class="text-[11px] font-semibold text-neutral-400 uppercase tracking-wider mb-2.5">I'm looking for...</p>
                <div class="flex flex-wrap gap-2" id="search-category-chips">
                    <button type="button" data-chip-category="" class="chip-btn active inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-blue-600 text-white shadow-xs transition hover:bg-blue-700">
                        <span class="w-4 h-4 rounded-full bg-white/20 text-white flex items-center justify-center text-[10px] font-bold">A</span>
                        All Items
                    </button>
                    @foreach($searchCategories as $cat)
                        <button type="button" data-chip-category="{{ $cat->id }}" class="chip-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-medium bg-neutral-100 text-neutral-700 hover:bg-neutral-200 transition">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- "Recent" Searches Section --}}
            <div id="modal-recent-section" class="hidden">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[11px] font-semibold text-neutral-400 uppercase tracking-wider">Recent</p>
                    <button type="button" id="clear-recent-searches" class="text-[11px] font-medium text-neutral-400 hover:text-neutral-700 transition">Clear all</button>
                </div>
                <div id="recent-search-list" class="space-y-1">
                    {{-- Dynamic list populated via JS --}}
                </div>
            </div>

            {{-- "Trending Products / Results" Section --}}
            <div>
                <div class="flex items-center justify-between mb-2.5">
                    <p id="results-heading" class="text-[11px] font-semibold text-neutral-400 uppercase tracking-wider">Trending Products</p>
                    <span id="results-count" class="text-[11px] text-neutral-400 font-medium"></span>
                </div>
                
                {{-- Grid of products / suggestions --}}
                <div id="modal-search-results" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    {{-- Rendered dynamically --}}
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 py-3 bg-neutral-50 border-t border-neutral-100 flex items-center justify-between text-xs text-neutral-500">
            <div class="hidden sm:flex items-center gap-4 text-[11px]">
                <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-neutral-600 bg-white border border-neutral-200 rounded shadow-xs">↑</kbd><kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-neutral-600 bg-white border border-neutral-200 rounded shadow-xs">↓</kbd> Select</span>
                <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-neutral-600 bg-white border border-neutral-200 rounded shadow-xs">↵</kbd> Open</span>
                <span class="inline-flex items-center gap-1"><kbd class="px-1.5 py-0.5 text-[10px] font-semibold text-neutral-600 bg-white border border-neutral-200 rounded shadow-xs">ESC</kbd> Close</span>
            </div>
            <div class="w-full sm:w-auto flex items-center justify-between sm:justify-end gap-2">
                <a href="{{ route('shop') }}" id="view-all-results-link" class="inline-flex items-center gap-1 font-semibold text-xs text-neutral-900 hover:text-blue-600 transition">
                    View All Products
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #e5e5e5;
        border-radius: 9999px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background-color: #d4d4d4;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('search-modal');
    const backdrop = document.getElementById('search-modal-backdrop');
    const content = document.getElementById('search-modal-content');
    const closeBtn = document.getElementById('close-search-modal');
    const input = document.getElementById('modal-search-input');
    const clearBtn = document.getElementById('clear-modal-search');
    const resultsContainer = document.getElementById('modal-search-results');
    const resultsHeading = document.getElementById('results-heading');
    const resultsCount = document.getElementById('results-count');
    const recentSection = document.getElementById('modal-recent-section');
    const recentList = document.getElementById('recent-search-list');
    const clearRecentBtn = document.getElementById('clear-recent-searches');
    const chipBtns = document.querySelectorAll('#search-category-chips .chip-btn');
    const viewAllLink = document.getElementById('view-all-results-link');

    let debounceTimer = null;
    let selectedCategoryId = '';
    let recentSearches = JSON.parse(localStorage.getItem('upsilon_recent_searches') || '[]');

    // Open Modal Function
    function openModal(initialQuery = '') {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        // Trigger animations
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        if (initialQuery) {
            input.value = initialQuery;
            clearBtn.classList.remove('hidden');
        }
        
        renderRecentSearches();
        fetchSuggestions(input.value.trim());

        setTimeout(() => input.focus(), 150);
    }

    // Close Modal Function
    function closeModal() {
        backdrop.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 200);
    }

    // Recent Searches Handling
    function renderRecentSearches() {
        if (!recentSearches.length) {
            recentSection.classList.add('hidden');
            return;
        }

        recentSection.classList.remove('hidden');
        recentList.innerHTML = recentSearches.slice(0, 4).map(term => `
            <div class="group flex items-center justify-between px-3 py-2 rounded-xl hover:bg-neutral-100 text-xs font-medium text-neutral-700 cursor-pointer transition" data-recent-term="${term}">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>${escapeHtml(term)}</span>
                </div>
                <button type="button" class="remove-recent text-neutral-400 hover:text-neutral-700 opacity-0 group-hover:opacity-100 transition p-1" data-term="${term}" title="Remove">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        `).join('');
    }

    function saveRecentSearch(term) {
        if (!term || term.length < 2) return;
        recentSearches = [term, ...recentSearches.filter(t => t.toLowerCase() !== term.toLowerCase())].slice(0, 6);
        localStorage.setItem('upsilon_recent_searches', JSON.stringify(recentSearches));
        renderRecentSearches();
    }

    if (clearRecentBtn) {
        clearRecentBtn.addEventListener('click', function() {
            recentSearches = [];
            localStorage.removeItem('upsilon_recent_searches');
            renderRecentSearches();
        });
    }

    recentList.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-recent');
        if (removeBtn) {
            e.stopPropagation();
            const term = removeBtn.getAttribute('data-term');
            recentSearches = recentSearches.filter(t => t !== term);
            localStorage.setItem('upsilon_recent_searches', JSON.stringify(recentSearches));
            renderRecentSearches();
            return;
        }

        const item = e.target.closest('[data-recent-term]');
        if (item) {
            const term = item.getAttribute('data-recent-term');
            input.value = term;
            clearBtn.classList.remove('hidden');
            fetchSuggestions(term);
        }
    });

    // Helper HTML sanitizer
    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, function(m) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
        });
    }

    // Fetch Suggestions AJAX
    function fetchSuggestions(query) {
        resultsContainer.innerHTML = `
            <div class="col-span-full py-8 text-center text-neutral-400">
                <svg class="animate-spin h-6 w-6 mx-auto mb-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-xs font-medium">Searching catalog...</span>
            </div>
        `;

        if (query) {
            resultsHeading.textContent = `Results for "${query}"`;
            viewAllLink.href = `{{ route('shop') }}?search=${encodeURIComponent(query)}` + (selectedCategoryId ? `&category=${selectedCategoryId}` : '');
        } else {
            resultsHeading.textContent = selectedCategoryId ? 'Category Products' : 'Trending Products';
            viewAllLink.href = `{{ route('shop') }}` + (selectedCategoryId ? `?category=${selectedCategoryId}` : '');
        }

        const params = new URLSearchParams();
        if (query) params.append('q', query);
        if (selectedCategoryId) params.append('category_id', selectedCategoryId);

        fetch(`{{ route('api.search.suggestions', [], false) }}?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
                if (!data.products || !data.products.length) {
                    resultsCount.textContent = '0 items';
                    resultsContainer.innerHTML = `
                        <div class="col-span-full py-10 text-center text-neutral-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <p class="text-sm font-semibold text-neutral-700 mb-1">No products found</p>
                            <p class="text-xs text-neutral-400">Try searching for keywords like "Hoodie", "Air", "Jacket" or clear filter chips.</p>
                        </div>
                    `;
                    return;
                }

                resultsCount.textContent = `${data.products.length} items`;
                resultsContainer.innerHTML = data.products.map(p => `
                    <a href="${p.url}" data-product-name="${escapeHtml(p.name)}" class="search-result-card group flex items-center gap-3 p-2.5 rounded-2xl border border-neutral-100 hover:border-blue-500/40 hover:bg-blue-50/40 transition">
                        <div class="w-14 h-14 rounded-xl bg-neutral-100 overflow-hidden shrink-0 border border-neutral-200/50">
                            <img src="${p.image}" alt="${escapeHtml(p.name)}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider truncate mb-0.5">${escapeHtml(p.category_name)}</p>
                            <h4 class="text-xs font-bold text-neutral-900 group-hover:text-blue-600 transition truncate leading-tight">${escapeHtml(p.name)}</h4>
                            <div class="mt-1 flex items-center gap-2 text-xs font-bold text-neutral-900">
                                <span>${p.price}</span>
                                ${p.original_price ? `<span class="text-[11px] text-neutral-400 line-through font-normal">${p.original_price}</span>` : ''}
                            </div>
                        </div>
                    </a>
                `).join('');
            })
            .catch(() => {
                resultsContainer.innerHTML = `
                    <div class="col-span-full py-6 text-center text-xs text-red-500">
                        Unable to load search suggestions.
                    </div>
                `;
            });
    }

    // Save recent search on product click
    resultsContainer.addEventListener('click', function(e) {
        const card = e.target.closest('.search-result-card');
        if (card) {
            const productName = card.getAttribute('data-product-name');
            if (productName) saveRecentSearch(productName);
        }
    });

    // Category Chip Filters
    chipBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            chipBtns.forEach(b => {
                b.classList.remove('active', 'bg-blue-600', 'text-white', 'hover:bg-blue-700');
                b.classList.add('bg-neutral-100', 'text-neutral-700', 'hover:bg-neutral-200');
                const badge = b.querySelector('span');
                if (badge) badge.className = 'w-4 h-4 rounded-full bg-neutral-300 text-neutral-700 flex items-center justify-center text-[10px] font-bold';
            });

            this.classList.remove('bg-neutral-100', 'text-neutral-700', 'hover:bg-neutral-200');
            this.classList.add('active', 'bg-blue-600', 'text-white', 'hover:bg-blue-700');
            const badge = this.querySelector('span');
            if (badge) badge.className = 'w-4 h-4 rounded-full bg-white/20 text-white flex items-center justify-center text-[10px] font-bold';

            selectedCategoryId = this.getAttribute('data-chip-category');
            fetchSuggestions(input.value.trim());
        });
    });

    // Input Typing Handler
    input.addEventListener('input', function() {
        const val = this.value.trim();
        if (val) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchSuggestions(val);
        }, 250);
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        clearBtn.classList.add('hidden');
        input.focus();
        fetchSuggestions('');
    });

    // Submit Form
    document.getElementById('search-modal-form').addEventListener('submit', function(e) {
        const val = input.value.trim();
        if (val) saveRecentSearch(val);
    });

    // Close actions
    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
        
        // Ctrl+K or Cmd+K or "/" to open search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (modal.classList.contains('hidden')) {
                openModal();
            } else {
                closeModal();
            }
        }
    });

    // Global trigger event attachment for any search bar/button
    document.addEventListener('click', function(e) {
        // Desktop search bar trigger
        const desktopSearchInput = e.target.closest('#desktop-search');
        if (desktopSearchInput) {
            e.preventDefault();
            openModal(desktopSearchInput.value);
            return;
        }

        // Mobile search input trigger
        const mobileSearchInput = e.target.closest('#mobile-search-input');
        if (mobileSearchInput) {
            e.preventDefault();
            openModal(mobileSearchInput.value);
            return;
        }

        // Search trigger buttons
        const trigger = e.target.closest('[data-open-search-modal], #mobile-search-btn');
        if (trigger) {
            e.preventDefault();
            openModal();
            return;
        }
    });
});
</script>
