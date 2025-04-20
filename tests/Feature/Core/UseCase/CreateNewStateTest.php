<?php

namespace Feature\Core\UseCase;

use App\Core\Service\CountryService;
use App\Core\Service\StateService;
use Tests\TestCaseWithRefreshDatabase;

class CreateNewStateTest extends TestCaseWithRefreshDatabase
{
    public function testCreateNewState(): void
    {
        $countryService = app(CountryService::class);
        $country = $countryService->create('Brazil');

        $stateService = app(StateService::class);
        $result = $stateService->create('São Paulo', $country->id);

        $this->assertIsInt($result->id);
        $this->assertEquals('São Paulo', $result->name);
        $this->assertEquals($country->id, $result->countryId);
    }
}
