<?php

namespace App\Core\Infra\Contracts;

use App\Core\Domain\State;

interface StateRepository
{
    public function store(string $name, string $code, int $countryId): State;
    public function findById(int $id): ?State;
}
