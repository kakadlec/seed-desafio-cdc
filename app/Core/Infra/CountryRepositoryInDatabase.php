<?php

namespace App\Core\Infra;

use App\Core\Domain\Country;
use App\Models\Country as CountryModel;

class CountryRepositoryInDatabase implements CountryRepository
{
    public function store(string $name): Country
    {
        $country = CountryModel::create(['name' => $name]);

        return Country::reconstitute($country->id, $country->name);
    }
}
