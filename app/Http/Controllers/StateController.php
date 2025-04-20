<?php

namespace App\Http\Controllers;

use App\Core\Service\StateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    public function store(Request $request, StateService $stateService): JsonResponse
    {
        $validatedRequest = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('states')
                    ->where(fn($query) => $query->where('country_id', $request->country_id)),
            ],
            'code' => 'required|string|size:2|unique:states,code',
            'country_id' => 'required|int|exists:countries,id',
        ]);
        $state = $stateService->create($validatedRequest['name'], $validatedRequest['code'],
            $validatedRequest['country_id']);
        return response()->json(["id" => $state->id, "country_id" => $state->countryId, "state" => $state->name], 201);
    }
}
