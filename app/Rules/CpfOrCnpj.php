<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class CpfOrCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        // Validate CPF (11 digits) or CNPJ (14 digits)
        if (!$this->validateCpf($value) && !$this->validateCnpj($value)) {
            $fail('The :attribute must be a valid CPF or CNPJ.');
        }
    }

    /**
     * Validate CPF (Brazilian ID).
     *
     * @param  string  $cpf
     * @return bool
     */
    private function validateCpf($cpf)
    {
        // Remove non-numeric characters
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Check if the length is correct
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Validate CPF digits
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate CNPJ (Brazilian company ID).
     *
     * @param  string  $cnpj
     * @return bool
     */
    private function validateCnpj($cnpj)
    {
        // Remove non-numeric characters
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Check if the length is correct
        if (strlen($cnpj) !== 14) {
            return false;
        }

        // Validate CNPJ digits
        for ($t = 12; $t < 14; $t++) {
            for ($d = 0, $p = 5, $c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $p;
                $p = ($p - 1) < 2 ? 9 : $p - 1;
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
