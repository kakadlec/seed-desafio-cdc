<?php

namespace Feature\Core\UseCase;

use App\Core\Service\CountryService;
use Tests\TestCaseWithRefreshDatabase;

class CreateNewCountryTest extends TestCaseWithRefreshDatabase
{
    public function testCreateNewCountry(): void
    {
        $service = app(CountryService::class);
        $result = $service->create('Brazil');

        $this->assertIsInt($result->id);
        $this->assertEquals('Brazil', $result->name);
    }
}
