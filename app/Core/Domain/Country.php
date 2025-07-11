<?php

declare(strict_types=1);

namespace App\Core\Domain;

final readonly class Country
{
    private function __construct(
        public int $id,
        public string $name,
        public string $code,
        /** @var State[] $states */
        public array $states
    ) {}

    public static function reconstitute(int $id, string $name, string $code, array $states = []): self
    {
        if (strlen($code) !== 3) {
            throw new \InvalidArgumentException('Country code must be 3 characters long');
        }

        return new self($id, $name, $code, $states);
    }
}
