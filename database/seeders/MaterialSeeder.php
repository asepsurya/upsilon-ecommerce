<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'title' => 'Premium Leather',
                'subtitle' => 'Crafted to Last',
                'description' => 'Full-grain leather that molds to your feet over time. Durable, breathable, and always in style — built for daily wear.',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Shop Leather',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Engineered Mesh',
                'subtitle' => 'Breathe Easy',
                'description' => 'Lightweight engineered mesh keeps your feet cool on the move. Flexible, airy, and perfect for warm days.',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Shop Mesh',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Knit & Textile',
                'subtitle' => 'Flexible Fit',
                'description' => 'Soft knit uppers wrap around your foot for a sock-like feel. Stretch where you need it, support where it counts.',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Shop Knit',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Classic Suede',
                'subtitle' => 'Retro Touch',
                'description' => 'Timeless suede with a velvety finish. A premium texture that instantly upgrades any casual outfit.',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Shop Suede',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
