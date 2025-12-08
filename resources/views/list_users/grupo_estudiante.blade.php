@extends('template')
@section('title', 'Dashboard Supervisor')
@section('subtitle', 'Panel de supervisión y seguimiento de estudiantes')

@section('content')
    <div class="container">
        <h2 class="mb-4">Lista de Grupos de Estudiantes</h2>
        <h5 class="mb-4">{{ $grupo?->name }}</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombres del Estudiante</th>
                    <th>Apellidos del Estudiante</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grupo_estudiante as $grupo)
                    <tr>
                        <td>{{ $grupo->nombres }}</td>
                        <td>{{ $grupo->apellidos }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection