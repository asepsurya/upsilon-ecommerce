<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        $xml = Cache::remember('sitemap.xml', now()->addDay(), function () {
            $urls = [];

            $urls[] = ['url' => route('home'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'daily', 'priority' => '1.0'];
            $urls[] = ['url' => route('shop'), 'lastmod' => now()->toAtomString(), 'changefreq' => 'daily', 'priority' => '0.9'];

            foreach (Category::active()->sorted()->get() as $category) {
                $urls[] = ['url' => route('shop.category', $category->slug), 'lastmod' => $category->updated_at?->toAtomString() ?? now()->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.8'];
            }

            foreach (Product::active()->with('category')->get() as $product) {
                $urls[] = ['url' => route('product.show', $product), 'lastmod' => $product->updated_at->toAtomString(), 'changefreq' => 'weekly', 'priority' => '0.9'];
            }

            return view('sitemap.index', compact('urls'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
