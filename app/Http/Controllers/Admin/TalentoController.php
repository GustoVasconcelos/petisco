<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talento;

class TalentoController extends Controller
{
    //para teste
    //public function index()
    //{
    //    die('ESTE É O CONTROLLER EM EXECUÇÃO');
    //}

    //function index()
    //{
    //    dd('funcionando');
    //}

    public function index()
    {
        $talentos = Talento::all();

        return view('admin.talentos.index', compact('talentos'));
    }
    public function store(Request $request)
    {
        Talento::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'cargo' => $request->cargo,
            'crmv' => $request->crmv,
            'turno' => $request->turno,
            'status' => 'Ativo'
        ]);

        return redirect('/admin/talentos')
            ->with('success', 'Funcionário cadastrado com sucesso!');
    }
    
    public function update(Request $request, $id)
    {
        $talento = Talento::findOrFail($id);

        $talento->update([
            'nome' => $request->nome,
            'cargo' => $request->cargo,
            'telefone' => $request->telefone,
            'crmv' => $request->crmv,
        ]);

        return redirect('/admin/talentos')->with('success', 'Talento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $talento = Talento::findOrFail($id);

        $talento->delete();

        return redirect('/admin/talentos')
            ->with('success', 'Funcionário removido com sucesso!');
    }
}