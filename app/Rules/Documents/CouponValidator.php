<?php

namespace App\Rules\Documents;

use Closure;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Contracts\Validation\ValidationRule;


class CouponValidator implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidCoupon($value)) {
            $fail("The :attribute must be a valid coupon code");
        }
    }

    private function isValidCoupon(string $coupon): bool
    {
        $coupon = Coupon::where('codigo', $coupon)->first();
        if (!$coupon) {
            return false;
        }
        return Carbon::parse($coupon->validade)->isFuture();
    }
}
