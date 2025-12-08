<div class="section-card shadow-sm p-4 bg-white rounded">
    <h3 class="section-title text-center mb-4 text-primary fw-bold">
        <i class="bi bi-award-fill me-2"></i>
        Quinta Etapa - Resultado Final
    </h3>

    <div id="resultado-loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando resultados...</span>
        </div>
        <p class="mt-3 text-muted">Consultando estado de calificación...</p>
    </div>

    <div id="resultado-contenido" class="d-none">
        
        <!-- Caso: Aprobado con Nota -->
        <div id="case-graded" class="d-none text-center">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            </div>
            <h4 class="mb-3 text-dark fw-bold">¡Felicitaciones!</h4>
            <p class="lead mb-4">Has completado satisfactoriamente tus Prácticas Pre Profesionales.</p>
            
            <div class="card bg-success bg-opacity-10 border-success mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <h5 class="card-title text-success text-uppercase fs-6 mb-2">Calificación Final</h5>
                    <div class="display-1 fw-bold text-success" id="final-grade">00</div>
                </div>
            </div>

            <div class="alert alert-info mt-4 mx-auto" style="max-width: 600px;">
                <i class="bi bi-info-circle-fill me-2"></i>
                Tu proceso ha finalizado. Puedes descargar tu constancia final en la sección de documentos si está disponible.
            </div>
        </div>

        <!-- Caso: Pendiente de Calificación -->
        <div id="case-pending" class="d-none text-center">
            <div class="mb-4">
                <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
            </div>
            <h4 class="mb-3 text-dark fw-bold">Evaluación Pendiente</h4>
            <p class="lead text-secondary mx-auto" style="max-width: 600px;">
                Has completado la etapa de documentación final. El docente encargado está revisando tu expediente para asignar tu calificación final.
            </p>
            <div class="alert alert-warning d-inline-block mt-3">
                <i class="bi bi-clock-history me-2"></i> Por favor, espera a que el docente registre tu nota.
            </div>
        </div>

        <!-- Caso: Aún no llega a la etapa (Safety fallback) -->
        <div id="case-locked" class="d-none text-center py-5">
            <i class="bi bi-lock-fill text-secondary mb-3" style="font-size: 3rem;"></i>
            <h5 class="text-secondary">Etapa no disponible aún</h5>
            <p>Debes completar las etapas anteriores para ver tu resultado final.</p>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const practicaId = {{ $practicas->id ?? 0 }};
        const container = document.getElementById('resultado-contenido');
        const loading = document.getElementById('resultado-loading');
        
        if (practicaId === 0) {
            loading.classList.add('d-none');
            container.classList.remove('d-none');
            document.getElementById('case-locked').classList.remove('d-none');
            return;
        }

        const url = "{{ route('practica.status', ':id') }}".replace(':id', practicaId);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                loading.classList.add('d-none');
                container.classList.remove('d-none');

                // Lógica de visualización basada en estado y calificación
                // Asumimos que state >= 4 es necesario para estar "cerca" del final.
                // Si el sistema marca "completo" o state 5, suele ser el fin.
                
                if (data.calificacion !== null) {
                    // Ya tiene nota
                    document.getElementById('case-graded').classList.remove('d-none');
                    document.getElementById('final-grade').textContent = parseFloat(data.calificacion).toFixed(0); 
                    // toFixed(0) para enteros, o (2) para decimales según preferencia
                } else if (parseInt(data.state) >= 4) {
                    // Está en etapa final pero sin nota
                    document.getElementById('case-pending').classList.remove('d-none');
                } else {
                    // Aún no debería ver esto
                    document.getElementById('case-locked').classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loading.innerHTML = '<p class="text-danger">Error al cargar la información. Por favor actualiza la página.</p>';
            });
    });
</script>