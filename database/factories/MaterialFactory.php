<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'subtitle' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'image' => null,
            'link' => '/shop',
            'link_text' => 'Shop Now',
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
