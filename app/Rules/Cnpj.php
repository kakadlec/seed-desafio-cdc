<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Cnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) === 11) {
            $fail("The :attribute must be a valid CNPJ");
        }

        if (!$this->isValidCnpj($digits)) {
            $fail("The :attribute must be a valid CNPJ");
        }
    }

    private function isValidCnpj(string $cnpj): bool
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $lengths = [5, 6];
        foreach ([12, 13] as $t => $pos) {
            $sum = 0;
            $j = $lengths[$t];
            for ($i = 0; $i < $pos; $i++) {
                $sum += $cnpj[$i] * $j--;
                if ($j < 2) {
                    $j = 9;
                }
            }
            $d = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
            if ($cnpj[$pos] != $d) {
                return false;
            }
        }

        return true;
    }
}
