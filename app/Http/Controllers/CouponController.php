<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCouponRequest;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function store(StoreCouponRequest $request)
    {
        // Gerar código aleatório de 10 caracteres
        $codigo = strtoupper(Str::random(10));
        // Definir validade para 30 dias a partir de agora
        $validade = Carbon::now()->addDays(30);

        $cupom = Coupon::create([
            'codigo' => $codigo,
            'percentual' => $request->input('percentual'),
            'validade' => $validade,
        ]);

        return response()->json([
            'codigo' => $cupom->codigo,
            'percentual' => $cupom->percentual,
            'validade' => $cupom->validade,
            'created_at' => $cupom->created_at,
        ], 201);
    }
}
