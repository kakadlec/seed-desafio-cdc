<?php

namespace App\Http\Controllers;

use App\Core\Infra\AuthorRepositoryInDatabase;
use App\Core\UseCase\AuthorRequestDTO;
use App\Core\UseCase\CreateNewAuthor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|string',
                'description' => 'required|string|max:400',
            ]
        );

        $authorDTO = new AuthorRequestDTO(
            $validatedRequest['name'],
            $validatedRequest['email'],
            $validatedRequest['description']
        );

        $authorUseCase = new CreateNewAuthor(new AuthorRepositoryInDatabase());
        $authorUseCase->execute($authorDTO);


        return response()->json($validatedRequest);
    }
}
