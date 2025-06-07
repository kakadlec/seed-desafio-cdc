<?php

declare(strict_types=1);

namespace App\Core\Service\Order;

use App\Core\Domain\Order;
use App\Core\Infra\Contracts\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository) {}

    public function create(OrderDTO $orderDTO): Order
    {
        return $this->orderRepository->store($orderDTO);
    }
}
