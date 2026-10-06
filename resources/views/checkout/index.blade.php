@extends("layouts.home")

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
                        <h3 class="font-headline-md text-xl mb-4">Shipping Address</h3>
                        @if($addresses->isEmpty())
                            <div class="bg-surface border border-outline-variant/40 p-8 text-center">
                                <p class="text-sm text-on-surface-variant mb-4">You haven't added any address yet.</p>
                                <a href="{{ route('account.addresses.create') }}" class="bg-black text-white px-6 py-3 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">Add Address</a>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($addresses as $address)
                                    <label class="block bg-surface border border-outline-variant/40 p-6 cursor-pointer hover:border-outline transition-colors">
                                        <div class="flex items-start gap-3">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }} class="mt-1 w-4 h-4 text-black focus:ring-brand-orange" required>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">{{ $address->label }} — {{ $address->full_name }}</p>
                                                <p class="text-sm text-on-surface-variant mt-1">{{ $address->address }}</p>
                                                <p class="text-sm text-on-surface-variant">{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                                <p class="text-sm text-on-surface-variant mt-1">{{ $address->phone }}</p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('address_id')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <h3 class="font-headline-md text-xl mb-4">Shipping & Payment</h3>
                        <div class="space-y-6">
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Courier</label>
                                <select name="shipping_courier" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                    <option value="">Select Courier</option>
                                    @foreach($couriers as $courierId => $courierName)
                                        <option value="{{ $courierId }}" {{ old('shipping_courier') === $courierId ? 'selected' : '' }}>{{ $courierName }}</option>
                                    @endforeach
                                </select>
                                @error('shipping_courier')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Courier Service (Optional)</label>
                                <input type="text" name="shipping_service" value="{{ old('shipping_service') }}" placeholder="e.g. REG, OKE, YES" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>

                            @if($checkoutMode === 'both')
                                <div>
                                    <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Payment Method</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($paymentMethods as $methodId => $methodName)
                                            <label class="block bg-surface border border-outline-variant/40 p-4 cursor-pointer hover:border-outline transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <input type="radio" name="payment_method" value="{{ $methodId }}" {{ $methodId === 'bank_transfer' ? 'checked' : '' }} class="w-4 h-4 text-black focus:ring-brand-orange" {{ $checkoutMode === 'whatsapp' ? 'disabled' : '' }}>
                                                    <span class="text-sm">{{ $methodName }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('payment_method')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @elseif($checkoutMode === 'midtrans')
                                <input type="hidden" name="payment_method" value="payment_gateway">
                                <div class="bg-surface border border-outline-variant/40 p-6">
                                    <p class="text-sm font-medium mb-2">Payment Gateway (Midtrans)</p>
                                    <p class="text-xs text-on-surface-variant">You will be redirected to Midtrans payment page after placing the order.</p>
                                </div>
                            @else
                                <input type="hidden" name="payment_method" value="whatsapp">
                                <div class="bg-surface border border-outline-variant/40 p-6">
                                    <p class="text-sm font-medium mb-2">WhatsApp Confirmation</p>
                                    <p class="text-xs text-on-surface-variant">After placing the order, you will be directed to WhatsApp to confirm your payment.</p>
                                </div>
                            @endif

                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Voucher Code (Optional)</label>
                                <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" placeholder="Enter voucher code" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>

                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Order Notes (Optional)</label>
                                <textarea name="notes" rows="2" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-4 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">Place Order</button>
                </form>

                <div>
                    <div class="bg-surface border border-outline-variant/40 p-8 sticky top-8">
                        <h3 class="font-headline-md text-xl mb-6">Order Summary</h3>
                        <div class="space-y-4 mb-6">
                            @forelse($cart->items as $item)
                                <div class="flex gap-4">
                                    <div class="w-16 h-20 bg-surface-container flex-shrink-0 overflow-hidden">
                                        <img src="{{ $item->variant->product->images->first()?->url ?? 'https://placehold.co/100x120/stone-200/stone-500?text=No+Image' }}" alt="{{ $item->variant->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium">{{ $item->variant->product->name }}</h4>
                                        <p class="text-xs text-on-surface-variant">{{ $item->variant->color?->name }} / {{ $item->variant->size?->name }} x {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-sm">{{ currency_format($item->subtotal) }}</div>
                                </div>
                            @empty
                                <p class="text-sm text-on-surface-variant">Your cart is empty.</p>
                            @endforelse
                        </div>
                        <div class="border-t border-outline-variant/40 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Subtotal</span>
                                <span>{{ currency_format($cart->total) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-on-surface-variant">Shipping</span>
                                <span>Calculated at confirmation</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-outline-variant/40 font-semibold">
                                <span>Total</span>
                                <span>{{ currency_format($cart->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection