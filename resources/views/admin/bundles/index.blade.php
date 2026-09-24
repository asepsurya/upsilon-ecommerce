@extends('admin.layouts.admin')

@section('title', 'Bundles - Admin')

@section('page-title', 'Bundles')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Bundles</h3>
            <p class="admin-card-description">Create and manage product bundles</p>
        </div>
        <a href="{{ route('admin.bundles.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Bundle</a>
    </div>

    <form method="GET" class="admin-form-group" style="margin-bottom: 16px;">
        <div class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bundles..." class="admin-form-input" style="max-width: 250px;">
            <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Search</button>
            @if (request('search'))
                <a href="{{ route('admin.bundles.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Clear</a>
            @endif
        </div>
    </form>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Bundle Price</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundles as $bundle)
                    <tr>
                        <td class="font-medium">{{ $bundle->name }}</td>
                        <td>{{ $bundle->slug }}</td>
                        <td>${{ $bundle->bundle_price ? number_format($bundle->bundle_price, 2) : '—' }}</td>
                        <td>{{ $bundle->items_count }}</td>
                        <td>
                            @if($bundle->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.bundles.edit', $bundle) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.bundles.destroy', $bundle) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No bundles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bundles->hasPages())
        <div class="mt-4">
            {{ $bundles->links() }}
        </div>
    @endif
</div>
@endsection
