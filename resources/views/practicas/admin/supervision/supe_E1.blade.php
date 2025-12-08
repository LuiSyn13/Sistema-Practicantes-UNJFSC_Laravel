@if($etapa == 1)
<style>
    :root {
        --primary-color: #1e3a8a;
        --primary-light: #3b82f6;
        --secondary-color: #64748b;
        --background-color: #f8fafc;
        --surface-color: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --success-color: #059669;
        --warning-color: #d97706;
        --danger-color: #dc2626;
        --info-color: #0891b2;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .supervision-container {
        background: var(--background-color);
        padding: 1rem;
        border-radius: 1rem;
    }

    .supervision-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .supervision-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .supervision-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .supervision-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .supervision-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: center;
    }

    .supervision-body {
        padding: 2rem;
    }

    .info-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        transition: all 0.3s ease;
    }

    .info-card.empresa::before {
        background: linear-gradient(90deg, var(--success-color), #047857);
    }

    .info-card.jefe::before {
        background: linear-gradient(90deg, var(--warning-color), #b45309);
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .info-card-content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
    }

    .info-icon {
        font-size: 3rem;
        transition: all 0.3s ease;
    }

    .info-card.empresa .info-icon {
        color: var(--success-color);
    }

    .info-card.jefe .info-icon {
        color: var(--warning-color);
    }

    .info-card:hover .info-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .info-details {
        text-align: center;
    }

    .info-details h5 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-visualizar {
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-visualizar.empresa {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
    }

    .btn-visualizar.empresa:hover {
        background: linear-gradient(135deg, #047857, #065f46);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
        text-decoration: none;
    }

    .btn-visualizar.jefe {
        background: linear-gradient(135deg, var(--warning-color), #b45309);
        color: white;
    }

    .btn-visualizar.jefe:hover {
        background: linear-gradient(135deg, #b45309, #92400e);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
        text-decoration: none;
    }

    .supervision-footer {
        background: #f8fafc;
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-select {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        background: var(--surface-color);
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    .btn-guardar {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-guardar:hover {
        background: linear-gradient(135deg, var(--primary-light), #2563eb);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    @media (max-width: 768px) {
        .supervision-body {
            padding: 1rem;
        }

        .info-card-content {
            flex-direction: column;
            gap: 1rem;
        }

        .info-icon {
            font-size: 2.5rem;
        }

        .supervision-footer {
            padding: 1rem;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease;
    }
</style>

<div class="supervision-container fade-in">
    <div class="supervision-card">
        <div class="supervision-header">
            <h6 class="supervision-title">Primera Etapa - Información General</h6>
        </div>
        
        <div class="supervision-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="info-card empresa">
                        <div class="info-card-content">
                            <i class="bi bi-building info-icon"></i>
                            <div class="info-details">
                                <h5>Empresa</h5>
                                <a href="#" class="btn-visualizar empresa" id="btnEtapa2">
                                    Visualizar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="info-card jefe">
                        <div class="info-card-content">
                            <i class="bi bi-person-badge info-icon"></i>
                            <div class="info-details">
                                <h5>Jefe Inmediato</h5>
                                <a href="#" class="btn-visualizar jefe" id="btnEtapa3">
                                    Visualizar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="supervision-footer">
            <form id="formProcesoE1" class="form-etapa" action="{{ route('proceso') }}" method="POST" data-estado="1">
                @csrf
                <input type="hidden" name="id" id="idE1">
                <input type="hidden" name="test" id="test" value="1">
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado de Aprobación</label>
                            <select class="form-select" id="estadoE1" name="estado" required>
                                <option value="" selected disabled>Seleccione un estado</option>
                                <option value="rechazado">Rechazado</option>
                                <option value="aprobado">Aprobado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <button type="submit" form="formProcesoE1" class="btn-guardar w-100">
                                <i class="bi bi-check-circle me-2"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@elseif($etapa == 2)
<style>
    .etapa-container {
        background: var(--background-color);
        padding: 1rem;
        border-radius: 1rem;
    }

    .etapa-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .etapa-header {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .etapa-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .etapa-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .etapa-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-control.readonly {
        background: #f8fafc;
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        font-weight: 500;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
    }

    .data-field {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.875rem 1rem;
        color: var(--text-primary);
        font-weight: 500;
        min-height: 44px;
        display: flex;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .data-field:hover {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .data-field::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--success-color), #047857);
        border-radius: 0.5rem 0 0 0.5rem;
    }

    .etapa-footer {
        background: #f8fafc;
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
    }

    .btn-regresar {
        background: linear-gradient(135deg, var(--secondary-color), #475569);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-regresar:hover {
        background: linear-gradient(135deg, #475569, #334155);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
    }
</style>

<div class="etapa-container fade-in">
    <div class="etapa-card">
        <div class="etapa-header">
            <h5 class="etapa-title">
                <i class="bi bi-building"></i>
                Datos de la Empresa
            </h5>
        </div>
        
        <div class="etapa-body">
            <div class="form-group">
                <label class="form-label">Nombre de la Empresa</label>
                <div class="data-field">
                    <span id="modal-nombre-empresa"></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ruc" class="form-label">RUC</label>
                        <div class="data-field">
                            <span id="modal-ruc-empresa"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="razon_social" class="form-label">Razón Social</label>
                        <div class="data-field">
                            <span id="modal-razon_social-empresa"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="direccion" class="form-label">Dirección</label>
                <div class="data-field">
                    <span id="modal-direccion-empresa"></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="data-field">
                            <span id="modal-telefono-empresa"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <div class="data-field">
                            <span id="modal-email-empresa"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="sitio_web" class="form-label">Sitio web (opcional)</label>
                <div class="data-field">
                    <span id="modal-sitio_web-empresa"></span>
                </div>
            </div>
        </div>
        
        <div class="etapa-footer">
            <div class="text-end">
                <button type="button" class="btn-regresar btn-regresar-etapa1">
                    <i class="bi bi-arrow-left me-2"></i>
                    Regresar
                </button>
            </div>
        </div>
    </div>
</div>
@elseif($etapa == 3)
<style>
    .jefe-container {
        background: var(--background-color);
        padding: 1rem;
        border-radius: 1rem;
    }

    .jefe-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .jefe-header {
        background: linear-gradient(135deg, var(--warning-color), #b45309);
        color: white;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .jefe-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .jefe-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .jefe-body {
        padding: 2rem;
    }

    .data-field-jefe {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.875rem 1rem;
        color: var(--text-primary);
        font-weight: 500;
        min-height: 44px;
        display: flex;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .data-field-jefe:hover {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    .data-field-jefe::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--warning-color), #b45309);
        border-radius: 0.5rem 0 0 0.5rem;
    }

    .jefe-footer {
        background: #fffbeb;
        border-top: 1px solid #fbbf24;
        padding: 1.5rem 2rem;
    }

    .btn-regresar-jefe {
        background: linear-gradient(135deg, var(--secondary-color), #475569);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-regresar-jefe:hover {
        background: linear-gradient(135deg, #475569, #334155);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
    }
</style>

<div class="jefe-container fade-in">
    <div class="jefe-card">
        <div class="jefe-header">
            <h5 class="jefe-title">
                <i class="bi bi-person-tie"></i>
                Datos del Jefe Inmediato
            </h5>
        </div>
        
        <div class="jefe-body">
            <div class="form-group">
                <label for="name" class="form-label">Apellidos y Nombres</label>
                <div class="data-field-jefe">
                    <span id="modal-name-jefe"></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dni" class="form-label">DNI</label>
                        <div class="data-field-jefe">
                            <span id="modal-dni-jefe"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sitio_web" class="form-label">Sitio web (opcional)</label>
                        <div class="data-field-jefe">
                            <span id="modal-sitio_web-jefe"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area" class="form-label">Área o Departamento</label>
                        <div class="data-field-jefe">
                            <span id="modal-area-jefe"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cargo" class="form-label">Cargo o Puesto</label>
                        <div class="data-field-jefe">
                            <span id="modal-cargo-jefe"></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="data-field-jefe">
                            <span id="modal-telefono-jefe"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <div class="data-field-jefe">
                            <span id="modal-email-jefe"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="jefe-footer">
            <div class="text-end">
                <button type="button" class="btn-regresar-jefe btn-regresar-etapa2">
                    <i class="bi bi-arrow-left me-2"></i>
                    Regresar
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: '{{ session('error') }}',
        showConfirmButton: false,
        timer: 4000, // Un poco más de tiempo para errores
        timerProgressBar: true,
    });
</script>
@endif
@endpush

