<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'peso', 'altura'];

    // Um usuário tem muitos agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
