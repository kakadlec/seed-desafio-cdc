<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Author;
use Illuminate\Support\Facades\DB;

class AuthorRepositoryInDatabase implements AuthorRepository
{
    public const TABLE_NAME = 'author';

    public function store(Author $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }
}
