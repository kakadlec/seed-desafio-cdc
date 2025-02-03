<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Book;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookRepositoryInDatabase
{
    public const string TABLE_NAME = 'book';

    public function store(Book $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }

    public function retrieveOne(int $id): ?Book
    {
        $result = DB::table(self::TABLE_NAME)->find($id)->toArray();

        if (empty($result)) {
           return null;
        }

        $book = new Book(
            $result['author'],
            $result['category'],
            $result['title'],
            $result['summary'],
            $result['abstract'],
            $result['price'],
            $result['total_pages'],
            $result['book_identifier'],
            $result['publication_date']
        );
        $book->setId($result['id']);

        return $book;

    }

    public function retrieve(): Collection
    {
        return DB::table(self::TABLE_NAME)->get(['id', 'title']);
    }
}
