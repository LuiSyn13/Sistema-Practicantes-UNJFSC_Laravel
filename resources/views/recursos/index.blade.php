@extends('template')

@section('title', 'Recursos')
@section('subtitle', 'Repositorio de Documentos y Plantillas')

@section('content')
<div class="row">
    <div class="col-12">
        {{-- Mensajes de éxito/error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Recursos Disponibles</h5>
                    @if(Auth::user()->hasAnyRoles([1, 2, 3, 4]) && !empty($tiposPermitidos))
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadRecursoModal">
                            <i class="bi bi-cloud-upload"></i> Subir Recurso
                        </button>
                    @endif
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> En esta sección podrás encontrar documentos, plantillas y guías necesarias para el proceso de prácticas preprofesionales.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre del Recurso</th>
                                <th>Tipo</th>
                                <th>Fecha Subida</th>
                                <th>Subido por</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recursos as $recurso)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf text-danger me-2" style="font-size: 1.5rem;"></i>
                                            <div>
                                                <div class="fw-semibold">{{ $recurso->nombre }}</div>
                                                @if($recurso->descripcion)
                                                    <small class="text-muted">{{ Str::limit($recurso->descripcion, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $tipoLabels = [
                                                'otros' => 'Otros',
                                                'carga_lectiva' => 'Carga Lectiva',
                                                'horario' => 'Horario',
                                                'resolucion' => 'Resolución',
                                                'ficha' => 'Ficha',
                                                'record' => 'Record',
                                                'fut' => 'FUT',
                                                'carta_presentacion' => 'Carta de Presentación',
                                                'carta_aceptacion' => 'Carta de Aceptación',
                                                'plan_actividades_ppp' => 'Plan de Actividades PPP',
                                                'constancia_cumplimiento' => 'Constancia de Cumplimiento',
                                                'informe_final_ppp' => 'Informe Final PPP',
                                                'anexo_7' => 'Anexo 7',
                                                'anexo_8' => 'Anexo 8',
                                            ];
                                        @endphp
                                        <span class="badge bg-secondary">{{ $tipoLabels[$recurso->tipo] ?? $recurso->tipo }}</span>
                                    </td>
                                    <td>{{ $recurso->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($recurso->uploader && $recurso->uploader->persona)
                                            {{ $recurso->uploader->persona->nombres }} {{ $recurso->uploader->persona->apellidos }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ asset($recurso->ruta) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Descargar">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        @if(Auth::user()->hasAnyRoles([1, 2]))
                                            <form action="{{ route('recursos.destroy', $recurso->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este recurso?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No hay recursos disponibles por el momento.
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

<!-- Modal Subir Recurso -->
@if(Auth::user()->hasAnyRoles([1, 2, 3, 4]) && !empty($tiposPermitidos))
<div class="modal fade" id="uploadRecursoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Nuevo Recurso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('recursos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombreArchivo" class="form-label">Nombre del Documento</label>
                        <input type="text" class="form-control" id="nombreArchivo" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="archivoRecurso" class="form-label">Archivo (PDF, DOCX, XLSX)</label>
                        <input type="file" class="form-control" id="archivoRecurso" name="archivo" accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                    </div>
                    <!-- Select de tipo dinámico por rol -->
                    <div class="mb-3">
                        <label for="tipoRecurso" class="form-label">Tipo de Recurso</label>
                        <select class="form-select" id="tipoRecurso" name="tipo" required>
                            @php
                                $tipoLabels = [
                                    'otros' => 'Otros',
                                    'carga_lectiva' => 'Carga Lectiva',
                                    'horario' => 'Horario',
                                    'resolucion' => 'Resolución',
                                    'ficha' => 'Ficha',
                                    'record' => 'Record',
                                    'fut' => 'FUT',
                                    'carta_presentacion' => 'Carta de Presentación',
                                    'carta_aceptacion' => 'Carta de Aceptación',
                                    'plan_actividades_ppp' => 'Plan de Actividades PPP',
                                    'constancia_cumplimiento' => 'Constancia de Cumplimiento',
                                    'informe_final_ppp' => 'Informe Final PPP',
                                    'anexo_7' => 'Anexo 7',
                                    'anexo_8' => 'Anexo 8',
                                ];
                            @endphp
                            @foreach($tiposPermitidos as $tipo)
                                <option value="{{ $tipo }}">{{ $tipoLabels[$tipo] ?? ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionRecurso" class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" id="descripcionRecurso" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
