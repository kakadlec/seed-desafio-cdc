<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Author;
use App\Core\Domain\Book;
use Illuminate\Support\Facades\DB;

class BookRepositoryInDatabase
{
    public const string TABLE_NAME = 'book';

    public function store(Book $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }
}
