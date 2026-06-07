<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plano extends Model
{
    protected $fillable = ['nome', 'valor', 'descricao', 'ativo'];

    // Um plano possui muitas regras de cobertura
    public function regras(): HasMany
    {
        // Nota: O contador de "Pets Assinantes" da tabela virá do relacionamento com os Pets no futuro.
        return $this->hasMany(PlanoRegra::class);
    }

    // Um plano pode incluir vários serviços
    public function servicos(): BelongsToMany
    {
        return $this->belongsToMany(Servico::class, 'plano_servico');
    }
}
?>