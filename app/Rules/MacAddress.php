<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MacAddress implements Rule
{
    public function passes($attribute, $value)
    {
        // Utiliza una expresión regular para validar la dirección MAC
        return preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $value);
    }

    public function message()
    {
        return 'El campo :attribute no es una dirección MAC válida.';
    }
}
