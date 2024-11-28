<?php

declare(strict_types=1);

namespace App\Core\Infra;

use App\Core\Domain\Author;
use Illuminate\Support\Facades\DB;

class AuthorRepositoryInDatabase implements AuthorRepository
{
    public function store(Author $data): void
    {
        DB::table('author')->insert($data->toArray());
    }
}
