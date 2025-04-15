<?php

namespace Tests\Feature\EndToEnd;

use Tests\TestCase;

class PhpInfoTest extends TestCase
{
    public function test_phpinfo_page_returns_successful_response()
    {
        $response = $this->get('/phpinfo');

        $response->assertStatus(200);
    }
}