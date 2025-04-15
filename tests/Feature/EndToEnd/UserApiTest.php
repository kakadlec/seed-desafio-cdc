<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class UserApiTest extends TestCase
{
    public function test_user_endpoint_returns_successful_response()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(200);
    }
}