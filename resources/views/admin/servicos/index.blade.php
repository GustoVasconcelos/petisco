@extends('layouts.admin')

@section('title', 'Catálogo de Serviços')

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
                <h2 class="fw-bold text-secondary"><i class="bi bi-list-check text-primary me-2"></i>Serviços</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovoServico">
                    <i class="bi bi-plus-lg me-2"></i>Novo Serviço
                </button>
            </div>

            {{-- Busca --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <input type="text" id="buscaServico" class="form-control bg-light border-0"
                           placeholder="Buscar serviço por nome ou categoria..." oninput="filtrarServicos()">
                </div>
            </div>

            {{-- Tabela --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tabelaServicos">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Serviço</th>
                                    <th>Categoria</th>
                                    <th>Duração Est.</th>
                                    <th>Valor Base</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($servicos as $servico)
                                <tr data-busca="{{ strtolower($servico->nome . ' ' . $servico->categoria) }}">
                                    <td class="ps-4 fw-bold">{{ $servico->nome }}</td>
                                    <td>
                                        @php
                                            $badgeMap = [
                                                'Consulta'  => 'bg-info text-dark',
                                                'Vacina'    => 'bg-success',
                                                'Estética'  => 'bg-secondary',
                                                'Exame'     => 'bg-warning text-dark',
                                                'Cirurgia'  => 'bg-danger',
                                            ];
                                            $badgeClass = $badgeMap[$servico->categoria] ?? 'bg-primary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $servico->categoria }}</span>
                                    </td>
                                    <td>{{ $servico->duracao ? $servico->duracao . ' min' : '—' }}</td>
                                    <td class="text-success fw-bold">R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                                    <td class="text-end pe-4">
                                        {{-- Botão Editar --}}
                                        <button class="btn btn-sm btn-outline-secondary me-1"
                                                title="Editar"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarServico"
                                                data-id="{{ $servico->id }}"
                                                data-nome="{{ $servico->nome }}"
                                                data-categoria="{{ $servico->categoria }}"
                                                data-duracao="{{ $servico->duracao }}"
                                                data-valor="{{ $servico->valor }}"
                                                data-descricao="{{ $servico->descricao }}"
                                                onclick="preencherEdicao(this)">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        {{-- Botão Excluir --}}
                                        <button class="btn btn-sm btn-outline-danger"
                                                title="Excluir"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalExcluirServico"
                                                data-id="{{ $servico->id }}"
                                                data-nome="{{ $servico->nome }}"
                                                onclick="preencherExclusao(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="semRegistros">
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Nenhum serviço cadastrado ainda.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div id="semResultados" class="text-center text-muted py-5 d-none">
                            <i class="bi bi-search fs-1 d-block mb-2"></i>
                            Nenhum serviço encontrado para a busca.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL: NOVO SERVIÇO                                          --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalNovoServico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Novo Serviço</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form action="/admin/servicos/store" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nome do Serviço</label>
                            <input type="text" class="form-control" name="nome"
                                   placeholder="Ex: Vacina Antirrábica" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoria</label>
                            <select class="form-select" name="categoria" required>
                                <option value="">Selecione...</option>
                                <option value="Consulta">Consulta</option>
                                <option value="Vacina">Vacina</option>
                                <option value="Estética">Estética (Banho/Tosa)</option>
                                <option value="Exame">Exame</option>
                                <option value="Cirurgia">Cirurgia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Duração (minutos)</label>
                            <input type="number" class="form-control" name="duracao"
                                   placeholder="Ex: 45" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-success">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control border-success"
                                   name="valor" placeholder="0.00" min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descrição / Notas</label>
                            <textarea class="form-control" name="descricao" rows="3"
                                      placeholder="Informações adicionais sobre o serviço..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-check-lg me-1"></i>Salvar Serviço
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL: EDITAR SERVIÇO                                        --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalEditarServico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Serviço</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formEditar" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nome do Serviço</label>
                            <input type="text" class="form-control" id="editNome" name="nome" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoria</label>
                            <select class="form-select" id="editCategoria" name="categoria" required>
                                <option value="Consulta">Consulta</option>
                                <option value="Vacina">Vacina</option>
                                <option value="Estética">Estética (Banho/Tosa)</option>
                                <option value="Exame">Exame</option>
                                <option value="Cirurgia">Cirurgia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Duração (minutos)</label>
                            <input type="number" class="form-control" id="editDuracao" name="duracao" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-success">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control border-success"
                                   id="editValor" name="valor" min="0" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descrição / Notas</label>
                            <textarea class="form-control" id="editDescricao" name="descricao" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-secondary fw-bold">
                        <i class="bi bi-save me-1"></i>Atualizar Serviço
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL: CONFIRMAR EXCLUSÃO                                    --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalExcluirServico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-trash me-2"></i>Excluir Serviço</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-1">Tem certeza que deseja excluir o serviço:</p>
                <p class="fw-bold fs-5 text-danger" id="excluirNome"></p>
                <p class="text-muted small">Essa ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-2">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                <form id="formExcluir" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger fw-bold">
                        <i class="bi bi-trash me-1"></i>Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- SCRIPTS                                                      --}}
{{-- ============================================================ --}}
<script>
    // Preenche o modal de edição com os dados do serviço clicado
    function preencherEdicao(btn) {
        const id = btn.dataset.id;
        document.getElementById('formEditar').action = '/admin/servicos/update/' + id;
        document.getElementById('editNome').value      = btn.dataset.nome;
        document.getElementById('editDuracao').value   = btn.dataset.duracao;
        document.getElementById('editValor').value     = btn.dataset.valor;
        document.getElementById('editDescricao').value = btn.dataset.descricao;

        // Define a opção selecionada no select de categoria
        const sel = document.getElementById('editCategoria');
        for (let opt of sel.options) {
            opt.selected = opt.value === btn.dataset.categoria;
        }
    }

    // Preenche o modal de exclusão
    function preencherExclusao(btn) {
        const id = btn.dataset.id;
        document.getElementById('excluirNome').textContent = btn.dataset.nome;
        document.getElementById('formExcluir').action = '/admin/servicos/delete/' + id;
    }

    // Filtro de busca em tempo real
    function filtrarServicos() {
        const termo = document.getElementById('buscaServico').value.toLowerCase().trim();
        const linhas = document.querySelectorAll('#tabelaServicos tbody tr[data-busca]');
        let visiveis = 0;

        linhas.forEach(tr => {
            const match = tr.dataset.busca.includes(termo);
            tr.style.display = match ? '' : 'none';
            if (match) visiveis++;
        });

        const semResultados = document.getElementById('semResultados');
        if (semResultados) {
            semResultados.classList.toggle('d-none', visiveis > 0 || linhas.length === 0);
        }
    }
</script>
@endsection