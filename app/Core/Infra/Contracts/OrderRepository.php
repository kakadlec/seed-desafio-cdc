<?php

namespace App\Core\Infra\Contracts;

use App\Core\Domain\Order;
use App\Core\Service\Order\OrderDTO;

interface OrderRepository
{
    public function store(OrderDTO $orderDTO): Order;
    public function findById(int $id): ?Order;
}
