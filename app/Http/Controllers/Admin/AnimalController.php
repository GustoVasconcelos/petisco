<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;

class AnimalController extends Controller
{
    public function index()
    {
        $animais = Animal::all();

        return view('admin.animais.index', compact('animais'));
    }

    public function store(Request $request)
    {
        Animal::create([
            'nome' => $request->nome,
            'tutor' => $request->tutor,
            'tipo' => $request->tipo,
            'raca' => $request->raca,
            'peso' => $request->peso,
            'nascimento' => $request->nascimento,
            'genero' => $request->genero,
            'porte' => $request->porte,
            'observacoes' => $request->observacoes
        ]);

        return redirect('/admin/animais')
            ->with('success', 'Animal cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        $animal->update([
            'nome' => $request->nome,
            'tutor' => $request->tutor,
            'tipo' => $request->tipo,
            'raca' => $request->raca,
            'peso' => $request->peso,
            'nascimento' => $request->nascimento,
            'genero' => $request->genero,
            'porte' => $request->porte,
            'observacoes' => $request->observacoes
        ]);

        return redirect('/admin/animais')
            ->with('success', 'Animal atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $animal = Animal::findOrFail($id);

        $animal->delete();

        return redirect('/admin/animais')
            ->with('success', 'Animal removido com sucesso!');
    }
}