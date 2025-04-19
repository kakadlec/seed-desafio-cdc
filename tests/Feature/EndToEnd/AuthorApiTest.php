<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCaseWithRefreshDatabase;

class AuthorApiTest extends TestCaseWithRefreshDatabase
{
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
