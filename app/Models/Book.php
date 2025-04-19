<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $table = 'book';
    public $timestamps = false;

    protected $fillable = [
        'author_id',
        'category_id',
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
