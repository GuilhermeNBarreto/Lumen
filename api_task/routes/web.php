<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "rotas";
});

$router->post('auth/login', 'AuthController@authenticate');



$router->group(['prefix' => 'usuarios',  'middleware' => 'jwt.auth'], function () use ($router) {

    $router->get('/',  'UsuarioController@listar'); //OK Listar todos os Usuarios
    $router->get('/{id}', 'UsuarioController@obterPorId'); //OK Listar usuario por id
    $router->post('/', 'UsuarioController@criar'); //OK Criar usuario
    $router->put('/{id}', 'UsuarioController@editar'); //OK Editar usuario por id
    $router->delete('/{id}', 'UsuarioController@excluirPorId'); //OK Excluir usuario

    $router->group(['prefix' => '{usuario_id}/tarefa'], function () use ($router) {
        $router->get('/', 'TarefaController@listar'); //ok Listar tarefas do Usuario
        $router->get('/{id}', 'TarefaController@obterPorId'); //OK Listar tarefa por id
        $router->post('/', 'TarefaController@criar'); //ok Criar tarefa para usuario
        $router->put('/{id}', 'TarefaController@editar'); //ok Editar tarefa
        $router->delete('/{id}', 'TarefaController@excluirPorId'); //ok Excluir tarefa

    });
});

$router->post('login',  'UsuarioController@login'); // Login de Usuarios
