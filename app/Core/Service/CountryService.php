<?php

namespace App\Core\Service;

use App\Core\Domain\Country;
use App\Core\Infra\CountryRepositoryInDatabase;
use InvalidArgumentException;

final readonly class CountryService
{
    public function __construct(private CountryRepositoryInDatabase $countryRepository) {}

    public function create(string $name): Country
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException('The CountryModel name cannot be empty.');
        }

        return $this->countryRepository->store($name);
    }

}
