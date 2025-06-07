<?php

namespace App\Core\Infra;

use App\Models\Order;
use App\Core\ValueObjects\Customer;
use App\Core\Service\Order\OrderDTO;
use App\Core\Domain\Order as DomainOrder;
use App\Core\Infra\Contracts\OrderRepository;

class OrderRepositoryInDatabase implements OrderRepository
{
    public function store(OrderDTO $orderDTO): DomainOrder
    {
        $orderData = $orderDTO->toArrayForPersistence();
        $order = Order::create([
            'email' => $orderData['email'],
            'name' => $orderData['name'],
            'last_name' => $orderData['last_name'],
            'document' => $orderData['document'],
            'country_code' => $orderData['country_code'],
            'state_code' => $orderData['state_code'],
            'postal_code' => $orderData['postal_code'],
            'city' => $orderData['city'],
            'address' => $orderData['address'],
            'complement' => $orderData['complement'],
            'phone' => $orderData['phone'],
            'total' => $orderDTO->order['total'] ?? 0,
        ]);

        foreach ($orderDTO->order['items'] ?? [] as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
            ]);
        }

        return new DomainOrder(
            id: $order->id,
            customer: $orderDTO->customer,
            total: $orderDTO->order['total'] ?? 0,
            items: $orderDTO->order['items'] ?? []
        );
    }

    public function findById(int $id): ?DomainOrder
    {
        $order = Order::with('items')->find($id);
        if (!$order) {
            return null;
        }
        $items = $order->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ];
        })->toArray();        

        return new DomainOrder(
            id: $order->id,
            customer: new Customer(
                $order->email,
                $order->name,
                $order->last_name,
                $order->document,
                $order->country_code,
                $order->state_code,
                $order->postal_code,
                $order->city,
                $order->address,
                $order->complement,
                $order->phone
            ),
            total: $order->total,
            items: $items
        );
    }
}
