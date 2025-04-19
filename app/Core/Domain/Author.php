<?php

declare(strict_types=1);

namespace App\Core\Domain;

use DateTimeImmutable;

class Author
{
    private int $id;
    private DateTimeImmutable $createdAt;

    public static function createWithId(
        int $id,
        string $name,
        string $email,
        string $description,
        \DateTimeImmutable $createdAt
    ): self
    {
        $author = new self($name, $email, $description);
        $author->id = $id;
        $author->createdAt = $createdAt;

        return $author;
    }

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $description
    ) {
        $this->createdAt  = new DateTimeImmutable();
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id ?? null,
            "name" => $this->name,
            "email" => $this->email,
            "description" => $this->description,
            "created_at" => $this->createdAt,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
