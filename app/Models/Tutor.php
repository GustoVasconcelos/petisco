<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tutor extends Model
{
    protected $fillable = [
        'nome', 'cpf', 'telefone', 'email', 'cep', 
        'logradouro', 'numero', 'complemento', 'bairro', 'cidade'
    ];

    // Um tutor pode ter vários animais
    public function animais(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
