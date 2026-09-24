@extends('admin.layouts.admin')

@section('title', 'Orders - Admin')

@section('page-title', 'Orders')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Orders</h3>
            <p class="admin-card-description">Manage and track customer orders</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-medium" style="color: hsl(var(--foreground)); text-decoration: none;">{{ $order->order_number }}</a>
                        </td>
                        <td>{{ $order->customer?->name ?? 'Guest' }}</td>
                        <td class="text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            @php
                                $statusClasses = [
                                    'pending' => 'admin-badge-warning',
                                    'paid' => 'admin-badge-info',
                                    'processing' => 'admin-badge-info',
                                    'shipped' => 'admin-badge-info',
                                    'delivered' => 'admin-badge-success',
                                    'cancelled' => 'admin-badge-danger',
                                ];
                            @endphp
                            <span class="admin-badge {{ $statusClasses[$order->status] ?? 'admin-badge-info' }}">{{ $order->status }}</span>
                        </td>
                        <td>
                            <span class="admin-badge {{ $order->payment_status == 'paid' ? 'admin-badge-success' : 'admin-badge-info' }}">{{ $order->payment_status }}</span>
                        </td>
                        <td class="text-right">$ {{ number_format($order->total, 0, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
        <div class="admin-card-footer">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
