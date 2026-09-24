<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }, 'category', 'reviews'])
            ->withCount('reviews');

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->sizes) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size_id', $request->sizes);
            });
        }

        if ($request->colors) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('color_id', $request->colors);
            });
        }

        if ($request->price_min || $request->price_max) {
            $query->priceBetween(
                $request->price_min ?? 0,
                $request->price_max ?? 999999
            );
        }

        if ($request->in_stock) {
            $query->whereHas('variants', function ($q) {
                $q->where('stock', '>', 0);
            });
        }

        switch ($request->sort) {
            case 'newest':
                $query->latest();
                break;
            case 'price_low':
                $query->orderBy('base_price');
                break;
            case 'price_high':
                $query->orderBy('base_price', 'desc');
                break;
            case 'bestseller':
                $query->bestseller();
                break;
            default:
                $query->sorted();
        }

        $products = $query->paginate(12);
        $products->appends($request->all());

        $categories = Cache::remember('categories.active', now()->addHours(6), function () {
            return Category::active()->sorted()->withCount('products')->get();
        });

        $sizes = Cache::remember('sizes.all', now()->addDay(), function () {
            return Size::sorted()->get();
        });

        $colors = Cache::remember('colors.all', now()->addDay(), function () {
            return Color::all();
        });

        $maxPrice = Product::active()->max('base_price') ?: 1850;

        return view('shop.index', compact(
            'products', 'categories', 'sizes', 'colors', 'maxPrice'
        ));
    }

    public function category(Category $category)
    {
        $products = Product::active()
            ->byCategory($category->id)
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }])
            ->sorted()
            ->paginate(12);

        $categories = Cache::remember('categories.active', now()->addHours(6), function () {
            return Category::active()->sorted()->get();
        });

        return view('shop.category', compact('products', 'categories', 'category'));
    }
}
