<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Infra\BookRepositoryInDatabase;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function details(int $id): JsonResponse
    {
        $book = new BookRepositoryInDatabase()->findById($id);

        if (!$book) {
            return response()->json('Book not found', 404);
        }

        $response = [
          "id" => $book->id,
          "title" => $book->title,
          "summary" => $book->summary,
          "abstract" => $book->abstract,
          "book_identifier" => $book->bookIdentifier,
          "price" => $book->price,
          "publication_date" => $book->publicationDate->format("Y-m-d"),
          "total_pages" => $book->totalPages,
          "category" => $book->category->getName(),
          "author" => [
            "name" => "{$book->author->name}",
            "description" => "{$book->author->description}"
          ]
        ];

        return response()->json($response);
    }
}
