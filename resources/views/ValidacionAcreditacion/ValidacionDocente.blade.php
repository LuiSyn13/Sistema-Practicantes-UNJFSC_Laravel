@extends('template')
@section('title', 'Acreditación del Docente')
@section('subtitle', 'Gestionar y validar documentos académicos del docente titular')

@section('content')
    <div class="app-container">
        <div class="app-card fade-in">
            <div class="app-card-header">
                <h5 class="app-card-title">
                    <i class="bi bi-clipboard-check"></i>
                    Lista de {{ $msj }} para Acreditar
                </h5>
            </div>
            <div class="app-card-body">
                <x-data-filter
                route="docente"
                :facultades="$facultades"
                />
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Docente</th>
                                    <th>Semestre</th>
                                    <th>Escuela</th>
                                    <th>C. Lectiva</th>
                                    <th>Horario</th>
                                    @if($option == 2)
                                    <th>Resolucion</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($acreditar as $index => $item)
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
 
                                        $latestCL = $getLatest('carga_lectiva');
                                        $historialCL = $archivosPorTipo->get('carga_lectiva');
                                        $estadoCL = $latestCL ? $latestCL->estado_archivo : 'Falta';
                                        $bg_cl = $getBgColor($estadoCL);
 
                                        $latestHorario = $getLatest('horario');
                                        $historialHorario = $archivosPorTipo->get('horario');
                                        $estadoHorario = $latestHorario ? $latestHorario->estado_archivo : 'Falta';
                                        $bg_horario = $getBgColor($estadoHorario);
 
                                        if ($item->asignacion_persona->id_rol == 4) {
                                            $latestResolucion = $getLatest('resolucion');
                                            $historialResolucion = $archivosPorTipo->get('resolucion');
                                            $estadoResolucion = $latestResolucion ? $latestResolucion->estado_archivo : 'Falta';
                                            $bg_resolucion = $getBgColor($estadoResolucion);
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $item->asignacion_persona->persona->nombres }}</td>
                                        <td>{{ $item->asignacion_persona->semestre->codigo }}</td>
                                        <td>{{ $item->asignacion_persona->seccion_academica->escuela->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-{{ $bg_cl }}" data-toggle="modal" data-target="#modalCLectiva{{ $item->id }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                                Carga Lectiva
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-{{ $bg_horario }}" data-toggle="modal" data-target="#modalHorario{{ $item->id }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                                Horario de Clases
                                            </button>
                                        </td>
                                        @if($item->asignacion_persona->id_rol == 4)
                                        <td>
                                            <button type="button" class="btn btn-{{ $bg_resolucion }}" data-toggle="modal" data-target="#modalResolucion{{ $item->id }}">
                                                <i class="bi bi-file-earmark-text"></i>
                                                Resolución
                                            </button>
                                        </td>
                                        @endif
                                    </tr>
                                    
                                    <!-- Modal Carga Lectiva -->
                                    <x-document-modal
                                        :item="$item"
                                        modalId="modalCLectiva"
                                        title="Carga Lectiva"
                                        icon="file-earmark-text"
                                        :bgClass="$bg_cl"
                                        estadoKey="estado_archivo"
                                        rutaKey="ruta"
                                        updateRoute="actualizar.estado.archivo"
                                        :latestArchivo="$latestCL"
                                        :historialArchivos="$historialCL"
                                        isArchivoModel="true"
                                    />

                                    <!-- Modal Horario -->
                                    <x-document-modal
                                        :item="$item"
                                        modalId="modalHorario"
                                        title="Horario de Clases"
                                        icon="clock"
                                        :bgClass="$bg_horario"
                                        estadoKey="estado_archivo"
                                        rutaKey="ruta"
                                        updateRoute="actualizar.estado.archivo"
                                        :latestArchivo="$latestHorario"
                                        :historialArchivos="$historialHorario"
                                        isArchivoModel="true"
                                    />

                                    @if($item->asignacion_persona->id_rol == 4)
                                    <!-- Modal Resolucion -->
                                    <x-document-modal
                                        :item="$item"
                                        modalId="modalResolucion"
                                        title="Resolución de Designación"
                                        icon="file-text"
                                        bgClass="primary" {{-- Usamos un color fijo para Resolución --}}
                                        estadoKey="estado_archivo"
                                        rutaKey="ruta"
                                        updateRoute="actualizar.estado.archivo"
                                        :latestArchivo="$latestResolucion"
                                        :historialArchivos="$historialResolucion"
                                        isArchivoModel="true"
                                    />
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection