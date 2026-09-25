@extends('admin.layouts.admin')

@section('title', 'Create Announcement - Admin')

@section('page-title', 'Create Announcement')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.announcements.index') }}">Announcements</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Create</span>
    </nav>
@endsection

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">New Announcement</h3>
            <p class="admin-card-description">Create a new announcement for the top bar</p>
        </div>
    </div>
    <div class="admin-card-footer">
        <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-6">
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
                <label for="title" class="admin-form-label">Title (Optional)</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}"
                    class="admin-form-input" placeholder="Short title for internal reference">
            </div>

            <div>
                <label for="message" class="admin-form-label">Message <span class="text-destructive">*</span></label>
                <textarea id="message" name="message" rows="3"
                    class="admin-form-input resize-none" placeholder="Enter your announcement message">{{ old('message') }}</textarea>
                <p class="text-xs text-muted mt-1">This will be displayed in the top bar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="code" class="admin-form-label">Promo Code (Optional)</label>
                    <input id="code" name="code" type="text" value="{{ old('code') }}"
                        class="admin-form-input" placeholder="e.g., HEALTH10">
                </div>

                <div>
                    <label for="type" class="admin-form-label">Type <span class="text-destructive">*</span></label>
                    <select id="type" name="type" class="admin-form-input">
                        <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>Info</option>
                        <option value="promo" {{ old('type') === 'promo' ? 'selected' : '' }}>Promo</option>
                        <option value="warning" {{ old('type') === 'warning' ? 'selected' : '' }}>Warning</option>
                        <option value="success" {{ old('type') === 'success' ? 'selected' : '' }}>Success</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="animation" class="admin-form-label">Animation <span class="text-destructive">*</span></label>
                    <select id="animation" name="animation" class="admin-form-input">
                        <option value="slide" {{ old('animation') === 'slide' ? 'selected' : '' }}>Slide Up</option>
                        <option value="typewriter" {{ old('animation') === 'typewriter' ? 'selected' : '' }}>Typewriter</option>
                    </select>
                </div>

                <div>
                    <label for="duration" class="admin-form-label">Duration (ms) <span class="text-destructive">*</span></label>
                    <input id="duration" name="duration" type="number" value="{{ old('duration', 5000) }}"
                        class="admin-form-input" min="2000" max="30000" step="1000">
                    <p class="text-xs text-muted mt-1">Time each announcement shows (2000-30000ms)</p>
                </div>
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
                        class="admin-form-input" placeholder="Shop Now">
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
                    <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at') ? \Carbon\Carbon::parse(old('starts_at'))->format('Y-m-d\TH:i') : '' }}"
                        class="admin-form-input">
                </div>

                <div>
                    <label for="ends_at" class="admin-form-label">End Date (Optional)</label>
                    <input id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at') ? \Carbon\Carbon::parse(old('ends_at'))->format('Y-m-d\TH:i') : '' }}"
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
                <a href="{{ route('admin.announcements.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                <button type="submit" class="admin-btn admin-btn-primary">Create Announcement</button>
            </div>
        </form>
    </div>
</div>
@endsection