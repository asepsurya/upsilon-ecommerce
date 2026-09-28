@extends('admin.layouts.admin')

@section('title', 'Size Guides | Upsilon')

@section('page-title', 'Size Guides')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Size Guides</h3>
            <p class="admin-card-description">Manage clothing size measurements</p>
        </div>
        <a href="{{ route('admin.size-guides.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Size Guide</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Chest</th>
                    <th>Waist</th>
                    <th>Hip</th>
                    <th>Shoulder</th>
                    <th>Sleeve</th>
                    <th>Length</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sizeGuides as $guide)
                    <tr>
                        <td class="font-medium">{{ $guide->size_label }}</td>
                        <td class="text-muted">{{ ucfirst($guide->size_type) }}</td>
                        <td class="text-muted">{{ $guide->chest_cm ? $guide->chest_cm . ' cm' : '-' }}</td>
                        <td class="text-muted">{{ $guide->waist_cm ? $guide->waist_cm . ' cm' : '-' }}</td>
                        <td class="text-muted">{{ $guide->hip_cm ? $guide->hip_cm . ' cm' : '-' }}</td>
                        <td class="text-muted">{{ $guide->shoulder_cm ? $guide->shoulder_cm . ' cm' : '-' }}</td>
                        <td class="text-muted">{{ $guide->sleeve_length_cm ? $guide->sleeve_length_cm . ' cm' : '-' }}</td>
                        <td class="text-muted">{{ $guide->body_length_cm ? $guide->body_length_cm . ' cm' : '-' }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.size-guides.edit', $guide) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.size-guides.destroy', $guide) }}" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted" style="text-align: center; padding: 24px;">No size guides yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
