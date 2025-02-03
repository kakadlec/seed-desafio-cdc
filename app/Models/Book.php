<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'book';
    public $timestamps = false;

    protected $fillable = [
        'author',
        'category',
        'title',
        'summary',
        'abstract',
        'price',
        'total_pages',
        'book_identifier',
        'publication_date',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'datetime',
        ];
    }
}
