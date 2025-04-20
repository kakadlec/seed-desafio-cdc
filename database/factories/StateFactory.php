<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeBR = \Faker\Factory::create('pt_BR');

        return [
            "name" => $fakeBR->state(),
            "code" => $fakeBR->stateAbbr(),
            "country_id" => Country::factory()
        ];
    }
}
