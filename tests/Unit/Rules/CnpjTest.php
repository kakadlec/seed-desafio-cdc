<?php

namespace Tests\Unit\Rules;

use App\Rules\Documents\Cnpj;
use Tests\TestCase;

class CnpjTest extends TestCase
{
    public function testValidateCnpj(): void
    {
        $rule = new Cnpj();
        $rule->validate('document', '11.222.333/0001-81', function ($message) {
            $this->fail($message);
        });

        $this->expectNotToPerformAssertions();
    }

    public function testValidateCnpjWhenNotLookLikeACnpjShouldSkip(): void
    {
        $rule = new Cnpj();
        $rule->validate('document', '111.444.777-35', function ($message) {
            $this->fail($message);
        });

        $this->expectNotToPerformAssertions();
    }

    public function testValidateCnpjShouldFailWhenInvalid(): void
    {
        $fail = fn($message) => $this->assertEquals('The :attribute must be a valid CNPJ', $message);
        $rule = new Cnpj();

        $rule->validate('document', '00.000.000/0000-00', $fail);
    }
}
