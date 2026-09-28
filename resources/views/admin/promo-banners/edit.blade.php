@extends('admin.layouts.admin')

@section('title', 'Edit Promo Banner | Upsilon')

@section('page-title', 'Edit Promo Banner')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.promo-banners.index') }}">Promo Banners</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Edit</span>
    </nav>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Edit Promo Banner</h3>
                    <p class="admin-card-description">Update the promo banner details</p>
                </div>
            </div>
            <div class="admin-card-body">
                <form id="promo-banner-edit-form" method="POST" action="{{ route('admin.promo-banners.update', $promoBanner) }}" enctype="multipart/form-data">
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

                    <div class="space-y-6">
                        <div>
                            <label for="heading" class="admin-form-label">Heading</label>
                            <input id="heading" name="heading" type="text" value="{{ old('heading', $promoBanner->heading) }}"
                                class="admin-form-input" placeholder="e.g. JD, JD EXCLUSIVE">
                        </div>

                        <div>
                            <label for="title" class="admin-form-label">Title / Subtitle</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $promoBanner->title) }}"
                                class="admin-form-input" placeholder="e.g. Complimentary adidas Adicolor Classic Bag">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="background_color" class="admin-form-label">Background Color (Optional)</label>
                                <input id="background_color" name="background_color" type="color" value="{{ old('background_color', $promoBanner->background_color ?? '#1C3545') }}"
                                    class="admin-form-input h-10 w-full p-1">
                            </div>

                            <div>
                                <label for="text_color" class="admin-form-label">Text Color (Optional)</label>
                                <input id="text_color" name="text_color" type="color" value="{{ old('text_color', $promoBanner->text_color ?? '#FFFFFF') }}"
                                    class="admin-form-input h-10 w-full p-1">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="link" class="admin-form-label">Link URL (Optional)</label>
                                <input id="link" name="link" type="url" value="{{ old('link', $promoBanner->link) }}"
                                    class="admin-form-input" placeholder="https://example.com">
                            </div>

                            <div>
                                <label for="link_text" class="admin-form-label">Link Text (Optional)</label>
                                <input id="link_text" name="link_text" type="text" value="{{ old('link_text', $promoBanner->link_text) }}"
                                    class="admin-form-input" placeholder="e.g., Shop Now">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="sort_order" class="admin-form-label">Sort Order</label>
                                <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', $promoBanner->sort_order) }}"
                                    class="admin-form-input" min="0" placeholder="0">
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $promoBanner->is_active) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="admin-form-label mb-0">Active</span>
                            </label>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="admin-card p-4 sticky" style="top: 24px;">
                                <h5 class="font-medium mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">image</span>
                                    Banner Image
                                </h5>

                                <div class="space-y-5">
                                    <div>
                                        <label for="image" class="admin-form-label">Banner Image</label>
                                        <input id="image" name="image" type="file" accept="image/*" class="admin-form-input">
                                        <p class="text-xs text-muted mt-1">Leave unchanged to keep the existing image. Recommended size: 1200x300px.</p>
                                        @if($promoBanner->image)
                                            <div class="mt-2">
                                                <img src="{{ $promoBanner->image_url }}" alt="{{ $promoBanner->heading ?? 'Promo Banner' }}"
                                                    class="w-full max-h-40 object-cover rounded border border-outline">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="admin-card-footer">
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.promo-banners.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                    <button type="submit" form="promo-banner-edit-form" class="admin-btn admin-btn-primary">Update Banner</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
