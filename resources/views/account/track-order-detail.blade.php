@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-navy">Order Tracking</h1>
            <p class="mt-2 text-navy/60">Order <span class="font-medium">{{ $order->order_number }}</span></p>
        </div>

        {{-- Order Status Timeline --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-navy">Delivery Status</h2>
            </div>
            
            <div class="divide-y divide-gray-100">
                {{-- Status: Order Placed --}}
                <div class="flex items-start p-6 relative">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary flex items-center justify-center relative z-10">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1 pt-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-navy">Order Placed</h3>
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <p class="mt-1 text-sm text-navy/60">Your order has been confirmed</p>
                    </div>
                    <div class="absolute left-3 top-10 bottom-0 w-0.5 bg-gray-200"></div>
                </div>

                {{-- Status: Processing --}}
                <div class="flex items-start p-6 relative">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status !== 'pending' ? 'bg-primary' : 'bg-gray-200' }} flex items-center justify-center relative z-10">
                        @if($order->status !== 'pending')
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="w-2 h-2 rounded-full bg-gray-400 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1 pt-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium {{ $order->status !== 'pending' ? 'text-navy' : 'text-navy/40' }}">Processing</h3>
                            @if($order->status !== 'pending')
                                <span class="text-sm text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-navy/60">We're preparing your order</p>
                    </div>
                    <div class="absolute left-3 top-10 bottom-0 w-0.5 bg-gray-200"></div>
                </div>

                {{-- Status: Shipped --}}
                <div class="flex items-start p-6 relative">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary' : 'bg-gray-200' }} flex items-center justify-center relative z-10">
                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="w-2 h-2 rounded-full bg-gray-400 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1 pt-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-navy' : 'text-navy/40' }}">Shipped</h3>
                            @if(in_array($order->status, ['shipped', 'delivered']) && $order->shipments->first())
                                <span class="text-sm text-gray-500">{{ $order->shipments->first()->created_at->format('M d, Y h:i A') }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-navy/60">Your order is on the way</p>
                        
                        @if($order->shipments->first() && $order->shipments->first()->tracking_number)
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs font-medium text-navy/60">Tracking Number</p>
                                <p class="text-sm font-mono text-navy">{{ $order->shipments->first()->tracking_number }}</p>
                                @if($order->shipments->first()->tracking_url)
                                    <a href="{{ $order->shipments->first()->tracking_url }}" target="_blank" rel="noopener" class="mt-2 inline-block text-sm text-primary hover:underline">Track on courier website</a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="absolute left-3 top-10 bottom-0 w-0.5 bg-gray-200"></div>
                </div>

                {{-- Status: Delivered --}}
                <div class="flex items-start p-6 relative">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-primary' : 'bg-gray-200' }} flex items-center justify-center relative z-10">
                        @if($order->status === 'delivered')
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <div class="w-2 h-2 rounded-full bg-gray-400 animate-pulse"></div>
                        @endif
                    </div>
                    <div class="ml-4 flex-1 pt-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium {{ $order->status === 'delivered' ? 'text-navy' : 'text-navy/40' }}">Delivered</h3>
                            @if($order->status === 'delivered' && $order->delivered_at)
                                <span class="text-sm text-gray-500">{{ $order->delivered_at->format('M d, Y h:i A') }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-navy/60">Order has been delivered</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Details --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-navy">Order Details</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    <div>
                        <p class="text-xs font-medium text-navy/60 uppercase tracking-wide">Order Number</p>
                        <p class="text-sm font-medium text-navy">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-navy/60 uppercase tracking-wide">Order Date</p>
                        <p class="text-sm font-medium text-navy">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-navy/60 uppercase tracking-wide">Payment Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-navy/60 uppercase tracking-wide">Total</p>
                        <p class="text-sm font-bold text-navy">{{ currency_format($order->total_amount) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-navy">Order Items</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <div class="p-6 flex items-center gap-4">
                        @if($item->product && $item->product->images->first())
                            <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-medium text-navy truncate">{{ $item->product->name ?? $item->product_name }}</h3>
                            @if($item->variant)
                                <p class="text-xs text-navy/60">{{ $item->variant->name }}</p>
                            @endif
                            <p class="text-sm text-navy/60">Qty: {{ $item->quantity }}</p>
                        </div>
                        <p class="text-sm font-medium text-navy whitespace-nowrap">{{ currency_format($item->price * $item->quantity) }}</p>
                    </div>
                @endforeach
            </div>
            
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                <div class="flex justify-between text-sm">
                    <span class="text-navy/60">Subtotal</span>
                    <span class="text-navy">{{ currency_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-navy/60">Shipping</span>
                    <span class="text-navy">{{ currency_format($order->shipping_cost) }}</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm mt-1 text-green-600">
                    <span>Discount</span>
                    <span>-{{ currency_format($order->discount_amount) }}</span>
                </div>
                @endif
                <div class="flex justify-between text-base font-semibold text-navy mt-2 pt-2 border-t border-gray-200">
                    <span>Total</span>
                    <span>{{ currency_format($order->total_amount) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        @if($order->shipping_address)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-8">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-navy">Shipping Address</h2>
            </div>
            <div class="p-6">
                <p class="font-medium text-navy">{{ $order->shipping_address['full_name'] }}</p>
                <p class="text-sm text-navy/60 mt-1">{{ $order->shipping_address['phone'] }}</p>
                <p class="text-sm text-navy/60 mt-1">{{ $order->shipping_address['address'] }}, {{ $order->shipping_address['district'] }}, {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['province'] }} {{ $order->shipping_address['postal_code'] }}</p>
            </div>
        </div>
        @endif

        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="text-primary hover:underline font-medium">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection