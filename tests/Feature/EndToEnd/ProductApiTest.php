<?php

namespace Feature\EndToEnd;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Tests\TestCaseWithRefreshDatabase;

class ProductApiTest extends TestCaseWithRefreshDatabase
{
    public function testGetProductDetailsEndpointReturnsSuccessfulResponse(): void
    {
        $book = Book::factory()
            ->for(Author::factory())
            ->for(Category::factory())
            ->create()
            ->load('author', 'category');

        $response = $this->getJson("/api/product/$book->id");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
            'summary' => $book->summary,
            'abstract' => $book->abstract,
            'book_identifier' => $book->book_identifier,
            'price' => $book->price,
            'publication_date' => $book->publication_date->format('Y-m-d'),
            'total_pages' => $book->total_pages,
            'category' => $book->category->name,
            'author' => [
                'name' => $book->author->name,
                'description' => $book->author->description
            ],
        ]);
    }
}
