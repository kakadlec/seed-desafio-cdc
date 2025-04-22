<?php

namespace App\Core\Infra;

use App\Core\Domain\Order;
use App\Core\Infra\Contracts\OrderRepository;
use App\Core\Service\Order\OrderDTO;

class OrderRepositoryInDatabase implements OrderRepository
{
    public function store(OrderDTO $orderDTO): Order
    {
        $result = $orderDTO->toArrayForPersistence();

    }

    public function findById(int $id): ?Order
    {
        // TODO: Implement findById() method.
    }
}
