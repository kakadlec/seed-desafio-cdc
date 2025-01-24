<?php

declare(strict_types=1);

namespace App\Core\Domain;

class Book
{
    private int $id;

    public function __construct(
        private readonly Author $author,
        private readonly Category $category,
        private readonly string $title,
        private readonly string $summary,
        private readonly string $abstract,
        private readonly float $price,
        private readonly int $totalPages,
        private readonly string $bookIdentifier,
        private readonly \DateTimeImmutable $publicationDate,
    )
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
            "author" => $this->author->getId(),
            "category" => $this->category->getId(),
            "title" => $this->title,
            "summary" => $this->summary,
            "abstract" => $this->abstract,
            "price" => $this->price,
            "total_pages" => $this->totalPages,
            "book_identifier" => $this->bookIdentifier,
            "publication_date" => $this->publicationDate,
        ];
    }
}
