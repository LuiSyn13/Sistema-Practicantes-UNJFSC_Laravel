@extends('template')
@section('title', 'Desarrollo')

@push('css')
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary text-uppercase">Detalles de la Práctica</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="docente">Docente Titular: </label>
                    <label for="docente">{{ $docente->apellidos }} {{ $docente->nombres }}</label>
                </div>
                <div class="col-md-6">
                    <label for="docente">Supervisor Asignado: </label>
                    <label for="docente">{{ $supervisor->apellidos }} {{ $supervisor->nombres }}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="estado">Estado: </label>
                    <label for="estado">Activo</label>
                </div>
                <div class="col-md-6">
                    <label for="estado">Periodo: </label>
                    <span id="lblArea">{{ $semestre->codigo }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $etapa = $practicaData->state;
@endphp

@if ($etapa == 1)
    @include('practicas.admin.desarrollo.desa_E1')
@elseif ($etapa == 2)
    @include('practicas.admin.desarrollo.desa_E2')
@elseif ($etapa == 3)
    @include('practicas.admin.desarrollo.desa_E3')
@elseif ($etapa == 4)
    @include('practicas.admin.desarrollo.desa_E4')
@elseif ($etapa >= 5)
    @include('practicas.admin.desarrollo.desa_E5')
@else
    <div class="alert alert-success text-center mt-4" role="alert">
        <h4 class="alert-heading">Estado Desconocido</h4>
        <p>Contacte al soporte técnico.</p>
    </div>
@endif

@endsection

@push('js')

@endpush
