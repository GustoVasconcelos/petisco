@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">

        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">

            {{-- Cabeçalho --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-secondary mb-0">Painel de Controle</h2>
                    <span class="text-muted small">Bem-vindo, <strong>{{ Auth::user()->name }}</strong></span>
                </div>
                <span class="text-muted small">{{ now()->format('d/m/Y') }}</span>
            </div>

            {{-- ── Cards de estatísticas ── --}}
            <div class="row g-3 mb-4">

                <div class="col-sm-6 col-xl-3">
                    <a href="{{ url('/admin/tutores') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3 p-4">
                                <div class="rounded-3 p-3 bg-primary bg-opacity-10">
                                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase">Tutores</div>
                                    <div class="fs-2 fw-bold text-dark lh-1">{{ $stats['totalTutores'] }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a href="{{ url('/admin/animais') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3 p-4">
                                <div class="rounded-3 p-3 bg-danger bg-opacity-10">
                                    <i class="bi bi-heart-fill fs-3 text-danger"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase">Animais</div>
                                    <div class="fs-2 fw-bold text-dark lh-1">{{ $stats['totalAnimais'] }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a href="{{ url('/admin/servicos') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3 p-4">
                                <div class="rounded-3 p-3 bg-success bg-opacity-10">
                                    <i class="bi bi-scissors fs-3 text-success"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase">Serviços</div>
                                    <div class="fs-2 fw-bold text-dark lh-1">{{ $stats['totalServicos'] }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-xl-3">
                    <a href="{{ url('/admin/planos') }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex align-items-center gap-3 p-4">
                                <div class="rounded-3 p-3 bg-warning bg-opacity-10">
                                    <i class="bi bi-shield-check fs-3 text-warning"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase">Planos Ativos</div>
                                    <div class="fs-2 fw-bold text-dark lh-1">{{ $stats['planoAtivos'] }}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            {{-- ── Tabelas de resumo ── --}}
            <div class="row g-3">

                {{-- Últimos Tutores --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-secondary mb-0">
                                    <i class="bi bi-people me-2 text-primary"></i>Últimos Tutores Cadastrados
                                </h6>
                                <a href="{{ url('/admin/tutores') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-2 small text-muted">Nome</th>
                                        <th class="py-2 small text-muted">Telefone</th>
                                        <th class="py-2 small text-muted">Cidade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosTutores as $tutor)
                                    <tr>
                                        <td class="ps-4 fw-semibold">{{ $tutor->nome }}</td>
                                        <td class="text-muted small">{{ $tutor->telefone }}</td>
                                        <td class="text-muted small">{{ $tutor->cidade ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4 small">
                                            Nenhum tutor cadastrado ainda.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Últimos Animais --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-secondary mb-0">
                                    <i class="bi bi-heart-fill me-2 text-danger"></i>Últimos Animais Cadastrados
                                </h6>
                                <a href="{{ url('/admin/animais') }}" class="btn btn-sm btn-outline-danger">Ver todos</a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-2 small text-muted">Animal</th>
                                        <th class="py-2 small text-muted">Espécie</th>
                                        <th class="py-2 small text-muted">Tutor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosAnimais as $animal)
                                    <tr>
                                        <td class="ps-4 fw-semibold">{{ $animal->nome }}</td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $animal->tipo }}</span>
                                        </td>
                                        <td class="text-muted small">{{ $animal->tutor?->nome ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4 small">
                                            Nenhum animal cadastrado ainda.
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
</div>
@endsection