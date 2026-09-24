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

        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('product_images')->truncate();
        DB::table('sizes')->truncate();
        DB::table('colors')->truncate();

        $this->call([
            CategorySeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
