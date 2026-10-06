@extends('admin.layouts.admin')

@section('title', 'Products | Upsilon')

@section('page-title', 'Products')



@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Products</h3>
            <p class="admin-card-description">Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Product</a>
    </div>

    <div class="px-6 pb-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="admin-form-input" style="flex: 1; max-width: 320px;">
            <button type="submit" class="admin-btn admin-btn-primary">Search</button>
        </form>
    </div>

    <form id="products-form" method="POST" action="{{ route('admin.products.bulk-action') }}">
        @csrf
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">
                            <input type="checkbox" id="select-all" class="admin-checkbox admin-checkbox-sm" aria-label="Select all products">
                        </th>
                        <th style="width: 300px;">Product</th>
                        <th style="width: 150px;">Category</th>
                        <th style="width: 120px;">Price</th>
                        <th style="width: 100px;">Stock</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 120px;">Date</th>
                        <th style="width: 180px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        @php
                            $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
                            $imageSrc = $primaryImage ? $primaryImage->url : 'https://placehold.co/60x70/stone-200/stone-500?text=No+Image';
                            $totalStock = $product->variants->sum('stock');
                            $firstVariant = $product->variants->first();
                            $isSale = $product->sale_price && $product->sale_price < $product->base_price;
                        @endphp

                        <tr data-product-id="{{ $product->id }}">
                            <td style="text-align: center;">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="admin-checkbox admin-checkbox-sm product-checkbox" aria-label="Select product {{ $product->name }}">
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $imageSrc }}" alt="{{ $product->name }}" class="w-12 h-16 object-cover rounded-md border border-border">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $product->name }}</span>
                                        <span class="text-xs text-muted-foreground">{{ $firstVariant?->sku ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-base text-muted-foreground">sell</span>
                                    <span class="capitalize">{{ $product->category?->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($isSale)
                                    <div class="flex flex-col">
                                        <span class="text-green-600 dark:text-green-400 font-medium">{{ currency_format($product->sale_price) }}</span>
                                        <span class="text-muted-foreground line-through text-xs">{{ currency_format($product->base_price) }}</span>
                                    </div>
                                @else
                                    <span class="font-medium">{{ currency_format($product->base_price) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($totalStock > 0)
                                    <span class="admin-badge admin-badge-success text-xs">Ready Stock</span>
                                @elseif($product->variants->isNotEmpty())
                                    <span class="text-red-600 dark:text-red-400 font-medium">0</span>
                                @else
                                    <span class="text-muted-foreground">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="admin-badge admin-badge-success">Active</span>
                                @else
                                    <span class="admin-badge admin-badge-warning">Inactive</span>
                                @endif
                            </td>
                            <td>
                                {{ $product->created_at->format('M d, Y') }}
                            </td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('product.show', $product) }}" class="admin-btn admin-btn-secondary admin-btn-sm" title="View">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="admin-btn admin-btn-secondary admin-btn-sm" title="Edit">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline-block m-0" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-muted-foreground">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="bulk-actions" class="admin-card-footer hidden flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span id="selected-count" class="text-sm text-muted-foreground">0 items selected</span>
                <div class="admin-dropdown">
                    <button type="button" class="admin-btn admin-btn-secondary admin-btn-sm admin-dropdown-toggle" id="bulk-action-toggle" aria-label="Bulk actions">
                        <span class="material-symbols-outlined">more_vert</span>
                        Bulk Actions
                    </button>
                    <div class="admin-dropdown-menu hidden" id="bulk-action-menu">
                        <button type="button" class="admin-dropdown-item" data-action="activate">Activate Selected</button>
                        <button type="button" class="admin-dropdown-item" data-action="deactivate">Deactivate Selected</button>
                        <div class="admin-dropdown-divider"></div>
                        <button type="button" class="admin-dropdown-item text-red-600 dark:text-red-400" data-action="delete">Delete Selected</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="action" id="bulk-action-input" value="">
    </form>

    @if($products->hasPages())
        <div class="admin-card-footer">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    const bulkActionToggle = document.getElementById('bulk-action-toggle');
    const bulkActionMenu = document.getElementById('bulk-action-menu');
    const bulkActionInput = document.getElementById('bulk-action-input');
    const productsForm = document.getElementById('products-form');

    function updateSelection() {
        const selected = document.querySelectorAll('.product-checkbox:checked');
        const count = selected.length;
        
        selectedCount.textContent = count === 1 ? '1 item selected' : `${count} items selected`;
        
        if (count > 0) {
            bulkActions.classList.remove('hidden');
            bulkActions.classList.add('flex');
        } else {
            bulkActions.classList.add('hidden');
            bulkActions.classList.remove('flex');
        }
        
        selectAll.checked = count === productCheckboxes.length && count > 0;
        selectAll.indeterminate = count > 0 && count < productCheckboxes.length;
    }

    selectAll.addEventListener('change', function() {
        productCheckboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelection();
    });

    productCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelection);
    });

    bulkActionToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        bulkActionMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(e) {
        if (!bulkActionMenu.contains(e.target) && e.target !== bulkActionToggle) {
            bulkActionMenu.classList.add('hidden');
        }
    });

    bulkActionMenu.querySelectorAll('[data-action]').forEach(item => {
        item.addEventListener('click', function() {
            const action = this.dataset.action;
            const selected = document.querySelectorAll('.product-checkbox:checked');
            
            if (selected.length === 0) return;
            
            if (action === 'delete') {
                if (!confirm('Are you sure you want to delete the selected products?')) {
                    return;
                }
            }
            
            bulkActionInput.value = action;
            productsForm.action = "{{ route('admin.products.bulk-action') }}";
            productsForm.submit();
        });
    });

    // Keyboard navigation for checkboxes
    document.querySelectorAll('tr[data-product-id]').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button') && !e.target.closest('form')) {
                const checkbox = this.querySelector('.product-checkbox');
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            }
        });
    });
});
</script>
@endpush
