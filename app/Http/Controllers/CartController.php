<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(CartService $cartService)
    {
        $cart = $cartService->getCart(request());
        $cart->load(['items.variant.size', 'items.variant.color', 'items.variant.product.images' => function ($q) {
            $q->orderBy('sort_order')->limit(1);
        }]);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, CartService $cartService)
    {
        $validated = $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        $variant = ProductVariant::active()->find($validated['product_variant_id']);

        if (! $variant) {
            return response()->json(['error' => 'Product not available'], 404);
        }

        if ($variant->stock < $validated['quantity']) {
            return response()->json(['error' => 'Insufficient stock'], 422);
        }

        $cart = $cartService->getCart($request);
        $cartService->add($cart, $variant, $validated['quantity']);

        return response()->json([
            'success' => true,
            'count' => $cartService->count($cart),
            'message' => 'Added to cart',
        ]);
    }

    public function update(CartItem $item, Request $request, CartService $cartService)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $variant = $item->variant;

        if ($variant->stock < $validated['quantity']) {
            return response()->json(['error' => 'Insufficient stock'], 422);
        }

        $cartService->update($item, $validated['quantity']);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($item->subtotal, 2),
            'total' => number_format($item->cart->fresh()->total, 2),
            'count' => $cartService->count($item->cart),
        ]);
    }

    public function remove(CartItem $item, CartService $cartService)
    {
        $cart = $item->cart;
        $cartService->remove($item);

        return response()->json([
            'success' => true,
            'total' => number_format($cart->fresh()->total, 2),
            'count' => $cartService->count($cart),
            'message' => 'Item removed',
        ]);
    }

    public function merge(Request $request, CartService $cartService)
    {
        $guestSessionId = $request->input('session_id');
        $guestCart = $guestSessionId ? Cart::where('session_id', $guestSessionId)->first() : null;
        $userCart = $cartService->getCart($request);

        if ($guestCart) {
            $cartService->merge($guestCart, $userCart);
        }

        return response()->json(['success' => true]);
    }

    public function count(CartService $cartService)
    {
        $cart = $cartService->getCart(request());

        return response()->json(['count' => $cartService->count($cart)]);
    }
}
