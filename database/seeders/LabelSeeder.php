<?php

namespace Database\Seeders;

use App\Models\Label;
use Illuminate\Database\Seeder;

class LabelSeeder extends Seeder
{
    public function run(): void
    {
        $labels = [
            [
                'name' => 'Bespoke',
                'slug' => 'bespoke',
                'image' => null,
                'color' => '#1C3545',
                'text_color' => '#FFFFFF',
                'style' => 'badge',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Runway',
                'slug' => 'runway',
                'image' => null,
                'color' => '#000000',
                'text_color' => '#FFFFFF',
                'style' => 'badge',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Sustainable',
                'slug' => 'sustainable',
                'image' => null,
                'color' => '#2D6A4F',
                'text_color' => '#FFFFFF',
                'style' => 'badge',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Limited Edition',
                'slug' => 'limited-edition',
                'image' => null,
                'color' => '#7B2D8E',
                'text_color' => '#FFFFFF',
                'style' => 'badge',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Archive',
                'slug' => 'archive',
                'image' => null,
                'color' => '#5C4033',
                'text_color' => '#FFFFFF',
                'style' => 'badge',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($labels as $label) {
            Label::create($label);
        }
    }
}
