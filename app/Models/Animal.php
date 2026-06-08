<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animais';

    protected $fillable = [
        'nome',
        'tutor_id',
        'tipo',
        'raca',
        'peso',
        'nascimento',
        'genero',
        'porte',
        'observacoes',
    ];

    // Um animal pertence a um tutor
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}