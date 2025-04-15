<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    public function test_create_author_endpoint_returns_successful_response()
    {
        $response = $this->postJson('/api/author', [
            'name' => 'Author Name',
            'email' => 'author@example.com'
        ]);

        $response->assertStatus(201);
    }
}