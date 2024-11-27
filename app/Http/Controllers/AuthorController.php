<?php

namespace App\Http\Controllers;

use App\Core\UseCase\AuthorRequestDTO;
use App\Core\UseCase\CreateNewAuthor;
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

        $authorDTO = new AuthorRequestDTO(
            $validatedRequest['name'],
            $validatedRequest['email'],
            $validatedRequest['description']
        );

        $authorUseCase = new CreateNewAuthor();
        $result = $authorUseCase->execute($authorDTO);


        return response()->json($validatedRequest);
    }
}
