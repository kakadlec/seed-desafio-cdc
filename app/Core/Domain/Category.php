<?php

declare(strict_types=1);

namespace App\Core\Domain;

class Category
{
    private int $id;

    public function __construct(private readonly string $name)
    {
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id ?? null,
            "name" => $this->name
        ];
    }
}
