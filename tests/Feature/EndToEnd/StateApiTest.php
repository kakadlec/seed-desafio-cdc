<?php

namespace Feature\EndToEnd;

use App\Models\Country;
use Tests\TestCaseWithRefreshDatabase;

class StateApiTest extends TestCaseWithRefreshDatabase
{
    public function testCreateCountryEndpointReturnsSuccessfulResponse(): void
    {
        $country = $this->postJson('/api/country', [
            'name' => 'Brazil'
        ]);

        $response = $this->postJson('/api/state', [
            'name' => 'Paraná',
            'country_id' => $country->json('id')
        ]);


        $response->assertStatus(201);
        $response->assertJson([
            'id' => $response->json('id'),
            'state' => 'Paraná',
            'country_id' => $country->json('id')
        ]);
    }
}
