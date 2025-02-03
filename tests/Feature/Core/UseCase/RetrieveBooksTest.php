<?php

declare(strict_types=1);

namespace Feature\Core\UseCase;

use App\Core\Domain\Author;
use App\Core\Domain\Book;
use App\Core\Infra\BookRepositoryInDatabase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrieveBooksTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNewBook(): void
    {
        $authorModel = \App\Models\Author::factory()->create();
        $authorAttr = $authorModel->getAttributes();
        $author = Author::createWithId(
            $authorAttr['id'],
            $authorAttr['name'],
            $authorAttr['email'],
            $authorAttr['description'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $authorAttr['created_at'])
        );

        $categories = Category::factory(2)->create();
        $categoryModel1 = $categories->pop();
        $category1 = \App\Core\Domain\Category::createWithId(...$categoryModel1->toArray());
        $categoryModel2 = $categories->pop();
        $category2 = \App\Core\Domain\Category::createWithId(...$categoryModel2->toArray());

        $books = \App\Models\Book::factory(2)->create();
        $bookModel1 = $books->pop();
        $book1 = new Book(
            $author,
            $category1,
            $bookModel1['title'],
            $bookModel1['summary'],
            $bookModel1['abstract'],
            $bookModel1['price'],
            $bookModel1['total_pages'],
            $bookModel1['book_identifier'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $bookModel1['publication_date'])
        );

        $bookModel2 = $books->pop();
        $book2 = new Book(
            $author,
            $category2,
            $bookModel2['title'],
            $bookModel2['summary'],
            $bookModel2['abstract'],
            $bookModel2['price'],
            $bookModel2['total_pages'],
            $bookModel2['book_identifier'],
            \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $bookModel1['publication_date'])
        );

        $bookRepository = new BookRepositoryInDatabase();
        $book1->setId($bookRepository->store($book1));
        $book2->setId($bookRepository->store($book2));

        $response = $this->getJson('api/books');

        $expected = [
            [
                'id' => $book1->toArray()['id'],
                'title' => $book1->toArray()['title'],
            ],
            [
                'id' => $book2->toArray()['id'],
                'title' => $book2->toArray()['title'],
            ]
        ];
        $this->assertSame(200, $response->status());
        $this->assertSame($expected, $response->json());
    }
}
