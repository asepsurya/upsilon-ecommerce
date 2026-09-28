<?php

namespace Database\Factories;

use App\Models\FlashSale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FlashSale>
 */
class FlashSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->randomElement(['Limited Pairs Only', 'Flash Sale', 'Weekend Special']),
            'subtitle' => fake()->randomElement(['Ends in', 'Hurry!', 'Almost Gone']),
            'description' => fake()->optional()->paragraph(),
            'ends_at' => fake()->dateTimeBetween('+1 hour', '+3 days'),
            'is_active' => true,
        ];
    }
}
