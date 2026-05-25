@extends('layouts.admin')

@section('title', 'Gerenciar Planos de Saúde')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary"><i class="bi bi-shield-check text-success me-2"></i>Planos de Saúde</h2>
                <button type="button" class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalPlano">
                    <i class="bi bi-plus-circle me-2"></i>Novo Plano
                </button>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome do Plano</th>
                                    <th>Valor Mensal</th>
                                    <th>Pets Assinantes</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- 1. LOOP DINÂMICO PARA LISTAR OS PLANOS --}}
                                @forelse($planos as $plano)
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            {{ $plano->nome }}
                                        </td>
                                        <td class="text-success fw-bold">
                                            R$ {{ number_format($plano->valor, 2, ',', '.') }}
                                        </td>
                                        <td>
                                            {{-- Estático por enquanto, até criar a relação com Pets futuramente --}}
                                            0
                                        </td>
                                        <td>
                                            @if($plano->ativo)
                                                <span class="badge bg-success bg-opacity-25 text-success">Ativo</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-25 text-danger">Inativo</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" title="{{ $plano->ativo ? 'Inativar' : 'Ativar' }}">
                                                <i class="bi bi-power"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Mensagem exibida caso a tabela do banco esteja vazia --}}
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Nenhum plano de saúde cadastrado ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPlano" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Configurar Plano de Saúde</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- 2. ROTAS DO FORMULÁRIO --}}
            <form action="{{ route('planos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-light">
                    
                    <div class="row">
                        <div class="col-md-4 border-end pe-4">
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informações Básicas</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nome do Plano</label>
                                {{-- Ajustado 'name="nome"' para casar com o banco --}}
                                <input type="text" class="form-control" name="nome" placeholder="Ex: Ouro, Premium..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-success">Valor Mensal (R$)</label>
                                <input type="number" step="0.01" class="form-control border-success" name="valor" placeholder="0.00" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Descrição Comercial</label>
                                <textarea class="form-control" name="descricao" rows="4" placeholder="Breve texto para apresentar o plano..."></textarea>
                            </div>
                        </div>

                        <div class="col-md-8 ps-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                <h6 class="fw-bold text-secondary mb-0">Cobertura e Descontos (Regras)</h6>
                                <button type="button" class="btn btn-sm btn-primary fw-bold" id="btnAddRegra">
                                    <i class="bi bi-plus-lg"></i> Adicionar Regra
                                </button>
                            </div>
                            
                            <div id="regrasContainer">
                                <div class="row g-2 mb-2 regra-linha align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label small text-muted mb-1">Serviço / Produto</label>
                                        <select class="form-select" name="servico_id[]" required>
                                            <option value="" selected disabled>Selecione...</option>
                                            <option value="1">Consulta de Rotina</option>
                                            <option value="2">Vacina V10</option>
                                            <option value="3">Vacina Antirrábica</option>
                                            <option value="4">Banho e Tosa</option>
                                            <option value="5">Exame de Sangue</option>
                                            <option value="6">Produtos do PetShop (Geral)</option>
                                            <option value="7">Vacina contra a gripe canina</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted mb-1">Modalidade</label>
                                        <select class="form-select select-modalidade" name="modalidade[]" required>
                                            <option value="incluso">Totalmente Incluso (Grátis)</option>
                                            <option value="desconto">Oferecer Desconto</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 div-desconto d-none">
                                        <label class="form-label small text-muted mb-1">Desconto %</label>
                                        <input type="number" class="form-control" name="desconto_pct[]" placeholder="Ex: 20">
                                    </div>
                                    <div class="col-md-1 text-end">
                                        <button type="button" class="btn btn-outline-danger btn-remover-regra" title="Remover regra" disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-3 small border-0 bg-info bg-opacity-10 text-primary">
                                <i class="bi bi-info-circle me-1"></i> Adicione os serviços que fazem parte deste plano. Se um serviço não estiver listado aqui, o sistema cobrará o valor integral na agenda.
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success fw-bold">Salvar Plano</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mantive todo o seu script JavaScript idêntico, pois a lógica de clonagem está perfeita.
    document.addEventListener('DOMContentLoaded', function() {
        const btnAddRegra = document.getElementById('btnAddRegra');
        const container = document.getElementById('regrasContainer');

        function bindModalidadeChange(selectElement) {
            selectElement.addEventListener('change', function() {
                const row = this.closest('.regra-linha');
                const divDesconto = row.querySelector('.div-desconto');
                const inputDesconto = row.querySelector('input[name="desconto_pct[]"]');

                if (this.value === 'desconto') {
                    divDesconto.classList.remove('d-none');
                    inputDesconto.setAttribute('required', 'required');
                } else {
                    divDesconto.classList.add('d-none');
                    inputDesconto.removeAttribute('required');
                    inputDesconto.value = '';
                }
            });
        }

        function bindRemoverRegra(btnElement) {
            btnElement.addEventListener('click', function() {
                const row = this.closest('.regra-linha');
                if (container.querySelectorAll('.regra-linha').length > 1) {
                    row.remove();
                }
            });
        }

        const firstSelect = container.querySelector('.select-modalidade');
        bindModalidadeChange(firstSelect);

        btnAddRegra.addEventListener('click', function() {
            const originalRow = container.querySelector('.regra-linha');
            const newRow = originalRow.cloneNode(true);
            
            newRow.querySelector('select[name="servico_id[]"]').value = "";
            newRow.querySelector('select[name="modalidade[]"]').value = "incluso";
            newRow.querySelector('input[name="desconto_pct[]"]').value = "";
            newRow.querySelector('input[name="desconto_pct[]"]').removeAttribute('required');
            newRow.querySelector('.div-desconto').classList.add('d-none');
            
            const btnRemove = newRow.querySelector('.btn-remover-regra');
            btnRemove.removeAttribute('disabled');
            
            bindModalidadeChange(newRow.querySelector('.select-modalidade'));
            bindRemoverRegra(btnRemove);

            const allRemoveBtns = container.querySelectorAll('.btn-remover-regra');
            allRemoveBtns.forEach(btn => btn.removeAttribute('disabled'));

            container.appendChild(newRow);
        });
    });
</script>
@endsection