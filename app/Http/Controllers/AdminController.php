<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Color;
use App\Models\Label;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductView;
use App\Models\PromoBanner;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Size;
use App\Models\SizeGuide;
use App\Models\Slider;
use App\Models\User;
use App\Models\Voucher;
use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
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
        $revenue = $totalSales;

        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalCarts = Cart::count();
        $activeCarts = Cart::whereHas('items')->count();
        $cartItems = CartItem::count();
        $abandonedCarts = Cart::whereDoesntHave('items')->orWhereHas('items', function ($q) {
            $q->where('quantity', '<=', 0);
        })->count();

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

        $mostViewed = ProductView::select('product_id', DB::raw('COUNT(*) as view_count'))
            ->groupBy('product_id')
            ->orderByDesc('view_count')
            ->limit(10)
            ->with('product:id,name,base_price,sale_price')
            ->get();

        $chartData = $this->getSalesChartData();

        $monthlySales = $this->getMonthlySalesData();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'totalCustomers',
            'totalProducts', 'revenue', 'bestSelling', 'mostViewed',
            'pendingOrders', 'processingOrders', 'shippedOrders',
            'deliveredOrders', 'cancelledOrders', 'totalCarts',
            'activeCarts', 'cartItems', 'abandonedCarts', 'chartData', 'monthlySales'
        ));
    }

    private function getSalesChartData(): array
    {
        $days = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D');
            $values[] = (float) Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        return [
            'labels' => $days,
            'values' => $values,
        ];
    }

    private function getMonthlySalesData(): array
    {
        $months = [];
        $values = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            $values[] = (float) Order::where('payment_status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');
        }

        return [
            'labels' => $months,
            'values' => $values,
        ];
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
        $labels = Label::active()->sorted()->get();

        return view('admin.products.create', compact('categories', 'sizes', 'colors', 'labels'));
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
            'label_ids' => 'nullable|array',
            'label_ids.*' => 'exists:labels,id',
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
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.price_override' => 'nullable|numeric|min:0',
            'variants.*.sale_price_override' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival', false);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_bestseller'] = $request->boolean('is_bestseller', false);

        unset($validated['selected_sizes'], $validated['selected_colors'], $validated['label_ids']);

        $product = Product::create($validated);

        $this->syncVariants($product, $request->input('variants', []));

        $this->syncProductImages($product, $request);

        if ($request->filled('label_ids')) {
            $product->labels()->sync($request->input('label_ids'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::active()->sorted()->get();
        $sizes = Size::sorted()->get();
        $colors = Color::orderBy('name')->get();
        $labels = Label::active()->sorted()->get();
        $product->load(['variants.size', 'variants.color', 'images', 'labels']);

        return view('admin.products.edit', compact('product', 'categories', 'sizes', 'colors', 'labels'));
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
            'label_ids' => 'nullable|array',
            'label_ids.*' => 'exists:labels,id',
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
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.price_override' => 'nullable|numeric|min:0',
            'variants.*.sale_price_override' => 'nullable|numeric|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_new_arrival'] = $request->boolean('is_new_arrival', false);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_bestseller'] = $request->boolean('is_bestseller', false);

        unset($validated['selected_sizes'], $validated['selected_colors'], $validated['label_ids']);

        $product->update($validated);

        $this->syncVariants($product, $request->input('variants', []));

        $this->syncProductImages($product, $request);

        if ($request->filled('label_ids')) {
            $product->labels()->sync($request->input('label_ids'));
        } else {
            $product->labels()->detach();
        }

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
                'url' => $img->url,
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
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeWebPImage($request->file('image'), 'categories');
        }

        Category::create($validated);
        Cache::forget('categories.active');

        return back()->with('success', 'Category created successfully');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,'.$category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($category->image && str_starts_with($category->image, 'categories/')) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = $this->storeWebPImage($request->file('image'), 'categories');
        }

        $category->update($validated);
        Cache::forget('categories.active');

        return back()->with('success', 'Category updated successfully');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->image && str_starts_with($category->image, 'categories/')) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        Cache::forget('categories.active');

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

    protected function updateProductRating(Product $product): void
    {
        $stats = $product->reviews()
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as review_count')
            ->first();

        $product->update([
            'average_rating' => (float) ($stats->average_rating ?? 0),
            'review_count' => (int) ($stats->review_count ?? 0),
        ]);
    }

    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'product', 'replies.user']);

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

        $this->updateProductRating($review->product);

        return back()->with('success', 'Review updated successfully');
    }

    public function deleteReview(Review $review)
    {
        $product = $review->product;
        $review->delete();

        $this->updateProductRating($product);

        return back()->with('success', 'Review deleted successfully');
    }

    public function storeReviewReply(Request $request, Review $review)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $review->replies()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        return back()->with('success', 'Reply added successfully');
    }

    public function destroyReviewReply(Review $review, ReviewReply $reply)
    {
        if ($reply->review_id !== $review->id) {
            abort(404);
        }

        $reply->delete();

        return back()->with('success', 'Reply deleted successfully');
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
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
            $validated['thumbnail'] = $this->storeWebPImage($request->file('thumbnail'), 'bundles');
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
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

            $validated['thumbnail'] = $this->storeWebPImage($request->file('thumbnail'), 'bundles');
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

    public function sliders()
    {
        $sliders = Slider::sorted()->paginate(20);

        return view('admin.sliders.index', compact('sliders'));
    }

    public function createSlider()
    {
        return view('admin.sliders.create');
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeWebPImage($request->file('image'), 'sliders');
        }

        if ($request->hasFile('image_mobile')) {
            $validated['image_mobile'] = $this->storeWebPImage($request->file('image_mobile'), 'sliders/mobile');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully');
    }

    public function editSlider(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function updateSlider(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($slider->image && str_starts_with($slider->image, 'sliders/')) {
                Storage::disk('public')->delete($slider->image);
            }

            $validated['image'] = $this->storeWebPImage($request->file('image'), 'sliders');
        }

        if ($request->hasFile('image_mobile')) {
            if ($slider->image_mobile && str_starts_with($slider->image_mobile, 'sliders/')) {
                Storage::disk('public')->delete($slider->image_mobile);
            }

            $validated['image_mobile'] = $this->storeWebPImage($request->file('image_mobile'), 'sliders/mobile');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully');
    }

    public function deleteSlider(Slider $slider)
    {
        if ($slider->image && str_starts_with($slider->image, 'sliders/')) {
            Storage::disk('public')->delete($slider->image);
        }

        if ($slider->image_mobile && str_starts_with($slider->image_mobile, 'sliders/')) {
            Storage::disk('public')->delete($slider->image_mobile);
        }

        $slider->delete();

        return back()->with('success', 'Slider deleted successfully');
    }

    public function toggleSlider(Slider $slider)
    {
        $slider->update(['is_active' => ! $slider->is_active]);

        return back()->with('success', 'Slider status updated successfully');
    }

    public function labels()
    {
        $labels = Label::sorted()->paginate(20);

        return view('admin.labels.index', compact('labels'));
    }

    public function createLabel()
    {
        return view('admin.labels.create');
    }

    public function storeLabel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:labels,slug',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'style' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeWebPImage($request->file('image'), 'labels');
        }

        Label::create($validated);
        Cache::forget('labels.active');

        return redirect()->route('admin.labels.index')->with('success', 'Label created successfully');
    }

    public function editLabel(Label $label)
    {
        return view('admin.labels.edit', compact('label'));
    }

    public function updateLabel(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:labels,slug,'.$label->id,
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'style' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($label->image && str_starts_with($label->image, 'labels/')) {
                Storage::disk('public')->delete($label->image);
            }

            $validated['image'] = $this->storeWebPImage($request->file('image'), 'labels');
        }

        $label->update($validated);
        Cache::forget('labels.active');

        return redirect()->route('admin.labels.index')->with('success', 'Label updated successfully');
    }

    public function deleteLabel(Label $label)
    {
        if ($label->image && str_starts_with($label->image, 'labels/')) {
            Storage::disk('public')->delete($label->image);
        }

        $label->delete();
        Cache::forget('labels.active');

        return back()->with('success', 'Label deleted successfully');
    }

    public function toggleLabel(Label $label)
    {
        $label->update(['is_active' => ! $label->is_active]);
        Cache::forget('labels.active');

        return back()->with('success', 'Label status updated successfully');
    }

    public function promoBanners()
    {
        $promoBanners = PromoBanner::sorted()->paginate(20);

        return view('admin.promo-banners.index', compact('promoBanners'));
    }

    public function createPromoBanner()
    {
        return view('admin.promo-banners.create');
    }

    public function storePromoBanner(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeWebPImage($request->file('image'), 'promo-banners');
        }

        PromoBanner::create($validated);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Promo banner created successfully');
    }

    public function editPromoBanner(PromoBanner $promoBanner)
    {
        return view('admin.promo-banners.edit', compact('promoBanner'));
    }

    public function updatePromoBanner(Request $request, PromoBanner $promoBanner)
    {
        $validated = $request->validate([
            'heading' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'link' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($promoBanner->image && str_starts_with($promoBanner->image, 'promo-banners/')) {
                Storage::disk('public')->delete($promoBanner->image);
            }

            $validated['image'] = $this->storeWebPImage($request->file('image'), 'promo-banners');
        }

        $promoBanner->update($validated);

        return redirect()->route('admin.promo-banners.index')->with('success', 'Promo banner updated successfully');
    }

    public function deletePromoBanner(PromoBanner $promoBanner)
    {
        if ($promoBanner->image && str_starts_with($promoBanner->image, 'promo-banners/')) {
            Storage::disk('public')->delete($promoBanner->image);
        }

        $promoBanner->delete();

        return back()->with('success', 'Promo banner deleted successfully');
    }

    public function togglePromoBanner(PromoBanner $promoBanner)
    {
        $promoBanner->update(['is_active' => ! $promoBanner->is_active]);

        return back()->with('success', 'Promo banner status updated successfully');
    }

    public function sizeGuides()
    {
        $sizeGuides = SizeGuide::orderBy('size_type')->orderBy('size_label')->get();

        return view('admin.size-guides.index', compact('sizeGuides'));
    }

    public function createSizeGuide()
    {
        return view('admin.size-guides.create');
    }

    public function storeSizeGuide(Request $request)
    {
        $validated = $request->validate([
            'size_label' => 'required|string|max:20',
            'size_type' => 'required|string|max:50',
            'chest_cm' => 'nullable|string|max:50',
            'chest_inch' => 'nullable|string|max:50',
            'waist_cm' => 'nullable|string|max:50',
            'waist_inch' => 'nullable|string|max:50',
            'hip_cm' => 'nullable|string|max:50',
            'hip_inch' => 'nullable|string|max:50',
            'shoulder_cm' => 'nullable|string|max:50',
            'sleeve_length_cm' => 'nullable|string|max:50',
            'body_length_cm' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        SizeGuide::create($validated);

        return redirect()->route('admin.size-guides.index')->with('success', 'Size guide created successfully');
    }

    public function editSizeGuide(SizeGuide $sizeGuide)
    {
        return view('admin.size-guides.edit', compact('sizeGuide'));
    }

    public function updateSizeGuide(Request $request, SizeGuide $sizeGuide)
    {
        $validated = $request->validate([
            'size_label' => 'required|string|max:20',
            'size_type' => 'required|string|max:50',
            'chest_cm' => 'nullable|string|max:50',
            'chest_inch' => 'nullable|string|max:50',
            'waist_cm' => 'nullable|string|max:50',
            'waist_inch' => 'nullable|string|max:50',
            'hip_cm' => 'nullable|string|max:50',
            'hip_inch' => 'nullable|string|max:50',
            'shoulder_cm' => 'nullable|string|max:50',
            'sleeve_length_cm' => 'nullable|string|max:50',
            'body_length_cm' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ]);

        $sizeGuide->update($validated);

        return redirect()->route('admin.size-guides.index')->with('success', 'Size guide updated successfully');
    }

    public function destroySizeGuide(SizeGuide $sizeGuide)
    {
        $sizeGuide->delete();

        return back()->with('success', 'Size guide deleted successfully');
    }

    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        $data = [
            'app_name' => $settings['app_name'] ?? config('app.name', 'Upsilon'),
            'app_url' => $settings['app_url'] ?? config('app.url', ''),
            'mail_from_address' => $settings['mail_from_address'] ?? config('mail.from.address', ''),
            'mail_from_name' => $settings['mail_from_name'] ?? config('mail.from.name', ''),
            'whatsapp_number' => $settings['whatsapp_number'] ?? config('services.whatsapp.number', ''),
            'whatsapp_default_message' => $settings['whatsapp_default_message'] ?? config('services.whatsapp.default_message', ''),
            'instagram_account_id' => $settings['instagram_account_id'] ?? config('services.instagram.account_id', ''),
            'instagram_access_token' => $settings['instagram_access_token'] ?? config('services.instagram.access_token', ''),
            'instagram_api_version' => $settings['instagram_api_version'] ?? config('services.instagram.api_version', 'v22.0'),
            'instagram_api_base_url' => $settings['instagram_api_base_url'] ?? config('services.instagram.api_base_url', 'https://graph.facebook.com'),
            'instagram_cache_ttl' => $settings['instagram_cache_ttl'] ?? config('services.instagram.cache_ttl', 3600),
        ];

        return view('admin.settings.index', compact('data'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'nullable|string|max:255',
            'app_url' => 'nullable|url|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'whatsapp_default_message' => 'nullable|string|max:1000',
            'instagram_account_id' => 'nullable|string|max:255',
            'instagram_access_token' => 'nullable|string|max:255',
            'instagram_api_version' => 'nullable|string|max:50',
            'instagram_api_base_url' => 'nullable|url|max:255',
            'instagram_cache_ttl' => 'nullable|integer|min:0',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }
}
