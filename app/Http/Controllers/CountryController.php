<?php

namespace App\Http\Controllers;

use App\Core\Service\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function store(Request $request, CountryService $countryService): JsonResponse
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string|unique:countries,name',
            'code' => 'required|string|size:3|unique:countries,code',
        ]);
        $country = $countryService->create($validatedRequest['name'], $validatedRequest['code']);
        return response()->json(["id" => $country->id, "name" => $country->name], 201);
    }
}
