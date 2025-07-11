<?php

namespace Tests\Unit\Rules;

use App\Rules\Documents\Cpf;
use Tests\TestCase;

// @ICP_TOTAL(0)
class CpfTest extends TestCase
{
    public function testValidateCpf(): void
    {
        $rule = new Cpf();
        $rule->validate('document', '111.444.777-35', function ($message) {
            $this->fail($message);
        });

        $this->expectNotToPerformAssertions();
    }

    public function testValidateCpfShouldFailWhenNotACpf(): void
    {
        $fail = fn($message) => $this->assertEquals('The :attribute must be a valid CPF', $message);
        $rule = new Cpf();

        $rule->validate('document', '11.222.333/0001-81', $fail);
    }

    public function testValidateCpfShouldFailWhenInvalid(): void
    {
        $fail = fn($message) => $this->assertEquals('The :attribute must be a valid CPF', $message);
        $rule = new Cpf();

        $rule->validate('document', '11.222.333/0001-81', $fail);
    }
}
