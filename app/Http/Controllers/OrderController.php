<?php

namespace App\Http\Controllers;

use App\Core\Service\Order\OrderDTOFactory;
use App\Core\Service\Order\OrderService;
use App\Models\Country;
use App\Rules\Documents\DocumentValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Fluent;

// @ICP_TOTAL(14)
class OrderController extends Controller
{
    public function store(Request $request, OrderService $orderService): JsonResponse
    {
        // @ICP(1)
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
        // @ICP(1)
        $validator->sometimes('state', 'required', function (Fluent $input) {
            // @ICP(1)
            $country = Country::where('code', $input->country)->with('states')->first();

            // @ICP(1)
            return $country && $country->states->isNotEmpty();
        });

        // @ICP(1)
        $validatedRequest = $validator->validate();

        // @ICP(1)
        try {
            // @ICP(2)  Factory and class orderDTO returned by the factory
            $orderDTO = OrderDtoFactory::fromValidated($validatedRequest);
            // @ICP(1) orderService injected by the framework
            $order = $orderService->create($orderDTO);
        // @ICP(2) Exception + catch
        } catch (\InvalidArgumentException $exception) {
            return response()->json([
                'error' => 'Invalid input data',
                'message' => $exception->getMessage(),
            ], 422);
        // @ICP(3) Exceptions + catch
        } catch (\DomainException|\Exception) {
            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An unexpected error occurred',
            ], 500);
        }

        return response()->json(['status' => 'validated'], 201);
    }
}
