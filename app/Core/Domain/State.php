<?php

declare(strict_types=1);

namespace App\Core\Domain;

use App\Core\Service\CountryService;

final readonly class State
{
    public function __construct(public int $id, public string $name, public string $code, public int $countryId)
    {
    }

    public static function reconstitute(int $id, string $name, string $code, int $countryId): self
    {
        $country = app(CountryService::class)->retrieveOne($countryId);
        if (is_null($country)) {
            throw new \InvalidArgumentException('The country does not exist.');
        }

        return new self($id, $name, $code, $countryId);
    }
}
