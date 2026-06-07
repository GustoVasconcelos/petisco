<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use App\Models\PlanoRegra;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    /**
     * Exibe a listagem de planos.
     */
    public function index()
    {
        // Busca todos os planos com suas regras e serviços vinculados
        $planos = Plano::with('regras.servico')->get();

        // Busca todos os serviços disponíveis para popular os selects do formulário
        $servicos = Servico::orderBy('nome')->get();

        return view('admin.planos.index', compact('planos', 'servicos'));
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

    /**
     * Alterna o status do plano entre ativo e inativo.
     */
    public function toggleStatus(int $id)
    {
        $plano = Plano::findOrFail($id);
        $plano->ativo = !$plano->ativo;
        $plano->save();
    
        $status = $plano->ativo ? 'ativado' : 'inativado';
        return redirect()->back()->with('success', "Plano de Saúde {$status} com sucesso!");
    }
    
    /**
     * Exclui o plano do banco de dados.
     */
    public function destroy(int $id)
    {
        DB::transaction(function () use ($id) {
            // Encontra o plano
            $plano = Plano::findOrFail($id);
            
            // Remove primeiro as regras vinculadas para não quebrar a integridade
            PlanoRegra::where('plano_id', $plano->id)->delete();
            
            // Remove o plano
            $plano->delete();
        });
    
        return redirect()->back()->with('success', 'Plano de Saúde excluído com sucesso!');
    }

    /**
     * Retorna os dados do plano e suas regras em formato JSON para o modal.
     */
    public function edit(int $id)
    {
        // Busca o plano carregando junto as suas regras e os serviços de cada regra
        $plano = Plano::with('regras.servico')->findOrFail($id);
        return response()->json($plano);
    }

    /**
     * Atualiza os dados do plano e suas regras de cobertura.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'descricao' => 'nullable|string',
            'servico_id' => 'required|array',
            'modalidade' => 'required|array',
            'desconto_pct' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $id) {
            $plano = Plano::findOrFail($id);
            
            // Atualiza os dados básicos
            $plano->update([
                'nome' => $request->nome,
                'valor' => $request->valor,
                'descricao' => $request->descricao,
            ]);

            // Remove as regras antigas para reinserir as atualizadas
            PlanoRegra::where('plano_id', $plano->id)->delete();

            // Insere as novas regras vindas do modal de edição
            foreach ($request->servico_id as $index => $servicoId) {
                if (!empty($servicoId)) {
                    PlanoRegra::create([
                        'plano_id' => $plano->id,
                        'servico_id' => $servicoId,
                        'modalidade' => $request->modalidade[$index],
                        'desconto_pct' => $request->modalidade[$index] === 'desconto' ? $request->desconto_pct[$index] : null,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Plano de Saúde atualizado com sucesso!');
    }
}