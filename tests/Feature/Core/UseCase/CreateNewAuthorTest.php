<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Infra\AuthorRepositoryInDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CreateNewAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewAuthor(): void
    {
        $authorRepository = new AuthorRepositoryInDatabase();

        $name = 'Full Name';
        $email = 'full.name@test.com';
        $description = 'A description';

        $author  = new Author($name, $email, $description);
        $id = $authorRepository->store($author);

        $this->assertIsInt($id);
        $this->assertDatabaseHas(AuthorRepositoryInDatabase::TABLE_NAME,
            ['name' => $name, 'email' => $email, 'description' => $description]
        );
    }
}
