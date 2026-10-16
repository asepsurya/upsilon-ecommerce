@extends('admin.layouts.admin')

@section('title', 'About Slides | Upsilon')

@section('page-title', 'About Slides')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <a href="{{ route('admin.about-slides.index') }}">About Slides</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">List</span>
    </nav>
@endsection

@section('content')
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">About Slides</h3>
                <p class="admin-card-description">Manage the "About Upsilon" carousel slides on the homepage</p>
            </div>
            <a href="{{ route('admin.about-slides.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add
                Slide</a>
        </div>
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aboutSlides as $slide)
                        <tr>
                            <td>{{ $slide->sort_order }}</td>
                            <td>
                                @if($slide->image)
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}"
                                        class="w-24 h-14 object-cover rounded border border-outline mt-1">
                                @else
                                    <span class="text-muted text-xs">No image</span>
                                @endif
                            </td>
                            <td class="max-w-xs truncate">{{ $slide->title }}</td>
                            <td class="max-w-xs truncate">{{ $slide->subtitle ?? '&mdash;' }}</td>
                            <td>
                                @if($slide->link)
                                    <a href="{{ $slide->link }}" target="_blank" rel="noopener"
                                        class="text-primary font-label-caps text-[10px] uppercase">
                                        {{ $slide->link_text ?? 'Link' }}
                                    </a>
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>
                            <td>
                                @if($slide->is_active)
                                    <span class="admin-badge admin-badge-success">Active</span>
                                @else
                                    <span class="admin-badge admin-badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.about-slides.edit', $slide) }}"
                                    class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.about-slides.toggle', $slide) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="admin-btn admin-btn-{{ $slide->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                        {{ $slide->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.about-slides.destroy', $slide) }}" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this slide?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-8">No about slides found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($aboutSlides->hasPages())
            <div class="admin-card-footer">
                {{ $aboutSlides->links() }}
            </div>
        @endif
    </div>
@endsection