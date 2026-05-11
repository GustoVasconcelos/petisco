@extends('layouts.admin')

@section('title', 'Histórico de Atendimentos')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary">
                    <i class="bi bi-journal-medical text-primary me-2"></i>Histórico
                </h2>
                <button type="button" class="btn btn-outline-primary fw-bold">
                    <i class="bi bi-download me-2"></i>Exportar Relatório
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control bg-light border-start-0" placeholder="Buscar histórico por nome do animal, tutor ou serviço...">
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
                                    <th class="ps-4">Data</th>
                                    <th>Animal</th>
                                    <th>Tutor</th>
                                    <th>Serviço</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">11/05/2026</td>
                                    <td class="fw-bold">Rex</td>
                                    <td>Victor Orlandi</td>
                                    <td>Consulta de Rotina</td>
                                    <td><span class="badge bg-success">Concluído</span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary" title="Ver Prontuário"><i class="bi bi-eye"></i></button>
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
@endsection