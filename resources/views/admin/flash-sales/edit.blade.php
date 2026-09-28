@extends('admin.layouts.admin')

@section('title', 'Edit Flash Sale | Upsilon')

@section('page-title', 'Edit Flash Sale')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.flash-sales.index') }}">Flash Sales</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Edit</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Flash Sale</h3>
            <p class="admin-card-description">Update flash sale countdown details</p>
        </div>
    </div>
    <div class="admin-card-footer">
        <form method="POST" action="{{ route('admin.flash-sales.update', $flashSale) }}">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="rounded-lg bg-destructive/10 border border-destructive/20 p-4 text-sm text-destructive mb-6">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Left: Form Fields --}}
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="admin-form-label">Title <span class="text-destructive">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title', $flashSale->title) }}" required class="admin-form-input" placeholder="e.g., Limited Pairs Only">
                    </div>

                    <div>
                        <label for="subtitle" class="admin-form-label">Subtitle</label>
                        <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $flashSale->subtitle) }}" class="admin-form-input" placeholder="e.g., Ends in">
                    </div>

                    <div>
                        <label for="description" class="admin-form-label">Description</label>
                        <textarea id="description" name="description" rows="3" class="admin-form-input resize-none" placeholder="Optional description">{{ old('description', $flashSale->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ends_at" class="admin-form-label">Ends At <span class="text-destructive">*</span></label>
                            <input id="ends_at" name="ends_at" type="datetime-local" required
                                value="{{ old('ends_at', $flashSale->ends_at?->format('Y-m-d\TH:i')) }}"
                                class="admin-form-input">
                        </div>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $flashSale->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="admin-form-label mb-0">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Right: Product Selection --}}
                <div class="lg:col-span-1">
                    <label class="admin-form-label">Products</label>
                    <p class="text-xs text-muted mb-3">Select products to include in this flash sale. Leave empty to show featured products.</p>
                    <p class="text-xs text-amber-600 mb-3">Only 1 active flash sale is allowed. Activating this one will deactivate the previous active flash sale.</p>
                    <input type="text" id="flash-sale-product-search" placeholder="Search products..." class="admin-form-input mb-3">
                    <div class="space-y-2 max-h-[500px] overflow-y-auto border border-gray-200 rounded-lg p-3 bg-white">
                        @forelse($products as $product)
                            <label class="flash-sale-product-item flex items-center gap-3 p-2 rounded hover:bg-gray-200 cursor-pointer border border-transparent hover:border-gray-300 transition">
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary" @checked($flashSale->products->contains($product->id))>
                                <div class="h-10 w-10 flex-shrink-0 overflow-hidden rounded border border-outline bg-gray-50">
                                    <img src="{{ $product->image_url ?? asset('storage/images/sample/no-image.png') }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="truncate text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-muted">{{ $product->formatted_price ?? '$' . number_format($product->base_price, 2) }}</div>
                                </div>
                            </label>
                        @empty
                            <p class="text-sm text-muted py-4 text-center">No products available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
                <a href="{{ route('admin.flash-sales.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                <button type="submit" class="admin-btn admin-btn-primary">Update Flash Sale</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('flash-sale-product-search');
        const items = document.querySelectorAll('.flash-sale-product-item');

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();

            items.forEach(function (item) {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
</script>
@endsection
