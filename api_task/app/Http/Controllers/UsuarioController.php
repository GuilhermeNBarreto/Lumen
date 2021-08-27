<?php

namespace App\Http\Controllers;

use App\Enuns\UsuarioStatusEnum;
use App\Exceptions\Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Tarefa;
use App\Models\Usuario;
use App\Models\ValidacaoUsuario;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;


class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarios = Usuario::where('status', '!=', UsuarioStatusEnum::EXCLUIDO)
            ->paginate();

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
        $regras = ValidacaoUsuario::REGRAS;

        $this->validate($request, $regras, Validator::MESSAGES);

        $request['senha'] = PasswordService::criptografar($request['senha']);
        $request['status'] = UsuarioStatusEnum::ATIVO;

        Usuario::create($request->all());

        return response()->json(['message' => 'Usuário cadastrado com sucesso'], 201);
    }

    public function editar(Request $request, $id)
    {
        $regras = ValidacaoUsuario::REGRAS;

        $this->validate($request, $regras, Validator::MESSAGES);

        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->nome = $request->nome;
            $usuario->email = $request->email;
            $usuario->cpf = $request->cpf;
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
            $usuario = Usuario::findOrFail($id);
            
            if ($usuario && count($usuario->tarefas) > 0) {
                $usuario->status = UsuarioStatusEnum::EXCLUIDO;
                $usuario->save();
            } else {
                $usuario->delete();
            }

            return response()->json(['menssagem' => 'Usuário removido com sucesso'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['messagem' => 'Usuário não encontrado'], 404);
        }
    }
}
