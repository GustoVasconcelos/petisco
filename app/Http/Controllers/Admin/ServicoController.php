<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servico;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::orderBy('nome')->get();
        return view('admin.servicos.index', compact('servicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'duracao'   => 'nullable|integer|min:1',
            'valor'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);

        Servico::create([
            'nome'      => $request->nome,
            'categoria' => $request->categoria,
            'duracao'   => $request->duracao,
            'valor'     => $request->valor,
            'descricao' => $request->descricao,
        ]);

        return redirect('/admin/servicos')
            ->with('success', 'Serviço cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome'      => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'duracao'   => 'nullable|integer|min:1',
            'valor'     => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);

        $servico = Servico::findOrFail($id);

        $servico->update([
            'nome'      => $request->nome,
            'categoria' => $request->categoria,
            'duracao'   => $request->duracao,
            'valor'     => $request->valor,
            'descricao' => $request->descricao,
        ]);

        return redirect('/admin/servicos')
            ->with('success', 'Serviço atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return redirect('/admin/servicos')
            ->with('success', 'Serviço removido com sucesso!');
    }
}
