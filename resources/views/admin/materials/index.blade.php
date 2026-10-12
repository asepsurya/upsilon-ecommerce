@extends('admin.layouts.admin')

@section('title', 'Materials | Upsilon')

@section('page-title', 'Materials')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Materials</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Materials</h3>
            <p class="admin-card-description">Manage homepage material spotlight slider content</p>
        </div>
        <a href="{{ route('admin.materials.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Material</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                    <tr>
                        <td>{{ $material->sort_order }}</td>
                        <td>
                            @if($material->image)
                                <img src="{{ $material->image_url }}" alt="{{ $material->title }}"
                                    class="w-32 h-16 object-cover rounded border border-outline">
                            @else
                                <span class="text-muted text-xs">No image</span>
                            @endif
                        </td>
                        <td class="font-medium">{{ $material->title }}</td>
                        <td class="max-w-xs truncate">{{ $material->subtitle ?? '&mdash;' }}</td>
                        <td class="max-w-xs truncate">{{ $material->description ?? '&mdash;' }}</td>
                        <td>
                            @if($material->link)
                                <a href="{{ $material->link }}" target="_blank" rel="noopener" class="text-primary font-label-caps text-[10px] uppercase">
                                    {{ $material->link_text ?? 'Link' }}
                                </a>
                            @else
                                <span class="text-muted">&mdash;</span>
                            @endif
                        </td>
                        <td>
                            @if($material->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.materials.edit', $material) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.materials.toggle', $material) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="admin-btn admin-btn-{{ $material->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                    {{ $material->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this material?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-8">No materials found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($materials->hasPages())
        <div class="admin-card-footer">
            {{ $materials->links() }}
        </div>
    @endif
</div>
@endsection
