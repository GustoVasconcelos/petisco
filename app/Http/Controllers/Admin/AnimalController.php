<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Tutor;

class AnimalController extends Controller
{
    public function index()
    {
        // Carrega os animais com o tutor relacionado e pagina os resultados
        $animais = Animal::with('tutor')->orderBy('nome')->paginate(15);
        $tutores = Tutor::orderBy('nome')->get();

        return view('admin.animais.index', compact('animais', 'tutores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'       => 'required|string|max:255',
            'tutor_id'   => 'required|exists:tutors,id',
            'tipo'       => 'required|string|max:100',
            'raca'       => 'nullable|string|max:100',
            'peso'       => 'nullable|numeric|min:0',
            'nascimento' => 'nullable|date',
            'genero'     => 'nullable|in:M,F',
            'porte'      => 'nullable|in:P,M,G',
            'observacoes'=> 'nullable|string',
        ]);

        Animal::create($request->only([
            'nome', 'tutor_id', 'tipo', 'raca',
            'peso', 'nascimento', 'genero', 'porte', 'observacoes',
        ]));

        return redirect('/admin/animais')
            ->with('success', 'Animal cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        $request->validate([
            'nome'       => 'required|string|max:255',
            'tutor_id'   => 'required|exists:tutors,id',
            'tipo'       => 'required|string|max:100',
            'raca'       => 'nullable|string|max:100',
            'peso'       => 'nullable|numeric|min:0',
            'nascimento' => 'nullable|date',
            'genero'     => 'nullable|in:M,F',
            'porte'      => 'nullable|in:P,M,G',
            'observacoes'=> 'nullable|string',
        ]);

        $animal->update($request->only([
            'nome', 'tutor_id', 'tipo', 'raca',
            'peso', 'nascimento', 'genero', 'porte', 'observacoes',
        ]));

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