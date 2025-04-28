<?php

namespace Feature\EndToEnd;

use App\Models\Country;
use App\Models\State;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCaseWithRefreshDatabase;

// @ICP_TOTAL(0)
class OrderApiTest extends TestCaseWithRefreshDatabase
{
    public static function invalidOrderDataProvider(): array
    {
        $base = self::validPayload();

        return [
            'missing_email' => [
                array_merge($base, ['email' => null]),
                'email',
            ],
            'invalid_email_format' => [
                array_merge($base, ['email' => 'invalid-email']),
                'email',
            ],
            'missing_name' => [
                array_merge($base, ['name' => null]),
                'name',
            ],
            'missing_last_name' => [
                array_merge($base, ['last_name' => null]),
                'last_name',
            ],
            'invalid_document' => [
                array_merge($base, ['document' => '12345678900']),
                'document',
            ],
            'missing_country' => [
                array_merge($base, ['country' => null]),
                'country',
            ],
            'invalid_country_code_size' => [
                array_merge($base, ['country' => 'BR']),
                'country',
            ],
            'missing_state' => [
                array_merge($base, ['state' => null]),
                'state',
            ],
            'invalid_state_code_size' => [
                array_merge($base, ['state' => 'S']),
                'state',
            ],
            'missing_postal_code' => [
                array_merge($base, ['postal_code' => null]),
                'postal_code',
            ],
            'invalid_postal_code_size' => [
                array_merge($base, ['postal_code' => '123']),
                'postal_code',
            ],
            'missing_city' => [
                array_merge($base, ['city' => null]),
                'city',
            ],
            'missing_address' => [
                array_merge($base, ['address' => null]),
                'address',
            ],
            'missing_phone' => [
                array_merge($base, ['phone' => null]),
                'phone',
            ],
            'country_not_registered' => [
                array_merge($base, ['country' => 'XXX']),
                'country',
            ],
            'state_not_registered' => [
                array_merge($base, ['state' => 'XX']),
                'state',
            ],
            'missing_order' => [
                array_merge($base, ['order' => null]),
                'order',
            ],
            'missing_order_total' => [
                array_merge($base, ['order' => ['total' => null]]),
                'order.total',
            ],
            'missing_order_total_invalid' => [
                array_merge($base, ['order' => ['total' => 'a hundred']]),
                'order.total',
            ],
            'missing_order_total_less_than_zero' => [
                array_merge($base, ['order' => ['total' => -100]]),
                'order.total',
            ],
            'missing_order_items' => [
                array_merge($base, ['order' => [
                    'total' => 100,
                    'items' => null
                ]]),
                'order.items',
            ],
            'missing_order_items_invalid' => [
                array_merge($base, ['order' => [
                    'total' => 100,
                    'items' => 'invalid'
                ]]),
                'order.items',
            ],
            'missing_order_items_product_id' => [
                array_merge($base, [
                    'order' => [
                        'total' => 100,
                        'items' => [
                            ['product_id' => null, 'quantity' => 1]
                        ]
                    ]
                ]),
                'order.items.0.product_id',
            ],

        ];
    }

    private static function validPayload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'user@example.com',
            'name' => 'John',
            'last_name' => 'Doe',
            'document' => '11144477735',
            'address' => '123 Rua',
            'complement' => 'Apto 10',
            'city' => 'Curitiba',
            'country' => 'BRA',
            'state' => 'PR',
            'postal_code' => '80000000',
            'phone' => '41999999999',
            'order' => [
                'total' => 100.00,
                'items' => [
                    [
                        'product_id' => 1,
                        'quantity' => 2,
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 1,
                    ],
                ]
            ]
        ], $overrides);
    }

    #[DataProvider('invalidOrderDataProvider')]
    public function testValidationErrors(array $payload, string $expectedInvalidField): void
    {
        $response = $this->postJson('/api/order', $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($expectedInvalidField);
    }

    public function testFailsIfCountryHasStatesAndStateIsMissing(): void
    {
        $country = Country::factory()->create(['code' => 'BRA']);
        State::factory()->create(['country_id' => $country->id, 'code' => 'SC']);

        $payload = self::validPayload([
            'country' => $country->code,
            'state' => null,
        ]);

        $this->postJson('/api/order', $payload)
            ->assertStatus(422)
            ->assertJsonValidationErrors('state');
    }

    public function testValidOrderShouldReturnStatusCreated(): void
    {
        $this->postJson('/api/order', self::validPayload())
            ->assertStatus(201);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $country = Country::factory()->create(['name' => 'Brazil', 'code' => 'BRA']);
        State::factory()->create(['name' => 'Paraná', 'code' => 'PR', 'country_id' => $country->id]);
    }
}

