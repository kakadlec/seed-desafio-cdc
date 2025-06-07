<?php

namespace App\Core\Service\Order;

use App\Core\ValueObjects\Customer;

final readonly class OrderDTO
{
    public function __construct(
        public Customer $customer,
        public array $order
    ) {}

    public function toArrayForPersistence(): array
    {
        return [
            'email' => (string) $this->customer->email,
            'name' => $this->customer->firstName,
            'last_name' => $this->customer->lastName,
            'document' => $this->customer->document->value,
            'country_code' => $this->customer->address->country,
            'state_code' => $this->customer->address->state,
            'postal_code' => $this->customer->address->postalCode,
            'city' => $this->customer->address->city,
            'address' => $this->customer->address->street,
            'complement' => $this->customer->address->complement,
            'phone' => (string) $this->customer->phone,
        ];
    }
}
