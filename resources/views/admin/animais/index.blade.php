@extends('layouts.admin')

@section('title', 'Gerenciar Animais')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')
        <div class="col py-4 px-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary"><i class="bi bi-heart-fill text-danger me-2"></i>Animais</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalAnimal">
                    <i class="bi bi-plus-lg me-2"></i>Novo Animal
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" placeholder="Buscar animal por nome...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome</th>
                                    <th>Espécie / Raça</th>
                                    <th>Tutor</th>
                                    <th>Peso</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($animais as $animal)
                                <tr>
                                        <td class="ps-4 fw-bold">
                                            {{ $animal->nome }}
                                        </td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $animal->tipo }}
                                            </span>

                                            <div class="small text-muted">
                                                {{ $animal->raca }}
                                            </div>
                                        </td>

                                        <td>
                                            {{ $animal->tutor }}
                                        </td>

                                        <td>
                                            {{ $animal->peso }} kg
                                        </td>

                                        <td class="text-end pe-4">

                                            <button
                                                class="btn btn-sm btn-outline-secondary me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditar{{ $animal->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="/admin/animais/delete/{{ $animal->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Deseja excluir este animal?')">
                                                    <i class="bi bi-person-slash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Nenhum animal encontrado
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <nav>
                        <ul class="pagination pagination-sm mb-0 justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAnimal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="tituloModal">Cadastrar Novo Animal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <select class="form-select bg-light" name="tutor">
                                <option selected disabled>Selecione um tutor...</option>
                                <option value="1">Victor Orlandi</option>
                                <option value="2">Augusto Vasconcelos</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Espécie (Tipo)</label>
                            <input type="text" class="form-control bg-light" name="tipo" placeholder="Ex: Cão, Gato...">
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
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genero" id="macho" value="M">
                                    <label class="form-check-label" for="macho">Macho</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="genero" id="femea" value="F">
                                    <label class="form-check-label" for="femea">Fêmea</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Porte</label>
                            <select class="form-select bg-light" name="porte">
                                <option value="P">Pequeno</option>
                                <option value="M">Médio</option>
                                <option value="G">Grande</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Observações / Alergias</label>
                            <textarea class="form-control bg-light" name="observacoes" rows="3" placeholder="Informações médicas importantes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Salvar Cadastro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Aqui você pode adicionar lógica futura para mudar o título do modal 
    // quando for edição e preencher os campos via JavaScript/Ajax.
</script>
@foreach($animais as $animal)

<div class="modal fade" id="modalEditar{{ $animal->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">
                    Editar Animal
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="/admin/animais/update/{{ $animal->id }}" method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">
                                Nome do Animal
                            </label>

                            <input type="text"
                                   class="form-control bg-light"
                                   name="nome"
                                   value="{{ $animal->nome }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">
                                Tutor
                            </label>

                            <input type="text"
                                   class="form-control bg-light"
                                   name="tutor"
                                   value="{{ $animal->tutor }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Espécie
                            </label>

                            <input type="text"
                                   class="form-control bg-light"
                                   name="tipo"
                                   value="{{ $animal->tipo }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Raça
                            </label>

                            <input type="text"
                                   class="form-control bg-light"
                                   name="raca"
                                   value="{{ $animal->raca }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Peso
                            </label>

                            <input type="number"
                                   step="0.01"
                                   class="form-control bg-light"
                                   name="peso"
                                   value="{{ $animal->peso }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Data de Nascimento
                            </label>

                            <input type="date"
                                   class="form-control bg-light"
                                   name="nascimento"
                                   value="{{ $animal->nascimento }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Gênero
                            </label>

                            <select class="form-select bg-light" name="genero">

                                <option value="M"
                                    {{ $animal->genero == 'M' ? 'selected' : '' }}>
                                    Macho
                                </option>

                                <option value="F"
                                    {{ $animal->genero == 'F' ? 'selected' : '' }}>
                                    Fêmea
                                </option>

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">
                                Porte
                            </label>

                            <select class="form-select bg-light" name="porte">

                                <option value="P"
                                    {{ $animal->porte == 'P' ? 'selected' : '' }}>
                                    Pequeno
                                </option>

                                <option value="M"
                                    {{ $animal->porte == 'M' ? 'selected' : '' }}>
                                    Médio
                                </option>

                                <option value="G"
                                    {{ $animal->porte == 'G' ? 'selected' : '' }}>
                                    Grande
                                </option>

                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">
                                Observações
                            </label>

                            <textarea class="form-control bg-light"
                                      rows="3"
                                      name="observacoes">{{ $animal->observacoes }}</textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light fw-bold"
                            data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="btn btn-primary fw-bold">
                        Salvar Alterações
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

@endforeach
@endsection