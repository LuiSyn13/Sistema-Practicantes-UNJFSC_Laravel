@extends('template')
@section('title', 'Revisión de Evaluaciones')
@section('subtitle', 'Panel de supervisión y seguimiento de estudiantes')

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
        --info-color: #0891b2;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .supervision-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0;
    }

    /* Card Principal */
    .supervision-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .supervision-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .supervision-card-header {
        background: linear-gradient(135deg, var(--surface-color) 0%, #f8fafc 100%);
        border-bottom: 2px solid var(--border-color);
        padding: 1.5rem 2rem;
        position: relative;
    }

    .supervision-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .supervision-card-title {
        font-size: 1.375rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-transform: none;
    }

    .supervision-card-title i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .supervision-card-body {
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
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: none;
        border-bottom: 2px solid var(--border-color);
        font-weight: 600;
        color: var(--text-primary);
        padding: 1rem 0.75rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
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

    /* Badges para tipo de práctica y área */
    .practice-badge {
        background: linear-gradient(135deg, var(--info-color), #0e7490);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .area-badge {
        background: linear-gradient(135deg, var(--success-color), #047857);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .no-registered {
        color: var(--text-secondary);
        font-style: italic;
        font-size: 0.875rem;
    }

    /* Botones de Acción */
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

    .btn-info {
        background: var(--info-color);
        color: white;
    }

    .btn-info:hover {
        background: #0e7490;
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

    /* Botones de Etapas */
    .etapas-container {
        margin-bottom: 2rem;
    }

    .btn-etapa {
        background: var(--surface-color);
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        padding: 1rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
        font-weight: 600;
        position: relative;
        overflow: hidden;
    }

    .btn-etapa::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), var(--text-secondary));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .btn-etapa:hover {
        border-color: var(--primary-color);
        background: rgba(30, 58, 138, 0.02);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-etapa:hover::before {
        transform: scaleX(1);
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .btn-etapa.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-etapa.active::before {
        transform: scaleX(1);
        background: linear-gradient(90deg, var(--primary-light), white);
    }

    .btn-etapa.completed {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .btn-etapa.completed::before {
        transform: scaleX(1);
        background: linear-gradient(90deg, #047857, white);
    }

    /* Contenedor de etapas */
    .etapa-content {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-top: 1rem;
        box-shadow: var(--shadow-sm);
    }

    /* Estados vacíos */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--border-color);
        margin-bottom: 1rem;
    }

    /* Progress indicator */
    .progress-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
    }

    .progress-indicator::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--border-color);
        z-index: 0;
    }

    .progress-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        border-radius: 2px;
        transition: width 0.5s ease;
        z-index: 0;
    }

    .progress-step {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background: var(--surface-color);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--text-secondary);
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .progress-step.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .progress-step.completed {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .progress-indicator.step-1::after { width: 25%; }
    .progress-indicator.step-2::after { width: 50%; }
    .progress-indicator.step-3::after { width: 75%; }
    .progress-indicator.step-4::after { width: 100%; }

    /* Responsive Design */
    @media (max-width: 768px) {
        .supervision-card-header {
            padding: 1.25rem 1.5rem;
        }

        .supervision-card-body {
            padding: 1rem;
        }

        .supervision-card-title {
            font-size: 1.25rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            min-width: 700px;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.25rem 1.5rem;
        }

        .btn-etapa {
            padding: 0.75rem;
            font-size: 0.875rem;
        }

        .progress-step {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
        }
    }

    @media (max-width: 576px) {
        .etapas-container .col-md-3 {
            margin-bottom: 0.75rem;
        }

        .btn-etapa {
            padding: 0.75rem 0.5rem;
        }

        .btn-etapa i {
            font-size: 1rem;
        }

        .btn-etapa div {
            font-size: 0.875rem;
        }

        .progress-indicator {
            flex-direction: column;
            gap: 1rem;
        }

        .progress-indicator::before,
        .progress-indicator::after {
            display: none;
        }

        .progress-step {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
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

    .etapa-content {
        animation: fadeIn 0.3s ease;
    }

    /* Mejoras adicionales para integración completa */
    
    /* Estados de badges mejorados */
    .practice-badge,
    .area-badge {
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }

    .practice-badge:hover,
    .area-badge:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    /* Texto de estudiante con estilo mejorado */
    .table tbody td strong {
        color: var(--text-primary);
        font-weight: 600;
        letter-spacing: -0.025em;
    }

    /* Warning state mejorado */
    .text-warning {
        color: var(--warning-color) !important;
    }

    /* Mejoras en los botones de etapa */
    .btn-etapa i {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }

    .btn-etapa div {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .btn-etapa small {
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: 400;
    }

    /* Estados específicos para el progress indicator */
    .progress-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 0%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        border-radius: 2px;
        transition: width 0.5s ease;
        z-index: 0;
    }

    .progress-indicator.step-1::after { width: 25%; }
    .progress-indicator.step-2::after { width: 50%; }
    .progress-indicator.step-3::after { width: 75%; }
    .progress-indicator.step-4::after { width: 100%; }

    /* Mejoras en el modal de proceso */
    .modal-lg {
        max-width: 900px;
    }

    /* Contenido de etapa con padding mejorado */
    .etapa-content {
        min-height: 300px;
        display: flex;
        flex-direction: column;
    }

    /* Estados de botón activo/completado mejorados */
    .btn-etapa.active {
        transform: scale(1.02);
    }

    .btn-etapa.completed {
        transform: scale(1.02);
    }

    .btn-etapa.completed i::before {
        content: '\f633'; /* Bootstrap icon check-circle */
    }

    /* Mejoras en hover effects */
    .table tbody tr:hover td .practice-badge,
    .table tbody tr:hover td .area-badge {
        transform: scale(1.05);
    }

    /* Footer del modal mejorado */
    .modal-footer .btn {
        min-width: 120px;
    }

    /* Estados de carga */
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

    /* Mejoras en responsive para etapas */
    @media (max-width: 576px) {
        .etapas-container .col-md-3 {
            margin-bottom: 0.75rem;
        }

        .btn-etapa {
            padding: 0.75rem 0.5rem;
        }

        .btn-etapa i {
            font-size: 1rem;
        }

        .btn-etapa div {
            font-size: 0.875rem;
        }

        .progress-indicator {
            flex-direction: column;
            gap: 1rem;
        }

        .progress-indicator::before,
        .progress-indicator::after {
            display: none;
        }

        .progress-step {
            width: 2rem;
            height: 2rem;
            font-size: 0.875rem;
        }
    }

    /* Mejoras en el estado vacío */
    .empty-state {
        animation: fadeIn 0.5s ease;
    }

    .empty-state p {
        font-size: 1rem;
        margin-top: 1rem;
    }

    /* Transiciones suaves para cambio de etapas */
    .etapa-content > div {
        transition: all 0.3s ease;
    }

    .etapa-content > div[style*="display: none"] {
        opacity: 0;
        transform: translateY(10px);
    }

    /* Focus states mejorados */
    .btn-etapa:focus,
    .btn:focus {
        outline: 0;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.25);
    }

    /* Estilos para módulos bloqueados/desbloqueados */
    .module-selector-cell.locked {
        opacity: 0.65;
        cursor: not-allowed;
        position: relative;
        pointer-events: none;
    }

    .module-selector-cell.locked .lock-overlay {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0,0,0,0.06);
        color: rgba(0,0,0,0.6);
        border-radius: 50%;
        padding: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .module-selector-cell.unlocked { cursor: pointer; }

    /* ...existing styles... */
</style>
@endpush

@section('content')
    <div class="app-container">
        <div class="app-card">
            <div class="app-card-header">
                <h1 class="app-card-title">Panel de Revisión de Evaluaciones</h1>
            </div>
            <div class="app-card-body">
                <div class="row g-3">
                    <form method="GET" action="{{ route('revisar.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="grupo">Seleccionar Grupo:</label>
                                <select class="form-control" id="grupo" name="grupo" onchange="this.form.submit()">
                                    <option value="">-- Seleccione un grupo --</option>
                                    @foreach ($grupos_practica as $gp)
                                        <option value="{{ $gp->id }}">{{ $gp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <form id="form-modulo" method="GET" action="{{ route('revisar.index') }}" class="mt-4">
                        <input type="hidden" name="grupo" value="{{ $selected_grupo_id }}">
                        <input type="hidden" name="modulo" id="selected_modulo" value="{{ request('modulo', 1) }}">
                        
                        <div class="form-group">
                            <label class="font-weight-bold mb-2"><i class="bi bi-journal-bookmark-fill"></i> Seleccionar el Módulo:</label>
                            <div class="row g-2">
                                @php
                                    $modules = [1 => 'Módulo I', 2 => 'Módulo II', 3 => 'Módulo III', 4 => 'Módulo IV'];
                                    $currentModulo = isset($id_modulo_now) ? (int)$id_modulo_now : null;
                                    $selectedModuloRequest = (int) request('modulo', 1);
                                @endphp
                                @foreach($modules as $m => $label)
                                    @php
                                        $isActive = ($selectedModuloRequest === $m);
                                        $locked = is_null($selected_grupo_id) || is_null($currentModulo) || ($m > $currentModulo);
                                    @endphp
                                    <div class="col">
                                        <div
                                            class="module-selector-cell btn-etapa h-100 {{ $isActive ? 'active' : '' }} {{ $locked ? 'locked' : 'unlocked' }}"
                                            role="button"
                                            tabindex="{{ $locked ? '-1' : '0' }}"
                                            aria-disabled="{{ $locked ? 'true' : 'false' }}"
                                            data-module="{{ $m }}"
                                            data-locked="{{ $locked ? 1 : 0 }}"
                                            onclick="selectModule({{ $m }}, {{ $locked ? 'true' : 'false' }})"
                                        >
                                            <i class="bi bi-{{ $m }}-circle" style="font-size: 1.5em;"></i><br>{{ $label }}
                                            @if($locked)
                                                <span class="lock-overlay" title="Módulo bloqueado hasta completar etapas anteriores"><i class="bi bi-lock-fill"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                
                <!-- Espacio -->
                <br>
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Estudiante</th>
                                    <th>Anexo 7</th>
                                    <th>Anexo 8</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupo_estudiante as $index => $item)
                                    @php
                                        $getBgColor = function ($estado) {
                                            switch ($estado) {
                                                case 'Aprobado':
                                                    return 'primary';
                                                case 'Enviado':
                                                    return 'warning';
                                                case 'Corregir':
                                                    return 'danger';
                                                default:
                                                    return 'secondary';
                                            }
                                        };
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $item->asignacion_persona->persona->nombres }} {{ $item->asignacion_persona->persona->apellidos }}</strong></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-review-anexo" 
                                                data-id-estudiante="{{ $item->id_ap }}" 
                                                data-anexo-numero="7">Revisar Anexo 7</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary btn-review-anexo" 
                                                data-id-estudiante="{{ $item->id_ap }}" 
                                                data-anexo-numero="8">Revisar Anexo 8</button>
                                        </td>
                                        <td class="status-cell">
                                            <span class="badge bg-{{ $getBgColor($item->estado_evaluacion) }} status-badge"><i class="bi bi-hourglass-split"></i>{{ $item->estado_evaluacion }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($grupo_estudiante->isEmpty())
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <i class="bi bi-person-x"></i>
                                            <p class="mb-0">No se encontraron docentes registrados.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            <div class="app-card-footer">
                <p>Panel de revisión para supervisores.</p>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Revisión de Documento</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 1.5rem;">
                    <div id="no-file-container" style="display: none;">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-file-earmark-x" style="font-size: 2rem;"></i>
                            <h5 class="alert-heading mt-2">No se ha enviado ningún archivo</h5>
                            <p>No se ha encontrado ningún archivo para revisar.</p>
                        </div>
                    </div>
                    <div id="approved-file-container" style="display: none;">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-clipboard-check" style="font-size: 2rem;"></i>
                            <h5 class="alert-heading mt-2">Aprobado el Archivo</h5>
                            <p>El docente ya revisó y ha aprobado este anexo. No es posible modificarlo.</p>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-paperclip"></i> Archivo enviado:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-between align-items-center border flex-grow-1">
                                    <span class="text-truncate"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Anexo_7_Estudiante.pdf</span>
                                    <a href="#" class="btn btn-sm btn-outline-primary flex-shrink-0 ms-2" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver</a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-clipboard-data"></i> Nota:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-center align-items-center border flex-grow-1">
                                    <span class="fw-bold fs-5 text-primary">13</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="pending-review-container" style="display: none;">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-hourglass-split" style="font-size: 2rem;"></i>
                            <h5 class="alert-heading mt-2">Enviado para Revisión</h5>
                            <p>Ya has enviado este anexo. El docente lo está revisando.</p>
                        </div>
                        <!--<div class="row mb-3">
                            <div class="col-md-8 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-paperclip"></i> Archivo enviado:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-between align-items-center border flex-grow-1">
                                    <span class="text-truncate"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Anexo_7_Estudiante.pdf</span>
                                    <a href="#" id="pending-ruta" class="btn btn-sm btn-outline-primary flex-shrink-0 ms-2" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver</a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-clipboard-data"></i> Nota:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-center align-items-center border flex-grow-1">
                                    <span class="fw-bold fs-5 text-primary" id="pending-nota"></span>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <form id="submission-form" action="{{ route('actualizar.anexo') }}" method="POST">
                        @csrf
                        <!-- input de ap_id -->
                        <input type="hidden" name="ap_id" id="ap_id">
                        <input type="hidden" name="evaluacion" id="eval_archivo">
                        <input type="hidden" name="archivo" id="archivo">
                        <input type="hidden" name="anexo" id="anexo">

                        <div class="row mb-3">
                            <div class="col-md-8 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-paperclip"></i> Archivo enviado:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-between align-items-center border flex-grow-1">
                                    <span class="text-truncate"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Anexo_7_Estudiante.pdf</span>
                                    <a href="#" id="pending-ruta" class="btn btn-sm btn-outline-primary flex-shrink-0 ms-2" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver</a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex flex-column">
                                <label class="font-weight-bold"><i class="bi bi-clipboard-data"></i> Nota:</label>
                                <div class="alert alert-light p-2 d-flex justify-content-center align-items-center border flex-grow-1">
                                    <span class="fw-bold fs-5 text-primary" id="pending-nota">13</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="estado-anexo7-1" class="font-weight-bold mt-2">
                                <i class="bi bi-gear"></i> Estado del Documento
                            </label>
                            <select name="estado" id="estado-anexo7-1" class="form-control" onchange="toggleCorreccion(this)">
                                <option value="Enviado" selected>Enviado (Pendiente de Revisión)</option>
                                <option value="Aprobado">Aprobar</option>
                                <option value="Corregir">Marcar para Corregir</option>
                            </select>
                        </div>
                        <div class="form-group mt-3" id="correccion-options-anexo7-1" style="display: none;">
                            <label class="font-weight-bold"><i class="bi bi-exclamation-triangle"></i> Indicar qué se debe corregir:</label>
                            <div class="row g-2">
                                <div class="col">
                                    <div class="correccion-cell h-100" id="cellArchivo-anexo7-1" onclick="selectCorreccion('archivo', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar otro archivo y aprueba la nota.">
                                        <i class="bi bi-file-earmark-pdf" style="font-size: 1.5em;"></i><br>Archivo
                                        <input type="radio" name="correccionTipo" id="correccionArchivo-anexo7-1" value="2" class="d-none" checked>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="correccion-cell h-100" id="cellNota-anexo7-1" onclick="selectCorreccion('nota', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar otra nota y aprueba el archivo.">
                                        <i class="bi bi-123" style="font-size: 1.5em;"></i><br>Nota
                                        <input type="radio" name="correccionTipo" id="correccionNota-anexo7-1" value="3" class="d-none">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="correccion-cell h-100" id="cellAmbos-anexo7-1" onclick="selectCorreccion('ambos', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar nuevamente tanto el archivo como la nota.">
                                        <i class="bi bi-file-earmark-pdf" style="font-size: 1.5em;"></i> + <i class="bi bi-123" style="font-size: 1.5em;"></i><br>Ambos
                                        <input type="radio" name="correccionTipo" id="correccionAmbos-anexo7-1" value="4" class="d-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="comentario-anexo7-1" class="font-weight-bold">
                                <i class="bi bi-chat-dots"></i> Comentario
                            </label>
                            <textarea name="comentario" id="comentario-anexo7-1" class="form-control" rows="3" placeholder="Ej: La firma no es visible, por favor, vuelva a escanear el documento."></textarea>
                        </div>
                        <div class="mt-4 d-flex justify-content-between gap-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="history-container mb-3">
                        <h6 class="mt-4">Documentos enviados (Historial)</h6>
                        <ul class="list-group history-list" id="archivosEnviadosList">
                            <!-- Los elementos de la lista se agregarán dinámicamente aquí -->
                        </ul>
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

<script>
    // Función para manejar la selección de módulo (ahora con control de bloqueo)
    function selectModule(moduleId, locked) {
        // Si está bloqueado, mostrar notificación y no enviar
        if (locked) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Módulo bloqueado',
                    text: 'No puedes avanzar a este módulo hasta que se habilite según la etapa actual.',
                    toast: true,
                    position: 'top-end',
                    timer: 2500,
                    showConfirmButton: false,
                });
            } else {
                alert('Módulo bloqueado. No puedes seleccionar este módulo.');
            }
            return;
        }

        // Actualizar el valor del input oculto que contiene el módulo seleccionado
        document.getElementById('selected_modulo').value = moduleId;
        // Enviar el formulario
        document.getElementById('form-modulo').submit();
    }

    // Script para mantener seleccionado el grupo después de la recarga y añadir accesibilidad al selector de módulos
    document.addEventListener('DOMContentLoaded', function() {
        const selectedGrupo = '{{ $selected_grupo_id }}';
        if (selectedGrupo) {
            const grupoEl = document.getElementById('grupo');
            if (grupoEl) grupoEl.value = selectedGrupo;
        }

        // Añadir listener de teclado para activar módulos con Enter o Space cuando estén enfocados
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                const focused = document.activeElement;
                if (focused && focused.classList && focused.classList.contains('module-selector-cell')) {
                    const moduleId = parseInt(focused.getAttribute('data-module'), 10);
                    const locked = focused.getAttribute('data-locked') === '1';
                    if (moduleId) {
                        e.preventDefault();
                        selectModule(moduleId, locked);
                    }
                }
            }
        });
    });

    // Logica del modal de revisión
    document.addEventListener('DOMContentLoaded', function () {
        const ID_MODULO = parseInt(document.getElementById('selected_modulo').value) || 1;// Cambiar por el valor dinámico si es necesario
        const MODAL_SELECTOR = '#reviewModal';
        const modalElement = document.querySelector(MODAL_SELECTOR);
        const myModal = new bootstrap.Modal(modalElement);

        const anexoButtons = document.querySelectorAll('.btn-review-anexo');
        anexoButtons.forEach(button => {
            button.addEventListener('click', async function() {
                const ID_EST = this.getAttribute('data-id-estudiante');
                const anexoNumero = this.getAttribute('data-anexo-numero');
                const ANEXO = 'anexo_' + anexoNumero;

                try {
                    const response = await fetch(`/api/evaluacion_practica/${ID_EST}/${ID_MODULO}/${ANEXO}`);

                    if (!response.ok) {
                        console.error('Error en la respuesta de la API:', response.status, response.statusText);
                        return;
                    }

                    const result = await response.json();
                    const data = result.length > 0 ? result[0] : null;

                    // Seleccionar los contenedores del modal
                    const formContainer = document.getElementById('submission-form');
                    const noFileContainer = document.getElementById('no-file-container');
                    const pendingReviewContainer = document.getElementById('pending-review-container');

                    const historyList = document.getElementById('archivosEnviadosList');
                    historyList.innerHTML = ''; // Limpiar historial

                    // Asegurarse de que el formulario siempre sea visible al abrir el modal
                    formContainer.style.display = 'block';
                    pendingReviewContainer.style.display = 'none';

                    if(data && data.evaluacion_archivo && data.evaluacion_archivo.length > 0) {
                        console.log('Datos recibidos:', data);
                        document.getElementById('modalTitle').textContent = `Calificar Estudiante: Anexo ${anexoNumero}`;

                        const ultimoEnvio = data.evaluacion_archivo[0];

                        if (ultimoEnvio && ultimoEnvio.state === 1) {
                            document.getElementById('pending-nota').textContent = ultimoEnvio.nota;
                            const rutaArchivoPendiente = document.getElementById('pending-ruta');
                            rutaArchivoPendiente.href = `/${ultimoEnvio.archivos[0].ruta}`;

                            document.getElementById('ap_id').value = data.id_ap;
                            document.getElementById('eval_archivo').value = ultimoEnvio.id;
                            document.getElementById('archivo').value = ultimoEnvio.archivos[0].id;
                            document.getElementById('anexo').value = ANEXO;
                        } else if (ultimoEnvio && ultimoEnvio.state !== 1) {
                            formContainer.style.display = 'none';
                            pendingReviewContainer.style.display = 'block';
                        }

                        // Llenar el historial de envíos
                        data.evaluacion_archivo.forEach((ear, index) => {
                            let archivo = null;
                            if(ear.archivos && ear.archivos.length > 0) {
                                archivo = ear.archivos[0]; // Suponiendo que solo hay un archivo por evaluación
                            }

                            let li = document.createElement('li');
                            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                            li.innerHTML = `
                                <div>
                                    <strong>Archivo:</strong> ${archivo.tipo.toUpperCase()} <br>
                                    <strong>Nota:</strong> ${ear.nota} <br>
                                    <strong>Fecha de Envío:</strong> ${new Date(archivo.created_at).toLocaleString()}
                                </div>
                                <a href="${archivo.ruta}" target="_blank" class="btn btn-sm btn-outline-success" target="_blank">
                                    <i class="bi bi-file-earmark-pdf"></i> Ver
                                </a>
                            `;
                            historyList.appendChild(li);
                        });
                    } else {
                        // No hay datos de evaluación para este anexo/módulo
                        document.getElementById('modalTitle').textContent = `Revisar Anexo ${anexoNumero}`;
                        formContainer.style.display = 'none'; // Ocultar formulario
                        pendingReviewContainer.style.display = 'none'; // Mostrar mensaje
                        noFileContainer.style.display = 'block'; // Mostrar mensaje
                    }
                } catch (error) {
                    console.error('Falló la petición fetch:', error);
                }
                myModal.show();
            });
        });
    });

    // Lógica para el modal - Corrección
    (function() {
            const modalIdSuffix = 'anexo7-1'; // ID único para este modal

            function toggleCorreccion(selectElement) {
                const correccionOptions = document.getElementById(`correccion-options-${modalIdSuffix}`);
                correccionOptions.style.display = (selectElement.value === 'Corregir') ? 'block' : 'none';
            }

            function selectCorreccion(tipo) {
                const cells = ['Archivo', 'Nota', 'Ambos'];
                cells.forEach(cellType => {
                    const cell = document.getElementById(`cell${cellType}-${modalIdSuffix}`);
                    cell.style.backgroundColor = '#fff'; // Reset all
                });

                const selectedCell = document.getElementById(`cell${tipo.charAt(0).toUpperCase() + tipo.slice(1)}-${modalIdSuffix}`);
                const radio = document.getElementById(`correccion${tipo.charAt(0).toUpperCase() + tipo.slice(1)}-${modalIdSuffix}`);
                
                selectedCell.style.backgroundColor = '#e0e0e0'; // Highlight selected
                radio.checked = true;
            }

            // Asignar funciones al ámbito global para que los `onclick` y `onchange` del HTML puedan encontrarlas
            window.toggleCorreccion = toggleCorreccion;
            window.selectCorreccion = (tipo) => selectCorreccion(tipo); // Adaptador para no pasar el segundo argumento desde el HTML

            // Inicialización cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', function() {
                selectCorreccion('archivo'); // Seleccionar 'archivo' por defecto
                $('[data-toggle="tooltip"]').tooltip(); // Inicializar tooltips de Bootstrap
            });
        })();
</script>
@endpush