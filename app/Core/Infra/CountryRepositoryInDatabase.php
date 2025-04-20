<?php

namespace App\Core\Infra;

use App\Core\Domain\Country;
use App\Core\Domain\State;
use App\Models\Country as CountryModel;

class CountryRepositoryInDatabase implements CountryRepository
{
    public function store(string $name, string $code): Country
    {
        $result = CountryModel::create(['name' => $name, 'code' => $code]);

        return Country::reconstitute($result->id, $result->name, $result->code);
    }

    public function findById(int $id): ?Country
    {
        $result = CountryModel::with('states')->find($id);

        if (!$result) {
            return null;
        }

        $states = array_map(
            fn($state) => State::reconstitute(
                $state->id,
                $state->name,
                $state->code,
                $state->country_id
            ),
            $result->states->all()
        );

        return Country::reconstitute($result->id, $result->name, $result->code, $states);
    }
}
