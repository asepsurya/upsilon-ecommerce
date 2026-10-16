@extends('admin.layouts.admin')

@section('title', 'Edit Bundle | Upsilon')

@section('page-title', 'Edit Bundle')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Bundle</h3>
            <p class="admin-card-description">Update bundle details, sub-bundles, and items</p>
        </div>
        <a href="{{ route('admin.bundles.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Bundles</a>
    </div>
    <div class="admin-card-body">
        @if($errors->any())
            <div class="admin-badge admin-badge-danger mb-4 p-4" style="display: block; border-radius: var(--radius);">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.bundles.update', $bundle) }}" enctype="multipart/form-data" id="bundle-form">
            @csrf
            @method('PATCH')

            {{-- ── Bundle Info ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Bundle Name</label>
                        <input type="text" name="name" value="{{ old('name', $bundle->name) }}" required class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $bundle->slug) }}" required class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Bundle Type</label>
                        @php
                            $typeLabels = [
                                'catalog' => 'Catalog (from product catalog)',
                                'manual' => 'Manual (custom items)',
                                'mixed' => 'Mixed (catalog + manual)',
                            ];
                            $typeColors = [
                                'catalog' => 'admin-badge-info',
                                'manual' => 'admin-badge-warning',
                                'mixed' => 'admin-badge-purple',
                            ];
                            $currentType = $bundle->bundle_type ?? 'catalog';
                        @endphp
                        <div class="admin-badge {{ $typeColors[$currentType] ?? 'admin-badge-secondary' }}" style="font-size: 13px; padding: 8px 12px;">
                            {{ $typeLabels[$currentType] ?? ucfirst($currentType) }}
                        </div>
                        <span class="text-sm text-muted mt-1 block">Automatically determined by input type</span>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Bundle Price</label>
                        <input type="number" name="bundle_price" value="{{ old('bundle_price', $bundle->bundle_price) }}" step="0.01" class="admin-form-input" placeholder="Leave empty for auto-calc">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Original Price (harga asli untuk diskon)</label>
                        <input type="number" name="bundle_original_price" value="{{ old('bundle_original_price', $bundle->bundle_original_price) }}" step="0.01"
                            class="admin-form-input" placeholder="Leave empty to auto-calculate from items">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $bundle->sort_order ?? 0) }}" class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Thumbnail</label>
                        @if($bundle->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $bundle->thumbnail) }}" alt="Current thumbnail" style="max-height: 100px; border-radius: var(--radius);">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="admin-form-input">
                        <span class="text-sm text-muted mt-1 block">Leave empty to keep current image.</span>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $bundle->is_active) ? 'checked' : '' }}>
                            Active
                        </label>
                    </div>
                </div>

                <div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea name="description" rows="4" class="admin-form-input">{{ old('description', $bundle->description) }}</textarea>
                    </div>
                </div>
            </div>

            <hr style="margin: 28px 0; border-color: hsl(var(--border));">

            {{-- ── Sub-Bundles ── --}}
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="admin-card-title" style="margin-bottom: 4px;">Sub-Bundles</h4>
                    <p class="admin-card-description">Kelola sub-bundle dan item produk di dalamnya.</p>
                </div>
                <button type="button" id="add-sub-bundle" class="admin-btn admin-btn-primary admin-btn-sm">
                    + Add Sub-Bundle
                </button>
            </div>

            <div id="sub-bundles-container">
                {{-- pre-populated by JS below --}}
            </div>

            <div id="empty-sub-bundle-notice" class="text-center py-10" style="border: 2px dashed hsl(var(--border)); border-radius: var(--radius);">
                <p class="text-muted text-sm">Belum ada sub-bundle. Klik <strong>Add Sub-Bundle</strong> untuk mulai.</p>
            </div>

            <div class="mt-6">
                <button type="submit" class="admin-btn admin-btn-primary">Update Bundle</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Data for JS ── --}}
