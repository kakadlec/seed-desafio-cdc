<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    public function test_create_category_endpoint_returns_successful_response()
    {
        $response = $this->postJson('/api/category', [
            'name' => 'Category Name'
        ]);

        $response->assertStatus(201);
    }
}