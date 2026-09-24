<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{category:slug}', [ShopController::class, 'category'])->name('shop.category');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::post('/product/{product:slug}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/merge', [CartController::class, 'merge'])->name('cart.merge');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist')->middleware('auth');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/about', [HomepageController::class, 'about'])->name('about');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Auth routes
Route::get('/login', [AccountController::class, 'showLogin'])->name('login');
Route::post('/login', [AccountController::class, 'login'])->middleware('throttle:login');
Route::get('/register', [AccountController::class, 'showRegister'])->name('register');
Route::post('/register', [AccountController::class, 'register']);
Route::post('/logout', [AccountController::class, 'logout'])->name('logout')->middleware('auth');

// Customer account routes
Route::prefix('/account')->middleware('auth')->group(function () {
    Route::get('/', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::patch('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/orders/{order}', [AccountController::class, 'orderDetail'])->name('account.order-detail');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::get('/addresses/create', [AccountController::class, 'createAddress'])->name('account.addresses.create');
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('account.addresses.store');
    Route::get('/addresses/{address}/edit', [AccountController::class, 'editAddress'])->name('account.addresses.edit');
    Route::patch('/addresses/{address}', [AccountController::class, 'updateAddress'])->name('account.addresses.update');
    Route::delete('/addresses/{address}', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');
    Route::patch('/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
});

// Admin routes
Route::prefix('/admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Products
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::patch('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.destroy');

    // Sizes & Colors (AJAX)
    Route::post('/sizes', [AdminController::class, 'storeSize'])->name('admin.sizes.store');
    Route::post('/colors', [AdminController::class, 'storeColor'])->name('admin.colors.store');

    // Product Images (AJAX)
    Route::get('/products/{product}/images', [AdminController::class, 'getProductImages'])->name('admin.products.images.index');
    Route::post('/products/{product}/images', [AdminController::class, 'uploadProductImages'])->name('admin.products.images.upload');
    Route::post('/products/{product}/images/{image}/primary', [AdminController::class, 'setPrimaryImage'])->name('admin.products.images.primary');
    Route::delete('/products/{product}/images/{image}', [AdminController::class, 'deleteProductImage'])->name('admin.products.images.delete');

    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories.index');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::patch('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.destroy');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminController::class, 'orderDetail'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update-status');
    Route::patch('/orders/{order}/tracking', [AdminController::class, 'updateTracking'])->name('admin.orders.update-tracking');
    Route::patch('/orders/{order}/payment', [AdminController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment');

    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers.index');
    Route::patch('/customers/{user}', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');

    // Vouchers
    Route::get('/vouchers', [AdminController::class, 'vouchers'])->name('admin.vouchers.index');
    Route::get('/vouchers/create', [AdminController::class, 'createVoucher'])->name('admin.vouchers.create');
    Route::post('/vouchers', [AdminController::class, 'storeVoucher'])->name('admin.vouchers.store');
    Route::get('/vouchers/{voucher}/edit', [AdminController::class, 'editVoucher'])->name('admin.vouchers.edit');
    Route::patch('/vouchers/{voucher}', [AdminController::class, 'updateVoucher'])->name('admin.vouchers.update');
    Route::delete('/vouchers/{voucher}', [AdminController::class, 'deleteVoucher'])->name('admin.vouchers.destroy');

    // Reviews
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('admin.reviews.index');
    Route::patch('/reviews/{review}', [AdminController::class, 'updateReview'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('admin.reviews.destroy');

    // Bundles
    Route::get('/bundles', [AdminController::class, 'bundles'])->name('admin.bundles.index');
    Route::get('/bundles/create', [AdminController::class, 'createBundle'])->name('admin.bundles.create');
    Route::post('/bundles', [AdminController::class, 'storeBundle'])->name('admin.bundles.store');
    Route::get('/bundles/{bundle}/edit', [AdminController::class, 'editBundle'])->name('admin.bundles.edit');
    Route::patch('/bundles/{bundle}', [AdminController::class, 'updateBundle'])->name('admin.bundles.update');
    Route::delete('/bundles/{bundle}', [AdminController::class, 'deleteBundle'])->name('admin.bundles.destroy');
});
