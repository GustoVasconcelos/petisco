@extends('layouts.admin')

@section('title', 'Gerenciar Talentos')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary">
                    <i class="bi bi-star-fill text-warning me-2"></i>Talentos (Equipe)
                </h2>

                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTalento">
                    <i class="bi bi-person-badge me-2"></i>Novo Funcionário
                </button>
            </div>

            <!-- SEARCH -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-start-0"
                               placeholder="Buscar funcionário por nome ou cargo...">
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome do Profissional</th>
                                    <th>Cargo</th>
                                    <th>CRMV</th>
                                    <th>Contato</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($talentos as $talento)
                                    <tr>
                                        <td class="ps-4 fw-bold">{{ $talento->nome }}</td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $talento->cargo }}
                                            </span>
                                        </td>

                                        <td class="text-muted">
                                            {{ $talento->crmv ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $talento->telefone }}
                                        </td>

                                        <td>
                                            <span class="badge bg-success bg-opacity-25 text-success">
                                                {{ $talento->status }}
                                            </span>
                                        </td>

                                        <td class="text-end pe-4">

                                            <button
                                                class="btn btn-sm btn-outline-secondary me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditar{{ $talento->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="/admin/talentos/delete/{{ $talento->id }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Deseja excluir este funcionário?')">
                                                    <i class="bi bi-person-slash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Nenhum talento encontrado
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

<!-- MODAL CADASTRO -->
<div class="modal fade" id="modalTalento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Cadastrar Novo Funcionário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/admin/talentos/store" method="POST">
                @csrf

                <div class="modal-body p-4">

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Dados Pessoais</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo</label>
                            <input type="text" class="form-control bg-light" name="nome" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">CPF</label>
                            <input type="text" class="form-control bg-light" name="cpf">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Celular</label>
                            <input type="text" class="form-control bg-light" name="telefone" required>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Atuação Profissional</h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Cargo</label>
                            <select class="form-select bg-light" name="cargo" id="selectCargo" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Atendente">Atendente</option>
                                <option value="Auxiliar Veterinário">Auxiliar Veterinário</option>
                                <option value="Esteticista/Tosador">Esteticista / Tosador</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Veterinário">Veterinário</option>
                                <option value="TI">TI / Desenvolvedor</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-none" id="divCrmv">
                            <label class="form-label small fw-bold text-primary">CRMV</label>
                            <input type="text" class="form-control border-primary" name="crmv" id="inputCrmv">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Turno</label>
                            <select class="form-select bg-light" name="turno">
                                <option value="Manhã">Manhã</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Integral">Integral</option>
                                <option value="Plantão">Plantão</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        Salvar Funcionário
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- MODAIS EDITAR -->
@foreach($talentos as $talento)
<div class="modal fade" id="modalEditar{{ $talento->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Editar Funcionário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/admin/talentos/update/{{ $talento->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label>Nome</label>
                        <input type="text" name="nome" class="form-control" value="{{ $talento->nome }}">
                    </div>

                    <div class="mb-3">
                        <label>Cargo</label>
                        <input type="text" name="cargo" class="form-control" value="{{ $talento->cargo }}">
                    </div>

                    <div class="mb-3">
                        <label>Telefone</label>
                        <input type="text" name="telefone" class="form-control" value="{{ $talento->telefone }}">
                    </div>

                    <div class="mb-3">
                        <label>CRMV</label>
                        <input type="text" name="crmv" class="form-control" value="{{ $talento->crmv }}">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectCargo = document.getElementById('selectCargo');
    const divCrmv = document.getElementById('divCrmv');
    const inputCrmv = document.getElementById('inputCrmv');

    selectCargo.addEventListener('change', function () {
        if (this.value === 'Veterinário') {
            divCrmv.classList.remove('d-none');
            inputCrmv.required = true;
        } else {
            divCrmv.classList.add('d-none');
            inputCrmv.required = false;
            inputCrmv.value = '';
        }
    });
});
</script>

@endsection