<?php

namespace App\Core\Service;

use App\Core\Domain\Country;
use App\Core\Infra\CountryRepositoryInDatabase;
use InvalidArgumentException;

final readonly class CountryService
{
    public function __construct(private CountryRepositoryInDatabase $countryRepository) {}

    public function create(string $name, string $code): Country
    {
        $name = trim($name);
        $code = strtoupper(trim($code));
        if ($name === '' || $code === '') {
            throw new InvalidArgumentException('The country name and code cannot be empty.');
        }

        return $this->countryRepository->store($name, $code);
    }

    public function retrieveOne(int $id): ?Country
    {
        return $this->countryRepository->findById($id);
    }
}
