<?php

declare(strict_types=1);

namespace App\Core\Domain;

class Book
{
    public int $id;

    public function __construct(
        public readonly Author $author,
        public readonly Category $category,
        public readonly string $title,
        public readonly string $summary,
        public readonly string $abstract,
        public readonly float $price,
        public readonly int $totalPages,
        public readonly string $bookIdentifier,
        public readonly \DateTimeImmutable $publicationDate,
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
            "author_id" => $this->author->getId(),
            "category_id" => $this->category->getId(),
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
