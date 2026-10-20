@extends('admin.layouts.admin')

@section('title', 'Dashboard | Upsilon')

@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
                <span class="material-symbols-outlined">attach_money</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Revenue</div>
                <div class="admin-stat-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
                <span class="material-symbols-outlined">shopping_bag</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Orders</div>
                <div class="admin-stat-value">{{ number_format($totalOrders) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Products</div>
                <div class="admin-stat-value">{{ number_format($totalProducts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #f5f5f5; color: #0a0a0a;">
                <span class="material-symbols-outlined">people</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Customers</div>
                <div class="admin-stat-value">{{ number_format($totalCustomers) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #fef3c7; color: #92400e;">
                <span class="material-symbols-outlined">visibility</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Views</div>
                <div class="admin-stat-value">{{ number_format($totalViews) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #dcfce7; color: #166534;">
                <span class="material-symbols-outlined">mail</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Total Contacts</div>
                <div class="admin-stat-value">{{ number_format($totalContacts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #dbeafe; color: #1e40af;">
                <span class="material-symbols-outlined">shopping_cart</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Active Carts</div>
                <div class="admin-stat-value">{{ number_format($activeCarts) }}</div>
            </div>
        </div>
        <div class="admin-stat-card dark-card">
            <div class="admin-stat-icon" style="background: #fee2e2; color: #991b1b;">
                <span class="material-symbols-outlined">local_shipping</span>
            </div>
            <div class="admin-stat-content">
                <div class="admin-stat-label">Delivered</div>
                <div class="admin-stat-value">{{ number_format($deliveredOrders) }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <!-- Sales Chart -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Sales Overview</h3>
                    <p class="admin-card-description">Revenue trend for the last 7 days</p>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 12px; height: 220px; padding-top: 16px;">
                    @foreach($chartData['labels'] as $index => $label)
                        @php
                            $max = max($chartData['values']) ?: 1;
                            $height = ($chartData['values'][$index] / $max) * 180;
                            $value = $chartData['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 40px;">
                            <span style="font-size: 0.75rem; color: #666; font-weight: 500;">Rp {{ number_format($value, 0, ',', '.') }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #0a0a0a 0%, #262626 100%); border-radius: 6px 6px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.75rem; color: #888;">{{ $label }}</span>
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
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 12px; height: 220px; padding-top: 16px;">
                    @foreach($viewsChartData['labels'] as $index => $label)
                        @php
                            $max = max($viewsChartData['values']) ?: 1;
                            $height = ($viewsChartData['values'][$index] / $max) * 180;
                            $value = $viewsChartData['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 40px;">
                            <span style="font-size: 0.75rem; color: #666; font-weight: 500;">{{ $value }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%); border-radius: 6px 6px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.75rem; color: #888;">{{ $label }}</span>
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
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 8px; height: 220px; padding-top: 16px;">
                    @foreach($monthlySales['labels'] as $index => $label)
                        @php
                            $max = max($monthlySales['values']) ?: 1;
                            $height = ($monthlySales['values'][$index] / $max) * 180;
                            $value = $monthlySales['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 24px;">
                            <span style="font-size: 0.65rem; color: #666; font-weight: 500;">Rp {{ number_format($value, 0, ',', '.') }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%); border-radius: 4px 4px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.65rem; color: #888; writing-mode: vertical-lr; transform: rotate(180deg);">{{ $label }}</span>
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
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 8px; height: 220px; padding-top: 16px;">
                    @foreach($monthlyViewsData['labels'] as $index => $label)
                        @php
                            $max = max($monthlyViewsData['values']) ?: 1;
                            $height = ($monthlyViewsData['values'][$index] / $max) * 180;
                            $value = $monthlyViewsData['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 24px;">
                            <span style="font-size: 0.65rem; color: #666; font-weight: 500;">{{ $value }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #7c3aed 0%, #5b21b6 100%); border-radius: 4px 4px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.65rem; color: #888; writing-mode: vertical-lr; transform: rotate(180deg);">{{ $label }}</span>
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
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 12px; height: 220px; padding-top: 16px;">
                    @foreach($contactsChartData['labels'] as $index => $label)
                        @php
                            $max = max($contactsChartData['values']) ?: 1;
                            $height = ($contactsChartData['values'][$index] / $max) * 180;
                            $value = $contactsChartData['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; min-width: 40px;">
                            <span style="font-size: 0.75rem; color: #666; font-weight: 500;">{{ $value }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); border-radius: 6px 6px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.75rem; color: #888;">{{ $label }}</span>
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
            <div style="overflow-x: auto;">
                <div style="display: flex; align-items: flex-end; gap: 8px; height: 220px; padding-top: 16px;">
                    @foreach($monthlyContactsData['labels'] as $index => $label)
                        @php
                            $max = max($monthlyContactsData['values']) ?: 1;
                            $height = ($monthlyContactsData['values'][$index] / $max) * 180;
                            $value = $monthlyContactsData['values'][$index];
                        @endphp
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 24px;">
                            <span style="font-size: 0.65rem; color: #666; font-weight: 500;">{{ $value }}</span>
                            <div style="width: 100%; height: {{ $height }}px; background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%); border-radius: 4px 4px 0 0; min-height: 4px;"></div>
                            <span style="font-size: 0.65rem; color: #888; writing-mode: vertical-lr; transform: rotate(180deg);">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <!-- Most Viewed Products -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h3 class="admin-card-title">Most Viewed Products</h3>
                    <p class="admin-card-description">Products with the highest views</p>
                </div>
            </div>
            <div style="overflow-x: auto;">
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
                                <td colspan="3" class="text-muted" style="text-align: center; padding: 24px;">No view data yet</td>
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
                                <td colspan="3" class="text-muted" style="text-align: center; padding: 24px;">No sales data yet</td>
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
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 8px;">
            <div class="dark-card" style="padding: 16px; border-radius: var(--radius);">
                <div class="admin-stat-label">Total Carts</div>
                <div class="admin-stat-value">{{ number_format($totalCarts) }}</div>
            </div>
            <div class="dark-card" style="padding: 16px; border-radius: var(--radius);">
                <div class="admin-stat-label">Active Carts</div>
                <div class="admin-stat-value">{{ number_format($activeCarts) }}</div>
            </div>
            <div class="dark-card" style="padding: 16px; border-radius: var(--radius);">
                <div class="admin-stat-label">Cart Items</div>
                <div class="admin-stat-value">{{ number_format($cartItems) }}</div>
            </div>
            <div class="dark-card" style="padding: 16px; border-radius: var(--radius);">
                <div class="admin-stat-label">Abandoned Carts</div>
                <div class="admin-stat-value" style="color: #f87171;">{{ number_format($abandonedCarts) }}</div>
            </div>
        </div>
    </div>
@endsection
