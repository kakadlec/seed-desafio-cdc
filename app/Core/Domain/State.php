<?php

declare(strict_types=1);

namespace App\Core\Domain;

final readonly class State
{
    private function __construct(public int $id, public string $name, public string $code, public int $countryId)
    {
    }

    public static function reconstitute(int $id, string $name, string $code, int $countryId): self
    {
        if (strlen($code) !== 2) {
            throw new \InvalidArgumentException('State code must be 2 characters long');
        }

        return new self($id, $name, $code, $countryId);
    }
}
