<?php

namespace App\Core\ValueObjects;

final readonly class Phone
{
    public function __construct(public string $value)
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) < 10 || strlen($digits) > 14) {
            throw new \InvalidArgumentException('Phone number must be between 10 and 14 digits.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
