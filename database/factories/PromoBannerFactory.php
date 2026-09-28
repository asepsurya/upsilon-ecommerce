<?php

namespace Database\Factories;

use App\Models\PromoBanner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PromoBanner>
 */
class PromoBannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'heading' => fake()->word(),
            'title' => fake()->sentence(4),
            'image' => null,
            'link' => fake()->url(),
            'link_text' => 'Shop Now',
            'background_color' => fake()->randomElement(['#1C3545', '#FFFFFF', '#000000']),
            'text_color' => fake()->randomElement(['#FFFFFF', '#000000']),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
