<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendamentoController extends Controller
{
    // Listar todos agendamentos (pode ser filtrado por usuário)
    public function index(Request $request)
    {
        if ($request->has('usuario_id')) {
            $agendamentos = Agendamento::where('usuario_id', $request->usuario_id)->get();
        } else {
            $agendamentos = Agendamento::all();
        }

        return response()->json($agendamentos);
    }

    // Criar agendamento com limite de 5 por dia e horário permitido (08:00 - 09:20)
    public function store(Request $request)
    {
        var_dump($request->all());
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
        ]);

        $data = $request->data;
        $hora = $request->hora;

        // Verifica se horário está entre 08:00 e 09:20
        $horaCarbon = Carbon::createFromFormat('H:i', $hora);
        $horaMin = Carbon::createFromFormat('H:i', '08:00');
        $horaMax = Carbon::createFromFormat('H:i', '09:20');

        if ($horaCarbon->lt($horaMin) || $horaCarbon->gt($horaMax)) {
            return response()->json([
                'message' => 'Horário inválido. Só permitido agendar entre 08:00 e 09:20.'
            ], 422);
        }

        // Verifica limite de 5 agendamentos para a data
        $count = Agendamento::where('data', $data)->count();
        if ($count >= 5) {
            return response()->json([
                'message' => 'Limite de 5 agendamentos para essa data já foi atingido.'
            ], 422);
        }

        // Cria o agendamento
        $agendamento = Agendamento::create([
            'usuario_id' => $request->usuario_id,
            'data' => $data,
            'hora' => $hora,
        ]);

        return response()->json([
            'message' => 'Agendamento realizado com sucesso!',
            'agendamento' => $agendamento,
        ]);
    }


     public function horariosDisponiveis($data)
{
    $horariosPossiveis = ['08:00', '08:20', '08:40', '09:00', '09:20'];

    // Buscar os horários já agendados para a data
    $agendados = Agendamento::where('data', $data)->pluck('hora')->toArray();

    // Remover os horários já agendados da lista de horários possíveis
    $disponiveis = array_values(array_diff($horariosPossiveis, $agendados));

    return response()->json($disponiveis);
}



    public function agendar(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'hora' => 'required|string',
        ]);

        $usuario = auth()->user();

        // Validar se o horário está dentro do intervalo permitido
        $horariosPermitidos = ['08:00', '08:20', '08:40', '09:00', '09:20'];
        if (!in_array($request->hora, $horariosPermitidos)) {
            return response()->json(['erro' => 'Horário inválido. Escolha entre 08:00 e 09:20.'], 400);
        }

        // Verificar se o limite de 5 agendamentos já foi atingido na data
        $quantidade = Agendamento::where('data', $request->data)->count();
        if ($quantidade >= 5) {
            return response()->json(['erro' => 'Limite de 5 agendamentos por dia atingido.'], 400);
        }

        // Verificar se o horário já foi agendado
        $existe = Agendamento::where('data', $request->data)
            ->where('hora', $request->hora)
            ->exists();
        if ($existe) {
            return response()->json(['erro' => 'Esse horário já está agendado.'], 400);
        }

        // Criar agendamento
        $agendamento = Agendamento::create([
            'usuario_id' => $usuario->id,
            'data' => $request->data,
            'hora' => $request->hora,
        ]);

        return response()->json(['mensagem' => 'Agendamento realizado com sucesso!', 'agendamento' => $agendamento]);
    }

    
}
