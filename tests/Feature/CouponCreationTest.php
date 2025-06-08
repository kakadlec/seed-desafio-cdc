<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Coupon;

class CouponCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_criacao_bem_sucedida_de_cupom()
    {
        $response = $this->postJson('/api/coupons', [
            'percentual' => 15.5
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'codigo',
                'percentual',
                'validade',
                'created_at',
            ]);

        $this->assertDatabaseHas('coupons', [
            'percentual' => 15.5
        ]);
    }

    public function test_falha_ao_criar_cupom_com_percentual_invalido()
    {
        $response = $this->postJson('/api/coupons', [
            'percentual' => -5
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['percentual']);

        $response = $this->postJson('/api/coupons', [
            'percentual' => 0
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['percentual']);

        $response = $this->postJson('/api/coupons', [
            'percentual' => null
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['percentual']);
    }

    public function test_mensagens_de_erro_de_validacao()
    {
        $response = $this->postJson('/api/coupons', [
            'percentual' => null
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['percentual']);           

        $response = $this->postJson('/api/coupons', [
            'percentual' => 0
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['percentual']);
    }
}
