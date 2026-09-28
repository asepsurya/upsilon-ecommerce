<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::active()->get();

        $bundles = [
            [
                'name' => 'The Essentials Bundle',
                'slug' => 'the-essentials-bundle',
                'description' => 'A curated selection of wardrobe essentials. Perfect for the modern minimalist.',
                'thumbnail' => null,
                'bundle_price' => 4500,
                'is_active' => true,
                'sort_order' => 1,
                'product_ids' => $products->take(3)->pluck('id')->toArray(),
            ],
            [
                'name' => 'Evening Edit',
                'slug' => 'evening-edit',
                'description' => 'Sophisticated evening pieces for special occasions.',
                'thumbnail' => null,
                'bundle_price' => 5200,
                'is_active' => true,
                'sort_order' => 2,
                'product_ids' => $products->skip(2)->take(3)->pluck('id')->toArray(),
            ],
            [
                'name' => 'Atelier Collection',
                'slug' => 'atelier-collection',
                'description' => 'Our most exclusive pieces. Limited availability.',
                'thumbnail' => null,
                'bundle_price' => 8900,
                'is_active' => true,
                'sort_order' => 3,
                'product_ids' => $products->skip(4)->take(2)->pluck('id')->toArray(),
            ],
        ];

        foreach ($bundles as $bundleData) {
            $productIds = $bundleData['product_ids'];
            unset($bundleData['product_ids']);

            $bundle = Bundle::create($bundleData);

            foreach ($productIds as $index => $productId) {
                BundleItem::create([
                    'bundle_id' => $bundle->id,
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        }
    }
}
