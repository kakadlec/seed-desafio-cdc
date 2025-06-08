<?php

namespace App\Core\Domain;

class CouponEntity
{
    public function __construct(public readonly string $code, public readonly float $percentage, public readonly \DateTimeImmutable $expiration)
    {}

    public static function createNew(float $percentage): self
    {
        $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
        $expiration = (new \DateTimeImmutable())->modify('+30 days');
        return new self($code, $percentage, $expiration);
    }

    public function isValid(): bool
    {
        return $this->expiration > new \DateTimeImmutable();
    }

    public function applyDiscount(float $amount): float
    {
        return $amount * (1 - $this->percentage / 100);
    }
}
