@extends("layouts.home")

@section("title")
    WhatsApp Confirmation - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl font-headline-md mb-4">Order Received!</h1>
            <p class="text-on-surface-variant mb-8">Your order <span class="font-medium text-on-surface">{{ $order->order_number }}</span> has been placed. Please confirm your payment via WhatsApp.</p>

            <div class="bg-surface border border-outline-variant/40 p-8 mb-8 text-left">
                <h2 class="font-headline-md text-lg mb-4">Order Summary</h2>

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

            <div class="bg-surface border border-outline-variant/40 p-8 mb-8">
                <h2 class="font-headline-md text-lg mb-4">Next Steps</h2>
                <ol class="text-left text-sm space-y-3 text-on-surface-variant">
                    <li class="flex gap-3">
                        <span class="font-medium text-on-surface">1.</span>
                        <span>Click the button below to open WhatsApp and send your payment confirmation.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="font-medium text-on-surface">2.</span>
                        <span>Include your order number <span class="font-medium text-on-surface">{{ $order->order_number }}</span> in the message.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="font-medium text-on-surface">3.</span>
                        <span>Send your payment proof (screenshot of transfer/receipt).</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="font-medium text-on-surface">4.</span>
                        <span>We will verify your payment and process your order within 1x24 hours.</span>
                    </li>
                </ol>
            </div>

            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-3 bg-[#25D366] text-white px-8 py-4 text-sm tracking-widest uppercase hover:bg-[#20bd5a] transition-colors mb-4">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Confirm via WhatsApp
            </a>

            <p class="text-xs text-on-surface-variant">WhatsApp: {{ $whatsappNumber }}</p>

            <div class="mt-8">
                <a href="{{ route('account.orders') }}" class="text-sm text-on-surface-variant hover:text-on-surface">View My Orders</a>
            </div>
        </div>
    </section>
@endsection