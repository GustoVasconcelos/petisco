<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanoRegra extends Model
{
    protected $fillable = ['plano_id', 'servico_id', 'modalidade', 'desconto_pct'];

    // Uma regra pertence a um plano específico
    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class);
    }
}
?>