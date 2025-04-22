<?php

namespace Feature\EndToEnd;

use App\Models\Country;
use App\Models\State;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCaseWithRefreshDatabase;

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
        ];
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
        ], $overrides);
    }
}