@php
    $productsData = $products->map(fn($p) => [
        'id'         => $p->id,
        'name'       => $p->name,
        'slug'       => $p->slug,
        'base_price' => $p->base_price,
        'sku'        => $p->variants->first()?->sku ?? '',
    ])->values()->all();

    $subBundlesData = $bundle->subBundles->map(fn($sb) => [
        'name'        => $sb->name,
        'description' => $sb->description,
        'sort_order'  => $sb->sort_order,
        'items'       => $sb->items->map(fn($item) => [
            'product_id' => $item->product_id,
            'quantity'   => $item->quantity,
        ])->values()->all(),
        'manual_items' => $sb->manualItems->map(fn($item) => 
            $item->product_name . ': ' . $item->quantity
        )->implode("\n"),
    ])->values()->all();
@endphp

<script id="products-data" type="application/json">
    @json($productsData)
</script>

<script id="existing-sub-bundles" type="application/json">
    @json($subBundlesData)
</script>

@push('scripts')
<style>
    .sub-bundle-card {
        border: 1px solid hsl(var(--border));
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 16px;
        background: hsl(var(--card));
    }
    .sub-bundle-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sb-accordion-toggle {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        text-align: left;
        background: none;
        border: 0;
        padding: 0;
        cursor: pointer;
        color: hsl(var(--foreground));
    }
    .sb-accordion-toggle:focus-visible {
        outline: 2px solid hsl(var(--ring));
        outline-offset: 1px;
    }
    .sb-chevron {
        margin-left: auto;
        transition: transform 0.2s ease;
        color: hsl(var(--muted-foreground));
    }
    .sub-bundle-card.is-collapsed .sb-chevron {
        transform: rotate(90deg);
    }
    .sb-accordion-body {
        margin-top: 16px;
    }
    .sub-bundle-card.is-collapsed .sb-accordion-body {
        display: none;
    }
    .sub-bundle-label {
        font-weight: 600;
        font-size: 14px;
        color: hsl(var(--foreground));
    }
    .sb-items-tab-bar {
        display: flex;
        gap: 4px;
        margin-bottom: 12px;
    }
    .sb-items-tab {
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid hsl(var(--border));
        background: transparent;
        border-radius: var(--radius) var(--radius) 0 0;
        cursor: pointer;
        color: hsl(var(--muted-foreground));
    }
    .sb-items-tab-active {
        background: hsl(var(--card));
        color: hsl(var(--foreground));
        border-bottom-color: hsl(var(--card));
    }
    .sb-items-tab-content {
        display: none;
    }
    .sb-items-tab-content.sb-items-tab-active {
        display: block;
    }
    .sb-products-table-wrap {
        max-height: 280px;
        overflow-y: auto;
        border: 1px solid hsl(var(--border));
        border-radius: var(--radius);
    }
    .sb-qty-input {
        width: 80px !important;
        padding: 4px 8px !important;
    }
    </style>
