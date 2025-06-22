<?php

namespace App\Core\Domain;

use App\Core\ValueObjects\Customer;

final class Order
{
    public function __construct(
        public readonly int $id,
        public Customer $customer,
        public float $total,
        public array $items,
        public ?string $coupon,
    ) {}
}
