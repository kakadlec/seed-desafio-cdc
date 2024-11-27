<?php

declare(strict_types=1);

namespace App\Core\UseCase;

use App\Core\Domain\Author;
use Illuminate\Validation\ValidationException;

class CreateNewAuthor
{
    /**
     * @throws ValidationException
     */
    public function execute(AuthorRequestDTO $authorDTO): void
    {
        $author = new Author($authorDTO->name, $authorDTO->email, $authorDTO->description);

    }
}
