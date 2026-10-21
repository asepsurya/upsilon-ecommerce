@extends('admin.layouts.admin')

@section('title', 'Dashboard | Upsilon')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-gray">
                <span class="material-symbols-outlined">attach_money</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Revenue</div>
                <div class="admin-stat-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-gray">
                <span class="material-symbols-outlined">shopping_bag</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Orders</div>
                <div class="admin-stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-gray">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Products</div>
                <div class="admin-stat-value">{{ number_format($totalProducts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-gray">
                <span class="material-symbols-outlined">people</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Customers</div>
                <div class="admin-stat-value">{{ number_format($totalCustomers) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-amber">
                <span class="material-symbols-outlined">visibility</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Views</div>
                <div class="admin-stat-value">{{ number_format($totalViews) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-green">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Contacts</div>
                <div class="admin-stat-value">{{ number_format($totalContacts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-blue">
                <span class="material-symbols-outlined">shopping_cart</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Active Carts</div>
                <div class="admin-stat-value">{{ number_format($activeCarts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon admin-stat-icon-red">
                <span class="material-symbols-outlined">local_shipping</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Delivered</div>
                <div class="admin-stat-value">{{ number_format($deliveredOrders) }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="admin-chart-grid">
        <!-- Sales Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Sales Overview</h3>
                    <p class="admin-card-description">Revenue trend for the last 7 days</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart">
                    @foreach($chartData['labels'] as $index => $label)
                        @php
                            $max = max($chartData['values']) ?: 1;
                            $height = ($chartData['values'][$index] / $max) * 180;
                            $value = $chartData['values'][$index];
                        @endphp
                        <div class="admin-bar-item">
                            <span class="admin-bar-value">Rp {{ number_format($value, 0, ',', '.') }}</span>
                            <div class="admin-bar-fill admin-bar-fill-primary" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Views Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Product Views</h3>
                    <p class="admin-card-description">Views trend for the last 7 days</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart">
                    @foreach($viewsChartData['labels'] as $index => $label)
                        @php
                            $max = max($viewsChartData['values']) ?: 1;
                            $height = ($viewsChartData['values'][$index] / $max) * 180;
                            $value = $viewsChartData['values'][$index];
                        @endphp
                        <div class="admin-bar-item">
                            <span class="admin-bar-value">{{ $value }}</span>
                            <div class="admin-bar-fill admin-bar-fill-blue" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Monthly Sales</h3>
                    <p class="admin-card-description">Revenue trend for the last 12 months</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart admin-bar-chart-sm">
                    @foreach($monthlySales['labels'] as $index => $label)
                        @php
                            $max = max($monthlySales['values']) ?: 1;
                            $height = ($monthlySales['values'][$index] / $max) * 180;
                            $value = $monthlySales['values'][$index];
                        @endphp
                        <div class="admin-bar-item-sm">
                            <span class="admin-bar-value-sm">Rp {{ number_format($value, 0, ',', '.') }}</span>
                            <div class="admin-bar-fill admin-bar-fill-blue admin-bar-fill-sm" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label-vertical">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Monthly Views Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Monthly Product Views</h3>
                    <p class="admin-card-description">Views trend for the last 12 months</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart admin-bar-chart-sm">
                    @foreach($monthlyViewsData['labels'] as $index => $label)
                        @php
                            $max = max($monthlyViewsData['values']) ?: 1;
                            $height = ($monthlyViewsData['values'][$index] / $max) * 180;
                            $value = $monthlyViewsData['values'][$index];
                        @endphp
                        <div class="admin-bar-item-sm">
                            <span class="admin-bar-value-sm">{{ $value }}</span>
                            <div class="admin-bar-fill admin-bar-fill-purple admin-bar-fill-sm" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label-vertical">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contacts Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Contact Submissions</h3>
                    <p class="admin-card-description">Contact messages received in the last 7 days</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart">
                    @foreach($contactsChartData['labels'] as $index => $label)
                        @php
                            $max = max($contactsChartData['values']) ?: 1;
                            $height = ($contactsChartData['values'][$index] / $max) * 180;
                            $value = $contactsChartData['values'][$index];
                        @endphp
                        <div class="admin-bar-item">
                            <span class="admin-bar-value">{{ $value }}</span>
                            <div class="admin-bar-fill admin-bar-fill-amber" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Monthly Contacts Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Monthly Contact Submissions</h3>
                    <p class="admin-card-description">Contact messages received in the last 12 months</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <div class="admin-bar-chart admin-bar-chart-sm">
                    @foreach($monthlyContactsData['labels'] as $index => $label)
                        @php
                            $max = max($monthlyContactsData['values']) ?: 1;
                            $height = ($monthlyContactsData['values'][$index] / $max) * 180;
                            $value = $monthlyContactsData['values'][$index];
                        @endphp
                        <div class="admin-bar-item-sm">
                            <span class="admin-bar-value-sm">{{ $value }}</span>
                            <div class="admin-bar-fill admin-bar-fill-amber admin-bar-fill-sm" style="height: {{ $height }}px;"></div>
                            <span class="admin-bar-label-vertical">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="admin-chart-grid-2">
        <!-- Most Viewed Products -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Most Viewed Products</h3>
                    <p class="admin-card-description">Products with the highest views</p>
                </div>
            </div>
            <div class="admin-table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Views</th>
                            <th class="text-right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mostViewed as $item)
                            <tr>
                                <td class="font-medium">{{ $item->product?->name ?? 'Unknown' }}</td>
                                <td>{{ number_format($item->view_count) }}</td>
                                <td class="text-right">$ {{ number_format($item->product?->effective_price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-6">No view data yet</td>
                            </tr>
                        @endforelse
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
            <div class="admin-table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Sold</th>
                            <th class="text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bestSelling as $item)
                            @php
                                $productRevenue = \App\Models\OrderItem::where('product_id', $item->product_id)
                                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                                    ->where('orders.payment_status', 'paid')
                                    ->sum('order_items.subtotal');
                            @endphp
                            <tr>
                                <td class="font-medium">{{ $item->product?->name ?? 'Unknown' }}</td>
                                <td>{{ number_format($item->total_quantity) }}</td>
                                <td class="text-right">Rp {{ number_format($productRevenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted text-center py-6">No sales data yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Cart Summary -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">Cart Summary</h3>
                <p class="admin-card-description">Shopping cart activity overview</p>
            </div>
        </div>
        <div class="admin-cart-summary-grid">
            <div class="dark-card admin-mini-stat">
                <div class="admin-stat-label">Total Carts</div>
                <div class="admin-stat-value">{{ number_format($totalCarts) }}</div>
            </div>
            <div class="dark-card admin-mini-stat">
                <div class="admin-stat-label">Active Carts</div>
                <div class="admin-stat-value">{{ number_format($activeCarts) }}</div>
            </div>
            <div class="dark-card admin-mini-stat">
                <div class="admin-stat-label">Cart Items</div>
                <div class="admin-stat-value">{{ number_format($cartItems) }}</div>
            </div>
            <div class="dark-card admin-mini-stat">
                <div class="admin-stat-label">Abandoned Carts</div>
                <div class="admin-stat-value text-red-500 dark:text-red-400">{{ number_format($abandonedCarts) }}</div>
            </div>
        </div>
    </div>
@endsection
