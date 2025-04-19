<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Domain\Book;
use App\Core\Domain\Category;
use App\Core\Infra\AuthorRepositoryInDatabase;
use App\Core\Infra\BookRepositoryInDatabase;
use App\Core\Infra\CategoryRepositoryInDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CreateNewBookTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewBook(): void
    {
        $name = 'Full Name';
        $email = 'full.name@test.com';
        $description = 'A description';
        $authorRepository = new AuthorRepositoryInDatabase();
        $author = new Author($name, $email, $description);
        $authorId = $authorRepository->store($author);
        $author->setId($authorId);

        $category_name = 'Category 1';
        $categoryRepository = new CategoryRepositoryInDatabase();
        $category = new Category($category_name);
        $categoryId = $categoryRepository->store($category);
        $category->setId($categoryId);

        $title = 'The Book';
        $summary = 'This is a book with letters';
        $abstract = 'The abstract';
        $price = 10.00;
        $totalPages = 500;
        $bookIdentifier = 'book-identifier';
        $pubDate = \DateTimeImmutable::createFromFormat('Y-m-d', '2025-10-01');
        $bookRepository = new BookRepositoryInDatabase();
        $book = new Book(
            $author, $category, $title, $summary, $abstract, $price, $totalPages, $bookIdentifier, $pubDate
        );
        $bookRepository->store($book);

        $this->assertDatabaseHas(
            BookRepositoryInDatabase::TABLE_NAME,
            [
                'author_id' => $author->getId(),
                'category_id' => $category->getId(),
                'title' => $title,
                'summary' => $summary,
                'abstract' => $abstract
            ]
        );
    }
}
