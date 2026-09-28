@extends('admin.layouts.admin')

@section('title', 'Promo Banners | Upsilon')

@section('page-title', 'Promo Banners')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Promo Banners</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Promo Banners</h3>
            <p class="admin-card-description">Manage homepage long banner promo sections</p>
        </div>
        <a href="{{ route('admin.promo-banners.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Banner</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Image</th>
                    <th>Heading</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promoBanners as $banner)
                    <tr>
                        <td>{{ $banner->sort_order }}</td>
                        <td>
                            @if($banner->image)
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->heading ?? 'Promo Banner' }}"
                                    class="w-32 h-16 object-cover rounded border border-outline">
                            @else
                                <span class="text-muted text-xs">No image</span>
                            @endif
                        </td>
                        <td class="font-medium">{{ $banner->heading ?? '&mdash;' }}</td>
                        <td class="max-w-xs truncate">{{ $banner->title ?? '&mdash;' }}</td>
                        <td>
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" rel="noopener" class="text-primary font-label-caps text-[10px] uppercase">
                                    {{ $banner->link_text ?? 'Link' }}
                                </a>
                            @else
                                <span class="text-muted">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($banner->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.promo-banners.edit', $banner) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.promo-banners.toggle', $banner) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="admin-btn admin-btn-{{ $banner->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                    {{ $banner->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.promo-banners.destroy', $banner) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-8">No promo banners found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($promoBanners->hasPages())
        <div class="admin-card-footer">
            {{ $promoBanners->links() }}
        </div>
    @endif
</div>
@endsection
