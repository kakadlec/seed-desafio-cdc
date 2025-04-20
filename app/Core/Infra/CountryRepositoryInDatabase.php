<?php

namespace App\Core\Infra;

use App\Core\Domain\Country;
use App\Models\Country as CountryModel;

class CountryRepositoryInDatabase implements CountryRepository
{
    public function store(string $name): Country
    {
        $result = CountryModel::create(['name' => $name]);

        return Country::reconstitute($result->id, $result->name);
    }

    public function findById(int $id): ?Country
    {
        $result = CountryModel::where('id', $id)->first();

        return $result ? Country::reconstitute($result->id, $result->name) : null;
    }
}
