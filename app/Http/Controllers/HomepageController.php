<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Services\CartService;
use App\Services\InstagramService;

class HomepageController extends Controller
{
    public function index(CartService $cartService, InstagramService $instagramService)
    {
        $categories = Category::active()->sorted()->limit(6)->get();

        $products = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }])
            ->sorted()
            ->get();

        $featuredProducts = $products->take(8);

        $newArrivals = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }])
            ->newArrival()
            ->sorted()
            ->get();

        $bundles = Bundle::active()
            ->sorted()
            ->with(['items.product'])
            ->take(3)
            ->get();

        $sliders = Slider::active()->get();

        $articles = $instagramService->getFormattedPosts(3);

        return view('home.index', compact(
            'categories', 'featuredProducts', 'products', 'newArrivals', 'bundles', 'articles', 'sliders'
        ));
    }

    public function about()
    {
        return view('home.about');
    }
}
