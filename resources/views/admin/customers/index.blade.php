@extends('admin.layouts.admin')

@section('title', 'Customers - Admin')

@section('page-title', 'Customers')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Customers</h3>
            <p class="admin-card-description">View and manage customer accounts</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Total Orders</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td class="font-medium">{{ $customer->name }}</td>
                        <td class="text-muted">{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? '-' }}</td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                        <td>{{ $customer->orders_count ?? 0 }}</td>
                        <td class="text-right">
                            <a href="#" class="admin-btn admin-btn-secondary admin-btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($customers->hasPages())
        <div class="admin-card-footer">
            {{ $customers->links() }}
        </div>
    @endif
</div>
@endsection
