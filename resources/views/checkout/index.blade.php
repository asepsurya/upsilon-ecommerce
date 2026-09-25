@extends("layouts.app")

@section("title")
Checkout - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12 text-center">Checkout</h1>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <form method="POST" action="{{ route('checkout.store') }}" class="space-y-8">
                        @csrf
                        <div>
                            <h3 class="font-headline-md text-xl mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Full Name</label>
                                    <input type="text" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                </div>
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                                    <input type="email" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                </div>
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Phone</label>
                                    <input type="tel" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-headline-md text-xl mb-4">Shipping Address</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Address</label>
                                    <textarea required rows="2" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent"></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Province</label>
                                        <select class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                            <option>Select Province</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->province }}">{{ $address->province }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">City</label>
                                        <select class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                            <option>Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">District</label>
                                        <input type="text" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Postal Code</label>
                                        <input type="text" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-headline-md text-xl mb-4">Shipping & Payment</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Courier</label>
                                    <select class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                        @foreach($couriers as $courier)
                                            <option value="{{ $courier->id }}">{{ $courier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Payment Method</label>
                                    <select class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Order Notes (Optional)</label>
                                    <textarea rows="2" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent"></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-surface-container-lowest text-tertiary py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Place Order</button>
                    </form>

                    <div>
                        <div class="bg-surface border border-outline-variant/40 p-8 sticky top-8">
                            <h3 class="font-headline-md text-xl mb-6">Order Summary</h3>
                            <div class="space-y-4 mb-6">
                                @foreach($cart as $item)
                                    <div class="flex gap-4">
                                        <div class="w-16 h-20 bg-surface-container flex-shrink-0 overflow-hidden">
                                            <img src="{{ $item->variant->product->images->first()?->url ?? 'https://placehold.co/100x120/stone-200/stone-500?text=No+Image' }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium">{{ $item->variant->product->name }}</h4>
                                            <p class="text-xs text-on-surface-variant">{{ $item->variant->color }} / {{ $item->variant->size }} x {{ $item->quantity }}</p>
                                        </div>
                                        <div class="text-sm">$ {{ number_format($item->subtotal, 0, '.', ',') }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-outline-variant/40 pt-4 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Subtotal</span>
                                    <span>$ {{ number_format($cart->sum('subtotal'), 0, '.', ',') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-on-surface-variant">Shipping</span>
                                    <span>Calculated next</span>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-outline-variant/40 font-semibold">
                                    <span>Total</span>
                                    <span>$ {{ number_format($cart->sum('subtotal'), 0, '.', ',') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
