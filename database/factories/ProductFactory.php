<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['Informatique', 'Maison', 'Sport', 'Jouet', 'Livre']),
            'price' => $this->faker->randomFloat(2, 5, 500),
        ];
    }
}
