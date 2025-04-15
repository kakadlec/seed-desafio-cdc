<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_returns_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}