@extends('admin.layouts.admin')

@section('title', 'Dashboard - Admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
            <span class="material-symbols-outlined">attach_money</span>
        </div>
        <div class="admin-stat-content">
            <div class="admin-stat-label">Total Revenue</div>
            <div class="admin-stat-value">$48.2M</div>
            <div class="admin-stat-change positive">+12.5% from last month</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
            <span class="material-symbols-outlined">shopping_bag</span>
        </div>
        <div class="admin-stat-content">
            <div class="admin-stat-label">Total Orders</div>
            <div class="admin-stat-value">1,284</div>
            <div class="admin-stat-change positive">+8.2% from last month</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
            <span class="material-symbols-outlined">inventory_2</span>
        </div>
        <div class="admin-stat-content">
            <div class="admin-stat-label">Total Products</div>
            <div class="admin-stat-value">342</div>
        </div>
    </div>
    <div class="admin-stat-card">
        <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
            <span class="material-symbols-outlined">people</span>
        </div>
        <div class="admin-stat-content">
            <div class="admin-stat-label">Customers</div>
            <div class="admin-stat-value">8,921</div>
            <div class="admin-stat-change positive">+4.1% from last month</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Recent Orders</h3>
            <p class="admin-card-description">Track and manage customer orders</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">View All</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-medium">#ORD-001</td>
                    <td>John Doe</td>
                    <td class="text-muted">Sep 8, 2026</td>
                    <td><span class="admin-badge admin-badge-info">Processing</span></td>
                    <td class="text-right">$ 1,250,000</td>
                </tr>
                <tr>
                    <td class="font-medium">#ORD-002</td>
                    <td>Jane Smith</td>
                    <td class="text-muted">Sep 7, 2026</td>
                    <td><span class="admin-badge admin-badge-success">Shipped</span></td>
                    <td class="text-right">$ 890,000</td>
                </tr>
                <tr>
                    <td class="font-medium">#ORD-003</td>
                    <td>Alice Brown</td>
                    <td class="text-muted">Sep 6, 2026</td>
                    <td><span class="admin-badge admin-badge-success">Delivered</span></td>
                    <td class="text-right">$ 2,100,000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Best Sellers -->
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Best Sellers</h3>
            <p class="admin-card-description">Top performing products this month</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Sold</th>
                    <th class="text-right">Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['Classic White Shirt', 'Slim Fit Chinos', 'Wool Blend Coat', 'Silk Blend Dress'] as $product)
                    <tr>
                        <td class="font-medium">{{ $product }}</td>
                        <td>{{ rand(50, 200) }}</td>
                        <td class="text-right">$ {{ number_format(rand(5000000, 50000000), 0, '.', ',') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
