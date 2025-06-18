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







