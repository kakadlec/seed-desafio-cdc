<?php

namespace Feature\EndToEnd;

use App\Models\Country;
use Tests\TestCaseWithRefreshDatabase;

class CountryApiTest extends TestCaseWithRefreshDatabase
{
    public function testCreateCountryEndpointReturnsSuccessfulResponse(): void
    {
        $response = $this->postJson('/api/country', [
            'name' => 'Brazil'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'id' => $response->json('id'),
            'name' => 'Brazil'
        ]);
    }

    public function testCreateCountryEndpointReturnsUnsuccessfulResponseWhenDuplicated(): void
    {
        Country::factory()->create(['name' => 'Brazil']);
        $response = $this->postJson('/api/country', [
            'name' => 'Brazil'
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name' => 'The name has already been taken.']);
    }
}
