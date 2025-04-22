<?php

namespace App\Http\Controllers;

use App\Rules\Documents\DocumentValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validatedRequest = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'document' => ['required', 'string', new DocumentValidator],
            'country' => 'required|string|size:3', // Se país tiver estados, precisa de um estado
            'state' => 'required|string|size:2', // O estado precisa ter um país associado
            'postal_code' => 'required|string|size:8',
            'city' => 'required|string',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'phone' => 'required|string',
        ]);

        return response()->json(["status" => "validated"], 201);
    }

}
