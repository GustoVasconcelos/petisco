@extends('layouts.admin')

@section('title', 'Gerenciar Animais')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">

            {{-- Alertas --}}
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
                <h2 class="fw-bold text-secondary"><i class="bi bi-heart-fill text-danger me-2"></i>Animais</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovoAnimal">
                    <i class="bi bi-plus-lg me-2"></i>Novo Animal
                </button>
            </div>

            {{-- Busca --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="buscaAnimal" class="form-control bg-light border-start-0"
                               placeholder="Buscar animal por nome, tutor ou raça..." oninput="filtrarAnimais()">
                    </div>
                </div>
            </div>

            {{-- Tabela --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tabelaAnimais">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome</th>
                                    <th>Espécie / Raça</th>
                                    <th>Tutor</th>
                                    <th>Peso</th>
                                    <th>Porte</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($animais as $animal)
                                <tr data-busca="{{ strtolower($animal->nome . ' ' . ($animal->tutor?->nome ?? '') . ' ' . $animal->raca) }}">
                                    <td class="ps-4 fw-bold">{{ $animal->nome }}</td>

                                    <td>
                                        <span class="badge bg-primary">{{ $animal->tipo }}</span>
                                        <div class="small text-muted">{{ $animal->raca }}</div>
                                    </td>

                                    <td>
                                        @if($animal->tutor)
                                            <span class="fw-semibold">{{ $animal->tutor->nome }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Sem tutor</span>
                                        @endif
                                    </td>

                                    <td>{{ $animal->peso ? $animal->peso . ' kg' : '—' }}</td>

                                    <td>
                                        @php
                                            $porteMap = ['P' => 'Pequeno', 'M' => 'Médio', 'G' => 'Grande'];
                                        @endphp
                                        {{ $porteMap[$animal->porte] ?? '—' }}
                                    </td>

                                    <td class="text-end pe-4">
                                        {{-- Botão Editar --}}
                                        <button class="btn btn-sm btn-outline-secondary me-1"
                                                title="Editar"
                                                onclick="preencherEdicao({{ $animal->id }}, '{{ addslashes($animal->nome) }}', {{ $animal->tutor_id ?? 'null' }}, '{{ addslashes($animal->tipo) }}', '{{ addslashes($animal->raca) }}', '{{ $animal->peso }}', '{{ $animal->nascimento }}', '{{ $animal->genero }}', '{{ $animal->porte }}', '{{ addslashes($animal->observacoes) }}')"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarAnimal">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        {{-- Botão Excluir --}}
                                        <form action="/admin/animais/delete/{{ $animal->id }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Deseja excluir {{ addslashes($animal->nome) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr id="semRegistros">
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Nenhum animal cadastrado ainda.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div id="semResultados" class="text-center text-muted py-5 d-none">
                            <i class="bi bi-search fs-1 d-block mb-2"></i>
                            Nenhum animal encontrado para a busca.
                        </div>
                    </div>
                </div>

                {{-- Paginação --}}
                @if($animais->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $animais->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- ================================================================ --}}
{{-- MODAL: NOVO ANIMAL                                               --}}
{{-- ================================================================ --}}
<div class="modal fade" id="modalNovoAnimal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Cadastrar Novo Animal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/animais/store" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome do Animal</label>
                            <input type="text" class="form-control bg-light" name="nome" placeholder="Ex: Rex" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tutor (Responsável)</label>
                            <select class="form-select bg-light" name="tutor_id" required>
                                <option value="" selected disabled>Selecione um tutor...</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Espécie</label>
                            <input type="text" class="form-control bg-light" name="tipo" placeholder="Ex: Cão, Gato..." required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Raça</label>
                            <input type="text" class="form-control bg-light" name="raca" placeholder="Ex: Poodle">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control bg-light" name="peso" placeholder="0.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Data de Nascimento</label>
                            <input type="date" class="form-control bg-light" name="nascimento">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Gênero</label>
                            <div class="mt-2 d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="novo_macho" value="M">
                                    <label class="form-check-label" for="novo_macho">Macho</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="novo_femea" value="F">
                                    <label class="form-check-label" for="novo_femea">Fêmea</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Porte</label>
                            <select class="form-select bg-light" name="porte">
                                <option value="">Selecione...</option>
                                <option value="P">Pequeno</option>
                                <option value="M">Médio</option>
                                <option value="G">Grande</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Observações / Alergias</label>
                            <textarea class="form-control bg-light" name="observacoes" rows="3"
                                      placeholder="Informações médicas importantes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-check-lg me-1"></i>Salvar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================ --}}
{{-- MODAL: EDITAR ANIMAL (único, preenchido via JS)                  --}}
{{-- ================================================================ --}}
<div class="modal fade" id="modalEditarAnimal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Animal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditarAnimal" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome do Animal</label>
                            <input type="text" class="form-control bg-light" id="editNome" name="nome" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tutor (Responsável)</label>
                            <select class="form-select bg-light" id="editTutorId" name="tutor_id" required>
                                <option value="" disabled>Selecione um tutor...</option>
                                @foreach($tutores as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Espécie</label>
                            <input type="text" class="form-control bg-light" id="editTipo" name="tipo" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Raça</label>
                            <input type="text" class="form-control bg-light" id="editRaca" name="raca">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Peso (kg)</label>
                            <input type="number" step="0.01" class="form-control bg-light" id="editPeso" name="peso">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Data de Nascimento</label>
                            <input type="date" class="form-control bg-light" id="editNascimento" name="nascimento">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Gênero</label>
                            <select class="form-select bg-light" id="editGenero" name="genero">
                                <option value="">Selecione...</option>
                                <option value="M">Macho</option>
                                <option value="F">Fêmea</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Porte</label>
                            <select class="form-select bg-light" id="editPorte" name="porte">
                                <option value="">Selecione...</option>
                                <option value="P">Pequeno</option>
                                <option value="M">Médio</option>
                                <option value="G">Grande</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Observações / Alergias</label>
                            <textarea class="form-control bg-light" id="editObservacoes" name="observacoes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-secondary fw-bold">
                        <i class="bi bi-save me-1"></i>Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Preenche o modal de edição com os dados do animal clicado
    function preencherEdicao(id, nome, tutorId, tipo, raca, peso, nascimento, genero, porte, observacoes) {
        document.getElementById('formEditarAnimal').action = '/admin/animais/update/' + id;
        document.getElementById('editNome').value        = nome;
        document.getElementById('editTipo').value        = tipo;
        document.getElementById('editRaca').value        = raca;
        document.getElementById('editPeso').value        = peso;
        document.getElementById('editNascimento').value  = nascimento;
        document.getElementById('editObservacoes').value = observacoes;

        // Seleciona o tutor correto no select
        const selTutor = document.getElementById('editTutorId');
        for (let opt of selTutor.options) {
            opt.selected = opt.value == tutorId;
        }

        // Seleciona o gênero correto
        const selGenero = document.getElementById('editGenero');
        for (let opt of selGenero.options) {
            opt.selected = opt.value === genero;
        }

        // Seleciona o porte correto
        const selPorte = document.getElementById('editPorte');
        for (let opt of selPorte.options) {
            opt.selected = opt.value === porte;
        }
    }

    // Filtro de busca em tempo real
    function filtrarAnimais() {
        const termo = document.getElementById('buscaAnimal').value.toLowerCase().trim();
        const linhas = document.querySelectorAll('#tabelaAnimais tbody tr[data-busca]');
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