<?php

namespace Tests\Feature\EndToEnd;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateAuthorEndpointReturnsSuccessfulResponse(): void
    {
        $response = $this->postJson('/api/author', [
            'name' => 'Author Name',
            'email' => 'author@example.com',
            'description' => 'Author description'
        ]);

        $response->assertStatus(200);
    }
}
