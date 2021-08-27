<?php

namespace App\Http\Controllers;

use App\Exceptions\Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Tarefa;
use App\Models\Usuario;

class TarefaController extends Controller
{
    public function listar($usuario_id)
    {
        try {
            $usuario = Usuario::findOrFail($usuario_id);
            $tarefas = $usuario->tarefas()->get();
            return response()->json($tarefas, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Usuário não encontrado'], 404);
        }
    }

    public function obterPorId($usuario_id, $id)
    {
        try {
            $tarefas = Tarefa::findOrfail($id);
            return response()->json($tarefas, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Tarefa não encontrada'], 404);
        }
    }

    public function criar(Request $request, $usuario_id)
    {
        $regras = [
            'usuario_id' => 'required',
            'status' => 'required',
            'descricao' => 'required',
        ];


        $this->validate($request, $regras, Validator::MESSAGES);

        Tarefa::create($request->all());

        return response()->json(['menssagem' => 'Tarefa cadastrada com sucesso'], 201);
    }

    public function editar(Request $request, $id)
    {
        $regras = [
            'status' => 'required',
            'descricao' => 'required',
            'usuario_id' => 'required'
        ];

        $this->validate($request, $regras, Validator::MESSAGES);

        try {
            $tarefa = Tarefa::findOrfail($id);
            $tarefa->usuario_id = $request->input('usuario_id');
            $tarefa->status = $request->input('status');
            $tarefa->descricao = $request->input('descricao');
            $tarefa->save();

            return response()->json(['menssagem' => 'Tarefa atualizado com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Tarefa não encontrado'], 404);
        }
    }

    public function excluirPorId($id)
    {
        try {
            $tarefa = Tarefa::findOrFail($id);
            $tarefa->delete();

            return response()->json(['menssagem' => 'Tarefa removido com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Tarefa não encontrado'], 404);
        }
    }
}
