<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCouponRequest;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Core\Service\CouponService;

class CouponController extends Controller
{
    public function store(StoreCouponRequest $request)
    {
        $validated = $request->validated();
        $service = new CouponService();
        $cupom = $service->createCoupon($validated['percentual']);

        return response()->json([
            'codigo' => $cupom->codigo,
            'percentual' => $cupom->percentual,
            'validade' => $cupom->validade,
            'created_at' => $cupom->created_at,
        ], 201);
    }
}
