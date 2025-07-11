<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosting>
 */
class JobPostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => fake()->jobTitle(),
            "description" => fake()->paragraph(),
            "salary" => fake()->randomNumber(),
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            "published_at" => fake()->dateTime()
        ]);
    }
}
