<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
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
            "author_id" => Author::factory(),
            "category_id" => Category::factory(),
            "title" => fake()->text(100),
            "summary" => fake()->text(),
            "abstract" => fake()->text(100),
            "price" => fake()->randomFloat(2,0,10000),
            "total_pages" => fake()->numberBetween(0, 5000),
            "book_identifier" => fake()->uuid(),
            "publication_date" => fake()->dateTimeThisYear(),
        ];
    }
}

