<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\MidtransService;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cartService, protected VoucherService $voucherService) {}

    public function index(Request $request, MidtransService $midtransService)
    {
        $user = $request->user();
        $cart = $this->cartService->getCart($request);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $cart->load(['items.variant.size', 'items.variant.color', 'items.variant.product.images' => function ($q) {
            $q->orderBy('sort_order')->limit(1);
        }]);

        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        $couriers = [
            'jne' => 'JNE',
            'jnt' => 'J&T',
            'sicapat' => 'SiCepat',
            'pos' => 'POS Indonesia',
            'other' => 'Other',
        ];

        $checkoutMode = MidtransService::getCheckoutMode();
        $paymentMethods = $this->getPaymentMethods($checkoutMode);

        return view('checkout.index', compact('cart', 'addresses', 'couriers', 'paymentMethods', 'checkoutMode'));
    }

    public function store(Request $request, MidtransService $midtransService)
    {
        $checkoutMode = MidtransService::getCheckoutMode();

        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_courier' => 'required|string|max:255',
            'shipping_service' => 'nullable|string|max:255',
            'payment_method' => $checkoutMode === 'whatsapp'
                ? 'nullable|string|max:255'
                : 'required|string|in:'.$this->getAllowedPaymentMethods($checkoutMode),
            'notes' => 'nullable|string|max:1000',
            'voucher_code' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        $address = Address::where('id', $validated['address_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $cart = $this->cartService->getCart($request);
        $cart->load(['items.variant.product']);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }

        $subtotal = $cart->total;
        $shippingCost = 0;
        $discount = 0;
        $voucher = null;
        $voucherCode = null;

        if (! empty($validated['voucher_code'])) {
            $voucher = $this->voucherService->validate(
                $validated['voucher_code'],
                $subtotal,
                $user->id,
                $request->session()->getId()
            );

            if ($voucher) {
                $discount = $this->voucherService->calculateDiscount($voucher, $subtotal);
                $voucherCode = $voucher->code;
            }
        }

        $total = max(0, $subtotal + $shippingCost - $discount);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'] ?? 'whatsapp',
            'shipping_courier' => $validated['shipping_courier'],
            'shipping_service' => $validated['shipping_service'],
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'total' => $total,
            'voucher_id' => $voucher?->id,
            'voucher_code' => $voucherCode,
            'shipping_address' => $address->toArray(),
            'billing_address' => $address->toArray(),
            'notes' => $validated['notes'],
        ]);

        foreach ($cart->items as $item) {
            $variant = $item->variant;
            $product = $variant->product;

            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $variant->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'size_name' => $variant->size?->name,
                'color_name' => $variant->color?->name,
                'image' => $variant->product->images->first()?->url ?? $variant->product->primaryImage->first()?->url,
                'quantity' => $item->quantity,
                'price' => $variant->effective_price,
                'subtotal' => $item->subtotal,
            ]);
        }

        if ($voucher) {
            $this->voucherService->apply($voucher, $subtotal, $user->id, $request->session()->getId(), $order->id);
        }

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'] ?? 'whatsapp',
            'amount' => $total,
            'status' => 'pending',
        ]);

        $cart->items()->delete();

        // Handle based on selected payment method
        if (($validated['payment_method'] ?? 'whatsapp') === 'whatsapp') {
            return redirect()->route('checkout.whatsapp', $order);
        }

        // Midtrans mode - create snap token
        $snapToken = $midtransService->createSnapToken($order);

        if (! $snapToken) {
            return redirect()->route('checkout.index')->with('error', 'Payment gateway is currently unavailable. Please try again.');
        }

        $order->update(['snap_token' => $snapToken]);

        return view('checkout.midtrans', compact('order', 'snapToken'));
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.images']);

        return view('checkout.success', compact('order'));
    }

    public function whatsapp(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.images']);

        $whatsappNumber = MidtransService::getWhatsAppNumber();
        $message = MidtransService::buildCheckoutMessage($order);

        $whatsappUrl = 'https://wa.me/'.$whatsappNumber.'?text='.urlencode($message);

        return view('checkout.whatsapp', compact('order', 'whatsappUrl', 'whatsappNumber'));
    }

    public function notification(Request $request, MidtransService $midtransService)
    {
        $result = $midtransService->handleNotification($request);

        return response()->json($result);
    }

    /**
     * Get payment methods based on checkout mode
     */
    private function getPaymentMethods(string $checkoutMode): array
    {
        $methods = [
            'bank_transfer' => 'Bank Transfer',
            'virtual_account' => 'Virtual Account',
            'e_wallet' => 'E-Wallet',
            'qris' => 'QRIS',
            'payment_gateway' => 'Payment Gateway',
        ];

        if ($checkoutMode === 'whatsapp') {
            return [
                'whatsapp' => 'WhatsApp (Manual Confirmation)',
            ];
        }

        if ($checkoutMode === 'midtrans') {
            return $methods;
        }

        // both mode
        return $methods + ['whatsapp' => 'WhatsApp (Manual Confirmation)'];
    }

    /**
     * Get comma-separated allowed payment method keys for validation
     */
    private function getAllowedPaymentMethods(string $checkoutMode): string
    {
        return implode(',', array_keys($this->getPaymentMethods($checkoutMode)));
    }
}
