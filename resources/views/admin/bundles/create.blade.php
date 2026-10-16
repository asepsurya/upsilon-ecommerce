@extends('admin.layouts.admin')

@section('title', 'Create Bundle | Upsilon')

@section('page-title', 'Create Bundle')

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">Create Bundle</h3>
                <p class="admin-card-description">Add a new product bundle with sub-bundles and items</p>
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

            <form method="POST" action="{{ route('admin.bundles.store') }}" enctype="multipart/form-data" id="bundle-form">
                @csrf

                {{-- ── Bundle Info ── --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Bundle Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="admin-form-input" id="bundle-name">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" class="admin-form-input"
                                placeholder="Auto-generated from name" id="bundle-slug">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Bundle Price</label>
                            <input type="number" name="bundle_price" value="{{ old('bundle_price') }}" step="0.01"
                                class="admin-form-input" placeholder="Leave empty for auto-calc">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Original Price (harga asli untuk diskon)</label>
                            <input type="number" name="bundle_original_price" value="{{ old('bundle_original_price') }}" step="0.01"
                                class="admin-form-input" placeholder="Leave empty to auto-calculate from items">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="admin-form-input">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Thumbnail</label>
                            <input type="file" name="thumbnail" accept="image/*" class="admin-form-input">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                Active
                            </label>
                        </div>
                    </div>
                    <div>
                        <div class="admin-form-group">
                            <label class="admin-form-label">Description</label>
                            <textarea name="description" rows="4" class="admin-form-input">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr style="margin: 28px 0; border-color: hsl(var(--border));">

                {{-- ── Sub-Bundles ── --}}
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="admin-card-title" style="margin-bottom: 4px;">Sub-Bundles</h4>
                        <p class="admin-card-description">Tambah sub-bundle, lalu pilih produk di tiap sub-bundle.</p>
                    </div>
                    <button type="button" id="add-sub-bundle" class="admin-btn admin-btn-primary admin-btn-sm">
                        + Add Sub-Bundle
                    </button>
                </div>

                <div id="sub-bundles-container">
                    {{-- JS will render sub-bundle cards here --}}
                </div>

                <div id="empty-sub-bundle-notice" class="text-center py-10" style="border: 2px dashed hsl(var(--border)); border-radius: var(--radius);">
                    <p class="text-muted text-sm">Belum ada sub-bundle. Klik <strong>Add Sub-Bundle</strong> untuk mulai.</p>
                </div>

                <div class="mt-6">
                    <button type="submit" class="admin-btn admin-btn-primary">Create Bundle</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── Product Data for JS ── --}}
    @php
        $productsJson = $products->map(fn($p) => [
            'id'         => $p->id,
            'name'       => $p->name,
            'slug'       => $p->slug,
            'base_price' => $p->base_price,
            'sku'        => $p->variants->first()?->sku ?? '',
        ])->values()->all();
    @endphp
    <script id="products-data" type="application/json">{!! json_encode($productsJson) !!}</script>

    @push('scripts')
    <script>
    (function () {
        'use strict';

        const ALL_PRODUCTS = JSON.parse(document.getElementById('products-data').textContent);
        const currency = (n) => 'Rp ' + Number(n).toLocaleString('id-ID');
        const CHEVRON = '<svg class="sb-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';

        /* ── slug auto-gen ── */
        const nameInput = document.getElementById('bundle-name');
        const slugInput = document.getElementById('bundle-slug');
        nameInput?.addEventListener('input', () => {
            if (!slugInput.dataset.manual) {
                slugInput.value = nameInput.value
                    .toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-');
            }
        });
        slugInput?.addEventListener('input', () => slugInput.dataset.manual = '1');

        /* ── sub-bundle counter ── */
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

        /* ── render one sub-bundle card ── */
        function createSubBundleCard(index) {
            const card = document.createElement('div');
            card.className = 'sub-bundle-card';
            card.dataset.index = index;

            card.innerHTML = `
                <div class="sub-bundle-card-header">
                    <button type="button" class="sb-accordion-toggle" aria-expanded="true">
                        <span class="sub-bundle-label sub-bundle-title" data-index="${index}">Sub-Bundle</span>
                        ${CHEVRON}
                    </button>
                    <button type="button" class="admin-btn admin-btn-danger admin-btn-sm remove-sb-btn">Remove</button>
                </div>
                <div class="sb-accordion-body" aria-hidden="false">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Sub-Bundle Name <span style="color:red">*</span></label>
                        <input type="text" name="sub_bundles[${index}][name]"
                               class="admin-form-input" required placeholder="e.g. Outfit Pria">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <input type="text" name="sub_bundles[${index}][description]"
                               class="admin-form-input" placeholder="Optional description">
                    </div>
                </div>
                <input type="hidden" name="sub_bundles[${index}][sort_order]" value="${index}">

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
                                placeholder="Masukkan item manual, satu per baris.&#10;Format: Nama Produk: Jumlah&#10;Contoh:&#10;T-Shirt: 2&#10;Jeans: 1&#10;Sneakers"></textarea>
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
                                                   class="sb-product-checkbox">
                                        </td>
                                        <td>${p.name}</td>
                                        <td>${currency(p.base_price)}</td>
                                        <td>
                                            <input type="number"
                                                   name="sub_bundles[${index}][quantities][${p.id}]"
                                                   value="1" min="1"
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
            `;

            /* update accordion title when name changes */
            const nameInput = card.querySelector('input[name="sub_bundles[' + index + '][name]"]');
            const titleEl = card.querySelector('.sub-bundle-title');
            nameInput.addEventListener('input', () => {
                titleEl.textContent = nameInput.value.trim() || 'Sub-Bundle';
            });

/* remove btn */
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
            return String(str ?? '').replace(/&/g,'&').replace(/"/g,'"').replace(/</g,'<').replace(/>/g,'>');
        }

        document.getElementById('add-sub-bundle').addEventListener('click', () => {
            const card = createSubBundleCard(sbIndex++);
            container.appendChild(card);
            openAccordion(card);
            updateEmptyNotice();
        });

        normalizeAccordion();
        updateEmptyNotice();
    })();
    </script>

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
    @endpush
@endsection