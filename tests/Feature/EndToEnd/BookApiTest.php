<?php

namespace Tests\Feature\EndToEnd;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Tests\TestCaseWithRefreshDatabase;

class BookApiTest extends TestCaseWithRefreshDatabase
{
    public function testCreateBookEndpointReturnsSuccessfulResponse(): void
    {
        $author = Author::factory()->create();
        $category = Category::factory()->create();

        $response = $this->postJson('/api/book', [
            'author' => $author->name,
            'category' => $category->name,
            'summary' => 'A brief summary of the book.',
            'abstract' => 'Some abstract',
            'title' => 'Book Title',
            'price' => 20.01,
            'totalPages' => 350,
            'bookIdentifier' => 'book-identifier',
            'pubDate' => '2025-10-01',
        ]);

        $response->assertStatus(200);
    }

    public function testRetrieveBookByIdEndpointReturnsSuccessfulResponse(): void
    {
        $book = Book::factory()->create();
        $response = $this->getJson("/api/book/$book->id");

        $response->assertStatus(200);
    }

    public function test_retrieve_books_endpoint_returns_successful_response(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
    }
}
