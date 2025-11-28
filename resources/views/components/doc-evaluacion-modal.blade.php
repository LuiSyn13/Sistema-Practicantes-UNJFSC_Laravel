@props([
    'modalId',
    'number',
    'item'
])
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluationModalLabel">Calificar Estudiante: {{ $item->id_estudiante }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subir.anexo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ap_id" value="{{ $item->id_estudiante }}">
                    <input type="hidden" name="number" value="{{ $number }}">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-file-pdf"></i>
                            Anexo {{ $number }} (PDF)
                        </label>
                        <input type="file" name="anexo" class="form-control" accept="application/pdf"
                            onchange="validateFileSize(this, 10)">
                        <small class="text-muted">Archivo PDF, máximo 10MB</small>
                    </div>
                    <div class="mb-3">
                        <label for="finalScore" class="form-label">Nota Final (0-20)</label>
                        <input type="number" name="nota" class="form-control" id="finalScore" min="0" max="20">
                    </div>                
                    <div class="mb-3 d-flex justify-content-between gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="saveEvaluation">Guardar y Aprobar</button>
                    </div>
                </form>
                <div class="history-container mb-3">
                    <h6 class="mt-4">Documentos enviados (Historial)</h6>
                    <ul class="list-group history-list">
                        <!-- El historial se llenará aquí dinámicamente -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>