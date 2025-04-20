<?php

declare(strict_types=1);

namespace App\Core\Domain;

final readonly class Country
{
    private function __construct(public int $id, public string $name) {}

    public static function reconstitute(int $id, string $name): self
    {
        return new self($id, $name);
    }
}
