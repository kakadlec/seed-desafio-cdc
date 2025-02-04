<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepositoryInDatabase
{
    public const string TABLE_NAME = 'category';

    public function store(Category $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }

    public function findById(int $id): Category|null
    {
        $record = DB::table(self::TABLE_NAME)
            ->where('id', $id)
            ->first();

        if (!$record) {
            return null;
        }

        return Category::createWithId(
            id: $record->id,
            name: $record->name
        );
    }

    public function findByName(string $name): Category|null
    {
        $record = DB::table(self::TABLE_NAME)
            ->where('name', $name)
            ->first();

        if (!$record) {
            return null;
        }

        return Category::createWithId(
            id: $record->id,
            name: $record->name
        );
    }
}
