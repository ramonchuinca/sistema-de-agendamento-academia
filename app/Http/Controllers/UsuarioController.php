<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Login simples: cria o usuário se não existir, ou retorna o existente
    public function login(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
        ]);

        // Tenta achar usuário pelo nome
        $usuario = Usuario::where('nome', $request->nome)->first();

        if (!$usuario) {
            // Cria novo usuário
            $usuario = Usuario::create($request->only('nome', 'peso', 'altura'));
        }

        return response()->json([
            'message' => 'Login efetuado com sucesso!',
            'usuario' => $usuario,
        ]);
    }
}
