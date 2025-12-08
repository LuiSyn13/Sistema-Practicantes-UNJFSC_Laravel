@php
    $practicaData = $practicas;
@endphp
<!-- Cuarta Etapa -->
<div class="section-card">
    <h3 class="section-title text-center mb-4">
        <i class="bi bi-4-circle me-2"></i>
        Cuarta Etapa - Presentación de Informes
    </h3>

    <div class="row">
        <!-- Constancia de Cumplimiento -->
        <div class="col-md-6 mb-4">
            <div class="practice-stage-card text-center h-100">
                <div class="stage-icon" style="background: linear-gradient(135deg, #84cc16, #65a30d); color: white;">
                    <i class="bi bi-award"></i>
                </div>
                <h5 class="text-primary font-weight-bold text-uppercase mb-3">Constancia de Cumplimiento</h5>
                <div id="constanciaCumplimientoStatus">
                    <span id="status-file-plan" class="status-badge status-completed">Completo</span>
                    <button class="btn btn-primary-custom btn-sm btn-view-archivo"
                        data-type="constancia_cumplimiento"
                        data-bs-target="#archivoModal">Visualizar</button>
                </div>
            </div>
        </div>

        <!-- Informe Final de PPP -->
        <div class="col-md-6 mb-4">
            <div class="practice-stage-card text-center h-100">
                <div class="stage-icon" style="background: linear-gradient(135deg, #a855f7, #9333ea); color: white;">
                    <i class="bi bi-file-earmark-ruled"></i>
                </div>
                <h5 class="text-primary font-weight-bold text-uppercase mb-3">Informe Final de PPP</h5>
                <div id="informeFinalStatus">
                    <span id="status-file-plan" class="status-badge status-completed">Completo</span>
                    <button class="btn btn-primary-custom btn-sm btn-view-archivo"
                        data-type="informe_final_ppp"
                        data-bs-target="#archivoModal">Visualizar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Estado de Rechazo -->
    @if ($practicaData->estado_proceso === 'rechazado')
        <div class="alert alert-danger mt-4" id="rejectionAlert">
            <div class="text-center">
                <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #dc2626;"></i>
                <h4 class="mt-3 mb-3">¡Atención!</h4>
                <p class="mb-0">
                    Debes corregir los archivos ingresados en la sección de Constancia de Cumplimiento y/o Informe Final de PPP antes de continuar con el proceso.
                </p>
            </div>
        </div>
    @endif
</div>

<!-- Modal Constancia de Cumplimiento -->
<div class="modal fade" id="modalConstanciaCumplimiento" tabindex="-1" aria-labelledby="modalConstanciaCumplimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-blue), #1d4ed8); color: white;">
                <h5 class="modal-title" id="modalConstanciaCumplimientoLabel">
                    <i class="bi bi-award me-2"></i>
                    Constancia de Cumplimiento
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.constanciacumplimiento') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $practicaData->id }}">
                <div class="modal-body">
                    <div class="upload-area-modal border-2 border-dashed p-4 text-center" style="border-color: var(--border-gray); border-radius: 12px;">
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                        <h6 class="mb-3">Selecciona tu constancia de cumplimiento</h6>
                        <p class="text-muted mb-3">Solo se permiten archivos PDF (máximo 10MB)</p>
                        <input type="file" name="constancia_cumplimiento" accept="application/pdf" required class="form-control" style="border-radius: 8px;">
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Importante:</strong> La constancia debe estar firmada y sellada por la empresa certificando el cumplimiento satisfactorio de tus prácticas.
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

<!-- Modal Informe Final de PPP -->
<div class="modal fade" id="modalInformeFinalPPP" tabindex="-1" aria-labelledby="modalInformeFinalPPPLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-blue), #1d4ed8); color: white;">
                <h5 class="modal-title" id="modalInformeFinalPPPLabel">
                    <i class="bi bi-file-earmark-ruled me-2"></i>
                    Informe Final de PPP
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('store.informefinalppp') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="persona_id" value="{{ $practicaData->id }}">
                <div class="modal-body">
                    <div class="upload-area-modal border-2 border-dashed p-4 text-center" style="border-color: var(--border-gray); border-radius: 12px;">
                        <i class="bi bi-cloud-upload" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
                        <h6 class="mb-3">Selecciona tu informe final</h6>
                        <p class="text-muted mb-3">Solo se permiten archivos PDF (máximo 10MB)</p>
                        <input type="file" name="informe_final_ppp" accept="application/pdf" required class="form-control" style="border-radius: 8px;">
                    </div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Importante:</strong> El informe debe incluir un resumen completo de todas las actividades realizadas, logros obtenidos y aprendizajes adquiridos durante las prácticas.
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
