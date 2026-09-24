@extends('admin.layouts.admin')

@section('title', 'Edit Bundle - Admin')

@section('page-title', 'Edit Bundle')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Bundle</h3>
            <p class="admin-card-description">Update bundle details</p>
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
                        <label class="admin-form-label">Bundle Price</label>
                        <input type="number" name="bundle_price" value="{{ old('bundle_price', $bundle->bundle_price) }}" step="0.01" class="admin-form-input" placeholder="Leave empty for auto-calc">
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

            <hr style="margin: 24px 0; border-color: hsl(var(--border));">

            <h4 class="admin-card-title" style="margin-bottom: 8px;">Bundle Items</h4>
            <p class="admin-card-description" style="margin-bottom: 16px;">Select products to include in this bundle and set quantities.</p>

            <div class="admin-form-group" style="margin-bottom: 16px;">
                <label class="admin-form-label">Search Products</label>
                <input type="text" id="product-search" class="admin-form-input" placeholder="Search by name, slug, or SKU...">
            </div>

            <div style="max-height: 400px; overflow-y: auto; border: 1px solid hsl(var(--border)); border-radius: var(--radius);" id="products-container">
                <table class="admin-table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Product</th>
                            <th style="width: 120px;">Base Price</th>
                            <th style="width: 120px;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="products-tbody">
                        @php
                            $selectedItems = $bundle->items->keyBy('product_id');
                        @endphp
                        @forelse($products as $product)
                            @php
                                $isSelected = $selectedItems->has($product->id);
                                $quantity = $isSelected ? $selectedItems[$product->id]->quantity : 1;
                            @endphp
                            <tr class="product-row" data-name="{{ strtolower($product->name) }}" data-slug="{{ strtolower($product->slug) }}" data-sku="{{ strtolower($product->variants->first()?->sku ?? '') }}">
                                <td class="text-center">
                                    <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" class="product-checkbox" {{ $isSelected ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $product->name }}
                                    @if($product->variants->count())
                                        <div class="text-xs text-muted mt-1">
                                            @foreach($product->variants->take(3) as $variant)
                                                <span class="inline-block bg-surface-container-high px-1.5 py-0.5 rounded text-[10px] mr-1 mb-1">{{ $variant->size?->name ?? '' }} / {{ $variant->color?->name ?? '' }}</span>
                                            @endforeach
                                            @if($product->variants->count() > 3)
                                                <span class="text-muted">+{{ $product->variants->count() - 3 }} more</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td>${{ number_format($product->base_price, 2) }}</td>
                                <td>
                                    <input type="number" name="quantities[{{ $product->id }}]" value="{{ $quantity }}" min="1" class="admin-form-input product-quantity">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No products available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="admin-form-group" style="margin-top: 16px;">
                <label class="admin-form-label">
                    <input type="checkbox" id="select-all-products" class="admin-form-input" style="width: auto; display: inline-block;">
                    Select All Products
                </label>
            </div>

            <button type="submit" class="admin-btn admin-btn-primary">Update Bundle</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all-products');
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const searchInput = document.getElementById('product-search');
    const productRows = document.querySelectorAll('.product-row');

    // Select All
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => {
            if (!cb.closest('.product-row').classList.contains('hidden')) {
                cb.checked = this.checked;
            }
        });
        updateSelectAllState();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectAllState);
    });

    function updateSelectAllState() {
        const visibleCheckboxes = Array.from(checkboxes).filter(cb => !cb.closest('.product-row').classList.contains('hidden'));
        const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
        const anyChecked = visibleCheckboxes.some(cb => cb.checked);
        selectAll.checked = allChecked;
        selectAll.indeterminate = !allChecked && anyChecked;
    }

    // Product Search
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        productRows.forEach(row => {
            const name = row.dataset.name || '';
            const slug = row.dataset.slug || '';
            const sku = row.dataset.sku || '';
            
            if (query === '' || name.includes(query) || slug.includes(query) || sku.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
        
        updateSelectAllState();
    });

    });
});
</script>
@endpush
@endsection