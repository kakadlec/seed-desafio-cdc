<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Infra\AuthorRepositoryInDatabase;
use App\Core\UseCase\AuthorRequestDTO;
use App\Core\UseCase\CreateNewAuthor;
use Tests\TestCase;


class CreateNewAuthorTest extends TestCase
{
    public function testCreateNewAuthor(): void
    {
        $authorRepository = new AuthorRepositoryInDatabase();

        $name = 'Full Name';
        $email = 'full.name@test.com';
        $description = 'A description';

        $authorDTO = new AuthorRequestDTO($name, $email, $description);
        $author  = new CreateNewAuthor($authorRepository);
        $result = $author->execute($authorDTO);

        $expectedResult = ['name' => $name, 'email' => $email, 'description' => $description];
        $this->assertSame($expectedResult, $result);
    }

}
