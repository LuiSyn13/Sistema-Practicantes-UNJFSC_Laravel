@props([
    'modalId',
    'title'
])

<div class="modal fade" id="docRevisionModal-anexo7-1" tabindex="-1" aria-labelledby="docRevisionModal-anexo7-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="docRevisionModal-anexo7-1">
                    <i class="bi bi-file-earmark-text"></i>
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">

                <form action="revisar.anexo7" method="POST">
                    @csrf
                    <!-- input de ap_id -->
                    <input type="hidden" name="ap_id" value="#">
                    <div class="row mb-3">
                        <div class="col-md-8 d-flex flex-column">
                            <label class="font-weight-bold"><i class="bi bi-paperclip"></i> Archivo enviado:</label>
                            <div class="alert alert-light p-2 d-flex justify-content-between align-items-center border flex-grow-1">
                                <span class="text-truncate"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Anexo_7_Estudiante.pdf</span>
                                <a href="#" class="btn btn-sm btn-outline-primary flex-shrink-0 ms-2" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Ver</a>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column">
                            <label class="font-weight-bold"><i class="bi bi-clipboard-data"></i> Nota:</label>
                            <div class="alert alert-light p-2 d-flex justify-content-center align-items-center border flex-grow-1">
                                <span class="fw-bold fs-5 text-primary">13</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="estado-anexo7-1" class="font-weight-bold mt-2">
                            <i class="bi bi-gear"></i> Estado del Documento
                        </label>
                        <select name="estado" id="estado-anexo7-1" class="form-control" onchange="toggleCorreccion(this)">
                            <option value="Enviado" selected>Enviado (Pendiente de Revisión)</option>
                            <option value="Aprobado">Aprobar</option>
                            <option value="Corregir">Marcar para Corregir</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="correccion-options-anexo7-1" style="display: none;">
                        <label class="font-weight-bold"><i class="bi bi-exclamation-triangle"></i> Indicar qué se debe corregir:</label>
                        <div class="row g-2">
                            <div class="col">
                                <div class="correccion-cell h-100" id="cellArchivo-anexo7-1" onclick="selectCorreccion('archivo', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar otro archivo y aprueba la nota.">
                                    <i class="bi bi-file-earmark-pdf" style="font-size: 1.5em;"></i><br>Archivo
                                    <input type="radio" name="correccionTipo" id="correccionArchivo-anexo7-1" value="archivo" class="d-none" checked>
                                </div>
                            </div>
                            <div class="col">
                                <div class="correccion-cell h-100" id="cellNota-anexo7-1" onclick="selectCorreccion('nota', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar otra nota y aprueba el archivo.">
                                    <i class="bi bi-123" style="font-size: 1.5em;"></i><br>Nota
                                    <input type="radio" name="correccionTipo" id="correccionNota-anexo7-1" value="nota" class="d-none">
                                </div>
                            </div>
                            <div class="col">
                                <div class="correccion-cell h-100" id="cellAmbos-anexo7-1" onclick="selectCorreccion('ambos', 'anexo7-1')" style="cursor: pointer; padding: 10px; border: 1px solid #ddd; border-radius: 5px; text-align: center;" data-toggle="tooltip" data-placement="top" title="Tendrá que enviar nuevamente tanto el archivo como la nota.">
                                    <i class="bi bi-file-earmark-pdf" style="font-size: 1.5em;"></i> + <i class="bi bi-123" style="font-size: 1.5em;"></i><br>Ambos
                                    <input type="radio" name="correccionTipo" id="correccionAmbos-anexo7-1" value="ambos" class="d-none">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="comentario-anexo7-1" class="font-weight-bold">
                            <i class="bi bi-chat-dots"></i> Comentario
                        </label>
                        <textarea name="comentario" id="comentario-anexo7-1" class="form-control" rows="3" placeholder="Ej: La firma no es visible, por favor, vuelva a escanear el documento."></textarea>
                    </div>
                    <div class="mt-4 d-flex justify-content-between gap-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="saveEvaluation">Guardar Cambios</button>
                    </div>
                </form>
                <hr class="my-4">
                <div>
                    <h6><i class="bi bi-clock-history"></i> Documentos enviados (Historial)</h6>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">Versión:</span> 1
                            <span class="badge bg-danger ms-3">Temporal</span>
                                <small class="text-danger d-block fst-italic">Corrección: Falta</small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-danger" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Ver
                        </a>
                    </li>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const modalIdSuffix = 'anexo7-1'; // ID único para este modal

            function toggleCorreccion(selectElement) {
                const correccionOptions = document.getElementById(`correccion-options-${modalIdSuffix}`);
                correccionOptions.style.display = (selectElement.value === 'Corregir') ? 'block' : 'none';
            }

            function selectCorreccion(tipo) {
                const cells = ['Archivo', 'Nota', 'Ambos'];
                cells.forEach(cellType => {
                    const cell = document.getElementById(`cell${cellType}-${modalIdSuffix}`);
                    cell.style.backgroundColor = '#fff'; // Reset all
                });

                const selectedCell = document.getElementById(`cell${tipo.charAt(0).toUpperCase() + tipo.slice(1)}-${modalIdSuffix}`);
                const radio = document.getElementById(`correccion${tipo.charAt(0).toUpperCase() + tipo.slice(1)}-${modalIdSuffix}`);
                
                selectedCell.style.backgroundColor = '#e0e0e0'; // Highlight selected
                radio.checked = true;
            }

            // Asignar funciones al ámbito global para que los `onclick` y `onchange` del HTML puedan encontrarlas
            window.toggleCorreccion = toggleCorreccion;
            window.selectCorreccion = (tipo) => selectCorreccion(tipo); // Adaptador para no pasar el segundo argumento desde el HTML

            // Inicialización cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', function() {
                selectCorreccion('archivo'); // Seleccionar 'archivo' por defecto
                $('[data-toggle="tooltip"]').tooltip(); // Inicializar tooltips de Bootstrap
            });
        })();
    </script>
</div>