<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use App\Models\PlanoRegra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    /**
     * Exibe a listagem de planos.
     */
    public function index()
    {
        // Busca todos os planos do banco de dados
        $planos = Plano::all();

        // Retorna a sua view enviando a variável $planos
        return view('admin.planos.index', compact('planos'));
    }

    /**
     * Salva o novo plano e suas regras de cobertura.
     */
    public function store(Request $request)
    {
        // 1. Validação simples dos dados recebidos do formulário
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'servico_id' => 'required|array',
            'modalidade' => 'required|array',
            'desconto_pct' => 'nullable|array',
        ]);

        // 2. Uso de Transaction para garantir que se a regra falhar, o plano não seja salvo sozinho
        DB::transaction(function () use ($request) {
            
            // Cria o registro principal do Plano de Saúde
            $plano = Plano::create([
                'nome' => $request->nome,
                'valor' => $request->valor,
                'descricao' => $request->descricao,
                'ativo' => true, // Todo plano nasce ativo
            ]);

            // Percorre os arrays das regras dinâmicas vindas do formulário
            foreach ($request->servico_id as $index => $servicoId) {
                // Só cria a regra se o serviço tiver sido selecionado corretamente
                if (!empty($servicoId)) {
                    PlanoRegra::create([
                        'plano_id' => $plano->id,
                        'servico_id' => $servicoId,
                        'modalidade' => $request->modalidade[$index],
                        // Se for a modalidade 'incluso', grava nulo, se for 'desconto' pega o valor do array correspondente
                        'desconto_pct' => $request->modalidade[$index] === 'desconto' ? $request->desconto_pct[$index] : null,
                    ]);
                }
            }
        });

        // Retorna para a mesma página com uma mensagem de sucesso no padrão do Laravel
        return redirect()->back()->with('success', 'Plano de Saúde configurado com sucesso!');
    }
}