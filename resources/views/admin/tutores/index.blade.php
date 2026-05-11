@extends('layouts.admin')

@section('title', 'Gerir Tutores')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary"><i class="bi bi-people text-primary me-2"></i>Tutores</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTutor">
                    <i class="bi bi-person-plus-fill me-2"></i>Novo Tutor
                </button>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('tutores.index') }}" method="GET" class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <button type="submit" class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></button>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0" placeholder="Procurar tutor por nome, CPF ou telefone...">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Nome Completo</th>
                                    <th>CPF</th>
                                    <th>Contacto (WhatsApp)</th>
                                    <th>E-mail</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tutores as $tutor)
                                <tr>
                                    <td class="ps-4 fw-bold">{{ $tutor->nome }}</td>
                                    <td>{{ $tutor->cpf }}</td>
                                    <td>{{ $tutor->telefone }}</td>
                                    <td>{{ $tutor->email }}</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1 btn-edit" 
                                            title="Editar"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditTutor"
                                            data-id="{{ $tutor->id }}"
                                            data-nome="{{ $tutor->nome }}"
                                            data-cpf="{{ $tutor->cpf }}"
                                            data-telefone="{{ $tutor->telefone }}"
                                            data-email="{{ $tutor->email }}"
                                            data-cep="{{ $tutor->cep }}"
                                            data-logradouro="{{ $tutor->logradouro }}"
                                            data-numero="{{ $tutor->numero }}"
                                            data-complemento="{{ $tutor->complemento }}"
                                            data-bairro="{{ $tutor->bairro }}"
                                            data-cidade="{{ $tutor->cidade }}"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        
                                        <form action="{{ route('tutores.destroy', $tutor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este tutor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">Nenhum tutor encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    {{ $tutores->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create Tutor -->
<div class="modal fade" id="modalTutor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Registar Novo Tutor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tutores.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    
                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Dados Pessoais</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo</label>
                            <input type="text" class="form-control bg-light" name="nome" value="{{ old('nome') }}" placeholder="Ex: João da Silva" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">CPF</label>
                            <input type="text" class="form-control bg-light" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Telefone / WhatsApp</label>
                            <input type="text" class="form-control bg-light" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" class="form-control bg-light" name="email" value="{{ old('email') }}" placeholder="email@exemplo.com">
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Endereço</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">CEP</label>
                            <input type="text" class="form-control bg-light" name="cep" value="{{ old('cep') }}" placeholder="00000-000">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label small fw-bold">Morada (Rua/Avenida)</label>
                            <input type="text" class="form-control bg-light" name="logradouro" value="{{ old('logradouro') }}" placeholder="Ex: Rua das Flores">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Número</label>
                            <input type="text" class="form-control bg-light" name="numero" value="{{ old('numero') }}" placeholder="123">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Complemento</label>
                            <input type="text" class="form-control bg-light" name="complemento" value="{{ old('complemento') }}" placeholder="Apto, Bloco, etc.">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Bairro</label>
                            <input type="text" class="form-control bg-light" name="bairro" value="{{ old('bairro') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Cidade</label>
                            <input type="text" class="form-control bg-light" name="cidade" value="{{ old('cidade') }}">
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Salvar Registo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Tutor -->
<div class="modal fade" id="modalEditTutor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Editar Tutor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="formEditTutor" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    
                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Dados Pessoais</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo</label>
                            <input type="text" class="form-control bg-light" name="nome" id="edit_nome" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">CPF</label>
                            <input type="text" class="form-control bg-light" name="cpf" id="edit_cpf" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Telefone / WhatsApp</label>
                            <input type="text" class="form-control bg-light" name="telefone" id="edit_telefone" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" class="form-control bg-light" name="email" id="edit_email">
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Endereço</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">CEP</label>
                            <input type="text" class="form-control bg-light" name="cep" id="edit_cep">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label small fw-bold">Morada (Rua/Avenida)</label>
                            <input type="text" class="form-control bg-light" name="logradouro" id="edit_logradouro">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Número</label>
                            <input type="text" class="form-control bg-light" name="numero" id="edit_numero">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Complemento</label>
                            <input type="text" class="form-control bg-light" name="complemento" id="edit_complemento">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Bairro</label>
                            <input type="text" class="form-control bg-light" name="bairro" id="edit_bairro">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Cidade</label>
                            <input type="text" class="form-control bg-light" name="cidade" id="edit_cidade">
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Atualizar Registo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    const formEditTutor = document.getElementById('formEditTutor');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            
            // Set action URL dynamically
            formEditTutor.action = `/admin/tutores/${id}`;

            // Populate fields
            document.getElementById('edit_nome').value = this.getAttribute('data-nome');
            document.getElementById('edit_cpf').value = this.getAttribute('data-cpf');
            document.getElementById('edit_telefone').value = this.getAttribute('data-telefone');
            document.getElementById('edit_email').value = this.getAttribute('data-email');
            document.getElementById('edit_cep').value = this.getAttribute('data-cep');
            document.getElementById('edit_logradouro').value = this.getAttribute('data-logradouro');
            document.getElementById('edit_numero').value = this.getAttribute('data-numero');
            document.getElementById('edit_complemento').value = this.getAttribute('data-complemento');
            document.getElementById('edit_bairro').value = this.getAttribute('data-bairro');
            document.getElementById('edit_cidade').value = this.getAttribute('data-cidade');
        });
    });
});
</script>
@endsection