@extends('admin.layouts.admin')

@section('title', 'Labels | Upsilon')

@section('page-title', 'Labels')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Labels</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Labels</h3>
            <p class="admin-card-description">Manage product labels with custom images and styles</p>
        </div>
        <a href="{{ route('admin.labels.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Label</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Style</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labels as $label)
                    <tr>
                        <td>{{ $label->sort_order }}</td>
                        <td>
                            @if($label->image)
                                <img src="{{ $label->image_url }}" alt="{{ $label->name }}"
                                    class="w-16 h-10 object-cover rounded border border-outline">
                            @else
                                <span class="text-muted text-xs">No image</span>
                            @endif
                        </td>
                        <td class="font-medium">{{ $label->name }}</td>
                        <td class="text-sm text-muted">{{ $label->slug }}</td>
                        <td class="text-sm">{{ $label->style ?? 'badge' }}</td>
                        <td>
                            @if($label->color)
                                <span class="inline-block w-6 h-6 rounded border border-outline" style="background-color: {{ $label->color }};"></span>
                            @else
                                <span class="text-muted">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($label->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.labels.edit', $label) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.labels.toggle', $label) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="admin-btn admin-btn-{{ $label->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                    {{ $label->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.labels.destroy', $label) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this label?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-8">No labels found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($labels->hasPages())
        <div class="admin-card-footer">
            {{ $labels->links() }}
        </div>
    @endif
</div>
@endsection
