@extends('admin.layouts.admin')

@section('title', 'Flash Sales | Upsilon')

@section('page-title', 'Flash Sales')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Flash Sales</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Flash Sales</h3>
            <p class="admin-card-description">Manage homepage flash sale / countdown</p>
        </div>
        <a href="{{ route('admin.flash-sales.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Flash Sale</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Ends At</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($flashSales as $flashSale)
                    <tr>
                        <td class="font-medium">{{ $flashSale->title }}</td>
                        <td>{{ $flashSale->subtitle ?? '&mdash;' }}</td>
                        <td class="text-sm text-muted">
                            {{ $flashSale->ends_at?->format('M d, Y H:i') ?? '&mdash;' }}
                        </td>
                        <td>
                            @if($flashSale->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.flash-sales.edit', $flashSale) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.flash-sales.destroy', $flashSale) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this flash sale?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-8">No flash sales found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($flashSales->hasPages())
        <div class="admin-card-footer">
            {{ $flashSales->links() }}
        </div>
    @endif
</div>
@endsection
