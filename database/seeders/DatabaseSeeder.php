<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends BaseSeeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@upsilon.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'is_admin' => true]
        );
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password')]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('product_images')->truncate();
        DB::table('review_images')->truncate();
        DB::table('reviews')->truncate();
        DB::table('cart_items')->truncate();
        DB::table('order_items')->truncate();
        DB::table('wishlists')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('label_product')->truncate();
        DB::table('flash_sale_product')->truncate();
        DB::table('bundle_items')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('sizes')->truncate();
        DB::table('colors')->truncate();
        DB::table('sliders')->truncate();
        DB::table('flash_sales')->truncate();
        DB::table('promo_banners')->truncate();
        DB::table('labels')->truncate();
        DB::table('announcements')->truncate();
        DB::table('settings')->truncate();
        DB::table('bundles')->truncate();
        DB::table('vouchers')->truncate();
        DB::table('size_guides')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            CategorySeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            SizeGuideSeeder::class,
            ProductSeeder::class,
            ProductSalePriceSeeder::class,
            AnnouncementSeeder::class,
            SliderSeeder::class,
            FlashSaleSeeder::class,
            PromoBannerSeeder::class,
            LabelSeeder::class,
            SettingSeeder::class,
            BundleSeeder::class,
            VoucherSeeder::class,
        ]);
    }
}
