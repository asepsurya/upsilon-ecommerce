@extends("layouts.app")

@section("title")
Shopping Cart - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12 text-center">Shopping Cart</h1>

                @if($cart->count() > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <div class="lg:col-span-2">
                            <div class="bg-surface border border-outline-variant/40">
                                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 border-b border-outline-variant/40 text-xs font-semibold tracking-widest uppercase text-on-surface-variant">
                                    <div class="col-span-6">Product</div>
                                    <div class="col-span-2 text-center">Quantity</div>
                                    <div class="col-span-2 text-right">Price</div>
                                    <div class="col-span-2 text-right">Subtotal</div>
                                </div>
                                @foreach($cart->items as $item)
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-6 py-6 border-b border-outline-variant/40 items-center">
                                        <div class="md:col-span-6 flex gap-4">
                                            <div class="w-20 h-24 bg-surface-container flex-shrink-0 overflow-hidden">
                                                <img src="{{ asset($item->variant->product->images->first()?->image ?? 'https://placehold.co/100x120/stone-200/stone-500?text=No+Image') }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h3 class="font-headline-md text-on-surface">{{ $item->variant->product->name }}</h3>
                                                <p class="text-sm text-on-surface-variant mt-1">{{ $item->variant->color }} / {{ $item->variant->size }}</p>
                                                <form method="POST" action="{{ route('cart.destroy', $item) }}" class="mt-3 inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-on-surface-variant hover:text-on-surface underline">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2 flex items-center justify-between md:justify-center">
                                            <span class="md:hidden text-sm text-on-surface-variant">Quantity:</span>
                                            <div class="flex items-center border border-outline-variant/50">
                                                <button class="px-3 py-1 hover:bg-surface-container-high transition-colors">-</button>
                                                <span class="px-3 py-1 text-sm border-x border-outline-variant/50">{{ $item->quantity }}</span>
                                                <button class="px-3 py-1 hover:bg-surface-container-high transition-colors">+</button>
                                            </div>
                                        </div>
                                        <div class="md:col-span-2 text-right">
                                            <span class="md:hidden text-sm text-on-surface-variant">Price:</span>
                                            <span class="text-sm">$ {{ number_format($item->variant->effective_price, 0, '.', ',') }}</span>
                                        </div>
                                        <div class="md:col-span-2 text-right">
                                            <span class="md:hidden text-sm text-on-surface-variant">Subtotal:</span>
                                            <span class="text-sm font-semibold">$ {{ number_format($item->subtotal, 0, '.', ',') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="lg:col-span-1">
                            <div class="bg-surface border border-outline-variant/40 p-8">
                                <h3 class="font-headline-md text-xl mb-6">Order Summary</h3>
                                <div class="space-y-4 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">Subtotal</span>
                                        <span>$ {{ number_format($cart->total, 0, '.', ',') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">Shipping</span>
                                        <span>Calculated at checkout</span>
                                    </div>

                                    <div class="border-t border-outline-variant/40 pt-4 flex justify-between text-base font-semibold">
                                        <span>Total</span>
                                        <span>$ {{ number_format($cart->total, 0, '.', ',') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('checkout') }}" class="block w-full bg-surface-container-lowest text-tertiary text-center py-4 mt-8 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-24">
                        <div class="w-16 h-16 bg-surface-container flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-on-surface-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h2 class="font-headline-md text-2xl mb-3">Your cart is empty</h2>
                        <p class="text-on-surface-variant mb-8">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('shop') }}" class="inline-block bg-surface-container-lowest text-tertiary px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </section>
@endsection
