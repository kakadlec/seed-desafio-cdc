<?php

namespace App\Core\ValueObjects;

final readonly class Document
{
    public function __construct(public string $value)
    {
        $digits = preg_replace('/\D/', '', $value);

        if (strlen($digits) === 11 && !$this->isValidCpf($digits)) {
            throw new \InvalidArgumentException('Invalid CPF.');
        }

        if (strlen($digits) === 14 && !$this->isValidCnpj($digits)) {
            throw new \InvalidArgumentException('Invalid CNPJ.');
        }

        if (!in_array(strlen($digits), [11, 14])) {
            throw new \InvalidArgumentException('Document must be a valid CPF or CNPJ.');
        }
    }

    private function isValidCpf(string $cpf): bool
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) return false;
        }

        return true;
    }

    private function isValidCnpj(string $cnpj): bool
    {
        if (strlen($cnpj) !== 14 || preg_match('/^(\d)\1{13}$/', $cnpj)) {
            return false;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }

        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ((int)$cnpj[12] !== $digit1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }

        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        return (int)$cnpj[13] === $digit2;
    }
}
