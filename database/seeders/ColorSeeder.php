<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder as BaseSeeder;

class ColorSeeder extends BaseSeeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Black', 'slug' => 'black', 'hex_code' => '#000000'],
            ['name' => 'White', 'slug' => 'white', 'hex_code' => '#FFFFFF'],
            ['name' => 'Charcoal', 'slug' => 'charcoal', 'hex_code' => '#36454F'],
            ['name' => 'Navy', 'slug' => 'navy', 'hex_code' => '#000080'],
            ['name' => 'Beige', 'slug' => 'beige', 'hex_code' => '#F5F5DC'],
            ['name' => 'Olive', 'slug' => 'olive', 'hex_code' => '#808000'],
            ['name' => 'Burgundy', 'slug' => 'burgundy', 'hex_code' => '#800020'],
            ['name' => 'Cream', 'slug' => 'cream', 'hex_code' => '#FFFDD0'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
