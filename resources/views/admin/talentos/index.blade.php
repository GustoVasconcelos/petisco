@extends('layouts.admin')

@section('title', 'Gerenciar Funcionários')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">

        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">

            {{-- Alertas de feedback --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Erros de validação (quando modal fecha após erro) --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Corrija os erros abaixo:</strong>
                    <ul class="mb-0 mt-1 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary">
                    <i class="bi bi-people-fill text-primary me-2"></i>Funcionários
                </h2>

                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalNovoFuncionario">
                    <i class="bi bi-person-plus-fill me-2"></i>Novo Funcionário
                </button>
            </div>

            {{-- BUSCA --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="/admin/talentos">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-light border-start-0"
                                   placeholder="Buscar por nome, cargo ou CPF..."
                                   value="{{ $search ?? '' }}">
                            @if($search ?? false)
                                <a href="/admin/talentos" class="btn btn-outline-secondary">Limpar</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- TABELA --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome</th>
                                    <th>E-mail</th>
                                    <th>Cargo</th>
                                    <th>CRMV</th>
                                    <th>Contato</th>
                                    <th>Turno</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($talentos as $talento)
                                    <tr>
                                        <td class="ps-4 fw-bold">{{ $talento->name }}</td>

                                        <td class="text-muted small">{{ $talento->email }}</td>

                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $talento->cargo ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="text-muted">
                                            {{ $talento->crmv ?? '-' }}
                                        </td>

                                        <td>{{ $talento->celular ?? '-' }}</td>

                                        <td class="text-muted small">{{ $talento->turno ?? '-' }}</td>

                                        <td>
                                            @if($talento->status === 'Ativo')
                                                <span class="badge bg-success bg-opacity-25 text-success">Ativo</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-25 text-danger">Inativo</span>
                                            @endif
                                        </td>

                                        <td class="text-end pe-4">
                                            <button
                                                class="btn btn-sm btn-outline-secondary me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditar{{ $talento->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- Protege contra auto-exclusão --}}
                                            @if(auth()->id() !== $talento->id)
                                                <form action="/admin/talentos/delete/{{ $talento->id }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Deseja excluir o funcionário {{ $talento->name }}? Esta ação não pode ser desfeita.')">
                                                        <i class="bi bi-person-slash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-outline-danger" disabled title="Você não pode excluir seu próprio usuário">
                                                    <i class="bi bi-person-slash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">
                                            <i class="bi bi-people display-6 d-block mb-2"></i>
                                            Nenhum funcionário encontrado
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

{{-- ============================================================
     MODAL: CADASTRAR NOVO FUNCIONÁRIO
     ============================================================ --}}
<div class="modal fade" id="modalNovoFuncionario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i>Cadastrar Novo Funcionário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/admin/talentos/store" method="POST">
                @csrf

                <div class="modal-body p-4">

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                        <i class="bi bi-person me-1"></i> Dados Pessoais
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="name" required
                                   value="{{ old('name') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control bg-light" name="email" required
                                   placeholder="nome@petisco.com"
                                   value="{{ old('email') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">CPF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="cpf" required
                                   placeholder="000.000.000-00"
                                   value="{{ old('cpf') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Celular <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light" name="celular" required
                                   placeholder="(00) 00000-0000"
                                   value="{{ old('celular') }}">
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                        <i class="bi bi-briefcase me-1"></i> Atuação Profissional
                    </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Cargo <span class="text-danger">*</span></label>
                            <select class="form-select bg-light" name="cargo" id="selectCargoNovo" required>
                                <option value="" disabled selected>Selecione...</option>
                                <option value="Atendente" {{ old('cargo') === 'Atendente' ? 'selected' : '' }}>Atendente</option>
                                <option value="Auxiliar Veterinário" {{ old('cargo') === 'Auxiliar Veterinário' ? 'selected' : '' }}>Auxiliar Veterinário</option>
                                <option value="Esteticista / Tosador" {{ old('cargo') === 'Esteticista / Tosador' ? 'selected' : '' }}>Esteticista / Tosador</option>
                                <option value="Gerente" {{ old('cargo') === 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="Veterinário" {{ old('cargo') === 'Veterinário' ? 'selected' : '' }}>Veterinário</option>
                                <option value="TI / Desenvolvedor" {{ old('cargo') === 'TI / Desenvolvedor' ? 'selected' : '' }}>TI / Desenvolvedor</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-none" id="divCrmvNovo">
                            <label class="form-label small fw-bold text-primary">CRMV <span class="text-danger">*</span></label>
                            <input type="text" class="form-control border-primary" name="crmv" id="inputCrmvNovo"
                                   placeholder="Número do CRMV"
                                   value="{{ old('crmv') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Turno <span class="text-danger">*</span></label>
                            <select class="form-select bg-light" name="turno" required>
                                <option value="Manhã" {{ old('turno') === 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ old('turno') === 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                <option value="Noite" {{ old('turno') === 'Noite' ? 'selected' : '' }}>Noite</option>
                                <option value="Integral" {{ old('turno') === 'Integral' ? 'selected' : '' }}>Integral</option>
                                <option value="Plantão" {{ old('turno') === 'Plantão' ? 'selected' : '' }}>Plantão</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">
                        <i class="bi bi-shield-lock me-1"></i> Acesso ao Sistema
                    </h6>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        O funcionário receberá estas credenciais para fazer login no sistema.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control bg-light" name="password"
                                   placeholder="Mínimo 8 caracteres" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Confirmar Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control bg-light" name="password_confirmation"
                                   placeholder="••••••••" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-person-check-fill me-1"></i> Cadastrar Funcionário
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAIS: EDITAR FUNCIONÁRIO (um por funcionário)
     ============================================================ --}}
@foreach($talentos as $talento)
<div class="modal fade" id="modalEditar{{ $talento->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Editar Funcionário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="/admin/talentos/update/{{ $talento->id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Dados Pessoais</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo</label>
                            <input type="text" name="name" class="form-control bg-light"
                                   value="{{ $talento->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" name="email" class="form-control bg-light"
                                   value="{{ $talento->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Celular</label>
                            <input type="text" name="celular" class="form-control bg-light"
                                   value="{{ $talento->celular }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select bg-light" required>
                                <option value="Ativo"   {{ $talento->status === 'Ativo'   ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ $talento->status === 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Atuação Profissional</h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Cargo</label>
                            <select class="form-select bg-light" name="cargo"
                                    id="selectCargoEditar{{ $talento->id }}" required>
                                <option value="Atendente"           {{ $talento->cargo === 'Atendente' ? 'selected' : '' }}>Atendente</option>
                                <option value="Auxiliar Veterinário" {{ $talento->cargo === 'Auxiliar Veterinário' ? 'selected' : '' }}>Auxiliar Veterinário</option>
                                <option value="Esteticista / Tosador" {{ $talento->cargo === 'Esteticista / Tosador' ? 'selected' : '' }}>Esteticista / Tosador</option>
                                <option value="Gerente"              {{ $talento->cargo === 'Gerente' ? 'selected' : '' }}>Gerente</option>
                                <option value="Veterinário"          {{ $talento->cargo === 'Veterinário' ? 'selected' : '' }}>Veterinário</option>
                                <option value="TI / Desenvolvedor"   {{ $talento->cargo === 'TI / Desenvolvedor' ? 'selected' : '' }}>TI / Desenvolvedor</option>
                            </select>
                        </div>

                        <div class="col-md-4 {{ $talento->cargo !== 'Veterinário' ? 'd-none' : '' }}"
                             id="divCrmvEditar{{ $talento->id }}">
                            <label class="form-label small fw-bold text-primary">CRMV</label>
                            <input type="text" class="form-control border-primary" name="crmv"
                                   id="inputCrmvEditar{{ $talento->id }}"
                                   value="{{ $talento->crmv }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Turno</label>
                            <select class="form-select bg-light" name="turno" required>
                                <option value="Manhã"    {{ $talento->turno === 'Manhã'    ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde"    {{ $talento->turno === 'Tarde'    ? 'selected' : '' }}>Tarde</option>
                                <option value="Noite"    {{ $talento->turno === 'Noite'    ? 'selected' : '' }}>Noite</option>
                                <option value="Integral" {{ $talento->turno === 'Integral' ? 'selected' : '' }}>Integral</option>
                                <option value="Plantão"  {{ $talento->turno === 'Plantão'  ? 'selected' : '' }}>Plantão</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded small text-muted">
                        <i class="bi bi-shield-lock me-1"></i>
                        <strong>Senha:</strong> Para redefinir a senha do funcionário, use a opção de recuperação de senha na tela de login.
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Salvar Alterações
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach

<script>
// === Modal Novo: mostrar/ocultar CRMV ===
document.addEventListener('DOMContentLoaded', function () {
    const selectNovo = document.getElementById('selectCargoNovo');
    if (selectNovo) {
        selectNovo.addEventListener('change', function () {
            const divCrmv    = document.getElementById('divCrmvNovo');
            const inputCrmv  = document.getElementById('inputCrmvNovo');
            const isVet      = this.value === 'Veterinário';
            divCrmv.classList.toggle('d-none', !isVet);
            inputCrmv.required = isVet;
            if (!isVet) inputCrmv.value = '';
        });

        // Restaurar estado ao abrir com old() values após erro de validação
        if (selectNovo.value === 'Veterinário') {
            document.getElementById('divCrmvNovo').classList.remove('d-none');
            document.getElementById('inputCrmvNovo').required = true;
        }
    }

    // === Modais Editar: mostrar/ocultar CRMV ===
    @foreach($talentos as $talento)
    (function () {
        const sel = document.getElementById('selectCargoEditar{{ $talento->id }}');
        if (!sel) return;
        sel.addEventListener('change', function () {
            const div   = document.getElementById('divCrmvEditar{{ $talento->id }}');
            const input = document.getElementById('inputCrmvEditar{{ $talento->id }}');
            const isVet = this.value === 'Veterinário';
            div.classList.toggle('d-none', !isVet);
            input.required = isVet;
            if (!isVet) input.value = '';
        });
    })();
    @endforeach

    // Reabrir modal se houver erros de validação
    @if($errors->any())
        var modal = new bootstrap.Modal(document.getElementById('modalNovoFuncionario'));
        modal.show();
    @endif
});
</script>

@endsection