<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:2000',
        ]);

        $review = new Review($validated);
        $review->product_id = $product->id;
        $review->user_id = $request->user()?->id;
        $review->is_approved = false;
        $review->is_verified_purchase = false;
        $review->save();

        return back()->with('success', 'Thank you for your review! It will be published after moderation.');
    }
}
