<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCaseWithRefreshDatabase;

class CategoryApiTest extends TestCaseWithRefreshDatabase
{
    public function testCreateCategoryEndpointReturnsSuccessfulResponse(): void
    {
        $response = $this->postJson('/api/category', [
            'name' => 'Category Name'
        ]);

        $response->assertStatus(200);
    }
}
