<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Database\Seeder;

class FlashSaleSeeder extends Seeder
{
    public function run(): void
    {
        $flashSale = FlashSale::create([
            'title' => 'Limited Pairs Only',
            'subtitle' => 'Ends in',
            'description' => 'Exclusive flash sale on selected premium products. Limited quantities available.',
            'ends_at' => now()->addDays(3),
            'is_active' => true,
        ]);

        $products = Product::active()->get()->take(5);

        foreach ($products as $index => $product) {
            $flashSale->products()->attach($product->id, ['sort_order' => $index + 1]);
        }
    }
}
