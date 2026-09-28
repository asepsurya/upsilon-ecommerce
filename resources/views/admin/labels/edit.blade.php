@extends('admin.layouts.admin')

@section('title', 'Edit Label | Upsilon')

@section('page-title', 'Edit Label')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.labels.index') }}">Labels</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Edit</span>
    </nav>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.labels.update', $label) }}" enctype="multipart/form-data">
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
        <div class="lg:col-span-2">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h3 class="admin-card-title">Edit Label</h3>
                        <p class="admin-card-description">Update label information and style</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="admin-form-label">Label Name</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $label->name) }}"
                                class="admin-form-input" placeholder="e.g., New Arrival, Sale, Exclusive" required>
                        </div>

                        <div>
                            <label for="slug" class="admin-form-label">Slug</label>
                            <input id="slug" name="slug" type="text" value="{{ old('slug', $label->slug) }}"
                                class="admin-form-input" placeholder="e.g., new-arrival" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="color" class="admin-form-label">Background Color</label>
                                <div class="flex gap-2">
                                    <input id="color" name="color" type="color" value="{{ old('color', $label->color ?? '#000000') }}"
                                        class="h-10 w-14 rounded border border-outline cursor-pointer"
                                        oninput="document.getElementById('color-text').value = this.value">
                                    <input type="text" id="color-text" value="{{ old('color', $label->color ?? '#000000') }}"
                                        class="admin-form-input flex-1" placeholder="#000000"
                                        oninput="document.getElementById('color').value = this.value">
                                </div>
                            </div>

                            <div>
                                <label for="text_color" class="admin-form-label">Text Color</label>
                                <div class="flex gap-2">
                                    <input id="text_color" name="text_color" type="color" value="{{ old('text_color', $label->text_color ?? '#ffffff') }}"
                                        class="h-10 w-14 rounded border border-outline cursor-pointer"
                                        oninput="document.getElementById('text-color-text').value = this.value">
                                    <input type="text" id="text-color-text" value="{{ old('text_color', $label->text_color ?? '#ffffff') }}"
                                        class="admin-form-input flex-1" placeholder="#ffffff"
                                        oninput="document.getElementById('text_color').value = this.value">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="style" class="admin-form-label">Style</label>
                            <select id="style" name="style" class="admin-form-input">
                                <option value="badge" {{ old('style', $label->style ?? 'badge') == 'badge' ? 'selected' : '' }}>Badge</option>
                                <option value="pill" {{ old('style', $label->style) == 'pill' ? 'selected' : '' }}>Pill</option>
                                <option value="ribbon" {{ old('style', $label->style) == 'ribbon' ? 'selected' : '' }}>Ribbon</option>
                                <option value="circle" {{ old('style', $label->style) == 'circle' ? 'selected' : '' }}>Circle</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sort_order" class="admin-form-label">Sort Order</label>
                                <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', $label->sort_order) }}"
                                    class="admin-form-input" min="0" placeholder="0">
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $label->is_active) ? 'checked' : '' }}
                                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    <span class="admin-form-label mb-0">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="admin-card p-4 sticky" style="top: 24px;">
                <h5 class="font-medium mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">image</span>
                    Label Image
                </h5>

                <div class="space-y-4">
                    @if($label->image)
                        <div class="rounded-lg border border-outline overflow-hidden">
                            <img src="{{ $label->image_url }}" alt="{{ $label->name }}" class="w-full h-auto object-cover">
                        </div>
                    @endif

                    <div>
                        <label for="image" class="admin-form-label">Replace Image</label>
                        <input id="image" name="image" type="file" accept="image/*" class="admin-form-input">
                        <p class="text-xs text-muted mt-1">Leave empty to keep current image. Converts to WebP automatically.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card mt-6">
        <div class="admin-card-footer">
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.labels.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                <button type="submit" class="admin-btn admin-btn-primary">Update Label</button>
            </div>
        </div>
    </div>
</form>
@endsection
