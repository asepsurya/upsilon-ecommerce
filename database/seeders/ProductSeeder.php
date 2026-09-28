<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Database\Seeder as BaseSeeder;

class ProductSeeder extends BaseSeeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');
        $sizes = Size::all();
        $colors = Color::all();

        $products = [
            [
                'name' => 'Oversized Silk-Twill Trench Coat',
                'slug' => 'oversized-silk-twill-trench-coat',
                'category' => 'outerwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Pure Mulberry Silk • Como, Italy',
                'size_fit' => 'Oversized architectural fit',
                'base_price' => 3450,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 1,
                'badge' => 'Bespoke',
                'edition' => 'Edition 08/50',
                'subtitle' => 'Atelier Tailoring',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-trench.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Black', 'sku' => 'TRENCH-S-BLK', 'stock' => 10],
                    ['size' => 'M', 'color' => 'Black', 'sku' => 'TRENCH-M-BLK', 'stock' => 15],
                    ['size' => 'L', 'color' => 'Charcoal', 'sku' => 'TRENCH-L-CHR', 'stock' => 8],
                    ['size' => 'XL', 'color' => 'Navy', 'sku' => 'TRENCH-XL-NVY', 'stock' => 5],
                ],
            ],
            [
                'name' => 'Hand-Stitched Wool Blazer',
                'slug' => 'hand-stitched-wool-blazer',
                'category' => 'tailoring',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Super 160s Virgin Wool • Biella Mills',
                'size_fit' => 'Slim architectural fit',
                'base_price' => 2800,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 2,
                'badge' => 'Runway SS25',
                'edition' => 'Edition 14/40',
                'subtitle' => 'Sartorial Master',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-blazer.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Navy', 'sku' => 'BLAZER-S-NVY', 'stock' => 12],
                    ['size' => 'M', 'color' => 'Navy', 'sku' => 'BLAZER-M-NVY', 'stock' => 20],
                    ['size' => 'L', 'color' => 'Charcoal', 'sku' => 'BLAZER-L-CHR', 'stock' => 18],
                    ['size' => 'XL', 'color' => 'Black', 'sku' => 'BLAZER-XL-BLK', 'stock' => 6],
                ],
            ],
            [
                'name' => 'Pleated Silk Georgette Gown',
                'slug' => 'pleated-silk-georgette-gown',
                'category' => 'eveningwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => '100% Organic Silk • Lyon Weavers',
                'size_fit' => 'Flowing evening silhouette',
                'base_price' => 3650,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 3,
                'badge' => 'Sustainable Silk',
                'edition' => 'Edition 04/25',
                'subtitle' => 'Couture Soirée',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-gown.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Burgundy', 'sku' => 'GOWN-S-BRG', 'stock' => 5],
                    ['size' => 'M', 'color' => 'Burgundy', 'sku' => 'GOWN-M-BRG', 'stock' => 8],
                    ['size' => 'L', 'color' => 'Black', 'sku' => 'GOWN-L-BLK', 'stock' => 7],
                    ['size' => 'XL', 'color' => 'Cream', 'sku' => 'GOWN-XL-CRM', 'stock' => 4],
                ],
            ],
            [
                'name' => 'Ribbed Mongolian Turtleneck',
                'slug' => 'ribbed-mongolian-turtleneck',
                'category' => 'knitwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => '100% Loro Piana Cashmere • Biella',
                'size_fit' => 'Regular fit',
                'base_price' => 1450,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 4,
                'badge' => 'Loro Piana Yarn',
                'edition' => 'Edition 22/60',
                'subtitle' => 'Permanent Archive',
                'bottom_label' => 'Immediate Dispatch',
                'image' => 'storage/images/sample/prod-turtleneck.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Cream', 'sku' => 'TURT-S-CRM', 'stock' => 15],
                    ['size' => 'M', 'color' => 'Cream', 'sku' => 'TURT-M-CRM', 'stock' => 25],
                    ['size' => 'L', 'color' => 'Olive', 'sku' => 'TURT-L-OLV', 'stock' => 20],
                    ['size' => 'XL', 'color' => 'Charcoal', 'sku' => 'TURT-XL-CHR', 'stock' => 12],
                ],
            ],
            [
                'name' => 'Structured Italian Satin Tuxedo',
                'slug' => 'structured-italian-satin-tuxedo',
                'category' => 'tailoring',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Silk Duchesse • Milanese Atelier',
                'size_fit' => 'Slim formal fit',
                'base_price' => 4200,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 5,
                'badge' => 'Bespoke',
                'edition' => 'Edition 06/30',
                'subtitle' => 'Formal Atelier',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-tuxedo.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Black', 'sku' => 'TUX-S-BLK', 'stock' => 6],
                    ['size' => 'M', 'color' => 'Black', 'sku' => 'TUX-M-BLK', 'stock' => 10],
                    ['size' => 'L', 'color' => 'Black', 'sku' => 'TUX-L-BLK', 'stock' => 8],
                    ['size' => 'XL', 'color' => 'Navy', 'sku' => 'TUX-XL-NVY', 'stock' => 4],
                ],
            ],
            [
                'name' => 'Asymmetric Cut-Out Velvet Dress',
                'slug' => 'asymmetric-cut-out-velvet-dress',
                'category' => 'eveningwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Silk-Plush Velvet • Venice',
                'size_fit' => 'Sculpted waistline',
                'base_price' => 2950,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 6,
                'badge' => 'Runway SS25',
                'edition' => 'Edition 03/35',
                'subtitle' => 'Sculptural Nocturne',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-velvet.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Burgundy', 'sku' => 'DRESS-S-BRG', 'stock' => 7],
                    ['size' => 'M', 'color' => 'Burgundy', 'sku' => 'DRESS-M-BRG', 'stock' => 10],
                    ['size' => 'L', 'color' => 'Black', 'sku' => 'DRESS-L-BLK', 'stock' => 9],
                    ['size' => 'XL', 'color' => 'Olive', 'sku' => 'DRESS-XL-OLV', 'stock' => 3],
                ],
            ],
            [
                'name' => 'Florentine Nappa Leather Overcoat',
                'slug' => 'florentine-nappa-leather-overcoat',
                'category' => 'outerwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Vegetable-Tanned Calfskin • Florence',
                'size_fit' => 'Architectural oversized fit',
                'base_price' => 5100,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 7,
                'badge' => 'Bespoke Hide',
                'edition' => 'Edition 02/20',
                'subtitle' => 'Cuir Imperial',
                'bottom_label' => 'Includes Fitting',
                'image' => 'storage/images/sample/prod-overcoat.jpg',
                'variants' => [
                    ['size' => 'M', 'color' => 'Black', 'sku' => 'COAT-M-BLK', 'stock' => 5],
                    ['size' => 'L', 'color' => 'Black', 'sku' => 'COAT-L-BLK', 'stock' => 8],
                    ['size' => 'XL', 'color' => 'Brown', 'sku' => 'COAT-XL-BRN', 'stock' => 4],
                    ['size' => 'XXL', 'color' => 'Black', 'sku' => 'COAT-XXL-BLK', 'stock' => 2],
                ],
            ],
            [
                'name' => 'Raw Filament Cashmere Shell',
                'slug' => 'raw-filament-cashmere-shell',
                'category' => 'knitwear',
                'description' => 'Sculptural silhouettes meticulously sculpted from double-faced Italian cashmere, structured Como silk-twill, and raw wool. An uncompromising study in dark skeuomorphic precision.',
                'material' => 'Cashmere & Gold Silk • Scottish Highlands',
                'size_fit' => 'Slim sleeveless fit',
                'base_price' => 980,
                'sale_price' => null,
                'is_new_arrival' => true,
                'is_featured' => true,
                'is_bestseller' => false,
                'sort_order' => 8,
                'badge' => 'Limited 25',
                'edition' => 'Edition 11/25',
                'subtitle' => 'Knitwear Atelier',
                'bottom_label' => 'Immediate Dispatch',
                'image' => 'storage/images/sample/prod-shell.jpg',
                'variants' => [
                    ['size' => 'S', 'color' => 'Cream', 'sku' => 'SHELL-S-CRM', 'stock' => 8],
                    ['size' => 'M', 'color' => 'Cream', 'sku' => 'SHELL-M-CRM', 'stock' => 12],
                    ['size' => 'L', 'color' => 'White', 'sku' => 'SHELL-L-WHT', 'stock' => 10],
                    ['size' => 'XL', 'color' => 'Beige', 'sku' => 'SHELL-XL-BG', 'stock' => 6],
                ],
            ],
        ];

        foreach ($products as $index => $data) {
            $category = $categories->get($data['category']);
            if (! $category) {
                continue;
            }

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'material' => $data['material'],
                'size_fit' => $data['size_fit'],
                'base_price' => $data['base_price'],
                'sale_price' => $data['sale_price'],
                'is_new_arrival' => $data['is_new_arrival'],
                'is_featured' => $data['is_featured'],
                'is_bestseller' => $data['is_bestseller'],
                'sort_order' => $data['sort_order'],
                'is_active' => true,
                'badge' => $data['badge'],
                'edition' => $data['edition'],
                'subtitle' => $data['subtitle'],
                'bottom_label' => $data['bottom_label'],
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $data['image'],
                'is_primary' => true,
                'sort_order' => 1,
            ]);

            if (isset($data['variants']) && is_array($data['variants'])) {
                foreach ($data['variants'] as $variantData) {
                    $size = $sizes->firstWhere('name', $variantData['size']);
                    $color = $colors->firstWhere('name', $variantData['color']);

                    if ($size && $color) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'size_id' => $size->id,
                            'color_id' => $color->id,
                            'sku' => $variantData['sku'],
                            'stock' => $variantData['stock'],
                            'is_active' => true,
                            'unlimited_stock' => false,
                        ]);
                    }
                }
            }
        }
    }
}
