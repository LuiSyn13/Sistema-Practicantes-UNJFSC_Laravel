@extends('template')
@section('title', 'Registro de Usuarios')
@section('subtitle', 'Agregar nuevos usuarios al sistema')

@push('css')
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
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .registration-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .registration-card {
        background: var(--surface-color);
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        cursor: pointer;
        height: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .registration-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .registration-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-color);
    }

    .registration-card:hover:before {
        transform: scaleX(1);
    }

    .registration-icon {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .registration-card:hover .registration-icon {
        color: var(--primary-light);
        transform: scale(1.1);
    }

    .registration-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.025em;
    }

    .registration-subtitle {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
        margin-bottom: 0;
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem 2rem;
        border-bottom: none;
    }

    .modal-title {
        font-size: 1.375rem;
        font-weight: 600;
        margin: 0;
    }

    .modal-header .close {
    background: transparent;
    border: none;
    font-size: 1.2rem;
    color: #ffffffcc;
    padding: 0.5rem 0.7rem;
    border-radius: 50%;
    transition: all 0.3s ease-in-out;
    position: absolute;
    top: 15px;
    right: 15px;
    }

    .modal-header .close:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    transform: rotate(90deg);
    box-shadow: 0 0 5px #ffffff88;
    }

    .modal-body {
        padding: 2rem;
        background: var(--surface-color);
    }

    .modal-footer {
        background: var(--background-color);
        border-top: 1px solid var(--border-color);
        border-radius: 0 0 1rem 1rem;
        padding: 1.5rem 2rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        display: block;
    }

    .form-control {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        background: var(--surface-color);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    .form-control:disabled {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: var(--text-secondary);
    }

    /* Button Styles */
    .btn {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    .btn-secondary {
        background: var(--secondary-color);
        color: white;
    }

    .btn-secondary:hover {
        background: #475569;
        color: white;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background: #047857;
        color: white;
    }

    /* File Upload Styles */
    .file-upload-container {
        border: 2px dashed var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s ease;
        background: var(--background-color);
        position: relative;
    }

    .file-upload-container:hover {
        border-color: var(--primary-color);
        background: rgba(30, 58, 138, 0.02);
    }

    .file-upload-container::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 48px;
        height: 48px;
        opacity: 0.1;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23059669' viewBox='0 0 16 16'%3E%3Cpath d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z'/%3E%3Cpath d='M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        pointer-events: none;
    }

    .file-name {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
        font-style: italic;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .registration-container {
            padding: 1rem 0;
        }
        
        .registration-card {
            height: 280px;
            padding: 1.5rem;
        }
        
        .registration-icon {
            font-size: 3rem;
        }
        
        .registration-title {
            font-size: 1.25rem;
        }
        
        .modal-body {
            padding: 1.5rem;
        }
    }

    /* Estilos adicionales para mejor integración */
    .modal-dialog.modal-lg {
        max-width: 900px;
    }

    /* Mejoras en formularios */
    .form-row {
        margin-bottom: 1rem;
    }

    /* Indicadores de campos obligatorios */
    .form-group label::after {
        content: '*';
        color: var(--danger-color);
        margin-left: 4px;
        font-weight: 600;
    }

    .form-group label[for="departamento"]::after,
    .form-group label[for="correo_inst"]::after {
        display: none;
    }

    /* Estados de validación */
    .form-control.is-valid {
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* Mejoras en los select */
    .form-control option {
        padding: 0.5rem;
        font-weight: 500;
    }

    /* Loading states */
    .btn.loading {
        position: relative;
        color: transparent;
    }

    .btn.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        color: white;
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* ...existing styles... */
</style>
@endpush

@section('content')
<div class="registration-container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-6 mb-4">
            <div class="registration-card" data-toggle="modal" data-target="#modalRegistro">
                <i class="bi bi-person-plus registration-icon"></i>
                <h3 class="registration-title">Añadir Usuario</h3>
                <p class="registration-subtitle">Registrar un nuevo usuario individualmente</p>
            </div>
        </div>

        <div class="col-xl-5 col-lg-6 col-md-6 mb-4">
            <div class="registration-card" data-toggle="modal" data-target="#modalCargaMasiva">
                <i class="bi bi-people registration-icon"></i>
                <h3 class="registration-title">Carga Masiva</h3>
                <p class="registration-subtitle">Importar múltiples usuarios desde archivo CSV</p>
            </div>
        </div>
    </div>
</div>

<!--Carga_Masiva-->
<div class="modal fade" id="modalCargaMasiva" tabindex="-1" role="dialog" aria-labelledby="modalCargaMasivaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCargaMasivaLabel">
                    <i class="bi bi-people me-2"></i>
                    Carga Masiva de Usuarios
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUsuarioMasivo" enctype="multipart/form-data" action="{{ route('usuarios.masivos.store') }}" method="POST">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rol">Tipo de Usuario</label>
                                <select class="form-control" id="rolMasivo" name="rol" required onchange="toggleFacultadEscuela('facultadEscuelaContainerMasivo')">
                                    <option value="">Seleccione un tipo de usuario</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="archivo" class="d-block mb-2">Archivo CSV</label>
                                <div class="file-upload-container" onclick="document.getElementById('archivo').click()">
                                    <i class="bi bi-cloud-upload me-2"></i>
                                    <span class="file-upload-text">Seleccionar Archivo</span>
                                    <div class="file-name" id="archivo-nombre">Ningún archivo seleccionado</div>
                                    <input type="file" class="d-none" id="archivo" name="archivo" accept=".csv" required 
                                        onchange="document.getElementById('archivo-nombre').textContent = this.files[0].name">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="facultadEscuelaContainerMasivo">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facultadMasiva">Facultad</label>
                                    <select class="form-control" id="facultadMasiva" name="facultad">
                                        <option value="">Seleccione una facultad</option>
                                        @foreach($facultades as $facultad)
                                            <option value="{{ $facultad->id }}">{{ $facultad->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="escuelaMasiva">Escuela</label>
                                    <select class="form-control" id="escuelaMasiva" name="escuela" disabled>
                                        <option value="">Seleccione una escuela</option>
                                        @foreach($escuelas as $escuela)
                                            <option value="{{ $escuela->id }}" data-facultad="{{ $escuela->facultad_id }}" hidden>
                                                {{ $escuela->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>
                    Cerrar
                </button>
                <button type="submit" form="formUsuarioMasivo" class="btn btn-primary">
                    <i class="bi bi-upload me-2"></i>
                    Importar Usuarios
                </button>
            </div>
        </div>
    </div>
</div>
<!--Fin Carga_Masiva-->

<!--Registro-->
<div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroLabel">
                    <i class="bi bi-person-plus me-2"></i>
                    Registro de Usuario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegistro" action="{{ route('personas.store') }}" method="POST">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="semestre">Semestre</label>
                                <select class="form-control" id="semestreRegistro" name="semestre" required>
                                    <option value="">Seleccione un semestre</option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->id }}">{{ $semestre->codigo }} - {{ $semestre->ciclo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="tel" class="form-control" id="codigo" name="codigo" maxlength="10" required  oninput="completarCorreo()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="dni">DNI</label>
                                <input type="tel" class="form-control" id="dni" name="dni" required maxlength="8" pattern="\d{1,9}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="tel" class="form-control" id="celular" name="celular" required maxlength="9" pattern="\d{1,9}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombres">Nombres</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required oninput="completarCorreo()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required oninput="completarCorreo()">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="correo_inst">Correo Institucional</label>
                                <input type="email" class="form-control" id="correo_inst" name="correo_inst" placeholder="ejemplo@unjfsc.edu.pe" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rol">Tipo de Usuario</label>
                                <select class="form-control" id="rolRegistro" name="rol" required onchange="toggleFacultadEscuela('facultadEscuelaContainerRegistro'); completarCorreo();">
                                    <option value="">Seleccione un tipo de usuario</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sexo">Género</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="">Seleccione su género</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento" value="Lima Provincias" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <select class="form-control" id="provincia" name="provincia" required>
                                    <option value="">Seleccione una provincia</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="distrito">Distrito</label>
                                <select class="form-control" id="distrito" name="distrito" required disabled>
                                    <option value="">Seleccione un distrito</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="facultadEscuelaContainerRegistro">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facultadRegistro">Facultad</label>
                                    <select class="form-control" id="facultadRegistro" name="facultad" >
                                        <option value="">Seleccione una facultad</option>
                                        @foreach($facultades as $facultad)
                                            <option value="{{ $facultad->id }}">{{ $facultad->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="escuelaRegistro">Escuela</label>
                                    <select class="form-control" id="escuelaRegistro" name="escuela"  disabled>
                                        <option value="">Seleccione una escuela</option>
                                        @foreach($escuelas as $escuela)
                                            <option value="{{ $escuela->id }}" data-facultad="{{ $escuela->facultad_id }}" hidden>
                                                {{ $escuela->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>
                    Cerrar
                </button>
                <button type="submit" form="formRegistro" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>
                    Registrar Usuario
                </button>
            </div>
        </div>
    </div>
</div>
<!--Fin Registro-->

@endsection

@push('js')
<script>
    function toggleFacultadEscuela(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        // Find the closest form and then find the role select within that form
        const form = container.closest('form');
        let rolSelect;
        
        // Handle both modals
        if (form.id === 'formUsuarioMasivo') {
            rolSelect = document.getElementById('rolMasivo');
        } else if (form.id === 'formRegistro') {
            rolSelect = document.getElementById('rolRegistro');
        }
        
        if (!rolSelect) return;
        
        const selectedRole = parseInt(rolSelect.value);
        
        // Show/hide based on selected role (2 or 3)
        /*if (selectedRole === 2) {
            container.style.display = 'none';
        } else {
            container.style.display = 'block';
        }*/
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize both containers
        toggleFacultadEscuela('facultadEscuelaContainerMasivo');
        toggleFacultadEscuela('facultadEscuelaContainerRegistro');
        
        // Add event listeners for select changes
        document.getElementById('rolMasivo')?.addEventListener('change', function() {
            toggleFacultadEscuela('facultadEscuelaContainerMasivo');
        });
        
        document.getElementById('rolRegistro')?.addEventListener('change', function() {
            toggleFacultadEscuela('facultadEscuelaContainerRegistro');
        });
    });
</script>
<script src="{{ asset('js/cuadro_registro_user.js') }}"></script>
@endpush
