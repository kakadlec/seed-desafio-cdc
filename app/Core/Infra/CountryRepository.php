<?php

namespace App\Core\Infra;

use App\Core\Domain\Country;

interface CountryRepository
{
    public function store(string $name): Country;
}
