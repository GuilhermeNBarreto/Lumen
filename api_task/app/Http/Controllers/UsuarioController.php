<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Tarefa;
use App\Models\Usuario;
use PhpParser\Node\Stmt\TryCatch;


class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarios = Usuario::all();

        return response()->json($usuarios, 200);
    }

    public function obterPorId($id)
    {
        try {
            $usuario = Usuario::findOrfail($id);
            return response()->json($usuario, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Usuário não encontrado'], 404);
        }
    }

    public function criar(Request $request)
    {
        $regras = [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios',
            'cpf' => 'required|cpf',
            'senha' => 'required',
            'status' => 'numeric'
        ];

        $message = [
            'nome.required' => 'O atributo nome é obrigatório',
            'email.required' => 'O atributo email é obrigatório',
            'email.email' => 'O atributo email precisar ser um email válido',
            'cpf.required' => 'O atributo cpf é obrigatório',
            'cpf.cpf' => 'O atributo cpf deve ser válido',
            'senha.required' => 'O atributo senha é obrigatório',
            'status.numeric' => 'O atributo status deve ser numérico',
        ];

        $this->validate($request, $regras, $message);

        Usuario::create($request->all());

        return response()->json(['message' => 'Usuário cadastrado com sucesso'], 201);
    }

    public function editar(Request $request, $id)
    {
        $regras = [
            'nome' => 'required',
            'email' => 'required',
            'cpf' => 'required|cpf',
            'senha' => 'required',
            'status' => 'numeric'
        ];

        $message = [
            'nome.required' => 'O atributo nome é obrigatório',
            'email.required' => 'O atributo email é obrigatório',
            'cpf.required' => 'O atributo cpf é obrigatório',
            'cpf.cpf' => 'O atributo cpf deve ser válido',
            'senha.required' => 'O atributo senha é obrigatório',
            'status.numeric' => 'O atributo status deve ser numérico',
        ];

        $this->validate($request, $regras, $message);

        try {

            $usuario = Usuario::findOrFail($id);
            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->cpf = $request->cpf;
            $usuario->senha = $request->senha;
            $usuario->status = $request->status;
            $usuario->save();

            return response()->json(['message' => 'Usuário atualizado com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    }

    public function excluirPorId($id)
    {
        try {
            $usuario = Usuario::findOrfail($id);
            $usuario->delete();

            return response()->json(['menssagem' => 'Usuário removido com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Usuário não encontrado'], 404);
        }
    }
}
