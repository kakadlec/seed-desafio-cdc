<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => fake()->unique()->numberBetween(),
            "author" => fake()->name(),
            "category" => fake()->domainWord(),
            "title" => fake()->text(100),
            "summary" => fake()->text(),
            "abstract" => fake()->text(100),
            "price" => fake()->randomFloat(4,0,10000),
            "total_pages" => fake()->numberBetween(0, 5000),
            "book_identifier" => fake()->uuid(),
            "publication_date" => fake()->dateTimeThisYear(),
        ];
    }
}

