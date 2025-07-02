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
        $categories = ['Électronique', 'Vêtements', 'Alimentation', 'Maison', 'Jardin'];

        return [
            'title' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement($categories),
            'price' => $this->faker->randomFloat(2, 5, 500),
             'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
