<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class BookApiTest extends TestCase
{
    public function test_create_book_endpoint_returns_successful_response()
    {
        $response = $this->postJson('/api/book', [
            'title' => 'Book Title',
            'author_id' => 1,
            'category_id' => 1,
            'price' => 19.99
        ]);

        $response->assertStatus(201);
    }

    public function test_retrieve_book_by_id_endpoint_returns_successful_response()
    {
        $response = $this->getJson('/api/book/1');

        $response->assertStatus(200);
    }

    public function test_retrieve_books_endpoint_returns_successful_response()
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200);
    }
}