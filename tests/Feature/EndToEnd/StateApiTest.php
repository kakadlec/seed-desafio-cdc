<?php

namespace Feature\EndToEnd;

use App\Models\Country;
use Tests\TestCaseWithRefreshDatabase;

class StateApiTest extends TestCaseWithRefreshDatabase
{
    public function testCreateCountryEndpointReturnsSuccessfulResponse(): void
    {
        $response = $this->postJson('/api/country', [
            'name' => 'Brazil'
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'id' => 1,
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
