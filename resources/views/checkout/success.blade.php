@extends("layouts.home")

@section("title")
    Order Confirmed - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-3xl mx-auto text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-headline-md mb-4">Order Placed!</h1>
            <p class="text-on-surface-variant mb-8">Thank you for your order. Your order number is <span class="font-medium text-on-surface">{{ $order->order_number }}</span></p>

            <div class="bg-surface border border-outline-variant/40 p-8 mb-8 text-left">
                <h2 class="font-headline-md text-lg mb-4">Order Details</h2>

                <div class="space-y-4 mb-6">
                    @foreach($order->items as $item)
                        <div class="flex gap-4">
                            <div class="w-16 h-20 bg-surface-container flex-shrink-0 overflow-hidden">
                                <img src="{{ $item->image ?? 'https://placehold.co/100x120/stone-200/stone-500?text=No+Image' }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium">{{ $item->product_name }}</h3>
                                <p class="text-xs text-on-surface-variant">{{ $item->size_name }} / {{ $item->color_name }} x {{ $item->quantity }}</p>
                            </div>
                            <div class="text-sm">{{ currency_format($item->subtotal) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-outline-variant/40 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Subtotal</span>
                        <span>{{ currency_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Shipping</span>
                        <span>{{ currency_format($order->shipping_cost) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant">Discount</span>
                            <span>-{{ currency_format($order->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pt-2 border-t border-outline-variant/40 font-semibold">
                        <span>Total</span>
                        <span>{{ currency_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('account.orders') }}" class="bg-black text-white px-8 py-4 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">View My Orders</a>
                <a href="{{ route('shop') }}" class="border border-outline-variant/50 px-8 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-high transition-colors">Continue Shopping</a>
            </div>
        </div>
    </section>
@endsection