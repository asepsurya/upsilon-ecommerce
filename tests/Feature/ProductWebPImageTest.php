<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductWebPImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_image_upload_converts_png_to_web_p(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        $product = Product::create([
            'name' => 'WebP Product',
            'slug' => 'webp-product',
            'base_price' => 100,
            'is_active' => true,
        ]);
        $image = new UploadedFile(
            public_path('images/logo-white.png'),
            'logo.png',
            'image/png',
            null,
            true,
        );

        $response = $this->actingAs($admin)->post(route('admin.products.images.upload', $product), [
            'images' => [$image],
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);

        $storedImage = $product->images()->firstOrFail();
        $storedPath = Storage::disk('public')->path($storedImage->image);

        $this->assertStringStartsWith('storage/products/', $storedImage->image);
        $this->assertStringEndsWith('.webp', $storedImage->image);
        $this->assertSame('image/webp', mime_content_type($storedPath));
        $this->assertTrue($storedImage->is_primary);
    }

    public function test_product_creation_stores_uploaded_images_as_web_p(): void
    {
        Storage::fake('public');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true,
        ]);
        $image = new UploadedFile(
            public_path('images/logo-white.png'),
            'logo.png',
            'image/png',
            null,
            true,
        );

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Created Product',
            'slug' => 'created-product',
            'category_id' => $category->id,
            'base_price' => 100,
            'images' => [$image],
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $product = Product::where('slug', 'created-product')->firstOrFail();
        $storedImage = $product->images()->firstOrFail();
        $storedPath = Storage::disk('public')->path($storedImage->image);

        $this->assertStringEndsWith('.webp', $storedImage->image);
        $this->assertSame('image/webp', mime_content_type($storedPath));
    }
}
