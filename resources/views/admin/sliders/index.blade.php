@extends('admin.layouts.admin')

@section('title', 'Sliders - Admin')

@section('page-title', 'Sliders')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Sliders</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Sliders</h3>
            <p class="admin-card-description">Manage homepage hero slider banners</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Slider</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Image Preview</th>
                    <th>Heading</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Schedule</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                    <tr>
                        <td>{{ $slider->sort_order }}</td>
                        <td>
                            @if($slider->image)
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->heading ?? 'Slider' }}"
                                    class="w-16 h-10 object-cover rounded border border-outline">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td class="font-medium">{{ $slider->heading ?? '&mdash;' }}</td>
                        <td class="max-w-xs truncate">{{ $slider->title ?? '&mdash;' }}</td>
                        <td>
                            @if($slider->link)
                                <a href="{{ $slider->link }}" target="_blank" rel="noopener" class="text-primary font-label-caps text-[10px] uppercase">
                                    {{ $slider->link_text ?? 'Link' }}
                                </a>
                            @else
                                <span class="text-muted">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($slider->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-sm text-muted">
                            @if($slider->starts_at)
                                {{ $slider->starts_at->format('M d, Y H:i') }}
                            @else
                                Immediately
                            @endif
                            @if($slider->ends_at)
                                &mdash; {{ $slider->ends_at->format('M d, Y H:i') }}
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.sliders.toggle', $slider) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="admin-btn admin-btn-{{ $slider->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                    {{ $slider->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this slider?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-8">No sliders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sliders->hasPages())
        <div class="admin-card-footer">
            {{ $sliders->links() }}
        </div>
    @endif
</div>
@endsection
