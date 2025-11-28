            <!-- Modal Principal de Matrícula -->
            <div class="modal fade" id="modalMatricula" tabindex="-1" aria-labelledby="modalMatriculaLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-blue), #1d4ed8); color: white;">
                            <h5 class="modal-title" id="modalMatriculaLabel">
                                <i class="bi bi-journal-bookmark me-2"></i>
                                Gestión de Matrícula
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <!-- Ficha de Matrícula -->
                                <div class="col-md-6 mb-4">
                                    <div class="document-card p-4 border rounded-3 h-100" style="background: linear-gradient(145deg, #f8fafc, #f1f5f9);">
                                        <div class="text-center">
                                            <i class="bi bi-file-earmark-text text-primary mb-3" style="font-size: 3rem;"></i>
                                            <h5 class="text-primary font-weight-bold mb-3">Ficha de Matrícula</h5>
                                            @if(isset($latestFicha) /*&& $persona?->matricula->ruta_ficha*/)
                                                @if ($estadoFicha == 'Aprobado')
                                                    <div class="mt-3">
                                                        <p><strong>Estado:</strong>
                                                            <span class="status-badge status-completed">Completo</span>
                                                            <span class="text-success ms-2">✓</span>
                                                        </p>
                                                        <div class="d-grid gap-2">
                                                            <a href="{{ asset($latestFicha->ruta) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-eye me-1"></i>Ver PDF
                                                            </a>
                                                        </div>
                                                    </div>
                                                @elseif ($estadoFicha == 'Enviado')
                                                    <!-- Simulando la lógica de Laravel -->
                                                    <div class="mt-3">
                                                        <p><strong>Estado:</strong>
                                                            <span class="status-badge status-active">En Progreso</span>
                                                        </p>
                                                        <div class="d-grid gap-2">
                                                            <a href="{{ asset($latestFicha->ruta) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-eye me-1"></i>Ver PDF
                                                            </a>
                                                            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalFicha">
                                                                <i class="bi bi-pencil me-1"></i>Editar
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="mt-3">
                                                    <p><strong>Estado:</strong>
                                                        <span class="status-badge status-pending">Pendiente</span>
                                                    </p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFicha">
                                                            <i class="bi bi-upload me-1"></i>Cargar Ficha de Matrícula
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Récord Académico -->
                                <div class="col-md-6 mb-4">
                                    <div class="document-card p-4 border rounded-3 h-100" style="background: linear-gradient(145deg, #f8fafc, #f1f5f9);">
                                        <div class="text-center">
                                            <i class="bi bi-file-earmark-bar-graph text-primary mb-3" style="font-size: 3rem;"></i>
                                            <h5 class="text-primary font-weight-bold mb-3">Récord Académico</h5>
                                            @if(isset($latestRecord) /* && $persona?->matricula->ruta_record*/)
                                                @if ($estadoRecord == 'Aprobado')
                                                    <div class="mt-3">
                                                        <p><strong>Estado:</strong>
                                                            <span class="status-badge status-completed">Completo</span>
                                                            <span class="text-success ms-2">✓</span>
                                                        </p>
                                                        <div class="d-grid gap-2">
                                                            <a href="{{ asset($latestRecord->ruta) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-eye me-1"></i>Ver PDF
                                                            </a>
                                                        </div>
                                                    </div>
                                                    
                                                @elseif ($estadoRecord == 'Enviado')
                                                <!-- Simulando la lógica de Laravel -->
                                                <div class="mt-3">
                                                    <p><strong>Estado:</strong>
                                                        <span class="status-badge status-active">En Progreso</span>
                                                    </p>
                                                    <div class="d-grid gap-2">
                                                        <a href="{{ asset($latestRecord->ruta) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-eye me-1"></i>Ver PDF
                                                        </a>
                                                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalRecord">
                                                            <i class="bi bi-pencil me-1"></i>Editar
                                                        </button>
                                                    </div>
                                                </div>
                                                @endif
                                            @else
                                                <div class="mt-3">
                                                    <p><strong>Estado:</strong>
                                                        <span class="status-badge status-pending">Pendiente</span>
                                                    </p>
                                                    <div class="d-grid">
                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRecord">
                                                            <i class="bi bi-upload me-1"></i>Cargar Récord Académico
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Información Adicional -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Información:</strong> Asegúrate de que todos los documentos estén en formato PDF y no excedan los 5MB.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Ficha de Matrícula -->
            <div class="modal fade" id="modalFicha" tabindex="-1" aria-labelledby="modalFichaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('subir.ficha') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <input type="hidden" name="ap_id" value="{{ $ap->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalFichaLabel">
                                <i class="bi bi-upload me-2"></i>Subir Ficha de Matrícula
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="upload-area-modal text-center p-4 border-2 border-dashed rounded-3" style="border-color: var(--border-gray);">
                                <i class="bi bi-cloud-upload text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="mb-3">Selecciona tu archivo PDF</p>
                                <input type="file" name="ficha" accept="application/pdf" required class="form-control">
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Formato permitido: PDF. Tamaño máximo: 5MB
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-upload me-1"></i>Subir Archivo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Récord Académico -->
            <div class="modal fade" id="modalRecord" tabindex="-1" aria-labelledby="modalRecordLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('subir.record') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        <input type="hidden" name="ap_id" value="{{ $ap->id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalRecordLabel">
                                <i class="bi bi-upload me-2"></i>Subir Récord Académico
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="upload-area-modal text-center p-4 border-2 border-dashed rounded-3" style="border-color: var(--border-gray);">
                                <i class="bi bi-cloud-upload text-muted mb-3" style="font-size: 3rem;"></i>
                                <p class="mb-3">Selecciona tu archivo PDF</p>
                                <input type="file" name="record" accept="application/pdf" required class="form-control">
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Formato permitido: PDF. Tamaño máximo: 5MB
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-upload me-1"></i>Subir Archivo
                            </button>
                        </div>
                    </form>
                </div>
            </div>