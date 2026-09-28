<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'FREE SHIPPING NATIONWIDE',
            'message' => 'Next day & standard delivery*',
            'code' => null,
            'link' => null,
            'link_text' => null,
            'type' => 'promo',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 1,
            'starts_at' => null,
            'ends_at' => null,
        ]);

        Announcement::create([
            'title' => 'ASICS GEL-CUMULUS',
            'message' => 'Where comfort pursues us',
            'code' => null,
            'link' => null,
            'link_text' => null,
            'type' => 'info',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 2,
            'starts_at' => null,
            'ends_at' => null,
        ]);

        Announcement::create([
            'title' => 'CLICK AND COLLECT',
            'message' => 'Available in web & app',
            'code' => null,
            'link' => null,
            'link_text' => null,
            'type' => 'info',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 3,
            'starts_at' => null,
            'ends_at' => null,
        ]);

        Announcement::create([
            'title' => 'NEW ARRIVALS',
            'message' => 'Just landed — fresh picks',
            'code' => null,
            'link' => null,
            'link_text' => null,
            'type' => 'info',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 4,
            'starts_at' => null,
            'ends_at' => null,
        ]);

        Announcement::create([
            'title' => 'FLASH SALE',
            'message' => 'Up to 70% off — today only',
            'code' => 'FLASH70',
            'link' => '/shop',
            'link_text' => 'Shop Now',
            'type' => 'promo',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 5,
            'starts_at' => now()->subHours(2),
            'ends_at' => now()->addHours(22),
        ]);
    }
}
