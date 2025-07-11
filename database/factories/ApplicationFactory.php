<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            "approved_at" => fake()->dateTime()
        ]);
    }

    public function completed(): static
    {
        return $this->approved()->state(fn(array $attributes) => [
            "completed_at" => fake()->dateTime()
        ]);
    }
}
