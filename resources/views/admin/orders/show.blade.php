@extends('admin.layouts.admin')

@section('title', 'Order #' . $order->order_number . ' - Admin')

@section('page-title', 'Order #' . $order->order_number)

@section('breadcrumb')
    <li class="admin-breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="admin-breadcrumb-separator">/</li>
    <li class="admin-breadcrumb-current">Order #{{ $order->order_number }}</li>
@endsection

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Order Items</h3>
            <p class="admin-card-description">Items in this order</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $item->variant->product->images->first()?->url ?? 'https://placehold.co/50x60/stone-200/stone-500?text=No+Image' }}" alt="" class="w-12 h-14 object-cover border border-gray-200">
                                <div>
                                    <p class="font-weight-bold">{{ $item->variant->product->name }}</p>
                                    <p class="text-muted text-sm">{{ $item->variant->color }} / {{ $item->variant->size }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>$ {{ number_format($item->price, 2) }}</td>
                        <td class="text-right">$ {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
