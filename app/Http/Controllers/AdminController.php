<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Size;
use App\Models\User;
use App\Models\Voucher;
use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalCustomers = User::customer()->count();
        $totalProducts = Product::count();
        $revenue = Order::where('payment_status', 'paid')->sum('total');

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->limit(10)
            ->get();

        $bestSelling = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->with('product:id,name')
            ->get();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'totalCustomers',
            'totalProducts', 'revenue', 'recentOrders', 'bestSelling'
        ));
    }

    public function products(Request $request)
    {
        $query = Product::query()->with(['category', 'images', 'variants']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::active()->sorted()->get();
        $sizes = Size::sorted()->get();
        $colors = Color::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'sizes', 'colors'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'material' => 'nullable|string|max:255',
            'size_fit' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_new_arrival' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'selected_sizes' => 'nullable|array',
            'selected_sizes.*' => 'exists:sizes,id',
            'selected_colors' => 'nullable|array',
            'selected_colors.*' => 'exists:colors,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,gif,webp|max:5120',
            'variants' => 'nullable|array',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.price_override' => 'nullable|numeric|min:0',
            'variants.*.sale_price_override' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival', false);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_bestseller'] = $request->boolean('is_bestseller', false);

        unset($validated['selected_sizes'], $validated['selected_colors']);

        $product = Product::create($validated);

        $this->syncVariants($product, $request->input('variants', []));

        $this->syncProductImages($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::active()->sorted()->get();
        $sizes = Size::sorted()->get();
        $colors = Color::orderBy('name')->get();
        $product->load(['variants.size', 'variants.color', 'images']);

        return view('admin.products.edit', compact('product', 'categories', 'sizes', 'colors'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'material' => 'nullable|string|max:255',
            'size_fit' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_new_arrival' => 'boolean',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'selected_sizes' => 'nullable|array',
            'selected_sizes.*' => 'exists:sizes,id',
            'selected_colors' => 'nullable|array',
            'selected_colors.*' => 'exists:colors,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,gif,webp|max:5120',
            'variants' => 'nullable|array',
            'variants.*.size_id' => 'required|exists:sizes,id',
            'variants.*.color_id' => 'required|exists:colors,id',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.price_override' => 'nullable|numeric|min:0',
            'variants.*.sale_price_override' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival', false);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_bestseller'] = $request->boolean('is_bestseller', false);

        unset($validated['selected_sizes'], $validated['selected_colors']);

        $product->update($validated);

        $this->syncVariants($product, $request->input('variants', []));

        $this->syncProductImages($product, $request);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }

    public function getProductImages(Product $product)
    {
        $images = $product->images()->orderBy('sort_order')->orderBy('id')->get();

        return response()->json([
            'images' => $images->map(fn ($img) => [
                'id' => $img->id,
                'url' => asset($img->image),
                'is_primary' => $img->is_primary,
            ]),
        ]);
    }

    public function uploadProductImages(Request $request, Product $product)
    {
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,gif,webp|max:5120',
        ]);

        $count = 0;

        if ($request->hasFile('images')) {
            $hasPrimaryImage = $product->images()->where('is_primary', true)->exists();
            $sortOrder = $product->images()->max('sort_order') ?? 0;
            $sortOrder++;

            foreach ($request->file('images') as $image) {
                $path = $this->storeWebPImage($image, 'products');

                $product->images()->create([
                    'image' => $path,
                    'is_primary' => ! $hasPrimaryImage,
                    'sort_order' => $sortOrder,
                ]);

                $count++;
                $hasPrimaryImage = true;
                $sortOrder++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $count.' image(s) uploaded successfully',
            'count' => $count,
        ]);
    }

    public function setPrimaryImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Primary image updated successfully',
        ]);
    }

    public function deleteProductImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $wasPrimary = $image->is_primary;

        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        if ($wasPrimary && $product->images()->count() > 0 && $product->images()->where('is_primary', true)->count() === 0) {
            $product->images()->orderBy('id')->first()->update(['is_primary' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully',
        ]);
    }

    protected function storeWebPImage(UploadedFile $image, string $directory): string
    {
        Storage::disk('public')->makeDirectory($directory);

        $filename = Str::uuid()->toString().'.webp';
        $webpPath = rtrim($directory, '/').'/'.$filename;

        if ($image->getMimeType() === 'image/webp') {
            if (! $image->storeAs($directory, $filename, ['disk' => 'public'])) {
                throw new \RuntimeException('Unable to store WebP image.');
            }

            return $webpPath;
        }

        $fullWebpPath = Storage::disk('public')->path($webpPath);

        if (! Webp::make($image)->quality((int) config('laravel-webp.default_quality', 80))->save($fullWebpPath)) {
            throw new \RuntimeException('Unable to convert image to WebP.');
        }

        return $webpPath;
    }

    protected function syncProductImages(Product $product, Request $request): void
    {
        if ($request->hasFile('images')) {
            $hasPrimaryImage = $product->images()->where('is_primary', true)->exists();
            $sortOrder = $product->images()->max('sort_order') ?? 0;
            $sortOrder++;

            foreach ($request->file('images') as $image) {
                $path = $this->storeWebPImage($image, 'products');

                $product->images()->create([
                    'image' => $path,
                    'is_primary' => ! $hasPrimaryImage,
                    'sort_order' => $sortOrder,
                ]);

                $hasPrimaryImage = true;
                $sortOrder++;
            }
        }

        $deleteIds = $request->input('delete_images', []);

        if (! empty($deleteIds)) {
            foreach ($deleteIds as $imageId) {
                $img = $product->images()->find($imageId);

                if ($img) {
                    if ($img->image && Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }

                    $img->delete();
                }
            }
        }

        if ($request->filled('primary_image_id')) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $request->input('primary_image_id'))->update(['is_primary' => true]);
        }

        if ($product->images()->count() > 0 && $product->images()->where('is_primary', true)->count() === 0) {
            $product->images()->orderBy('id')->first()->update(['is_primary' => true]);
        }
    }

    public function storeSize(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $size = Size::create($validated);

        return response()->json([
            'success' => true,
            'size' => $size,
        ]);
    }

    public function storeColor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'hex_code' => 'nullable|string|max:7',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $color = Color::create($validated);

        return response()->json([
            'success' => true,
            'color' => $color,
        ]);
    }

    protected function syncVariants(Product $product, array $variants): void
    {
        if (! empty($variants)) {
            $product->variants()->delete();

            foreach ($variants as $data) {
                unset($data['id']);

                $data['is_active'] = $data['is_active'] ?? true;

                ProductVariant::create(array_merge(['product_id' => $product->id], $data));
            }
        }
    }

    public function categories(Request $request)
    {
        $categories = Category::withCount('products')->sorted()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Category::create($validated);

        return back()->with('success', 'Category created successfully');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,'.$category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }

    public function orders(Request $request)
    {
        $query = Order::query()->with(['user', 'items']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->search($search);
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $order->load(['user', 'items.product.images', 'payments', 'shipments']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,paid,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully');
    }

    public function updateTracking(Request $request, Order $order)
    {
        $validated = $request->validate([
            'tracking_number' => 'required|string|max:255',
            'shipping_courier' => 'nullable|string|max:255',
            'shipping_service' => 'nullable|string|max:255',
        ]);

        $order->update($validated);

        if (! empty($validated['tracking_number'])) {
            $order->shipments()->create([
                'courier' => $validated['shipping_courier'] ?? $order->shipping_courier,
                'service' => $validated['shipping_service'] ?? $order->shipping_service,
                'tracking_number' => $validated['tracking_number'],
                'status' => 'in_transit',
            ]);
        }

        return back()->with('success', 'Tracking updated successfully');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $validated['payment_status']]);

        if ($validated['payment_status'] === 'paid') {
            $order->update(['paid_at' => now()]);
        }

        return back()->with('success', 'Payment status updated successfully');
    }

    public function customers(Request $request)
    {
        $query = User::customer()->withCount('orders');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $customers = $query->latest()->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function updateCustomer(Request $request, User $user)
    {
        if ($user->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $user->update($validated);

        return back()->with('success', 'Customer updated successfully');
    }

    public function vouchers()
    {
        $vouchers = Voucher::withCount('orders')->latest()->get();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function createVoucher()
    {
        return view('admin.vouchers.create');
    }

    public function storeVoucher(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:vouchers,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['used_count'] = 0;

        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher created successfully');
    }

    public function editVoucher(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function updateVoucher(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:vouchers,code,'.$voucher->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher updated successfully');
    }

    public function deleteVoucher(Voucher $voucher)
    {
        $voucher->delete();

        return back()->with('success', 'Voucher deleted successfully');
    }

    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($search = $request->input('search')) {
            $query->where('review', 'like', "%{$search}%");
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateReview(Request $request, Review $review)
    {
        $validated = $request->validate([
            'is_approved' => 'boolean',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully');
    }

    public function deleteReview(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }

    public function bundles(Request $request)
    {
        $query = Bundle::query()->withCount('items');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $bundles = $query->sorted()->latest()->paginate(20);

        return view('admin.bundles.index', compact('bundles'));
    }

    public function createBundle()
    {
        $products = Product::active()->sorted()->get();

        return view('admin.bundles.create', compact('products'));
    }

    public function storeBundle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:bundles,slug',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'bundle_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'selected_products' => 'nullable|array',
            'selected_products.*' => 'exists:products,id',
            'quantities' => 'nullable|array',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Bundle::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug.'-'.$counter;
                $counter++;
            }
        }

        if ($request->hasFile('thumbnail')) {
            // Store original image
            $originalPath = $request->file('thumbnail')->store('bundles', 'public');
            $fullOriginalPath = storage_path('app/public/'.$originalPath);

            // Determine WebP path
            $webpPath = preg_replace('/\.\w+$/', '.webp', $originalPath);
            $fullWebpPath = storage_path('app/public/'.$webpPath);

            // Convert to WebP
            Webp::make($fullOriginalPath)->save($fullWebpPath);

            // Delete original file
            Storage::disk('public')->delete($originalPath);

            // Save WebP path in validated data
            $validated['thumbnail'] = $webpPath;
        }

        $bundle = Bundle::create($validated);

        $this->syncBundleItems($bundle, $request);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle created successfully');
    }

    public function editBundle(Bundle $bundle)
    {
        $products = Product::active()->sorted()->get();
        $bundle->load('items');

        return view('admin.bundles.edit', compact('bundle', 'products'));
    }

    public function updateBundle(Request $request, Bundle $bundle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:bundles,slug,'.$bundle->id,
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'bundle_price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'selected_products' => 'nullable|array',
            'selected_products.*' => 'exists:products,id',
            'quantities' => 'nullable|array',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Bundle::where('slug', $validated['slug'])->where('id', '!=', $bundle->id)->exists()) {
                $validated['slug'] = $originalSlug.'-'.$counter;
                $counter++;
            }
        }

        if ($request->hasFile('thumbnail')) {
            if ($bundle->thumbnail) {
                Storage::disk('public')->delete($bundle->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('bundles', 'public');
        }

        $bundle->update($validated);

        $this->syncBundleItems($bundle, $request);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundle updated successfully');
    }

    protected function syncBundleItems(Bundle $bundle, Request $request)
    {
        $selectedProducts = $request->input('selected_products', []);
        $quantities = $request->input('quantities', []);

        $bundle->items()->delete();

        foreach ($selectedProducts as $productId) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'product_id' => $productId,
                'quantity' => $quantities[$productId] ?? 1,
            ]);
        }
    }

    public function deleteBundle(Bundle $bundle)
    {
        if ($bundle->thumbnail) {
            Storage::disk('public')->delete($bundle->thumbnail);
        }

        $bundle->delete();

        return back()->with('success', 'Bundle deleted successfully');
    }
}
