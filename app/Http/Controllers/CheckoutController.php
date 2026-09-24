<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\CartService;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cartService, protected VoucherService $voucherService) {}

    public function index(Request $request)
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
        $paymentMethods = [
            'bank_transfer' => 'Bank Transfer',
            'virtual_account' => 'Virtual Account',
            'e_wallet' => 'E-Wallet',
            'qris' => 'QRIS',
            'payment_gateway' => 'Payment Gateway',
        ];

        return view('checkout.index', compact('cart', 'addresses', 'couriers', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'shipping_courier' => 'required|string|max:255',
            'shipping_service' => 'nullable|string|max:255',
            'payment_method' => 'required|string|in:bank_transfer,virtual_account,e_wallet,qris,payment_gateway',
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
            'payment_method' => $validated['payment_method'],
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
            'payment_method' => $validated['payment_method'],
            'amount' => $total,
            'status' => 'pending',
        ]);

        $cart->items()->delete();

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully');
    }
}
