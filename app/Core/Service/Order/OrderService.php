<?php

declare(strict_types=1);

namespace App\Core\Service\Order;

use App\Core\Domain\Order;

class OrderService
{
    public function __construct() {}

    public function create(OrderDTO $orderDTO): Order
    {
        return new Order(
            id: fake()->randomDigitNotZero(), // Temporary ID generation
            customer: $orderDTO->customer
        );
    }
}
