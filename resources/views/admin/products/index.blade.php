@extends('admin.layouts.admin')

@section('title', 'Products - Admin')

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

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
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

                    <tr>
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
                                    <span class="text-green-600 dark:text-green-400 font-medium">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-muted-foreground line-through text-xs">${{ number_format($product->base_price, 2) }}</span>
                                </div>
                            @else
                                <span class="font-medium">${{ number_format($product->base_price, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($totalStock > 0)
                                <span class="text-green-600 dark:text-green-400 font-medium">{{ $totalStock }}</span>
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
                        <td colspan="7" class="text-center py-8 text-muted-foreground">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="admin-card-footer">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
