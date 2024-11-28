<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Infra\AuthorRepository;
use App\Core\Infra\AuthorRepositoryInDatabase;
use App\Core\UseCase\AuthorRequestDTO;
use App\Core\UseCase\CreateNewAuthor;
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

        $authorDTO = new AuthorRequestDTO($name, $email, $description);
        $author  = new CreateNewAuthor($authorRepository);
        $result = $author->execute($authorDTO);

        $expectedResult = ['name' => $name, 'email' => $email, 'description' => $description];
        $this->assertSame($expectedResult['name'], $result['name']);
        $this->assertSame($expectedResult['email'], $result['email']);
        $this->assertSame($expectedResult['description'], $result['description']);
        $this->assertNotNull($result['created_at']);
        $this->assertDatabaseHas(AuthorRepositoryInDatabase::TABLE_NAME,
            ['name' => $name, 'email' => $email, 'description' => $description]
        );
    }

}
