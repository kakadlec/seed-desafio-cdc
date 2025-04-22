<?php

namespace App\Rules\Documents;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DocumentValidator implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D/', '', $value);

        match (strlen($digits)) {
            11 => new Cpf()->validate($attribute, $value, $fail),
            14 => new Cnpj()->validate($attribute, $value, $fail),
            default => $fail("The :attribute must be a valid CPF or CNPJ"),
        };
    }
}
