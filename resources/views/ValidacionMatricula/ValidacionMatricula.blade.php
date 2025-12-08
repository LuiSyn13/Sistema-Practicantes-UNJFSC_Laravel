@extends('template')
@section('title', 'Validación de Matrícula')
@section('subtitle', 'Gestionar y validar documentos académicos de estudiantes')

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

    .validacion-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0;
    }

    /* Card Principal */
    .validacion-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .validacion-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .validacion-card-header {
        background: linear-gradient(135deg, var(--surface-color) 0%, #f8fafc 100%);
        border-bottom: 2px solid var(--border-color);
        padding: 1.5rem 2rem;
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .validacion-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    }

    .validacion-card-title {
        font-size: 1.375rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-transform: none;
    }

    .validacion-card-title i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .validacion-card-body {
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
        text-align: center;
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

    /* Badges y Estados */
    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        text-align: left;
    }

    .semester-badge {
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

    .school-badge {
        background: linear-gradient(135deg, var(--secondary-color), #475569);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    /* Botones de Acción */
    .btn {
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        border-radius: 0.5rem;
        padding: 0.375rem 1.25rem;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-width: 120px;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background: #047857;
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
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

    .btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background: #b45309;
        color: white;
    }

    .btn-outline-dark {
        background: transparent;
        border: 2px solid var(--text-primary);
        color: var(--text-primary);
    }

    .btn-outline-dark:hover {
        background: var(--text-primary);
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

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow-lg);
    }

    .modal-header {
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem 2rem;
        border-bottom: none;
        position: relative;
    }

    .modal-header.bg-success {
        background: linear-gradient(135deg, var(--success-color), #047857) !important;
        color: white;
    }

    .modal-header.bg-warning {
        background: linear-gradient(135deg, var(--warning-color), #b45309) !important;
        color: white;
    }

    .modal-title {
        font-size: 1.375rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
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

    /* Alerts Modernos */
    .alert {
        border: none;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-left: 4px solid;
        margin-bottom: 1rem;
    }

    .alert-success {
        background: rgba(5, 150, 105, 0.1);
        border-left-color: var(--success-color);
        color: #047857;
    }

    .alert-warning {
        background: rgba(217, 119, 6, 0.1);
        border-left-color: var(--warning-color);
        color: #92400e;
    }

    .alert-danger {
        background: rgba(220, 38, 38, 0.1);
        border-left-color: var(--danger-color);
        color: #991b1b;
    }

    /* Estados de Documentos */
    .document-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .status-completed {
        background: rgba(5, 150, 105, 0.1);
        color: var(--success-color);
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        border: 2px solid rgba(5, 150, 105, 0.2);
    }

    /* Tabla con scroll mejorada */
    .table-responsive {
        border-radius: 0.75rem;
        overflow: hidden;
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

    /* Mejoras adicionales para integración completa */
    
    /* Badge mejorado para ID */
    .badge-light {
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
    }

    .badge-light:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Estados de badges con hover */
    .semester-badge:hover,
    .school-badge:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Botones en la tabla con espaciado */
    .table tbody td .btn {
        margin: 0.125rem;
        min-width: 140px;
    }

    /* Estados de documento mejorados */
    .document-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .document-status.completed {
        background: rgba(5, 150, 105, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .document-status.pending {
        background: rgba(217, 119, 6, 0.1);
        color: var(--warning-color);
        border: 1px solid rgba(217, 119, 6, 0.2);
    }

    .document-status.error {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-color);
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    /* Mejoras en formularios del modal */
    .form-control option {
        padding: 0.5rem;
        font-weight: 500;
    }

    /* Alertas con íconos mejorados */
    .alert i {
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    .alert strong {
        font-weight: 600;
    }

    /* Estados de carga para botones */
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

    /* Mejoras en tooltips */
    .tooltip {
        font-size: 0.875rem;
    }

    .tooltip-inner {
        background: var(--text-primary);
        color: white;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
    }

    /* Estados de enfoque mejorados */
    .btn:focus,
    .form-control:focus {
        outline: 0;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.25);
    }

    /* Transiciones para los badges */
    .semester-badge,
    .school-badge {
        transition: all 0.3s ease;
    }

    /* Hover effects para la fila completa */
    .table tbody tr:hover .semester-badge,
    .table tbody tr:hover .school-badge {
        transform: scale(1.05);
    }

    /* Mejoras en la presentación de alertas sin PDF */
    .alert i[style*="font-size: 2rem"] {
        display: block;
        margin: 0 0 1rem 0;
    }

    /* Estados de validación visual */
    .form-control.is-valid {
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* Mejoras responsive adicionales */
    @media (max-width: 576px) {
        .table tbody td .btn {
            min-width: 100px;
            font-size: 0.8rem;
            padding: 0.5rem 0.75rem;
        }

        .semester-badge,
        .school-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .validacion-card-title {
            font-size: 1.125rem;
        }

        .modal-title {
            font-size: 1.25rem;
        }
    }

    /* Animaciones de entrada para modales */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
        transform: translate(0, -50px);
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    /* ...existing styles... */
</style>
@endpush

@section('content')
<div class="validacion-container">
  <div class="validacion-card fade-in">
    <div class="validacion-card-header">
      <h5 class="validacion-card-title">
        <i class="bi bi-clipboard-check"></i>
        Lista de Estudiantes para Validación
      </h5>
    </div>
    <div class="validacion-card-body">
      <div class="table-container">
        <div class="table-responsive">
          <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Estudiante</th>
                <th>Semestre</th>
                <th>Escuela</th>
                <th>F Matrícula</th>
                <th>R Académico</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($estudiantes as $item)
                @php
                  $archivosPorTipo = $item->archivos->groupBy('tipo');

                  $getLatest = function ($tipo) use ($archivosPorTipo) {
                      $history = $archivosPorTipo->get($tipo);
                      return $history ? $history->sortByDesc('created_at')->first() : null;
                  };

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

                  $latestFicha = $getLatest('ficha');
                  $historialFicha = $archivosPorTipo->get('ficha');
                  $estadoFicha = $latestFicha ? $latestFicha->estado_archivo : 'Falta';
                  $bg_ficha = $getBgColor($estadoFicha);

                  $latestRecord = $getLatest('record');
                  $historialRecord = $archivosPorTipo->get('record');
                  $estadoRecord = $latestRecord ? $latestRecord->estado_archivo : 'Falta';
                  $bg_record = $getBgColor($estadoRecord);
                @endphp
                <tr>
                  <td>
                    <span class="badge badge-light" style="background: var(--background-color); color: var(--text-primary); font-weight: 500;">
                      {{ $item->id }}
                    </span>
                  </td>
                  <td class="student-name">{{ $item->asignacion_persona->persona->nombres ?? 'Sin estudiante' }} {{ $asignacion->persona->apellidos ?? '' }}</td>
                  <td>
                    <span class="student-name">{{ $item->asignacion_persona->semestre->codigo ?? 'Sin semestre' }}</span>
                  </td>
                  <td>
                    <span class="student-name">{{ $item->asignacion_persona->seccion_academica->escuela->name ?? 'Sin escuela' }}</span>
                  </td>
                  <td>
                    <button type="button" class="btn btn-{{$bg_ficha}}" data-toggle="modal" data-target="#modalFicha{{ $item->id }}">
                      <i class="bi bi-file-earmark-text"></i>
                      Ficha Matrícula
                    </button>
                  </td>
                  <td>
                    <button type="button" class="btn btn-{{$bg_record}}" data-toggle="modal" data-target="#modalRecord{{ $item->id }}">
                      <i class="bi bi-journal-text"></i>
                      Récord Académico
                    </button>
                  </td>
                </tr>

                <x-document-modal
                  :item="$item"
                  modalId="modalFicha"
                  title="Ficha"
                  icon="file-earmark-text"
                  :bgClass="$bg_ficha"
                  estadoKey="estado_archivo"
                  rutaKey="ruta"
                  updateRoute="actualizar.estado.archivo"
                  :latestArchivo="$latestFicha"
                  :historialArchivos="$historialFicha"
                  isArchivoModel="true"
                />
                
                <x-document-modal
                  :item="$item"
                  modalId="modalRecord"
                  title="Récord"
                  icon="journal-text"
                  :bgClass="$bg_record"
                  estadoKey="estado_record"
                  rutaKey="ruta"
                  updateRoute="actualizar.estado.archivo"
                  :latestArchivo="$latestRecord"
                  :historialArchivos="$historialRecord"
                  isArchivoModel="true"
                />
@endforeach
              @if($estudiantes->isEmpty())
              <tr>
                <td colspan="6" class="empty-state">
                  <i class="bi bi-inbox"></i>
                  <p class="mb-0">No se encontraron estudiantes para validar.</p>
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
@endpush
