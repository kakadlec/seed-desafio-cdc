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

    public function create(string $name, string $code, int $countryId): State
    {
        $name = trim($name);
        $code = strtoupper(trim($code));
        if ($name === '' || $code === '') {
            throw new InvalidArgumentException('The state name and code cannot be empty.');
        }

        $country = app(CountryService::class)->retrieveOne($countryId);
        if (is_null($country)) {
            throw new InvalidArgumentException('The country does not exist.');
        }

        return $this->stateRepository->store($name, $code, $countryId);
    }

}
