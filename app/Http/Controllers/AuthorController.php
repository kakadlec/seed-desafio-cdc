<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Core\Domain\Author;
use App\Core\Infra\AuthorRepositoryInDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|string|unique:author,email',
                'description' => 'required|string|max:400',
            ]
        );

        //1 ICP - Acoplamento contextual
        $author = new Author(
            $validatedRequest['name'],
            $validatedRequest['email'],
            $validatedRequest['description']
        );

        //1 ICP - Acoplamento Contextual
        $repository = new AuthorRepositoryInDatabase();

        $id = $repository->store($author);
        $author->setId($id);

        return response()->json($author->toArray());
    }
}
