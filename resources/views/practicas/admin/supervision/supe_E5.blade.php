<div class="supervision-e2-container fade-in">
    <div class="supervision-e2-card">
            <div class="supervision-e2-header">
                <h6 class="supervision-e2-title">
                    <i class="bi bi-files"></i>
                    Evaluación Final de Prácticas
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-success"></i>
                            <i class="fas fa-star fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <h5 class="text-dark font-weight-bold">Conclusión del Proceso</h5>
                    <p class="text-muted">
                        Revise que el expediente esté completo. Si todo es conforme, proceda a ingresar la calificación final.
                        <br>Al guardar, el estado de la práctica cambiará automáticamente a <strong>"COMPLETO"</strong>.
                    </p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Formulario controlado por JS -->
                        <form action="{{ route('practica.calificar') }}" method="POST" id="form-calificacion-final">
                            @csrf
                            <!-- Este input será llenado por JS: populateModalData -->
                            <input type="hidden" name="practica_id" id="idE5">
                            
                            <div class="form-group">
                                <label for="calificacion-input" class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Nota Final (0 - 20)
                                </label>
                                <div class="input-group input-group-lg">
                                    <div class="input-group-text bg-success text-white border-success">
                                        <i class="bi bi-clipboard-check"></i>
                                    </div>
                                    <input type="number" step="0.01" min="0" max="20" 
                                           class="form-control border-success text-center font-weight-bold text-success" 
                                           id="calificacion-input"
                                           name="calificacion" 
                                           placeholder="0.00" required>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle"></i> La nota se enviará al estudiante inmediatamente.
                                </small>
                            </div>
                            
                            <!-- Div para mostrar si ya tiene nota (controlado por JS) -->
                            <div id="msg-calificado" class="alert alert-success mt-3 d-none text-center">
                                <i class="fas fa-check-circle mr-1"></i> Práctica calificada: <strong><span id="display-nota-final">--</span></strong>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-success btn-lg btn-block shadow-sm" id="btn-submit-calificacion">
                                <i class="fas fa-save mr-2"></i> Registrar Calificación Final
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
