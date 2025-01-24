<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepositoryInDatabase
{
    public const TABLE_NAME = 'category';

    public function store(Category $data): int
    {
        return DB::table(self::TABLE_NAME)->insertGetId($data->toArray());
    }
}
