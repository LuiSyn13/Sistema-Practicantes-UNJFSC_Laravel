{{-- Componente de Filtros de Búsqueda --}}
@props([
    'route',
    'facultades'
])

<div class="filters-section">
    <h6 class="filters-title">
        <i class="bi bi-funnel"></i>
        Filtros de Búsqueda
    </h6>
    <form method="GET" action="{{ route($route) }}">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="facultad" class="form-label">Facultad:</label>
                <select id="facultad" name="facultad" class="form-select">
                    <option value="">-- Todas --</option>
                    @foreach($facultades as $fac)
                        <option value="{{ $fac->id }}">{{ $fac->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="escuela" class="form-label">Escuela:</label>
                <select id="escuela" name="escuela" class="form-select">
                    <option value="">-- Todas --</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="seccion" class="form-label">Seccion:</label>
                <select id="seccion" name="seccion" class="form-select">
                    <option value="">-- Todos --</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end justify-content-end">
                <button type="submit" class="btn-filter">
                    <i class="bi bi-filter"></i> 
                    Filtrar Datos
                </button>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const facultadSelect = document.getElementById('facultad');
    const escuelaSelect = document.getElementById('escuela');
    const seccionSelect = document.getElementById('seccion');
    const semestreActivoId = {{ session('semestre_actual_id') ?? 'null' }};

    facultadSelect.addEventListener('change', function () {
        const facultadId = this.value;
        
        // Reset dependants
        escuelaSelect.innerHTML = '<option value="">-- Todas --</option>';
        seccionSelect.innerHTML = '<option value="">-- Todos --</option>';

        if (!facultadId) {
            return;
        }

        escuelaSelect.innerHTML = '<option value="">Cargando...</option>';
        fetch(`/api/escuelas/${facultadId}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Todas --</option>';
                data.forEach(e => {
                    options += `<option value="${e.id}">${e.name}</option>`;
                });
                escuelaSelect.innerHTML = options;
            })
            .catch(() => {
                escuelaSelect.innerHTML = '<option value="">Error al cargar</option>';
            });
    });

    escuelaSelect.addEventListener('change', function () {
        const escuelaId = this.value;
        seccionSelect.innerHTML = '<option value="">-- Todos --</option>';

        if (!escuelaId || !semestreActivoId) {
            return;
        }

        seccionSelect.innerHTML = '<option value="">Cargando...</option>';
        fetch(`/api/secciones/${escuelaId}/${semestreActivoId}`) // <-- Usar semestre activo
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Todos --</option>';
                data.forEach(d => {
                    options += `<option value="${d.id}">${d.name}</option>`;
                });
                seccionSelect.innerHTML = options;
            })
            .catch(() => {
                seccionSelect.innerHTML = '<option value="">Error al cargar</option>';
            });
    });
});
</script>