<?php

namespace App\Http\Controllers;

use App\Core\Domain\Author;
use App\Core\Infra\AuthorRepositoryInDatabase;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|string',
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

        //1 ICP - Bloco de código
        try {
            $id = $repository->store($author);
            $author->setId($id);

            return response()->json($author->toArray());
            //1 ICP - Bloco de código
        } catch (UniqueConstraintViolationException) {
            return response()->json(['erro' => 'Email ja cadastrado'], 409 );
        }
    }
}
