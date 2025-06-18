<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AgendamentoController;

Route::post('/login', [UsuarioController::class, 'login']);
Route::get('/usuario', [UsuarioController::class, 'login']);
Route::resource('/agendar', AgendamentoController::class);
Route::get('/horarios-disponiveis/{data}', [AgendamentoController::class, 'horariosDisponiveis']);
Route::get('/meus-agendamentos', [AgendamentoController::class, 'meusAgendamentos']);


Route::middleware(['auth:sanctum', 'admin'])->get('/admin/agendamentos', [AgendamentoController::class, 'listarTodos']);

Route::get('/vagas-restantes/{data}', [AgendamentoController::class, 'vagasRestantes']);


use Illuminate\Support\Carbon;

Route::get('/painel-secreto-agendamentos', function (Request $request) {
    if ($request->query('token') !== 'meu-token-super-secreto-123') {
        return response()->json(['message' => 'Acesso negado'], 403);
    }

    $hoje = Carbon::today()->toDateString();

    $agendamentos = \App\Models\Agendamento::with('usuario')
        ->where('data', $hoje)
        ->orderBy('hora')
        ->get();

    return response()->json($agendamentos);
});








