@extends('template')

@section('title', 'Gestión de Secciones por Escuela')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Lista de Escuelas</h6>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaEscuelaModal">
                <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table id="tablaEscuelas" class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Facultad</th>
                            <th>Nombre de la Escuela</th>
                            <th>Secciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($escuelas as $escuela)
                        <tr>
                            <td>{{ $escuela->id }}</td>
                            <td class="text-left">{{ $escuela->facultad->name ?? 'Sin Facultad' }}</td>
                            <td class="text-left">{{ $escuela->name }}</td>
                            <td class="text-left">
                                @forelse ($escuela->sa as $seccion)
                                    <span class="badge bg-primary me-1">{{ $seccion->seccion }}</span>
                                @empty
                                    <span class="badge bg-secondary">Sin secciones asignadas</span>
                                @endforelse
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarEscuelaModal-{{ $escuela->id }}">
                                   <i class="bi bi-plus-square-dotted"></i> 
                                </button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarSeccionModal-{{ $escuela->id }}">
                                    <i class="bi bi-eraser-fill"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal Nueva Escuela -->
<div class="modal fade" id="nuevaEscuelaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('seccion.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nueva Seccion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="facultad_id">Facultad</label>
                    <select name="facultad_id" class="form-control" required>
                        <option value="">-- Selecciona una Facultad --</option>
                        @foreach($facultades as $facultad)
                            <option value="{{ $facultad->id }}">{{ $facultad->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="name">Nombre de la Escuela</label>
                    <input type="text" name="name" class="form-control" required disabled>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modales Editar y Eliminar -->
@foreach($escuelas as $escuela)
<!-- Modal Editar -->
<div class="modal fade" id="editarEscuelaModal-{{ $escuela->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('seccion.store') }}" method="POST" class="modal-content">
            @csrf
            <!-- Enviar facultad_id por hidden input -->
            <input type="hidden" name="facultad_id" value="{{ $escuela->facultad->id }}">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nueva Sección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="name">Nombre de la Escuela</label>
                    <input type="text" name="name" class="form-control" value="{{ $escuela->name }}" required readonly>
                    <!-- Campo oculto para enviar el ID de la escuela -->
                    <input type="hidden" name="escuela_id" value="{{ $escuela->id }}">
                </div>
                <div class="form-group mb-3">
                    <label for="seccion">Sección</label>
                    <select name="seccion" class="form-control" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Sección</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="eliminarSeccionModal-{{ $escuela->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Secciones de: <strong>{{ $escuela->name }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($escuela->sa->isEmpty())
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Esta escuela no tiene secciones para eliminar.
                    </div>
                @else
                    <p>Selecciona la sección que deseas eliminar. Esta acción no se puede deshacer.</p>
                    <ul class="list-group">
                        @foreach ($escuela->sa as $seccion)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Sección "{{ $seccion->seccion }}"</span>
                                <form action="{{ route('seccion.destroy', $seccion->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la sección \'{{ $seccion->name }}\'?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

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
    $('#tablaEscuelas').DataTable({
        language: {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        }
    });
});
</script>
@endpush
