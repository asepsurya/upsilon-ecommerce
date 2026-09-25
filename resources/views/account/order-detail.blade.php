@extends("layouts.app")

@section("title")
Order #{{ $order->order_number }} - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <h1 class="text-3xl md:text-4xl font-headline-md">Order #{{ $order->order_number }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="inline-block {{ $order->status == 'delivered' ? 'bg-green-100 text-green-900' : ($order->status == 'shipped' ? 'bg-purple-100 text-purple-900' : 'bg-surface-container text-on-surface') }} text-xs px-3 py-1 tracking-wider uppercase">{{ $order->status }}</span>
                        <a href="{{ route('account.orders') }}" class="text-sm text-on-surface-variant hover:text-on-surface">Back to Orders</a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Order Items</h2>
                            </div>
                                <div class="divide-y divide-outline-variant/30">
                                @foreach($order->items as $item)
                                    <div class="px-8 py-6 flex gap-6">
                                        <div class="w-20 h-24 bg-surface-container flex-shrink-0 overflow-hidden">
                                            <img src="{{ $item->variant->product->images->first()?->url ?? 'https://placehold.co/100x120/stone-200/stone-500?text=No+Image' }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-headline-md text-on-surface">{{ $item->variant->product->name }}</h3>
                                            <p class="text-sm text-on-surface-variant mt-1">{{ $item->variant->color }} / {{ $item->variant->size }} x {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium">$ {{ number_format($item->subtotal, 0, '.', ',') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Shipping & Tracking</h2>
                            </div>
                            <div class="px-8 py-6">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-3 h-3 bg-surface-container-lowest rounded-full"></div>
                                    <span class="text-sm">Order placed - {{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-3 h-3 bg-surface-container-lowest rounded-full"></div>
                                    <span class="text-sm">Payment confirmed</span>
                                </div>
                                @if($order->tracking_number)
                                    <div class="flex items-center gap-4">
                                        <div class="w-3 h-3 bg-surface-container-lowest rounded-full"></div>
                                        <div>
                                            <span class="text-sm block">Shipped</span>
                                            <span class="text-xs text-on-surface-variant">Tracking: {{ $order->tracking_number }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-8">
                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Shipping Address</h2>
                            </div>
                            <div class="px-8 py-6 text-sm text-on-surface-variant">
                                <p>{{ $order->shipping_name }}</p>
                                <p>{{ $order->shipping_address }}</p>
                                <p>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
                                <p>{{ $order->shipping_phone }}</p>
                            </div>
                        </div>
                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Payment Info</h2>
                            </div>
                            <div class="px-8 py-6 text-sm text-on-surface-variant">
                                <p>Method: {{ $order->payment_method?->name ?? 'Online Payment' }}</p>
                                <p>Status: {{ ucfirst($order->payment_status) }}</p>
                            </div>
                        </div>
                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Order Total</h2>
                            </div>
                            <div class="px-8 py-6 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Subtotal</span>
                                    <span>$ {{ number_format($order->subtotal, 0, '.', ',') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Shipping</span>
                                    <span>$ {{ number_format($order->shipping_cost, 0, '.', ',') }}</span>
                                </div>
                                @if($order->discount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">Discount</span>
                                        <span>-$ {{ number_format($order->discount, 0, '.', ',') }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between pt-2 border-t border-outline-variant/40 font-semibold">
                                    <span>Total</span>
                                    <span>$ {{ number_format($order->total, 0, '.', ',') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
