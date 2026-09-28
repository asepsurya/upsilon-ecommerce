<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSales = FlashSale::latest()->paginate(20);

        return view('admin.flash-sales.index', compact('flashSales'));
    }

    public function create()
    {
        $products = Product::active()
            ->sorted()
            ->with('images')
            ->get(['id', 'name', 'base_price', 'sale_price']);

        return view('admin.flash-sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ends_at' => 'required|date|after:now',
            'is_active' => 'boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $flashSale = FlashSale::create($validated);

        if ($flashSale->is_active) {
            FlashSale::where('id', '!=', $flashSale->id)->update(['is_active' => false]);
        }

        if (! empty($validated['product_ids'])) {
            $flashSale->products()->sync($validated['product_ids']);
        }

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash sale created successfully');
    }

    public function edit(FlashSale $flashSale)
    {
        $products = Product::active()
            ->sorted()
            ->with('images')
            ->get(['id', 'name', 'base_price', 'sale_price']);

        return view('admin.flash-sales.edit', compact('flashSale', 'products'));
    }

    public function update(Request $request, FlashSale $flashSale)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ends_at' => 'required|date|after:now',
            'is_active' => 'boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['is_active']) {
            FlashSale::where('id', '!=', $flashSale->id)->update(['is_active' => false]);
        }

        $flashSale->update($validated);

        if (isset($validated['product_ids'])) {
            $flashSale->products()->sync($validated['product_ids']);
        } else {
            $flashSale->products()->detach();
        }

        return redirect()->route('admin.flash-sales.index')->with('success', 'Flash sale updated successfully');
    }

    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();

        return back()->with('success', 'Flash sale deleted successfully');
    }
}
