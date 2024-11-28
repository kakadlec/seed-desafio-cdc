<?php

declare(strict_types=1);

namespace App\Core\Domain;

use DateTimeImmutable;

class Author
{
    private DateTimeImmutable $createdAt;

    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $description
    ) {
        $this->createdAt  = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "description" => $this->description,
            "created_at" => $this->createdAt,
        ];
    }

}
