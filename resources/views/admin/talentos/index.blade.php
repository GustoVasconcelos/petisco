@extends('layouts.admin')

@section('title', 'Gerenciar Talentos')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary"><i class="bi bi-star-fill text-warning me-2"></i>Talentos (Equipe)</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalTalento">
                    <i class="bi bi-person-badge me-2"></i>Novo Funcionário
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" placeholder="Buscar funcionário por nome ou cargo...">
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
                                    <th class="ps-4">Nome do Profissional</th>
                                    <th>Cargo</th>
                                    <th>CRMV</th>
                                    <th>Contato</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold">Karina Favareto</td>
                                    <td><span class="badge bg-primary">Veterinária</span></td>
                                    <td class="text-muted">CRMV-SP 12345</td>
                                    <td>(18) 99999-1111</td>
                                    <td><span class="badge bg-success bg-opacity-25 text-success">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Desativar"><i class="bi bi-person-slash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Victor Orlandi</td>
                                    <td><span class="badge bg-info text-dark">Gerente</span></td>
                                    <td class="text-muted">-</td>
                                    <td>(18) 98888-2222</td>
                                    <td><span class="badge bg-success bg-opacity-25 text-success">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Desativar"><i class="bi bi-person-slash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Augusto</td>
                                    <td><span class="badge bg-secondary">TI / Desenvolvedor</span></td>
                                    <td class="text-muted">-</td>
                                    <td>(18) 97777-3333</td>
                                    <td><span class="badge bg-success bg-opacity-25 text-success">Ativo</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Desativar"><i class="bi bi-person-slash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTalento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Cadastrar Novo Funcionário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
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
                            <input type="text" class="form-control bg-light" name="cpf" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Celular / WhatsApp</label>
                            <input type="text" class="form-control bg-light" name="telefone" required>
                        </div>
                    </div>

                    <h6 class="fw-bold text-secondary mb-3 border-bottom pb-2">Atuação Profissional</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Cargo</label>
                            <select class="form-select bg-light" name="cargo" id="selectCargo" required>
                                <option value="" selected disabled>Selecione...</option>
                                <option value="Atendente">Atendente</option>
                                <option value="Auxiliar Veterinário">Auxiliar Veterinário</option>
                                <option value="Esteticista/Tosador">Esteticista / Tosador</option>
                                <option value="Gerente">Gerente</option>
                                <option value="Veterinário">Veterinário(a)</option>
                                <option value="TI">TI / Desenvolvedor</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 d-none" id="divCrmv">
                            <label class="form-label small fw-bold text-primary">Número do CRMV</label>
                            <input type="text" class="form-control border-primary" name="crmv" id="inputCrmv" placeholder="Ex: SP-12345">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Carga Horária (Turno)</label>
                            <select class="form-select bg-light" name="turno">
                                <option value="Manhã">Manhã (08h às 14h)</option>
                                <option value="Tarde">Tarde (14h às 20h)</option>
                                <option value="Integral">Integral (08h às 18h)</option>
                                <option value="Plantão">Plantão 12x36</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-outline-secondary fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Salvar Funcionário</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectCargo = document.getElementById('selectCargo');
        const divCrmv = document.getElementById('divCrmv');
        const inputCrmv = document.getElementById('inputCrmv');

        selectCargo.addEventListener('change', function() {
            // Se o cargo escolhido for Veterinário, mostra o campo CRMV e torna ele obrigatório
            if (this.value === 'Veterinário') {
                divCrmv.classList.remove('d-none');
                inputCrmv.setAttribute('required', 'required');
            } else {
                // Caso contrário, esconde, tira a obrigatoriedade e limpa o valor
                divCrmv.classList.add('d-none');
                inputCrmv.removeAttribute('required');
                inputCrmv.value = '';
            }
        });
    });
</script>
@endsection