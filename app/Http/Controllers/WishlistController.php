<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(protected CartService $cartService) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $wishlists = Wishlist::where('user_id', $user->id)
            ->with(['product.category', 'product.images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }])
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        $wishlist = Wishlist::where('product_id', $validated['product_id'])
            ->where(function ($q) use ($sessionId, $userId) {
                $q->when($userId, fn ($q) => $q->where('user_id', $userId))
                    ->when(! $userId, fn ($q) => $q->where('session_id', $sessionId));
            })
            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json(['added' => false, 'message' => 'Removed from wishlist']);
        }

        Wishlist::create([
            'product_id' => $validated['product_id'],
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);

        return response()->json(['added' => true, 'message' => 'Added to wishlist']);
    }

    public function remove(Wishlist $wishlist)
    {
        $this->authorizeWishlist($wishlist);
        $wishlist->delete();

        return response()->json(['success' => true, 'message' => 'Removed from wishlist']);
    }

    public function moveToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = $request->user();
        $sessionId = $request->session()->getId();

        $wishlist = Wishlist::where('product_id', $request->product_id)
            ->where(function ($q) use ($sessionId, $user) {
                $q->when($user, fn ($q) => $q->where('user_id', $user->id))
                    ->when(! $user, fn ($q) => $q->where('session_id', $sessionId));
            })
            ->firstOrFail();

        $product = Product::active()->findOrFail($request->product_id);
        $variant = $product->activeVariants()->first();

        if (! $variant) {
            return response()->json(['error' => 'Product not available'], 422);
        }

        $cart = $this->cartService->getCart($request);
        $this->cartService->add($cart, $variant, 1);
        $wishlist->delete();

        return response()->json([
            'success' => true,
            'count' => $this->cartService->count($cart),
            'message' => 'Moved to cart',
        ]);
    }

    private function authorizeWishlist(Wishlist $wishlist): void
    {
        $userId = request()->user()?->id;
        $sessionId = request()->session()->getId();

        if ($wishlist->user_id && $wishlist->user_id !== $userId) {
            abort(403);
        }

        if (! $wishlist->user_id && $wishlist->session_id !== $sessionId) {
            abort(403);
        }
    }
}
