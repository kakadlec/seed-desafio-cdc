<?php

namespace App\Core\ValueObjects;

final readonly class Address
{
    public function __construct(
        public string $country,
        public ?string $state,
        public string $postalCode,
        public string $city,
        public string $street,
        public ?string $complement
    ) {
        if (strlen($country) !== 3) {
            throw new \InvalidArgumentException('Country code must be 3 characters.');
        }

        if ($state !== null && strlen($state) !== 2) {
            throw new \InvalidArgumentException('State code must be 2 characters.');
        }

        if (!preg_match('/^\d{8}$/', $postalCode)) {
            throw new \InvalidArgumentException('Postal code must be 8 digits.');
        }

        if (empty($city) || empty($street)) {
            throw new \InvalidArgumentException('City and street are required.');
        }
    }

    public function full(): string
    {
        return "$this->street, $this->city, $this->state, $this->country, $this->postalCode";
    }
}
