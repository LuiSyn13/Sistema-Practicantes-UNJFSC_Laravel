@extends('template')
@section('title', 'Gestión de Evaluaciones')
@section('subtitle', 'Administrar evaluaciones y entrevistas de estudiantes en prácticas')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

    .evaluacion-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0;
    }

    /* Card Principal */
    .evaluacion-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .evaluacion-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .evaluacion-card-header {
        background: linear-gradient(135deg, var(--surface-color) 0%, #f8fafc 100%);
        border-bottom: 2px solid var(--border-color);
        padding: 1.5rem 2rem;
        position: relative;
    }

    .evaluacion-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .evaluacion-card-title {
        font-size: 1.375rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-transform: none;
    }

    .evaluacion-card-title i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .evaluacion-card-body {
        padding: 1.5rem;
    }

    /* Tabla Moderna */
    .table-container {
        background: var(--surface-color);
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table {
        margin: 0;
        border: none;
        font-size: 0.9rem;
    }

    .table thead th {
        background: linear-gradient(135deg, #1e293b 0%, #374151 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 1rem 0.75rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: center;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(30, 58, 138, 0.02);
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badge para ID */
    .id-badge {
        background: linear-gradient(135deg, var(--secondary-color), #475569);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        box-shadow: var(--shadow-sm);
    }

    .id-badge:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Nombre del estudiante */
    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    /* Botones de Acción */
    .btn {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.375rem;
        margin: 0.125rem;
        min-width: 80px;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background: #047857;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
        color: white;
    }

    .btn-info {
        background: var(--info-color);
        color: white;
    }

    .btn-info:hover {
        background: #0e7490;
        color: white;
    }

    .btn-outline-success {
        background: transparent;
        border: 2px solid var(--success-color);
        color: var(--success-color);
    }

    .btn-outline-success:hover {
        background: var(--success-color);
        color: white;
    }

    .btn-outline-warning {
        background: transparent;
        border: 2px solid var(--warning-color);
        color: var(--warning-color);
    }

    .btn-outline-warning:hover {
        background: var(--warning-color);
        color: white;
    }

    .btn-outline-primary {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
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

    .btn-outline-secondary {
        background: transparent;
        border: 2px solid var(--secondary-color);
        color: var(--secondary-color);
    }

    .btn-outline-secondary:hover {
        background: var(--secondary-color);
        color: white;
    }

    /* Botones de anexos con números */
    .anexo-btn {
        position: relative;
        min-width: 70px;
        transition: all 0.3s ease;
    }

    .anexo-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .anexo-btn .bi-file-pdf-fill {
        color: #dc3545;
        margin-right: 0.25rem;
        font-size: 0.9rem;
    }

    .anexo-btn .bi-6-square,
    .anexo-btn .bi-7-square,
    .anexo-btn .bi-8-square {
        font-size: 1rem;
        color: white;
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
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .btn-close:hover {
        opacity: 1;
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
    .form-group,
    .mb-3 {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
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

    .form-control[type="file"] {
        padding: 0.75rem;
        border: 2px dashed var(--border-color);
        background: var(--background-color);
        transition: all 0.3s ease;
    }

    .form-control[type="file"]:hover {
        border-color: var(--primary-color);
        background: rgba(30, 58, 138, 0.02);
    }

    .form-control[type="file"]:focus {
        border-style: solid;
        border-color: var(--primary-color);
        background: var(--surface-color);
    }

    /* Status indicators */
    .status-completed {
        color: var(--success-color);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-pending {
        color: var(--warning-color);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .text-muted {
        color: var(--text-secondary) !important;
        font-style: italic;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.25rem;
    }

    /* Badge para cantidad de respuestas */
    .response-count {
        background: var(--info-color);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Entrevista responses */
    .response-item {
        background: var(--background-color);
        border-left: 4px solid var(--primary-color);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .response-item strong {
        color: var(--text-primary);
        display: block;
        margin-bottom: 0.5rem;
    }

    /* Action buttons container */
    .evaluation-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        justify-content: center;
        align-items: center;
    }

    /* DataTable customizations */
    .dataTables_wrapper {
        font-family: 'Inter', sans-serif;
    }

    .dataTables_filter input {
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    .dataTables_filter input:focus {
        border-color: var(--primary-color);
        outline: none;
    }

    .dataTables_length select {
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        border: 1px solid var(--border-color);
        background: var(--surface-color);
        color: var(--text-primary);
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Estados de carga para formularios */
    .form-control.loading {
        background-image: url("data:image/svg+xml,%3csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill='%236b7280' d='M10 3.5a6.5 6.5 0 1 0 6.5 6.5h-1.5a5 5 0 1 1-5-5V3.5z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem 1rem;
        animation: spin 1s linear infinite;
    }

    /* Mejoras adicionales para integración completa */
    
    /* Alertas en modales */
    .alert {
        border: none;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-left: 4px solid;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-success {
        background: rgba(5, 150, 105, 0.1);
        border-left-color: var(--success-color);
        color: #047857;
    }

    .alert-info {
        background: rgba(8, 145, 178, 0.1);
        border-left-color: var(--info-color);
        color: #0e7490;
    }

    .alert-warning {
        background: rgba(217, 119, 6, 0.1);
        border-left-color: var(--warning-color);
        color: #92400e;
    }

    /* Estados de pregunta */
    .form-label {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        line-height: 1.4;
    }

    .form-label i {
        color: var(--primary-color);
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    /* Mejoras en DataTables */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        outline: none;
    }

    .dataTables_wrapper .dataTables_info {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        border: 1px solid var(--border-color);
        background: var(--surface-color);
        color: var(--text-primary);
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Mejoras responsive adicionales */
    @media (max-width: 576px) {
        .anexo-btn {
            min-width: 60px;
            font-size: 0.75rem;
            padding: 0.375rem 0.5rem;
        }

        .id-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .student-name {
            font-size: 0.875rem;
        }

        .modal-body {
            padding: 1.25rem;
        }

        .evaluation-actions {
            gap: 0.25rem;
        }
    }

    /* Animaciones */
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

    /* Estado vacío para la tabla */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
    }
</style>
@endpush

@section('content')
<div class="evaluacion-container">
    <div class="evaluacion-card fade-in">
        <div class="evaluacion-card-header">
            <h5 class="evaluacion-card-title">
                <i class="bi bi-clipboard2-check"></i>
                Evaluación de Estudiantes
            </h5>
        </div>
        <div class="evaluacion-card-body">
            <div class="table-container">
                <div class="table-responsive">
                    <table id="tablaEvaluacion" class="table" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre del Estudiante</th>
                                <th width="30%">Evaluación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @php
                                $evaluacion = $alumno->evaluaciones->first();
                                $anexosCompletos = $evaluacion && $evaluacion->anexo_6 && $evaluacion->anexo_7 && $evaluacion->anexo_8;
                                $entrevistaCompleta = $alumno->respuestas && $alumno->respuestas->count();
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="student-name">{{ $alumno->id }}</span>
                                </td>
                                <td class="student-name">{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                                <td class="text-center">
                                    <div class="evaluation-actions">
                                        @if($userRol == 1 || $userRol == 4)
                                            @if($evaluacion)
                                                @if($evaluacion->anexo_6)
                                                    <a href="{{ Storage::url($evaluacion->anexo_6) }}" class="btn btn-success anexo-btn" target="_blank">
                                                        <i class="bi bi-file-pdf-fill"></i>
                                                        <i class="bi bi-6-square"></i>
                                                    </a>
                                                @endif
                                                @if($evaluacion->anexo_7)
                                                    <a href="{{ Storage::url($evaluacion->anexo_7) }}" class="btn btn-success anexo-btn" target="_blank">
                                                        <i class="bi bi-file-pdf-fill"></i>
                                                        <i class="bi bi-7-square"></i>
                                                    </a>
                                                @endif
                                                @if($evaluacion->anexo_8)
                                                    <a href="{{ Storage::url($evaluacion->anexo_8) }}" class="btn btn-success anexo-btn" target="_blank">
                                                        <i class="bi bi-file-pdf-fill"></i>
                                                        <i class="bi bi-8-square"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            @if($entrevistaCompleta)
                                                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verEntrevistaModal-{{ $alumno->id }}">
                                                    <i class="bi bi-chat-text"></i>
                                                    Entrevista
                                                </button>
                                            @endif

                                            @if(!$anexosCompletos || !$entrevistaCompleta)
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuEvaluarModal-{{ $alumno->id }}">
                                                    <i class="bi bi-check2-circle"></i> 
                                                    Evaluar
                                                </button>
                                            @endif
                                        @elseif($userRol == 3)
                                            <button class="btn btn-outline-{{ $anexosCompletos && $entrevistaCompleta ? 'success' : 'warning' }}"
                                                    data-bs-toggle="modal" data-bs-target="#verTodoDocenteModal-{{ $alumno->id }}">
                                                <i class="bi bi-{{ $anexosCompletos && $entrevistaCompleta ? 'check-circle' : 'clock' }}"></i>
                                                {{ $anexosCompletos && $entrevistaCompleta ? 'Completado' : 'En Proceso' }}
                                            </button>
                                        @else
                                            <span class="text-muted">
                                                <i class="bi bi-lock"></i>
                                                Sin acciones
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        {{-- Modal Evaluar --}}
                        <div class="modal fade" id="menuEvaluarModal-{{ $alumno->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="bi bi-gear"></i>
                                            Opciones de Evaluación - {{ $alumno->nombres }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="d-flex flex-column gap-3">
                                            @if(!$anexosCompletos)
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#subirAnexosModal-{{ $alumno->id }}" data-bs-dismiss="modal">
                                                    <i class="bi bi-upload"></i> 
                                                    Subir Anexos de Evaluación
                                                </button>
                                            @else
                                                <div class="alert alert-success mb-0">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Anexos completados exitosamente
                                                </div>
                                            @endif

                                            @if(!$entrevistaCompleta)
                                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#realizarEntrevistaModal-{{ $alumno->id }}" data-bs-dismiss="modal">
                                                    <i class="bi bi-chat-square-text"></i> 
                                                    Realizar Entrevista de Evaluación
                                                </button>
                                            @else
                                                <div class="alert alert-info mb-0">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Entrevista completada exitosamente
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Subir Anexos --}}
                        <div class="modal fade" id="subirAnexosModal-{{ $alumno->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('evaluacion.storeAnexos') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-file-earmark-arrow-up"></i>
                                                Subir Anexos de Evaluación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @for($i = 6; $i <= 8; $i++)
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-file-pdf"></i>
                                                    Anexo {{ $i }} (PDF)
                                                </label>
                                                <input type="file" name="anexo_{{ $i }}" class="form-control" accept="application/pdf"
                                                       {{ empty($evaluacion->{'anexo_'.$i}) ? 'required' : '' }}>
                                                <small class="text-muted">Archivo PDF, máximo 10MB</small>
                                            </div>
                                            @endfor
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-save"></i>
                                                Guardar Anexos
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i>
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Realizar Entrevista --}}
                        <div class="modal fade" id="realizarEntrevistaModal-{{ $alumno->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('respuestas.store') }}">
                                        @csrf
                                        <input type="hidden" name="alumno_id" value="{{ $alumno->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-chat-left-text"></i>
                                                Entrevista de Evaluación
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($preguntas as $pregunta)
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="bi bi-question-circle"></i>
                                                    {{ $pregunta->pregunta }}
                                                </label>
                                                <input type="text" name="respuestas[{{ $pregunta->id }}]" class="form-control" 
                                                       placeholder="Escriba aquí la respuesta..." required>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle"></i>
                                                Guardar Entrevista
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i>
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>                        {{-- Modal Ver Entrevista --}}
                        @if($entrevistaCompleta)
                        <div class="modal fade" id="verEntrevistaModal-{{ $alumno->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Entrevista de {{ $alumno->nombres }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($alumno->respuestas as $respuesta)
                                        <div class="mb-3">
                                            <strong>{{ $respuesta->pregunta->pregunta }}</strong>
                                            <p>{{ $respuesta->respuesta }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Modal Docente ver todo --}}
                        <div class="modal fade" id="verTodoDocenteModal-{{ $alumno->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Evaluación completa de {{ $alumno->nombres }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>Anexos:</h6>
                                        @for($i = 6; $i <= 8; $i++)
                                            @if($evaluacion && $evaluacion->{'anexo_'.$i})
                                                <a href="{{ Storage::url($evaluacion->{'anexo_'.$i}) }}" class="btn btn-outline-secondary btn-sm mb-2" target="_blank">
                                                    <i class="bi bi-file-pdf-fill"></i> Anexo {{ $i }}
                                                </a><br>
                                            @endif
                                        @endfor

                                        <hr>
                                        <h6>Entrevista:</h6>
                                        @foreach ($alumno->respuestas as $respuesta)
                                            <div class="mb-2">
                                                <strong>{{ $respuesta->pregunta->pregunta }}</strong>
                                                <p>{{ $respuesta->respuesta }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                            @if($alumnos->isEmpty())
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="bi bi-person-x"></i>
                                    <p class="mb-0">No se encontraron estudiantes para evaluar.</p>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
    timer: 2000,
    timerProgressBar: true,
});
</script>
@endif
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#tablaEvaluacion').DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
        }
    });
});
</script>
@endpush
