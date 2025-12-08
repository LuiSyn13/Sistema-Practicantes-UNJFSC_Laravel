@extends('template')

@section('title', 'Cambiar Contraseña')
@section('subtitle', 'Actualiza tu contraseña de acceso')

@push('css')
<style>
    .password-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
    }

    .password-card-header {
        padding: 1.5rem;
        background-color: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .password-card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #1e3a8a;
    }

    .password-card-body {
        padding: 2rem;
    }

    .form-group label {
        font-weight: 500;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgb(59 130 246 / 25%);
    }

    .btn-primary {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }

    .btn-primary:hover {
        background-color: #1c3478;
        border-color: #1c3478;
    }

    .alert ul {
        margin-bottom: 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Ups! Hubo algunos problemas:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="password-card">
                <div class="password-card-header">
                    <h5><i class="bi bi-shield-lock-fill me-2"></i>Seguridad de la Cuenta</h5>
                </div>
                <div class="password-card-body">
                    <form action="{{ route('persona.update.password') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="current_password">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="new_password">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <small class="form-text text-muted">Debe tener al menos 8 caracteres.</small>
                        </div>
                        <div class="form-group mb-4">
                            <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save-fill me-2"></i>
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection