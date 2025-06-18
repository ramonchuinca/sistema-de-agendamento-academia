<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Login simples: cria o usuário se não existir, ou retorna o existente
public function login(Request $request)
{
    // Validação dos dados recebidos
    $request->validate([
        'nome' => 'required|string',
        'peso' => 'required|numeric',
        'altura' => 'required|numeric',
    ]);

    // Opcional: converter para float para garantir o tipo
    $request->merge([
        'peso' => floatval($request->peso),
        'altura' => floatval($request->altura),
    ]);

    // Criar usuário sempre que logar (como seu código original)
    $usuario = Usuario::create([
        'nome' => $request->nome,
        'peso' => $request->peso,
        'altura' => $request->altura,
    ]);

    return response()->json([
        'message' => 'Login efetuado com sucesso!',
        'usuario' => $usuario,
        // Se usar autenticação, poderia retornar token aqui
    ]);
}







     public function index(Request $request)
    {
     

        // Tenta achar usuário pelo nome
        $usuario = Usuario::get();

       
        return response()->json([
            'message' => 'Login efetuado com sucesso!',
            'usuario' => $usuario,
        ]);
    }
}
