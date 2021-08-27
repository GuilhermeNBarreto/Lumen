<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ValidacaoUsuario extends Model
{
    const REGRAS = [
        'nome' => 'required',
        'email' => 'required|email|unique:usuarios',
        'cpf' => 'required|cpf|unique:usuarios',
        'senha' => 'required'
    ];
}
