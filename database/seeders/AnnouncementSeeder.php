<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::create([
            'title' => 'Special Offer',
            'message' => 'Free shipping on all orders over $100',
            'code' => 'FREESHIP100',
            'type' => 'promo',
            'animation' => 'slide',
            'duration' => 6000,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Announcement::create([
            'title' => 'New Collection',
            'message' => 'Discover our latest Autumn Winter 2025 collection now available',
            'link' => '/shop',
            'link_text' => 'Shop Now',
            'type' => 'info',
            'animation' => 'typewriter',
            'duration' => 8000,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Announcement::create([
            'message' => 'Limited time: Use code HEALTH10 for 10% off your first order',
            'code' => 'HEALTH10',
            'type' => 'promo',
            'animation' => 'slide',
            'duration' => 5000,
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
