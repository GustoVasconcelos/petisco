@extends('layouts.admin')

@section('title', 'Agenda de Serviços')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="row">
                
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Início</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Fim</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Status</label>
                            <select class="form-select">
                                <option>Todos</option>
                                <option>A Iniciar</option>
                                <option>Em Andamento</option>
                                <option>Concluído</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary w-100">Filtrar Agenda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalServico" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Detalhes do Agendamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="text-muted small d-block">Animal</label>
                    <p class="fw-bold mb-0" id="modal-animal">Rex (Cão - Labrador)</p>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="text-muted small d-block">Profissional</label>
                        <p class="fw-bold mb-0" id="modal-profissional">Dr. Marcos Silva</p>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small d-block">Valor</label>
                        <p class="fw-bold mb-0 text-success" id="modal-valor">R$ 150,00</p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Serviço</label>
                    <p class="mb-0" id="modal-servico">Consulta de Rotina + Vacina Antirrábica</p>
                </div>
                <div class="badge bg-warning text-dark" id="modal-status">Em Andamento</div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Editar Agendamento</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            // Simulação de clique num evento para abrir o modal
            eventClick: function(info) {
                var myModal = new bootstrap.Modal(document.getElementById('modalServico'));
                myModal.show();
            },
            events: [
                { title: 'Rex - Consulta', start: '2026-05-22', color: '#ffc107' },
                { title: 'Bolinha - Vacina', start: '2026-05-23', color: '#198754' }
            ]
        });
        calendar.render();
    });
</script>
@endsection