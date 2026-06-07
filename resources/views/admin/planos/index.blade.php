@extends('layouts.admin')

@section('title', 'Gerenciar Planos de Saúde')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">

            {{-- Alertas de sucesso/erro --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Corrija os erros abaixo:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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
                                    <th>Serviços Incluídos</th>
                                    <th>Pets Assinantes</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($planos as $plano)
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            {{ $plano->nome }}
                                            @if($plano->descricao)
                                                <div class="text-muted small fw-normal">{{ Str::limit($plano->descricao, 60) }}</div>
                                            @endif
                                        </td>
                                        <td class="text-success fw-bold">
                                            R$ {{ number_format($plano->valor, 2, ',', '.') }}
                                        </td>
                                        <td>
                                            @if($plano->regras->count() > 0)
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($plano->regras as $regra)
                                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 small">
                                                            @if($regra->modalidade === 'incluso')
                                                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                            @else
                                                                <i class="bi bi-percent text-warning me-1"></i>
                                                            @endif
                                                            {{ $regra->servico?->nome ?? 'Serviço removido' }}
                                                            @if($regra->modalidade === 'desconto' && $regra->desconto_pct)
                                                                <span class="text-warning">({{ $regra->desconto_pct }}%)</span>
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted small">Nenhum serviço</span>
                                            @endif
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
                                            <div class="d-flex justify-content-end gap-1">
                                                {{-- Botão de Editar --}}
                                                <button class="btn btn-sm btn-outline-secondary btn-editar-plano" data-id="{{ $plano->id }}" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                        
                                                {{-- Formulário para Ativar/Inativar --}}
                                                <form action="{{ route('planos.status', $plano->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $plano->ativo ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $plano->ativo ? 'Inativar Plano' : 'Ativar Plano' }}">
                                                        <i class="bi bi-power"></i>
                                                    </button>
                                                </form>
                                        
                                                {{-- Formulário para Deletar --}}
                                                <form action="{{ route('planos.destroy', $plano->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir permanentemente este plano e todas as suas regras?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Plano">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
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

{{-- ================================================================ --}}
{{-- MODAL: NOVO PLANO                                                --}}
{{-- ================================================================ --}}
<div class="modal fade" id="modalPlano" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Configurar Plano de Saúde</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('planos.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 bg-light">
                    
                    <div class="row">
                        <div class="col-md-4 border-end pe-4">
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informações Básicas</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nome do Plano</label>
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
                                            @foreach($servicos as $servico)
                                                <option value="{{ $servico->id }}">{{ $servico->nome }}</option>
                                            @endforeach
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

{{-- ================================================================ --}}
{{-- MODAL: EDITAR PLANO                                              --}}
{{-- ================================================================ --}}
<div class="modal fade" id="modalEditarPlano" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Editar Plano de Saúde</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarPlano" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-light">
                    <div class="row">
                        <div class="col-md-4 border-end pe-4">
                            <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Informações Básicas</h6>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nome do Plano</label>
                                <input type="text" class="form-control" name="nome" id="edit_nome" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-success">Valor Mensal (R$)</label>
                                <input type="number" step="0.01" class="form-control border-success" name="valor" id="edit_valor" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Descrição Comercial</label>
                                <textarea class="form-control" name="descricao" id="edit_descricao" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="col-md-8 ps-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                <h6 class="fw-bold text-secondary mb-0">Cobertura e Descontos (Regras)</h6>
                                <button type="button" class="btn btn-sm btn-primary fw-bold" id="btnEditAddRegra">
                                    <i class="bi bi-plus-lg"></i> Adicionar Regra
                                </button>
                            </div>
                            
                            <div id="editRegrasContainer">
                                {{-- As linhas de regras serão injetadas dinamicamente via JS --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success fw-bold">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Passa a lista de serviços para o JS de forma segura --}}
<script>
    const servicosDisponiveis = @json($servicos->map(fn($s) => ['id' => $s->id, 'nome' => $s->nome]));
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==========================================
        // LÓGICA DO MODAL DE CRIAÇÃO (NOVO PLANO)
        // ==========================================
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
        if (firstSelect) bindModalidadeChange(firstSelect);

        if (btnAddRegra) {
            btnAddRegra.addEventListener('click', function() {
                const newRow = criarLinhaRegra();
                container.appendChild(newRow);

                const allRemoveBtns = container.querySelectorAll('.btn-remover-regra');
                allRemoveBtns.forEach(btn => btn.removeAttribute('disabled'));
            });
        }

        // ==========================================
        // LÓGICA DO MODAL DE EDIÇÃO
        // ==========================================
        document.querySelectorAll('.btn-editar-plano').forEach(botao => {
            botao.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                
                fetch(`/admin/planos/${id}/edit`)
                    .then(response => response.json())
                    .then(plano => {
                        document.getElementById('formEditarPlano').setAttribute('action', `/admin/planos/${id}`);
                        document.getElementById('edit_nome').value = plano.nome;
                        document.getElementById('edit_valor').value = plano.valor;
                        document.getElementById('edit_descricao').value = plano.descricao ?? '';

                        const containerEdit = document.getElementById('editRegrasContainer');
                        containerEdit.innerHTML = '';

                        plano.regras.forEach((regra) => {
                            adicionarLinhaRegraEdicao(regra);
                        });

                        if (plano.regras.length === 0) {
                            adicionarLinhaRegraEdicao();
                        }

                        const modal = new bootstrap.Modal(document.getElementById('modalEditarPlano'));
                        modal.show();
                    });
            });
        });

        const btnEditAddRegra = document.getElementById('btnEditAddRegra');
        if (btnEditAddRegra) {
            btnEditAddRegra.addEventListener('click', () => adicionarLinhaRegraEdicao());
        }
    });

    // Gera o HTML de opções de serviços dinamicamente
    function gerarOpcoesServicos(servicoIdSelecionado = null) {
        return servicosDisponiveis.map(s => {
            const selected = servicoIdSelecionado && s.id == servicoIdSelecionado ? 'selected' : '';
            return `<option value="${s.id}" ${selected}>${s.nome}</option>`;
        }).join('');
    }

    // Cria uma nova linha de regra para o modal de CRIAÇÃO
    function criarLinhaRegra() {
        const div = document.createElement('div');
        div.className = 'row g-2 mb-2 regra-linha align-items-end';
        div.innerHTML = `
            <div class="col-md-5">
                <label class="form-label small text-muted mb-1">Serviço / Produto</label>
                <select class="form-select" name="servico_id[]" required>
                    <option value="" disabled selected>Selecione...</option>
                    ${gerarOpcoesServicos()}
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
                <button type="button" class="btn btn-outline-danger btn-remover-regra" title="Remover regra">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;

        div.querySelector('.select-modalidade').addEventListener('change', function() {
            const divDesc = div.querySelector('.div-desconto');
            const inpDesc = div.querySelector('input[name="desconto_pct[]"]');
            if (this.value === 'desconto') {
                divDesc.classList.remove('d-none');
                inpDesc.setAttribute('required', 'required');
            } else {
                divDesc.classList.add('d-none');
                inpDesc.removeAttribute('required');
                inpDesc.value = '';
            }
        });

        div.querySelector('.btn-remover-regra').addEventListener('click', function() {
            const container = document.getElementById('regrasContainer');
            if (container.querySelectorAll('.regra-linha').length > 1) {
                div.remove();
            }
        });

        return div;
    }

    // Adiciona uma linha de regra ao modal de EDIÇÃO
    function adicionarLinhaRegraEdicao(regra = null) {
        const container = document.getElementById('editRegrasContainer');
        const dNoneClass = (regra && regra.modalidade === 'desconto') ? '' : 'd-none';
        const reqAttr    = (regra && regra.modalidade === 'desconto') ? 'required' : '';
        
        const html = `
            <div class="row g-2 mb-2 regra-linha align-items-end">
                <div class="col-md-5">
                    <select class="form-select" name="servico_id[]" required>
                        <option value="" disabled>Selecione...</option>
                        ${gerarOpcoesServicos(regra ? regra.servico_id : null)}
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select select-modalidade-edit" name="modalidade[]" required>
                        <option value="incluso" ${regra && regra.modalidade === 'incluso' ? 'selected' : ''}>Totalmente Incluso (Grátis)</option>
                        <option value="desconto" ${regra && regra.modalidade === 'desconto' ? 'selected' : ''}>Oferecer Desconto</option>
                    </select>
                </div>
                <div class="col-md-2 div-desconto-edit ${dNoneClass}">
                    <input type="number" class="form-control" name="desconto_pct[]" value="${regra ? (regra.desconto_pct ?? '') : ''}" ${reqAttr}>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-remover-regra-edit"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', html);
        
        const linhas = container.querySelectorAll('.regra-linha');
        const ultimaLinha = linhas[linhas.length - 1];
        
        ultimaLinha.querySelector('.select-modalidade-edit').addEventListener('change', function() {
            const divDesc = ultimaLinha.querySelector('.div-desconto-edit');
            const inpDesc = ultimaLinha.querySelector('input[name="desconto_pct[]"]');
            if (this.value === 'desconto') {
                divDesc.classList.remove('d-none');
                inpDesc.setAttribute('required', 'required');
            } else {
                divDesc.classList.add('d-none');
                inpDesc.removeAttribute('required');
                inpDesc.value = '';
            }
        });

        ultimaLinha.querySelector('.btn-remover-regra-edit').addEventListener('click', function() {
            if (container.querySelectorAll('.regra-linha').length > 1) {
                ultimaLinha.remove();
            }
        });
    }
</script>
@endsection