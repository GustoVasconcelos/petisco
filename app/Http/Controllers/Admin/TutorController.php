<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Tutor::query();

        if ($search) {
            $query->where('nome', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
        }

        $tutores = $query->paginate(10);
        return view('admin.tutores.index', compact('tutores', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:tutors',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'cep' => 'nullable|string|max:20',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
        ]);

        Tutor::create($validated);

        return redirect()->route('tutores.index')->with('success', 'Tutor registrado com sucesso!');
    }

    public function update(Request $request, string $id)
    {
        $tutor = Tutor::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:tutors,cpf,' . $tutor->id,
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'cep' => 'nullable|string|max:20',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
        ]);

        $tutor->update($validated);

        return redirect()->route('tutores.index')->with('success', 'Tutor atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->delete();

        return redirect()->route('tutores.index')->with('success', 'Tutor excluído com sucesso!');
    }
}
