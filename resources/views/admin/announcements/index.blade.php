@extends('admin.layouts.admin')

@section('title', 'Announcements - Admin')

@section('page-title', 'Announcements')

@section('breadcrumb')
    <nav class="admin-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="admin-breadcrumb-separator">/</span>
        <span class="admin-breadcrumb-current">Announcements</span>
    </nav>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Announcements</h3>
            <p class="admin-card-description">Manage top bar announcements for the website</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Announcement</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Animation</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Schedule</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                    <tr>
                        <td class="max-w-xs truncate">{{ $announcement->message }}</td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $announcement->type === 'promo' ? 'success' : ($announcement->type === 'warning' ? 'warning' : ($announcement->type === 'success' ? 'success' : 'info')) }}">
                                {{ ucfirst($announcement->type) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($announcement->animation) }}</td>
                        <td>{{ $announcement->code ?? '&mdash;' }}</td>
                        <td>
                            @if($announcement->is_active)
                                <span class="admin-badge admin-badge-success">Active</span>
                            @else
                                <span class="admin-badge admin-badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-sm text-muted">
                            @if($announcement->starts_at)
                                {{ $announcement->starts_at->format('M d, Y H:i') }}
                            @else
                                Immediately
                            @endif
                            @if($announcement->ends_at)
                                &mdash; {{ $announcement->ends_at->format('M d, Y H:i') }}
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.announcements.toggle', $announcement) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="admin-btn admin-btn-{{ $announcement->is_active ? 'warning' : 'success' }} admin-btn-sm">
                                    {{ $announcement->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-8">No announcements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($announcements->hasPages())
        <div class="admin-card-footer">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection