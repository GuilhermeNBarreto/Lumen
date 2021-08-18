<?php

namespace App\Exceptions;

class Validator {

    const MESSAGES = [
        'required' => 'O atributo :attribute é obrigatórios.',
        'email.email' => 'O atributo email precisar ser um email válido.',
        'cpf.cpf' => 'O atributo cpf deve ser válido.',
        'numeric' => 'O atributo :attribute deve ser numérico.',
        'unique'=> ':attribute já cadastrado.'
    ];

}