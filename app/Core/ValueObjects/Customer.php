<?php

namespace App\Core\ValueObjects;

final readonly class Customer
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public Document $document,
        public Email $email,
        public Phone $phone,
        public Address $address,
    ) {
        if (empty(trim($firstName)) || empty(trim($lastName))) {
            throw new \InvalidArgumentException('Name and last name are required.');
        }
    }

    public function fullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
