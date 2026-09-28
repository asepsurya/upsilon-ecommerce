<?php

namespace Database\Seeders;

use App\Models\PromoBanner;
use Illuminate\Database\Seeder;

class PromoBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'heading' => 'SALE',
                'title' => 'Up to 50% off selected styles',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Shop Sale',
                'background_color' => '#000000',
                'text_color' => '#FFFFFF',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'heading' => 'NEW ARRIVALS',
                'title' => 'Just landed — fresh picks from the atelier',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Discover More',
                'background_color' => '#1C3545',
                'text_color' => '#FFFFFF',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'heading' => 'FREE SHIPPING',
                'title' => 'On all orders over $200 — nationwide delivery',
                'image' => null,
                'link' => '/shop',
                'link_text' => 'Start Shopping',
                'background_color' => '#FFFFFF',
                'text_color' => '#000000',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $banner) {
            PromoBanner::create($banner);
        }
    }
}
