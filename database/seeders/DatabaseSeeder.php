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
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('sizes')->truncate();
        DB::table('colors')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            CategorySeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
