<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\Label;
use App\Models\Product;
use App\Models\PromoBanner;
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
                $q->orderBy('sort_order');
            }])
            ->sorted()
            ->get();

        $featuredProducts = $products->take(8);

        $newArrivals = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->newArrival()
            ->sorted()
            ->get();

        $bundles = Bundle::active()
            ->sorted()
            ->with(['items' => function ($q) {
                $q->orderBy('id')->limit(4);
            }, 'items.product.images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->take(4)
            ->get();

        $sliders = Slider::active()->get();

        $promoBanners = PromoBanner::active()->get();

        $flashSale = FlashSale::active()->first();

        $flashSaleDeadline = $flashSale?->ends_at_timestamp ?? now()->addHours(20)->timestamp;

        $flashSaleProducts = $flashSale
            ? $flashSale->products()->active()->with(['images' => function ($q) {
                $q->orderBy('sort_order');
            }])->get()
            : collect();

        $limitedPairsList = $flashSaleProducts->isNotEmpty()
            ? $flashSaleProducts
            : $featuredProducts->take(5);

        $topPicksList = $newArrivals->isNotEmpty()
            ? $newArrivals->take(8)
            : Product::active()
                ->with(['images' => function ($q) {
                    $q->orderBy('sort_order');
                }])
                ->latest()
                ->take(8)
                ->get();

        $articles = $instagramService->getFormattedPosts(3);

        $labels = Label::active()->sorted()->get();

        return view('home.index', compact(
            'categories', 'featuredProducts', 'products', 'newArrivals', 'bundles', 'articles', 'sliders', 'flashSale', 'flashSaleDeadline', 'flashSaleProducts', 'promoBanners', 'limitedPairsList', 'topPicksList', 'labels'
        ));
    }

    public function about()
    {
        return view('home.about');
    }

    public function bundles()
    {
        $bundles = Bundle::active()
            ->sorted()
            ->with(['items' => function ($q) {
                $q->orderBy('id')->limit(4);
            }, 'items.product.images' => function ($q) {
                $q->orderBy('sort_order');
            }])
            ->get();

        return view('home.bundles', compact('bundles'));
    }

    public function discoverUpsilonStyle(InstagramService $instagramService)
    {
        $articles = $instagramService->getFormattedPosts(12);

        $articlesList = collect($articles ?? [])->map(function ($a) {
            if (is_object($a) && method_exists($a, 'toArray')) {
                $a = $a->toArray();
            }

            return (object) (array) $a;
        });

        $fallbackArticles = collect([
            [
                'title' => 'adidas Originals x JENNIE: A Collection Every Fan Must See',
                'excerpt' => 'JENNIE\'s first collaboration with adidas Originals is finally here! From Superstar with a ballet twist to effortless apparel.',
                'image' => 'article-1.jpg',
            ],
            [
                'title' => 'New Drop, Instant Crush: adidas Originals ANFU',
                'excerpt' => 'New mood, new kicks! adidas Originals ANFU brings a versatile retro Mary Jane touch for your daily OOTD.',
                'image' => 'article-2.jpg',
            ],
            [
                'title' => 'Cute Meets Classic: Meet the PUMA Tacklette',
                'excerpt' => 'Meet your new sneaker crush, PUMA Tacklette! Classic terrace style meets playful Mary Jane touches, chic and stylish.',
                'image' => 'article-3.jpg',
            ],
        ])->map(function ($a) {
            return (object) [
                'title' => $a['title'],
                'excerpt' => $a['excerpt'],
                'image_url' => asset('storage/images/upsilon/'.$a['image']),
                'permalink' => '#',
            ];
        });

        if ($articlesList->isEmpty()) {
            $articlesList = $fallbackArticles;
        }

        return view('home.discover-upsilon-style', compact('articlesList'));
    }
}
