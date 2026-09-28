<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Autumn Winter Collection',
                'heading' => 'NEW SEASON',
                'description' => 'Discover the latest silhouettes crafted from the finest Italian materials.',
                'image' => 'storage/images/sample/slider-1.jpg',
                'image_mobile' => null,
                'link' => '/shop',
                'link_text' => 'Shop Now',
                'is_active' => true,
                'sort_order' => 1,
                'starts_at' => null,
                'ends_at' => null,
            ],
            [
                'title' => 'Bespoke Tailoring',
                'heading' => 'ATELIER TAILORING',
                'description' => 'Sculptural silhouettes meticulously crafted from double-faced Italian cashmere.',
                'image' => 'storage/images/sample/slider-2.jpg',
                'image_mobile' => null,
                'link' => '/shop',
                'link_text' => 'Explore',
                'is_active' => true,
                'sort_order' => 2,
                'starts_at' => null,
                'ends_at' => null,
            ],
            [
                'title' => 'Limited Edition',
                'heading' => 'EXCLUSIVE DROPS',
                'description' => 'Limited edition pieces. Each one numbered. Each one unique.',
                'image' => 'storage/images/sample/slider-3.jpg',
                'image_mobile' => null,
                'link' => '/shop',
                'link_text' => 'View Collection',
                'is_active' => true,
                'sort_order' => 3,
                'starts_at' => null,
                'ends_at' => null,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
