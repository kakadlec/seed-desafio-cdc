<?php

namespace App\Core\Infra;

use App\Core\Domain\State;
use App\Core\Infra\Contracts\StateRepository;
use App\Models\State as StateModel;

class StateRepositoryInDatabase implements StateRepository
{
    public function store(string $name, string $code, int $countryId): State
    {
        $result = StateModel::create(['name' => $name, 'code' => $code, 'country_id' => $countryId]);

        return State::reconstitute($result->id, $result->name, $result->code, $result->country_id);
    }

    public function findById(int $id): ?State
    {
        $result = StateModel::where('id', $id)->first();

        return $result ? State::reconstitute($result->id, $result->name, $result->code, $result->countryId) : null;
    }
}
