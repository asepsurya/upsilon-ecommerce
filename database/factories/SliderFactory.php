<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Slider>
 */
class SliderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'heading' => fake()->sentence(3),
            'description' => fake()->sentence(12),
            'image' => 'storage/sliders/'.fake()->uuid().'.webp',
            'link' => fake()->url(),
            'link_text' => 'Shop Now',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
            'starts_at' => null,
            'ends_at' => null,
        ];
    }
}
