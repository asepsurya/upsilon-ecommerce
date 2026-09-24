<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder as BaseSeeder;

class CategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tailoring',
                'slug' => 'tailoring',
                'description' => '18 Silhouettes',
                'image' => 'storage/images/sample/category-tailoring.jpg',
                'count_label' => 'Silhouettes',
                'product_count' => 18,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Eveningwear',
                'slug' => 'eveningwear',
                'description' => '24 Styles',
                'image' => 'storage/images/sample/category-eveningwear.jpg',
                'count_label' => 'Styles',
                'product_count' => 24,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Outerwear',
                'slug' => 'outerwear',
                'description' => '14 Masterpieces',
                'image' => 'storage/images/sample/category-outerwear.jpg',
                'count_label' => 'Masterpieces',
                'product_count' => 14,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Knitwear',
                'slug' => 'knitwear',
                'description' => '12 Compositions',
                'image' => 'storage/images/sample/category-knitwear.jpg',
                'count_label' => 'Compositions',
                'product_count' => 12,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Leather Goods',
                'slug' => 'leather-goods',
                'description' => '16 Objects',
                'image' => 'storage/images/sample/category-leather.jpg',
                'count_label' => 'Objects',
                'product_count' => 16,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Fine Jewelry',
                'slug' => 'fine-jewelry',
                'description' => '9 Artefacts',
                'image' => 'storage/images/sample/category-jewelry.jpg',
                'count_label' => 'Artefacts',
                'product_count' => 9,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
