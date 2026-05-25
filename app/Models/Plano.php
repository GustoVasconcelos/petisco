<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plano extends Model
{
    protected $fillable = ['nome', 'valor', 'descricao', 'ativo'];

    // Um plano possui muitas regras de cobertura
    public function regras(): HasMany
    {
        // Nota: O contador de "Pets Assinantes" da tabela virá do relacionamento com os Pets no futuro.
        return $this->hasMany(PlanoRegra::class);
    }
}
?>