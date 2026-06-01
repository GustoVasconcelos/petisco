@extends('layouts.admin')

@section('title', 'Cadastro de Funcionário')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 20px; padding-bottom: 20px;">
    <div class="col-md-7 col-lg-6">
        
        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/icons/logo-2.png') }}" alt="Logo Petisco" width="80" class="mb-2">
            <h3 class="fw-bold" style="color: #6c757d;">cadastro de funcionários</h3>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.register.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Nome Completo</label>
                        <input type="text" name="name" class="form-control form-control-lg bg-light" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">E-mail</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="nome@exemplo.com" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">CPF</label>
                            <input type="text" name="cpf" class="form-control form-control-lg bg-light" placeholder="000.000.000-00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Celular</label>
                            <input type="text" name="celular" class="form-control form-control-lg bg-light" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Cargo</label>
                        <select name="cargo" id="cargo" class="form-select form-select-lg bg-light" required onchange="toggleCrmv()">
                            <option value="">Selecione...</option>
                            <option value="Atendente">Atendente</option>
                            <option value="Auxiliar Veterinário">Auxiliar Veterinário</option>
                            <option value="Esteticista / Tosador">Esteticista / Tosador</option>
                            <option value="Gerente">Gerente</option>
                            <option value="Veterinário">Veterinário</option>
                            <option value="TI / Desenvolvedor">TI / Desenvolvedor</option>
                        </select>
                    </div>

                    <div class="mb-3" id="crmv_box" style="display: none;">
                        <label class="form-label text-muted fw-semibold">CRMV</label>
                        <input type="text" name="crmv" class="form-control form-control-lg bg-light" placeholder="Número do CRMV">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">Turno</label>
                        <select name="turno" class="form-select form-select-lg bg-light" required>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-semibold">Senha</label>
                            <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-muted fw-semibold">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Cadastrar Funcionário</button>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ url('/admin/login') }}" class="text-decoration-none text-muted small">← Voltar para o Login</a>
        </div>

    </div>
</div>

<script>
function toggleCrmv() {
    var cargo = document.getElementById('cargo').value;
    var crmvBox = document.getElementById('crmv_box');
    if (cargo === 'Veterinário') {
        crmvBox.style.display = 'block';
    } else {
        crmvBox.style.display = 'none';
    }
}
</script>
@endsection