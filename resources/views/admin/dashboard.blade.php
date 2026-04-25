@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        
        @include('admin.partials.sidebar')

        <div class="col py-4 px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-secondary">Bem-vindo ao Painel</h2>
                <div class="text-muted">Usuário logado: Admin</div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Consultas Hoje</h5>
                            <h2 class="fw-bold">12</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Novos Tutores</h5>
                            <h2 class="fw-bold">5</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Animais Internados</h5>
                            <h2 class="fw-bold">3</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-4 bg-white rounded shadow-sm border-0 text-center text-muted">
                <p>Selecione uma opção no menu lateral para iniciar.</p>
            </div>
        </div>

    </div>
</div>
@endsection