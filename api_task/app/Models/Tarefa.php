<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Tarefa extends Model
{

    protected $table = "tarefa";

    protected $fillable = [
        'status',
        'descricao',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
