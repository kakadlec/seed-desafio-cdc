<?php

namespace App\Core\Infra;

use App\Core\Domain\Country;

interface CountryRepository
{
    public function store(string $name, string $code): Country;
    public function findById(int $id): ?Country;
}
