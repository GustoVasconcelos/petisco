<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animais';

    protected $fillable = [
        'nome',
        'tutor',
        'tipo',
        'raca',
        'peso',
        'nascimento',
        'genero',
        'porte',
        'observacoes'
    ];
}