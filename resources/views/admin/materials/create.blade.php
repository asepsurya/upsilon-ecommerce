@extends('admin.layouts.admin')

@section('title', 'Create Material | Upsilon')

@section('page-title', 'Create Material')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.materials.index') }}">Materials</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Create</span>
    </nav>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">New Material</h3>
                    <p class="admin-card-description">Create a new material spotlight slide</p>
                </div>
            </div>
            <div class="admin-card-body">
                <form id="material-create-form" method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                    @csrf

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
                            <label for="title" class="admin-form-label">Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}"
                                class="admin-form-input" placeholder="e.g. Premium Leather" required>
                        </div>

                        <div>
                            <label for="subtitle" class="admin-form-label">Subtitle (Optional)</label>
                            <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle') }}"
                                class="admin-form-input" placeholder="e.g. Crafted to Last">
                        </div>

                        <div>
                            <label for="description" class="admin-form-label">Description (Optional)</label>
                            <textarea id="description" name="description" rows="4"
                                class="admin-form-input" placeholder="Short description about the material">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="link" class="admin-form-label">Link URL (Optional)</label>
                                <input id="link" name="link" type="url" value="{{ old('link') }}"
                                    class="admin-form-input" placeholder="https://example.com">
                            </div>

                            <div>
                                <label for="link_text" class="admin-form-label">Link Text (Optional)</label>
                                <input id="link_text" name="link_text" type="text" value="{{ old('link_text') }}"
                                    class="admin-form-input" placeholder="e.g., Shop Now">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="sort_order" class="admin-form-label">Sort Order</label>
                                <input id="sort_order" name="sort_order" type="number" value="{{ old('sort_order', 0) }}"
                                    class="admin-form-input" min="0" placeholder="0">
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="admin-form-label mb-0">Active</span>
                            </label>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="admin-card p-4 sticky" style="top: 24px;">
                                <h5 class="font-medium mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">image</span>
                                    Material Image
                                </h5>

                                <div class="space-y-5">
                                    <div>
                                        <label for="image" class="admin-form-label">Material Image (Optional)</label>
                                        <input id="image" name="image" type="file" accept="image/*" class="admin-form-input">
                                        <p class="text-xs text-muted mt-1">Recommended size: 800x600px. Shown on the left side of the slide.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="admin-card-footer">
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.materials.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                    <button type="submit" form="material-create-form" class="admin-btn admin-btn-primary">Create Material</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
