<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSalePriceSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::active()->get();

        $salePrices = [
            0 => 280.00,
            1 => 150.00,
            2 => 420.00,
            3 => 85.00,
            4 => 650.00,
        ];

        foreach ($salePrices as $index => $salePrice) {
            if (isset($products[$index])) {
                $product = $products[$index];
                if ($salePrice < $product->base_price) {
                    $product->update(['sale_price' => $salePrice]);
                }
            }
        }

        // Set remaining products without sale_price to null explicitly
        $products->skip(count($salePrices))->each(function ($product) {
            if ($product->sale_price !== null) {
                $product->update(['sale_price' => null]);
            }
        });
    }
}
