@extends('admin.layouts.admin')

@section('title', 'Create Slider - Admin')

@section('page-title', 'Create Slider')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.sliders.index') }}">Sliders</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Create</span>
    </nav>
@endsection

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">New Slider</h3>
            <p class="admin-card-description">Create a new homepage hero slider banner</p>
        </div>
    </div>
    <div class="admin-card-footer">
        <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if($errors->any())
                <div class="rounded-lg bg-destructive/10 border border-destructive/20 p-4 text-sm text-destructive">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="image" class="admin-form-label">Slide Image <span class="text-destructive">*</span></label>
                <input id="image" name="image" type="file" accept="image/*" class="admin-form-input">
                <p class="text-xs text-muted mt-1">Recommended size: 1920x1080px. Converts to WebP automatically.</p>
            </div>

            <div>
                <label for="heading" class="admin-form-label">Heading</label>
                <input id="heading" name="heading" type="text" value="{{ old('heading') }}"
                    class="admin-form-input" placeholder="Main headline text">
            </div>

            <div>
                <label for="title" class="admin-form-label">Title / Subtitle (Optional)</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}"
                    class="admin-form-input" placeholder="Short subtitle for internal reference">
            </div>

            <div>
                <label for="description" class="admin-form-label">Description (Optional)</label>
                <textarea id="description" name="description" rows="3"
                    class="admin-form-input resize-none" placeholder="Slide description text">{{ old('description') }}</textarea>
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

                <div>
                    <label for="starts_at" class="admin-form-label">Start Date (Optional)</label>
                    <input id="starts_at" name="starts_at" type="datetime-local"
                        value="{{ old('starts_at') ? \Carbon\Carbon::parse(old('starts_at'))->format('Y-m-d\TH:i') : '' }}"
                        class="admin-form-input">
                </div>

                <div>
                    <label for="ends_at" class="admin-form-label">End Date (Optional)</label>
                    <input id="ends_at" name="ends_at" type="datetime-local"
                        value="{{ old('ends_at') ? \Carbon\Carbon::parse(old('ends_at'))->format('Y-m-d\TH:i') : '' }}"
                        class="admin-form-input">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                    <span class="admin-form-label mb-0">Active</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.sliders.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                <button type="submit" class="admin-btn admin-btn-primary">Create Slider</button>
            </div>
        </form>
    </div>
</div>
@endsection
