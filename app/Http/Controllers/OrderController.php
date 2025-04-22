<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Rules\Documents\DocumentValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'document' => ['required', 'string', new DocumentValidator],
            'country' => 'required|string|size:3|exists:countries,code',
            'state' => 'nullable|string|size:2|exists:states,code',
            'postal_code' => 'required|string|size:8',
            'city' => 'required|string',
            'address' => 'required|string',
            'complement' => 'nullable|string',
            'phone' => 'required|string',
        ]);

        $validator->sometimes('state', 'required', function (Fluent $input) {
            $country = Country::where('code', $input->country)->with('states')->first();
            return $country && $country->states->isNotEmpty();
        });

        $validatedRequest = $validator->validate();

        return response()->json(["status" => "validated"], 201);
    }

}
