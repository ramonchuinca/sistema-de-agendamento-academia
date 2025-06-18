<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'data', 'hora'];

    // Um agendamento pertence a um usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}


