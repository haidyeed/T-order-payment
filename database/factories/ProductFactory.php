<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
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
            'name' => ucfirst($this->faker->word()) . ' ' . $this->faker->unique()->numberBetween(1000, 9999),            'sku' => strtoupper(fake()->unique()->bothify('??-###')), // e.g., "AB-123"
            'price' => $this->faker->randomFloat(2, 50, 1500000), // between 50–1500000
            'order' => $this->faker->numberBetween(1, 100),
            'status' => 1,
        ];
    }
}
