<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\Book;
use App\Core\Infra\AuthorRepositoryInDatabase;
use App\Core\Infra\BookRepositoryInDatabase;
use App\Core\Infra\CategoryRepositoryInDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
                'author' => 'string|required',
                'category' => 'string|required',
                'title' => 'string|required|unique:book',
                'summary' => 'string|required|max:500',
                'abstract' => 'required|string',
                'price' => 'numeric|decimal:2|min:20',
                'totalPages' => 'integer|min:100',
                'bookIdentifier' => 'string|unique:book,book_identifier',
                'pubDate' => 'date_format:Y-m-d|after:now',
            ]
        );

        $author = new AuthorRepositoryInDatabase()->findByName($validatedRequest['author']);
        $category = new CategoryRepositoryInDatabase()->findByName($validatedRequest['category']);

        $book = new Book(
            $author,
            $category,
            $validatedRequest['title'],
            $validatedRequest['summary'],
            $validatedRequest['abstract'],
            (float) $validatedRequest['price'],
            (int) $validatedRequest['totalPages'],
            $validatedRequest['bookIdentifier'],
            new \DateTimeImmutable($validatedRequest['pubDate'])
        );

        $id = new BookRepositoryInDatabase()->store($book);
        $book->setId($id);

        return response()->json($book->toArray());
    }

    public function retrieveById(int $id): JsonResponse
    {
        $book = new BookRepositoryInDatabase()->findById($id);

        if (!$book) {
            return response()->json('Book not found', 404);
        }

        return response()->json($book->toArray());
    }

    public function retrieve(): JsonResponse
    {
        return response()->json(new BookRepositoryInDatabase()->retrieve());
    }
}
