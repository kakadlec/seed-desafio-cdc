<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
                'author' => 'required',
                'category' => 'required',
                'title' => 'required|string|unique',
                'summary' => 'required|string|max:500',
                '$abstract' => 'string',
                '$price' => 'decimal|min:20',
                'totalPages' => 'integer|min:100',
                'bookIdentifier' => 'string|unique',
                'pubDate' => 'date_format:Y-m-d|after:now',
            ]
        );

        $book = new Book(
            $validatedRequest['author'],
            $validatedRequest['category'],
            $validatedRequest['title'],
            $validatedRequest['summary'],
            $validatedRequest['$abstract'],
            $validatedRequest['$price'],
            $validatedRequest['totalPages'],
            $validatedRequest['bookIdentifier'],
            $validatedRequest['pubDate']
        );
    }
}
