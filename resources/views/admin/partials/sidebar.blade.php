<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark" style="min-height: 100vh;">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-4 text-white">
        <a href="{{ url('/admin/dashboard') }}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-5 d-none d-sm-inline fw-bold">Petisco Admin</span>
        </a>
        
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100 mt-3" id="menu">
            <li class="nav-item w-100 mb-2">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link text-white bg-primary">
                    <i class="bi bi-house-door fs-5 me-2"></i> <span class="d-none d-sm-inline">Início</span>
                </a>
            </li>

            <li class="w-100 mb-1 mt-3">
                <span class="text-secondary small fw-bold text-uppercase d-none d-sm-inline">Operacional</span>
            </li>
            <li class="nav-item w-100">
                <a href="#" class="nav-link text-white px-3">
                    <i class="bi bi-calendar-event me-2"></i> 
                    <span class="d-none d-sm-inline">Agenda de Serviços</span>
                </a>
            </li>

            <li class="w-100 mb-1 mt-3">
                <span class="text-secondary small fw-bold text-uppercase d-none d-sm-inline">Comercial</span>
            </li>
            <li class="nav-item w-100">
                <a href="#" class="nav-link text-white px-3">
                    <i class="bi bi-shield-check me-2"></i> 
                    <span class="d-none d-sm-inline">Planos de Saúde</span>
                </a>
            </li>
            
            <li class="w-100 mb-1 mt-3">
                <span class="text-secondary small fw-bold text-uppercase d-none d-sm-inline">Cadastros</span>
            </li>
            <li class="nav-item w-100"><a href="{{ url('/admin/tutores') }}" class="nav-link text-white px-3"><i class="bi bi-people me-2"></i> <span class="d-none d-sm-inline">Tutores</span></a></li>
            <li class="nav-item w-100"><a href="#" class="nav-link text-white px-3"><i class="bi bi-heart-fill me-2 text-danger"></i> <span class="d-none d-sm-inline">Animais</span></a></li>
            <li class="nav-item w-100"><a href="#" class="nav-link text-white px-3"><i class="bi bi-journal-medical me-2"></i> <span class="d-none d-sm-inline">Histórico</span></a></li>
            <li class="nav-item w-100"><a href="{{ url('/admin/talentos') }}" class="nav-link text-white px-3"><i class="bi bi-star me-2"></i> <span class="d-none d-sm-inline">Talentos</span></a></li>
            <li class="nav-item w-100"><a href="#" class="nav-link text-white px-3"><i class="bi bi-scissors me-2"></i> <span class="d-none d-sm-inline">Serviços</span></a>
</li>

        </ul>
        
        <hr class="w-100 text-secondary">
        <div class="pb-4 w-100">
            <a href="{{ url('/admin/login') }}" class="nav-link text-danger fw-bold">
                <i class="bi bi-box-arrow-left fs-5 me-2"></i> <span class="d-none d-sm-inline">Sair do Sistema</span>
            </a>
        </div>
    </div>
</div>