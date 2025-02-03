<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => fake()->unique()->numberBetween(0),
            "name" => fake()->name(),
            "email" => fake()->unique()->safeEmail(),
            "description" => fake()->text(100),
            "created_at" => fake()->dateTimeThisYear(),
        ];
    }
}

