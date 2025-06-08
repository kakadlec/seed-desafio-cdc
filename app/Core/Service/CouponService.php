<?php

namespace App\Core\Service;

use App\Models\Coupon;
use App\Core\Domain\CouponEntity;

class CouponService
{
    public function createCoupon(float $percentage): Coupon
    {
        $entity = CouponEntity::createNew($percentage);
        return Coupon::create([
            'codigo' => $entity->code,
            'percentual' => $entity->percentage,
            'validade' => $entity->expiration->format('Y-m-d H:i:s'),
        ]);
    }
}
