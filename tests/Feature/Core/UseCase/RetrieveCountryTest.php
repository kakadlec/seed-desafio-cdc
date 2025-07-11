<?php

namespace Feature\Core\UseCase;

use App\Core\Service\CountryService;
use App\Models\Country;
use App\Models\State;
use InvalidArgumentException;
use Tests\TestCaseWithRefreshDatabase;

class RetrieveCountryTest extends TestCaseWithRefreshDatabase
{
    public function testRetrieveCountryWithoutState(): void
    {
        $country = Country::factory()->create(['name' => 'Brazil', 'code' => 'BRA']);

        $service = app(CountryService::class);
        $result = $service->retrieveOne($country->id);

        $this->assertIsInt($result->id);
        $this->assertEquals('Brazil', $result->name);
        $this->assertEquals('BRA', $result->code);
    }

    public function testRetrieveCountryWithStates(): void
    {
        $country = Country::factory()->create(['name' => 'Brazil', 'code' => 'BRA']);

        State::factory(1)->for($country)->create();

        $service = app(CountryService::class);
        $result = $service->retrieveOne($country->id);

        $this->assertIsInt($result->id);
        $this->assertEquals('Brazil', $result->name);
        $this->assertEquals('BRA', $result->code);
        $this->assertCount(1, $result->states);
    }
}
