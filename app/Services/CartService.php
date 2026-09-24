<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartService
{
    public function getCart(Request $request): Cart
    {
        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        return Cart::where(function ($q) use ($sessionId, $userId) {
            $q->where('session_id', $sessionId)
                ->when($userId, fn ($q) => $q->orWhere('user_id', $userId));
        })->firstOrCreate([
            'session_id' => $sessionId,
            'user_id' => $userId,
        ]);
    }

    public function add(Cart $cart, ProductVariant $variant, int $quantity = 1): CartItem
    {
        $item = $cart->items()->where('product_variant_id', $variant->id)->first();

        if ($item) {
            $item->update(['quantity' => $item->quantity + $quantity]);
        } else {
            $item = $cart->items()->create([
                'product_variant_id' => $variant->id,
                'quantity' => $quantity,
            ]);
        }

        return $item->load('variant');
    }

    public function update(CartItem $item, int $quantity): CartItem
    {
        $item->update(['quantity' => max(1, $quantity)]);

        return $item->load('variant');
    }

    public function remove(CartItem $item): void
    {
        $item->delete();
    }

    public function merge(Cart $guestCart, Cart $userCart): void
    {
        foreach ($guestCart->items as $item) {
            $this->add($userCart, $item->variant, $item->quantity);
        }
        $guestCart->delete();
    }

    public function count(Cart $cart): int
    {
        return $cart->items->sum('quantity');
    }
}
