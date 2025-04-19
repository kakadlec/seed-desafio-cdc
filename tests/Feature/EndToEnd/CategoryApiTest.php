<?php

namespace Tests\Feature\EndToEnd;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCategoryEndpointReturnsSuccessfulResponse(): void
    {
        $response = $this->postJson('/api/category', [
            'name' => 'Category Name'
        ]);

        $response->assertStatus(200);
    }
}
