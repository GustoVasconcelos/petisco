@extends('layouts.admin')

@section('title', 'Catálogo de Serviços')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary"><i class="bi bi-list-check text-primary me-2"></i>Serviços</h2>
                <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalServico">
                    <i class="bi bi-plus-lg me-2"></i>Novo Serviço
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <input type="text" class="form-control bg-light border-0" placeholder="Buscar serviço por nome ou categoria...">
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
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
                                <tr>
                                    <td class="ps-4 fw-bold">Consulta de Rotina</td>
                                    <td><span class="badge bg-info text-dark">Consulta</span></td>
                                    <td>30 min</td>
                                    <td class="text-success fw-bold">R$ 150,00</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Banho & Tosa (Médio)</td>
                                    <td><span class="badge bg-secondary">Estética</span></td>
                                    <td>90 min</td>
                                    <td class="text-success fw-bold">R$ 85,00</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-secondary me-1"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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

<div class="modal fade" id="modalServico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Configurar Serviço</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nome do Serviço</label>
                            <input type="text" class="form-control" name="nome" placeholder="Ex: Vacina Antirrábica" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoria</label>
                            <select class="form-select" name="categoria" required>
                                <option value="Consulta">Consulta</option>
                                <option value="Vacina">Vacina</option>
                                <option value="Estética">Estética (Banho/Tosa)</option>
                                <option value="Exame">Exame</option>
                                <option value="Cirurgia">Cirurgia</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Duração (minutos)</label>
                            <input type="number" class="form-control" name="duracao" placeholder="Ex: 45">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-success">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control border-success" name="valor" placeholder="0.00" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descrição / Notas</label>
                            <textarea class="form-control" name="descricao" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Salvar Serviço</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection