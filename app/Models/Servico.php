<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servico extends Model
{
    protected $fillable = [
        'nome',
        'categoria',
        'duracao',
        'valor',
        'descricao',
    ];

    // Um serviço pode pertencer a vários planos
    public function planos(): BelongsToMany
    {
        return $this->belongsToMany(Plano::class, 'plano_servico');
    }
}
