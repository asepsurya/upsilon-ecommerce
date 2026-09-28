<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductView;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load([
            'category',
            'images' => function ($q) {
                $q->orderBy('sort_order');
            },
            'variants' => function ($q) {
                $q->with(['size', 'color', 'images' => function ($iq) {
                    $iq->orderBy('sort_order');
                }]);
            },
            'variants.size',
            'variants.color',
            'reviews' => function ($q) {
                $q->approved()->with(['user', 'images', 'replies.user'])->latest();
            },
            'labels',
        ]);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->limit(4)
            ->get();

        $this->recordProductView($product);

        $recentlyViewed = $this->getRecentlyViewed($product);

        return view('product.show', compact(
            'product', 'related', 'recentlyViewed'
        ));
    }

    public function addToWishlist(Request $request, Product $product)
    {
        $sessionId = $request->session()->getId();
        $userId = $request->user()?->id;

        $exists = Wishlist::where(function ($q) use ($sessionId, $userId, $product) {
            $q->where('product_id', $product->id)
                ->when($userId, fn ($q) => $q->where('user_id', $userId))
                ->when(! $userId, fn ($q) => $q->where('session_id', $sessionId));
        })->exists();

        if ($exists) {
            return response()->json(['added' => false, 'message' => 'Already in wishlist']);
        }

        Wishlist::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'session_id' => $sessionId,
        ]);

        return response()->json(['added' => true]);
    }

    public function getRecentlyViewed(Product $current)
    {
        $ids = session('recently_viewed', []);
        $ids = array_diff($ids, [$current->id]);
        array_unshift($ids, $current->id);
        $ids = array_slice($ids, 0, 6);
        session(['recently_viewed' => $ids]);

        if (count($ids) <= 1) {
            return collect();
        }

        return Product::active()
            ->whereIn('id', $ids)
            ->where('id', '!=', $current->id)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->limit(4)
            ->get();
    }

    public function recordProductView(Product $product): void
    {
        ProductView::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'ip_address' => request()->ip(),
            'viewed_at' => now(),
        ]);
    }
}
