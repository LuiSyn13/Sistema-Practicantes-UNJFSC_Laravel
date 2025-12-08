@php
    $practicaData = $practicas;
@endphp
<!-- Segunda Etapa -->
<div class="section-card">
    <h3 id="subtitle" class="section-title text-center mb-4">
        <i class="bi bi-2-circle me-2"></i>
        Segunda Etapa - Documentación
    </h3>

    <div class="row">
        <!-- Formulario de Trámite (FUT) -->
        <div class="col-md-6 mb-4">
            <div class="practice-stage-card text-center h-100">
                <div class="stage-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h5 class="text-primary font-weight-bold text-uppercase mb-3">Formulario de Trámite (FUT)</h5>
                <div id="futStatus">
                    <span id="status-file-fut" class="status-badge status-completed">Completo</span>
                    <button class="btn btn-primary-custom btn-sm btn-view-archivo"
                        data-type="fut"
                        data-bs-target="#archivoModal">Visualizar</button>
                </div>
            </div>
        </div>

        <!-- Carta de Presentación -->
        <div class="col-md-6 mb-4">
            <div class="practice-stage-card text-center h-100">
                <div class="stage-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                    <i class="bi bi-envelope"></i>
                </div>
                <h5 class="text-primary font-weight-bold text-uppercase mb-3">Carta de Presentación</h5>
                <div id="futStatus">
                    <span id="status-file-fut" class="status-badge status-completed">Completo</span>
                    <button class="btn btn-primary-custom btn-sm btn-view-archivo"
                        data-type="carta_presentacion"
                        data-bs-target="#archivoModal">Visualizar</button>
                </div>
            </div>
        </div>
        <!--<div class="col-md-6 mb-4">
            <div class="practice-stage-card text-center h-100">
                <div class="stage-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
                    <i class="bi bi-envelope"></i>
                </div>
                <h5 class="text-primary font-weight-bold text-uppercase mb-3">Carta de Presentación</h5>
                <div id="cartaStatus">
                    @if ($practicaData->ruta_carta_presentacion != null)
                        @if ($practicaData->estado_proceso === 'en proceso' || $practicaData->estado_proceso === 'rechazado')
                            <p class="text-muted mb-3">Visualiza o edita tu carta de presentación</p>
                            <div class="d-flex flex-column gap-2 align-items-center">
                                <a href="{{ asset($practicaData->ruta_carta_presentacion) }}" target="_blank" class="btn btn-warning btn-sm">
                                    <i class="bi bi-file-pdf me-1"></i> Ver PDF
                                </a>
                                <button class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#modalCartaPresentacion">
                                    <i class="bi bi-pencil-square me-1"></i> Editar Documento
                                </button>
                            </div>
                        @elseif ($practicaData->estado_proceso === 'completo')
                            <p class="text-muted mb-3">Visualiza tu carta de presentación aprobada</p>
                            <a href="{{ asset($practicaData->ruta_carta_presentacion) }}" target="_blank" class="btn btn-warning btn-sm">
                                <i class="bi bi-file-pdf me-1"></i> Ver PDF
                            </a>
                        @endif
                    @else
                        <p class="text-muted mb-3">Sube tu carta de presentación para la empresa</p>
                        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalCartaPresentacion">
                            <i class="bi bi-cloud-upload me-1"></i> Subir Documento
                        </button>
                    @endif
                </div>
            </div>
        </div>-->
    </div>
</div>


<!-- Modal Formulario de Trámite (FUT) -->
<div class="modal fade" id="modalFUT" tabindex="-1" aria-labelledby="modalFUTLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-blue), #1d4ed8); color: white;">
                <h5 class="modal-title" id="modalFUTLabel">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Formulario de Trámite (FUT) {{ $practicaData->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.fut') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $practicaData->id }}">
                <div class="modal-body">
                    <div class="upload-area-modal border-2 border-dashed p-4 text-center" style="border-color: var(--border-gray); border-radius: 12px;">
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                        <h6 class="mb-3">Selecciona tu archivo FUT</h6>
                        <p class="text-muted mb-3">Solo se permiten archivos PDF (máximo 10MB)</p>
                        <input type="file" name="fut" accept="application/pdf" required class="form-control" style="border-radius: 8px;">
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Importante:</strong> El formulario debe estar completamente lleno y firmado antes de subirlo.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-cloud-upload me-1"></i> Subir Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Carta de Presentación -->
<div class="modal fade" id="modalCartaPresentacion" tabindex="-1" aria-labelledby="modalCartaPresentacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-blue), #1d4ed8); color: white;">
                <h5 class="modal-title" id="modalCartaPresentacionLabel">
                    <i class="bi bi-envelope me-2"></i>
                    Carta de Presentación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.cartapresentacion') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $practicaData->id }}">
                <div class="modal-body">
                    <div class="upload-area-modal border-2 border-dashed p-4 text-center" style="border-color: var(--border-gray); border-radius: 12px;">
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                        <h6 class="mb-3">Selecciona tu carta de presentación</h6>
                        <p class="text-muted mb-3">Solo se permiten archivos PDF (máximo 10MB)</p>
                        <input type="file" name="carta_presentacion" accept="application/pdf" required class="form-control" style="border-radius: 8px;">
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Importante:</strong> La carta debe estar dirigida a la empresa y firmada por la coordinación académica.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-cloud-upload me-1"></i> Subir Documento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>