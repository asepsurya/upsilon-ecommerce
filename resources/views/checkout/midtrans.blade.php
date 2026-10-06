@extends("layouts.home")

@section("title")
    Payment - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-headline-md mb-12 text-center">Complete Your Payment</h1>

            <div class="bg-surface border border-outline-variant/40 p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant">Order</p>
                        <p class="text-xl font-headline-md">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant">Total</p>
                        <p class="text-2xl font-headline-md">{{ currency_format($order->total) }}</p>
                    </div>
                </div>

                <div class="border-t border-outline-variant/40 pt-6">
                    <p class="text-sm text-on-surface-variant mb-4">Please complete your payment through the following methods:</p>
                    <ul class="text-sm space-y-2 text-on-surface-variant">
                        <li>Bank Transfer (BCA, BNI, BRI, Mandiri)</li>
                        <li>Virtual Account</li>
                        <li>E-Wallet (GoPay, OVO, DANA, ShopeePay)</li>
                        <li>QRIS</li>
                        <li>Credit Card</li>
                        <li>Convenience Store (Alfamart, Indomaret)</li>
                    </ul>
                </div>
            </div>

            <button type="button" id="pay-button" class="w-full bg-black text-white py-4 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors mb-4">
                Pay Now
            </button>

            <a href="{{ route('checkout.whatsapp', $order) }}" class="block text-center text-sm text-on-surface-variant hover:text-on-surface">
                Pay via WhatsApp instead
            </a>

            <p class="text-xs text-on-surface-variant text-center mt-6">
                Payment is secured by Midtrans. You will be redirected to the payment page.
            </p>
        </div>
    </section>
@endsection

@push('scripts')
    @php
    $snapUrl = ($siteSettings['midtrans_environment'] ?? 'sandbox') === 'production'
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp
<script src="{{ $snapUrl }}" data-client-key="{{ $siteSettings['midtrans_client_key'] ?? '' }}"></script>
    <script>
        (function () {
            const payButton = document.getElementById('pay-button');
            const snapToken = {{ json_encode($snapToken) }};

            if (payButton && snapToken) {
                payButton.addEventListener('click', function () {
                    payButton.disabled = true;
                    payButton.textContent = 'Processing...';

                    window.snap.pay(snapToken, {
                        onSuccess: function (result) {
                            window.location.href = '{{ route('checkout.success', $order) }}';
                        },
                        onPending: function (result) {
                            window.location.href = '{{ route('checkout.success', $order) }}';
                        },
                        onError: function (result) {
                            payButton.disabled = false;
                            payButton.textContent = 'Pay Now';
                            alert('Payment failed. Please try again.');
                        },
                        onClose: function () {
                            payButton.disabled = false;
                            payButton.textContent = 'Pay Now';
                        }
                    });
                });
            }
        })();
    </script>
@endpush