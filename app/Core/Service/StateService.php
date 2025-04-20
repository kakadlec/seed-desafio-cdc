<?php

namespace App\Core\Service;

use App\Core\Domain\Country;
use App\Core\Domain\State;
use App\Core\Infra\CountryRepositoryInDatabase;
use App\Core\Infra\StateRepositoryInDatabase;
use InvalidArgumentException;

final readonly class StateService
{
    public function __construct(private StateRepositoryInDatabase $stateRepository) {}

    public function create(string $name, int $countryId): State
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException('The state name cannot be empty.');
        }

        $country = app(CountryService::class)->retrieveOne($countryId);
        if (is_null($country)) {
            throw new InvalidArgumentException('The country does not exist.');
        }

        return $this->stateRepository->store($name, $countryId);
    }

}
