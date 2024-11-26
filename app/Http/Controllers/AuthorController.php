<?php

namespace App\Http\Controllers;

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

        $name = $request->input('name');

        return response()->json($validatedRequest);
    }
}
