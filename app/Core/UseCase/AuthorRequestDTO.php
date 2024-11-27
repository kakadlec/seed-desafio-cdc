<?php

declare(strict_types=1);

namespace App\Core\UseCase;

readonly class AuthorRequestDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $description
    ) {}
}
