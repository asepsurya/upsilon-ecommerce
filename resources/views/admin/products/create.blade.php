@extends('admin.layouts.admin')

@section('title', 'Create Product - Admin')

@section('page-title', 'Create Product')

@push('head')
<style>
    .size-pill, .color-pill {
        padding: 8px 16px;
        border-radius: 20px;
        border: 2px solid #e5e7eb;
        background: #fff;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    .size-pill:hover {
        background-color: #f3f4f6;
    }
    .size-pill.selected {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }
    .color-pill {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        border: 2px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
    }
    .color-pill.selected {
        border-color: #000;
        box-shadow: 0 0 0 2px #000;
    }
    .color-swatch {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid #ccc;
        flex-shrink: 0;
    }
    .dark .size-pill, .dark .color-pill {
        background: hsl(var(--card));
        border-color: hsl(var(--border));
    }
    .dark .size-pill.selected {
        background-color: #fff;
        color: #000;
    }
    .dark .color-pill:hover {
        background: hsl(var(--secondary));
    }
    .image-upload-zone {
        border: 2px dashed #d1d5db;
        border-radius: var(--radius);
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: hsl(var(--muted) / 0.3);
    }
    .image-upload-zone:hover {
        border-color: var(--primary);
        background: hsl(var(--muted) / 0.5);
    }
    .image-upload-zone.dragover {
        border-color: var(--primary);
        background: hsl(var(--primary) / 0.1);
    }
    .image-preview {
        position: relative;
    }
    .image-preview img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: var(--radius);
        border: 2px solid transparent;
    }
    .image-preview.primary img {
        border-color: var(--primary);
    }
    .image-preview .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        background: hsl(var(--destructive));
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
    }
    .dark .image-preview img {
        border-color: hsl(var(--border));
    }
</style>
@endpush

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Create Product</h3>
            <p class="admin-card-description">Add a new product to your inventory</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Products</a>
    </div>
    <div class="admin-card-body">
        @if ($errors->any())
            <div class="admin-card mb-4" style="border: 1px solid hsl(var(--destructive));">
                <div class="admin-card-body">
                    <ul class="text-sm" style="color: hsl(var(--destructive));">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-4">
                    <div class="admin-form-group">
                        <label class="admin-form-label">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" required class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Category</label>
                        <select name="category_id" class="admin-form-input">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Base Price</label>
                        <input type="number" name="base_price" value="{{ old('base_price') }}" step="0.01" required class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Sale Price</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" class="admin-form-input">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label">Description</label>
                        <textarea name="description" rows="4" class="admin-form-input">{{ old('description') }}</textarea>
                    </div>

                    <hr class="my-6 border-border">

                    <h4 class="text-lg font-semibold mb-4">Product Variants (Size &amp; Color)</h4>
                    <p class="text-sm text-muted-foreground mb-4">Select size and color options to generate product variants. Each combination becomes a separate variant with its own SKU, stock, and price.</p>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <div class="admin-card p-4">
                            <h5 class="font-medium mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">close_fullscreen</span>
                                Size Options
                            </h5>
                            <div id="size-panel"></div>
                        </div>

                        <div class="admin-card p-4">
                            <h5 class="font-medium mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">palette</span>
                                Color Options
                            </h5>
                            <div id="color-panel"></div>
                        </div>
                    </div>

                    <div class="admin-card p-4 mb-6">
                        <h5 class="font-medium mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">inventory_2</span>
                            Variant Matrix
                        </h5>
                        <div id="variants-matrix">
                            <p class="text-sm text-muted-foreground py-4">Select size and color options above to generate variants.</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="admin-card p-4 sticky" style="top: 24px;">
                        <h5 class="font-medium mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">image</span>
                            Product Images
                        </h5>
                        <p class="text-sm text-muted-foreground mb-4">Upload product images. The first image will be set as primary.</p>

                        <div class="image-upload-zone" id="image-upload-zone">
                            <input type="file" name="images[]" id="image-file-input" multiple accept="image/*" class="hidden">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-3xl text-muted-foreground">upload_file</span>
                                <span class="text-sm font-medium">Click to upload</span>
                                <span class="text-xs text-muted-foreground">or drag & drop</span>
                            </div>
                        </div>

                        <div id="image-preview-container" class="grid grid-cols-3 gap-3 mt-4">
                        </div>
                    </div>
                </div>
            </div>

            <div id="variants-hidden-inputs"></div>

            <button type="submit" class="admin-btn admin-btn-primary mt-6">Create Product</button>
        </form>
    </div>
</div>

@push('scripts')
@vite(['resources/js/admin-variants.js', 'resources/js/admin-image-gallery.js'])
<script>
(function() {
    const pollInit = setInterval(() => {
        if (typeof window.AdminVariants !== 'undefined' && typeof window.AdminImageGallery !== 'undefined') {
            clearInterval(pollInit);

            window.AdminVariants.init({
                sizes: @json($sizes),
                colors: @json($colors),
                existingVariants: {},
                formSelector: 'form',
                createSizeUrl: '{{ route('admin.sizes.store') }}',
                createColorUrl: '{{ route('admin.colors.store') }}',
            });

            window.AdminImageGallery.init({
                uploadZoneSelector: '#image-upload-zone',
                fileInputSelector: '#image-file-input',
                previewContainerSelector: '#image-preview-container',
                hasProduct: false,
            });
        }
    }, 10);
})();
</script>
@endpush
@endsection
