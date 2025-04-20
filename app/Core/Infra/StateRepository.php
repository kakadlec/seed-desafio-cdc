<?php

namespace App\Core\Infra;

use App\Core\Domain\State;

interface StateRepository
{
    public function store(string $name, int $countryId): State;
    public function findById(int $id): ?State;
}
