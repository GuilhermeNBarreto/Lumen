<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public static function criptografar($senha)
    {
        return Hash::make($senha);
    }

    public static function validarCriptografia($senha, $senhaBanco)
    {
        return $senha === $senhaBanco;
    }
}
