<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder as BaseSeeder;

class SizeSeeder extends BaseSeeder
{
    public function run(): void
    {
        $sizes = [
            ['name' => 'S', 'slug' => 's', 'sort_order' => 1],
            ['name' => 'M', 'slug' => 'm', 'sort_order' => 2],
            ['name' => 'L', 'slug' => 'l', 'sort_order' => 3],
            ['name' => 'XL', 'slug' => 'xl', 'sort_order' => 4],
            ['name' => 'XXL', 'slug' => 'xxl', 'sort_order' => 5],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