<script>
(function () {
    'use strict';

    const EXISTING_SB      = JSON.parse(document.getElementById('existing-sub-bundles').textContent);
    const ALL_PRODUCTS     = JSON.parse(document.getElementById('products-data').textContent);
    const currency         = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
    const CHEVRON          = '<svg class="sb-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';

    let sbIndex = 0;
    const container   = document.getElementById('sub-bundles-container');
    const emptyNotice = document.getElementById('empty-sub-bundle-notice');

    function updateEmptyNotice() {
        emptyNotice.style.display = container.children.length === 0 ? '' : 'none';
    }

    function setAccordionState(card, expanded) {
        card.classList.toggle('is-collapsed', !expanded);
        const toggle = card.querySelector('.sb-accordion-toggle');
        const body = card.querySelector('.sb-accordion-body');
        if (toggle) toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        if (body) body.setAttribute('aria-hidden', expanded ? 'false' : 'true');
    }

    function openAccordion(card) {
        container.querySelectorAll('.sub-bundle-card').forEach(c => {
            setAccordionState(c, c === card);
        });
    }

    function normalizeAccordion() {
        const first = container.querySelector('.sub-bundle-card');
        if (first) openAccordion(first);
    }

    function initCardAccordion(card) {
        const toggle = card.querySelector('.sb-accordion-toggle');
        if (!toggle) return;
        toggle.addEventListener('click', () => {
            if (card.classList.contains('is-collapsed')) {
                openAccordion(card);
            } else {
                setAccordionState(card, false);
            }
        });
    }


    function createSubBundleCard(index, prefill) {
        prefill = prefill || {};
        const selectedSet  = new Set((prefill.items || []).map(i => i.product_id));
        const quantityMap  = {};
        (prefill.items || []).forEach(i => { quantityMap[i.product_id] = i.quantity; });

        const card = document.createElement('div');
        card.className = 'sub-bundle-card';
        card.dataset.index = index;

        card.innerHTML = `
            <div class="sub-bundle-card-header">
                <button type="button" class="sb-accordion-toggle" aria-expanded="true">
                    <span class="sub-bundle-label sub-bundle-title">${escHtml(prefill.name || 'Sub-Bundle')}</span>
                    ${CHEVRON}
                </button>
                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-sb-btn">Remove</button>
            </div>
            <div class="sb-accordion-body" aria-hidden="false">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="admin-form-group">
                    <label class="admin-form-label">Sub-Bundle Name <span style="color:red">*</span></label>
                    <input type="text" name="sub_bundles[${index}][name]"
                           class="admin-form-input" required
                           placeholder="e.g. Outfit Pria"
                           value="${escHtml(prefill.name || '')}">
                </div>
                <div class="admin-form-group">
                    <label class="admin-form-label">Description</label>
                    <input type="text" name="sub_bundles[${index}][description]"
                           class="admin-form-input" placeholder="Optional description"
                           value="${escHtml(prefill.description || '')}">
                </div>
            </div>
            <input type="hidden" name="sub_bundles[${index}][sort_order]" value="${prefill.sort_order ?? index}">

            <div class="sb-items-section">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-medium" style="color: hsl(var(--foreground));">Bundle Items</p>
                </div>

                <div class="sb-items-tab-bar">
                    <button type="button" class="sb-items-tab sb-items-tab-active" data-tab="manual">Manual Input</button>
                    <button type="button" class="sb-items-tab" data-tab="products">Products Table</button>
                </div>

                <div class="sb-items-tab-content sb-items-tab-active" data-tab="manual">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Manual Items</label>
                        <textarea name="sub_bundles[${index}][manual_items]" rows="8" class="admin-form-input"
                            placeholder="Masukkan item manual, satu per baris.&#10;Format: Nama Produk: Jumlah&#10;Contoh:&#10;T-Shirt: 2&#10;Jeans: 1&#10;Sneakers">${escHtml(prefill.manual_items || '')}</textarea>
                        <p class="text-muted text-xs mt-2">Ketik satu item per baris. Jumlah bersifat opsional (default 1). Contoh: <code>T-Shirt: 2</code>. Item yang tidak ditemukan di katalog akan diabaikan.</p>
                    </div>
                </div>

                <div class="sb-items-tab-content" data-tab="products">
                    <div class="admin-form-group mb-3">
                        <input type="text" class="admin-form-input sb-product-search"
                               placeholder="Search products by name or SKU…">
                    </div>

                    <div class="sb-products-table-wrap">
                        <table class="admin-table" style="margin-bottom:0;">
                            <thead>
                                <tr>
                                    <th style="width:40px;"></th>
                                    <th>Product</th>
                                    <th style="width:140px;">Base Price</th>
                                    <th style="width:110px;">Qty</th>
                                </tr>
                            </thead>
                            <tbody class="sb-products-tbody">
                                ${ALL_PRODUCTS.map(p => `
                                <tr class="sb-product-row"
                                    data-name="${p.name.toLowerCase()}"
                                    data-sku="${(p.sku||'').toLowerCase()}">
                                    <td class="text-center">
                                        <input type="checkbox"
                                               name="sub_bundles[${index}][selected_products][]"
                                               value="${p.id}"
                                               class="sb-product-checkbox"
                                               ${selectedSet.has(p.id) ? 'checked' : ''}>
                                    </td>
                                    <td>${p.name}</td>
                                    <td>${currency(p.base_price)}</td>
                                    <td>
                                        <input type="number"
                                               name="sub_bundles[${index}][quantities][${p.id}]"
                                               value="${quantityMap[p.id] ?? 1}" min="1"
                                               class="admin-form-input sb-qty-input">
                                    </td>
                                </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>

                    <label class="admin-form-label mt-3 flex items-center gap-2">
                        <input type="checkbox" class="sb-select-all" style="width:auto;"> Select All
                    </label>
                </div>
            </div>
            </div>
        `;

            /* update accordion title when name changes */
            const nameInput = card.querySelector('input[name="sub_bundles[' + index + '][name]"]');
            const titleEl = card.querySelector('.sub-bundle-title');
            nameInput.addEventListener('input', () => {
                titleEl.textContent = nameInput.value.trim() || 'Sub-Bundle';
            });

/* remove */
        card.querySelector('.remove-sb-btn').addEventListener('click', () => {
            card.remove();
            renumberCards();
            normalizeAccordion();
            updateEmptyNotice();
        });

        initCardAccordion(card);

        /* ── items tabs: Manual Input ↔ Products Table ── */
        const tabBar = card.querySelector('.sb-items-tab-bar');
        const tabContents = card.querySelectorAll('.sb-items-tab-content');
        const productSearch = card.querySelector('.sb-product-search');
        const productRows = card.querySelectorAll('.sb-product-row');

        function switchTab(tab) {
            tabContents.forEach(c => c.classList.toggle('sb-items-tab-active', c.dataset.tab === tab));
            card.querySelectorAll('.sb-items-tab').forEach(t => {
                t.classList.toggle('sb-items-tab-active', t.dataset.tab === tab);
            });
        }

        tabBar.addEventListener('click', (e) => {
            const btn = e.target.closest('.sb-items-tab');
            if (!btn) return;
            switchTab(btn.dataset.tab);
        });

        productSearch.addEventListener('input', () => {
            const q = productSearch.value.toLowerCase().trim();
            productRows.forEach(row => {
                const match = !q || row.dataset.name.includes(q) || row.dataset.sku.includes(q);
                row.style.display = match ? '' : 'none';
            });
            syncSelectAll(card);
        });

        /* ── Products Table: search & select all ── */
        const searchInput = card.querySelector('.sb-product-search');
        const rows = card.querySelectorAll('.sb-product-row');
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase().trim();
            rows.forEach(row => {
                const match = !q || row.dataset.name.includes(q) || row.dataset.sku.includes(q);
                row.style.display = match ? '' : 'none';
            });
            syncSelectAll(card);
        });

        const selectAllCb = card.querySelector('.sb-select-all');
        const checkboxes  = card.querySelectorAll('.sb-product-checkbox');
        selectAllCb.addEventListener('change', () => {
            checkboxes.forEach(cb => {
                if (cb.closest('.sb-product-row').style.display !== 'none') {
                    cb.checked = selectAllCb.checked;
                }
            });
        });
        checkboxes.forEach(cb => cb.addEventListener('change', () => syncSelectAll(card)));

        return card;
    }

    function syncSelectAll(card) {
        const all = [...card.querySelectorAll('.sb-product-checkbox')].filter(
            cb => cb.closest('.sb-product-row').style.display !== 'none'
        );
        const checked = all.filter(cb => cb.checked);
        const sa = card.querySelector('.sb-select-all');
        sa.checked = all.length > 0 && checked.length === all.length;
        sa.indeterminate = checked.length > 0 && checked.length < all.length;
    }

    function renumberCards() {
        [...container.children].forEach((card, i) => {
            card.querySelector('.sb-num').textContent = i + 1;
        });
    }

function escHtml(str) {
        return str.replace(/&/g,'&').replace(/"/g,'"').replace(/</g,'<').replace(/>/g,'>');
    }

    document.getElementById('add-sub-bundle').addEventListener('click', () => {
        const card = createSubBundleCard(sbIndex++);
        container.appendChild(card);
        openAccordion(card);
        updateEmptyNotice();
    });

    /* pre-populate existing sub-bundles */
    EXISTING_SB.forEach(sb => {
        container.appendChild(createSubBundleCard(sbIndex++, sb));
    });

    normalizeAccordion();
    updateEmptyNotice();
})();
</script>
@endpush
@endsection
