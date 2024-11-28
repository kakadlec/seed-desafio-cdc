<?php

declare(strict_types=1);

namespace App\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Infra\AuthorRepository;
use Illuminate\Validation\ValidationException;

class CreateNewAuthor
{
    public function __construct(private readonly AuthorRepository $authorRepository)
    {
    }

    /**
     * @throws ValidationException
     */
    public function execute(AuthorRequestDTO $authorDTO): array
    {
        $author = new Author($authorDTO->name, $authorDTO->email, $authorDTO->description);
        $this->authorRepository->store($author);

        return $author->toArray();
    }
}
