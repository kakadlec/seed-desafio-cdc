<?php

namespace App\Http\Controllers;

use App\Core\Service\Order\OrderDTOFactory;
use App\Core\Service\Order\OrderService;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(OrderRequest $request, OrderService $orderService): JsonResponse
    {
        $validatedRequest = $request->validated();

        try {
            $orderDTO = OrderDTOFactory::fromValidated($validatedRequest);
            $order = $orderService->create($orderDTO);
        } catch (\InvalidArgumentException) {
            return response()->json([
                'error' => 'Invalid input data',
                'message' => 'Invalid input data provided',
            ], 422);
        } catch (\DomainException|\Exception) {
            return response()->json([
                'error' => 'Internal server error',
                'message' => 'An unexpected error occurred',
            ], 500);
        }

        $response = response()->json([
            'id' => $order->id,
            'total' => $order->total,
            'items' => $order->items,
            'status' => 'iniciada',
        ], 201);
        $response->headers->set('Location', url("/api/order/{$order->id}"));
        return $response;
    }
}
