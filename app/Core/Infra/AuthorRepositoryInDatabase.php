<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Author;
use Illuminate\Support\Facades\DB;

class AuthorRepositoryInDatabase
{
    public const string TABLE_NAME = 'author';

    public function store(Author $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }

    public function findById(int $id): Author|null
    {
        $record = DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->first();

        if (!$record) {
            return null;
        }

        return Author::createWithId(
            id: $record->id,
            name: $record->name,
            email: $record->email,
            description: $record->description,
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $record->created_at),
        );
    }

    public function findByName(string $name): Author|null
    {
        $record = DB::table(self::TABLE_NAME)
            ->where('name', $name)
            ->first();

        if (!$record) {
            return null;
        }

        return Author::createWithId(
            id: $record->id,
            name: $record->name,
            email: $record->email,
            description: $record->description,
            createdAt: \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $record->created_at),
        );
    }
}
