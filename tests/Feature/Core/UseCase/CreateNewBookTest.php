<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Domain\Category;
use App\Core\Infra\AuthorRepositoryInDatabase;
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
        $author = new AuthorRepositoryInDatabase($name, $email, $description);
        $authorRepository->store($author);

        $category_name = 'Category 1';
        $categoryRepository = new CategoryRepositoryInDatabase();
        $category = new Category($category_name);
        $categoryRepository->store($category);

        $title = 'The Book';
        $summary = 'This is a book with letters';
        $abstract = 'The abstract';
        $price = 10.00;
        $totalPages = 500;
        $bookIdentifier = 'book-identifier';
        $pubDate = \DateTime::createFromFormat('Y-m-d', '2025-10-01');
        $bookRepository = new BookRepositoryInDatabase();
        $book = new Book($author, $category, $title, $summary, $abstract, $price, $totalPages, $bookIdentifier, $pubDate);
        $bookRepository->store($book);

        $this->assertDatabaseHas(
            BookRepositoryInDatabase::TABLE_NAME,
            ['author' => $author, 'category' => $category, 'title' => $title, 'summary' => $summary, 'abstract' => $abstract]
        );
    }
}
