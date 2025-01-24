<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Infra\AuthorRepositoryInDatabase;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CreateNewAuthorTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewAuthor(): void
    {
        $authorRepository = new Author();

        $name = 'Full Name';
        $email = 'full.name@test.com';
        $description = 'A description';

        $author = new Author($name, $email, $description);
        $id = $authorRepository->store($author);

        $this->assertIsInt($id);
        $this->assertDatabaseHas(
            Author::TABLE_NAME,
            ['name' => $name, 'email' => $email, 'description' => $description]
        );
    }

    public function testEmailShouldBeUnique(): void
    {
        $authorRepository = new Author();

        $name = 'Full Name';
        $email = 'full.name@test.com';
        $description = 'A description';

        $author = new Author($name, $email, $description);
        $authorRepository->store($author);

        $this->expectException(UniqueConstraintViolationException::class);
        $authorRepository->store($author);
    }

    public function testOnDuplicatedEmailShouldFailGracefully(): void
    {
        $authorRepository = new Author();

        $payload = [
            'name' => 'Full Name',
            'email' => 'full.name@test.com',
            'description' => 'A description',
        ];

        $author = new Author($payload['name'], $payload['email'], $payload['description']);
        $authorRepository->store($author);

        $response = $this->postJson('api/author', $payload);

        $this->assertSame(422, $response->status());
        $this->assertSame(
            '{"message":"The email has already been taken.","errors":{"email":["The email has already been taken."]}}',
            $response->getContent()
        );
    }
}
