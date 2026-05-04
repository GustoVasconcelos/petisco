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

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" placeholder="Procurar tutor por nome, CPF ou telefone...">
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
                                    <th class="ps-4">Nome Completo</th>
                                    <th>CPF</th>
                                    <th>Contacto (WhatsApp)</th>
                                    <th>E-mail</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold">Victor Orlandi</td>
                                    <td>123.456.789-00</td>
                                    <td>(18) 99999-0000</td>
                                    <td>victor@exemplo.com</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Augusto Vasconcelos</td>
                                    <td>098.765.432-11</td>
                                    <td>(18) 98888-1111</td>
                                    <td>augusto@exemplo.com</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
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

<div class="modal fade" id="modalTutor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Registar Novo Tutor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    
                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Dados Pessoais</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nome Completo</label>
                            <input type="text" class="form-control bg-light" name="nome" placeholder="Ex: João da Silva" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">CPF</label>
                            <input type="text" class="form-control bg-light" name="cpf" placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Telefone / WhatsApp</label>
                            <input type="text" class="form-control bg-light" name="telefone" placeholder="(00) 00000-0000" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">E-mail</label>
                            <input type="email" class="form-control bg-light" name="email" placeholder="email@exemplo.com">
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Endereço</h6>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">CEP</label>
                            <input type="text" class="form-control bg-light" name="cep" placeholder="00000-000">
                        </div>
                        <div class="col-md-7">
                            <label class="form-label small fw-bold">Morada (Rua/Avenida)</label>
                            <input type="text" class="form-control bg-light" name="logradouro" placeholder="Ex: Rua das Flores">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Número</label>
                            <input type="text" class="form-control bg-light" name="numero" placeholder="123">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Complemento</label>
                            <input type="text" class="form-control bg-light" name="complemento" placeholder="Apto, Bloco, etc.">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Bairro</label>
                            <input type="text" class="form-control bg-light" name="bairro">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Cidade</label>
                            <input type="text" class="form-control bg-light" name="cidade">
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
@endsection