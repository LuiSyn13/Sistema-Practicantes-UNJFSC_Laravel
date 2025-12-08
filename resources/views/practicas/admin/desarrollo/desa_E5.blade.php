<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success text-uppercase text-center">Quinta Etapa - Evaluación Final y Logro</h6>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <i class="fas fa-award text-success" style="font-size: 5rem;"></i>
                        </div>
                        <h4 class="text-dark font-weight-bold">Evaluación de Prácticas Pre Profesionales</h4>
                        <p class="text-muted">
                            El estudiante ha completado todas las etapas documentarias. Ingrese la calificación final para cerrar el proceso.
                        </p>
                    </div>

                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <form action="{{ route('practica.calificar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="practica_id" value="{{ $practicaData->id }}">
                                
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Calificación Final (0 - 20)
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="number" step="0.01" min="0" max="20" 
                                                class="form-control form-control-lg border-success text-center font-weight-bold text-success" 
                                                style="font-size: 2rem;"
                                                name="calificacion" 
                                                value="{{ $practicaData->calificacion ?? '' }}" 
                                                placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm">
                                        <i class="fas fa-save mr-2"></i> Guardar Calificación y Finalizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($practicaData->calificacion)
                    <div class="alert alert-success mt-4 text-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Esta práctica ya ha sido calificada con una nota de <strong>{{ $practicaData->calificacion }}</strong>.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
