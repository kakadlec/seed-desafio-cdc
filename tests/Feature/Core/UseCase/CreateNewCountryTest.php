<?php

namespace Feature\Core\UseCase;

use App\Core\Service\CountryService;
use Tests\TestCaseWithRefreshDatabase;
use InvalidArgumentException;

class CreateNewCountryTest extends TestCaseWithRefreshDatabase
{
    public function testCreateNewCountry(): void
    {
        $service = app(CountryService::class);
        $result = $service->create('Brazil', 'BR');

        $this->assertIsInt($result->id);
        $this->assertEquals('Brazil', $result->name);
    }

    public function testCreateCountryWhenMissingValuesShouldThrow(): void
    {
        $service = app(CountryService::class);

        $this->expectException(InvalidArgumentException::class);
        $service->create('Brazil', '');
    }
}
