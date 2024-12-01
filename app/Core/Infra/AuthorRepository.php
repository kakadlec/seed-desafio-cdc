<?php

namespace App\Core\Infra;

use App\Core\Domain\Author;

interface AuthorRepository
{
    public function store(Author $data): int;
}
