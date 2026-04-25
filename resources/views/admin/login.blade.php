@extends('layouts.admin')

@section('title', 'Login')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5 col-lg-4">
        
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/icons/logo-2.png') }}" alt="Logo Petisco" width="80" class="mb-2">
            <h3 class="fw-bold" style="color: #6c757d;">área restrita</h3>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <form action="{{ url('/admin/dashboard') }}" method="GET">
                    @csrf 

                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-semibold">E-mail</label>
                        <input type="email" class="form-control form-control-lg bg-light" id="email" name="email" placeholder="nome@exemplo.com" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label text-muted fw-semibold">Senha</label>
                        <input type="password" class="form-control form-control-lg bg-light" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Entrar</button>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="text-decoration-none text-muted small">← Voltar para o site</a>
        </div>

    </div>
</div>
@endsection