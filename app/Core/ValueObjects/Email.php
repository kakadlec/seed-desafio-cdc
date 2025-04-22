<?php

namespace App\Core\ValueObjects;

final readonly class Email
{
    public function __construct(public string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format.');
        }
    }

    public function __toString(): string
    {
        return strtolower($this->value);
    }
}
