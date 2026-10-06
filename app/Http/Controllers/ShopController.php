<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Label;
use App\Models\Product;
use App\Models\PromoBanner;
use App\Models\Setting;
use App\Models\Size;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }, 'category', 'reviews', 'labels'])
            ->withCount('reviews');

        if ($request->search) {
            $query->search($request->search);
        }

        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->label) {
            $query->whereHas('labels', function ($q) use ($request) {
                $q->where('slug', $request->label);
            });
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
            return Color::withCount(['variants' => function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('is_active', true);
                })->where('is_active', true);
            }])->get();
        });

        $labels = Cache::remember('labels.active', now()->addHours(6), function () {
            return Label::active()->sorted()->get();
        });

        $maxPrice = Product::active()->max('base_price') ?: 1850;

        $sliders = Slider::active()->get();
        $promoBanners = PromoBanner::active()->get();

        return view('shop.index', compact(
            'products', 'categories', 'sizes', 'colors', 'labels', 'maxPrice', 'sliders', 'promoBanners'
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

    public function searchSuggestions(Request $request)
    {
        $q = trim($request->get('q', ''));
        $categoryId = $request->get('category_id');

        $query = Product::active()
            ->with(['images' => function ($q) {
                $q->orderBy('sort_order')->limit(1);
            }, 'category']);

        if (! empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (! empty($q)) {
            $query->search($q);
        } else {
            $query->latest();
        }

        $currencySymbol = Setting::currencySymbol();

        $products = $query->limit(6)->get()->map(function ($p) use ($currencySymbol) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'category_name' => $p->category?->name ?? 'Streetwear',
                'price' => $currencySymbol.number_format($p->effective_price, 2),
                'original_price' => ($p->sale_price && $p->sale_price < $p->base_price) ? $currencySymbol.number_format($p->base_price, 2) : null,
                'image' => $p->image_url,
                'url' => route('product.show', $p->slug),
            ];
        });

        $categories = Cache::remember('categories.search_api', now()->addHours(6), function () {
            return Category::active()->sorted()->get(['id', 'name', 'slug']);
        });

        $labels = Cache::remember('labels.search_api', now()->addHours(6), function () {
            return Label::active()->sorted()->get(['id', 'name', 'slug']);
        });

        return response()->json([
            'query' => $q,
            'products' => $products,
            'categories' => $categories,
            'labels' => $labels,
        ]);
    }
}
