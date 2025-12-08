
document.addEventListener("DOMContentLoaded", function () {
    // --- State Management ---
    const state = {
        currentPracticeId: null,
        currentStage: 1
    };

    // --- Elements ---
    const modalProceso = document.getElementById('modalProceso');
    const supervisionTabs = document.getElementById('supervisionTabs');
    const supervisionTabContent = document.getElementById('supervisionTabContent');
    const reviewFormContainer = document.getElementById('review-form-container');
    const btnBackToList = document.getElementById('btn-back-to-list');

    // --- Event Listeners ---

    // 1. Modal Open - Load Data
    modalProceso.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const idPractica = button.getAttribute('data-id_practica');
        state.currentPracticeId = idPractica;

        // Reset View
        resetView();

        // Reset Tabs to first one
        const firstTab = document.querySelector('#supervisionTabs button[data-bs-target="#content-stage-1"]');
        if (firstTab) {
            const tab = new bootstrap.Tab(firstTab);
            tab.show();
        }

        try {
            const response = await fetch(`/practica/${idPractica}`);
            const data = await response.json();

            // Populate Modal Data (Company, Boss, etc.)
            populateModalData(data);

            // Handle Stage Visibility/State
            const estado = parseInt(data.state) || 1;
            updateStageAccess(estado);

        } catch (error) {
            console.error('Error al obtener datos:', error);
        }
    });

    // 2. Tab Change - Reset View (Hide Review Form if open)
    if (supervisionTabs) {
        const tabEl = document.querySelectorAll('button[data-bs-toggle="pill"]');
        tabEl.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                // Hide review form when switching tabs
                reviewFormContainer.style.display = 'none';
                supervisionTabContent.style.display = 'block';

                // Also reset internal E1/E2 navigation if needed
                resetInternalNav();
            });
        });
    }

    // 3. Document Review Click (Delegated)
    document.addEventListener('click', async function (e) {
        if (e.target.closest('.btn-review-doc')) {
            e.preventDefault();
            const btn = e.target.closest('.btn-review-doc');
            const docType = btn.getAttribute('data-doctype');

            if (state.currentPracticeId && docType) {
                await openReviewForm(state.currentPracticeId, docType);
            }
        }
    });

    // 4. Back Button in Review Form
    if (btnBackToList) {
        btnBackToList.addEventListener('click', function () {
            reviewFormContainer.style.display = 'none';
            supervisionTabContent.style.display = 'block';

            // Add fade-in animation
            supervisionTabContent.classList.add('fade-in');
            setTimeout(() => supervisionTabContent.classList.remove('fade-in'), 500);
        });
    }

    // 5. Internal Navigation (Legacy E1/E2 buttons)
    // Handle "Visualizar Empresa" (btnEtapa2 in E1)
    const btnEtapa2 = document.getElementById('btnEtapa2');
    if (btnEtapa2) {
        btnEtapa2.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('etapa1-content').style.display = 'none';
            document.getElementById('etapa1-empresa').style.display = 'block';
        });
    }

    // Handle "Visualizar Jefe" (btnEtapa3 in E1)
    const btnEtapa3 = document.getElementById('btnEtapa3');
    if (btnEtapa3) {
        btnEtapa3.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('etapa1-content').style.display = 'none';
            document.getElementById('etapa1-jefe').style.display = 'block';
        });
    }

    // Handle "Regresar" buttons in internal nav
    document.querySelectorAll('.btn-regresar-etapa1').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('etapa1-content').style.display = 'block';
            document.getElementById('etapa1-empresa').style.display = 'none';
            document.getElementById('etapa1-jefe').style.display = 'none';
        });
    });

    // --- Functions ---

    function resetView() {
        reviewFormContainer.style.display = 'none';
        supervisionTabContent.style.display = 'block';
        resetInternalNav();
    }

    function resetInternalNav() {
        // Reset E1 internal nav
        const e1Content = document.getElementById('etapa1-content');
        if (e1Content) {
            e1Content.style.display = 'block';
            document.getElementById('etapa1-empresa').style.display = 'none';
            document.getElementById('etapa1-jefe').style.display = 'none';
        }
    }

    async function openReviewForm(practiceId, docType) {
        try {
            // Show loading state?

            const response = await fetch(`/api/documento/${practiceId}/${docType}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            if (data && data.length > 0) {
                const docData = data[0]; // Assuming the API returns an array

                // Populate Form
                document.getElementById('review_file_id').value = docData.id;
                document.getElementById('review_file_name').textContent = docData.nombre_archivo || `${docType}.pdf`; // Fallback name
                document.getElementById('review_file_date').textContent = `Fecha: ${docData.created_at || new Date().toLocaleDateString()}`;

                // Status Badge
                const badge = document.getElementById('review_file_status_badge');
                badge.textContent = docData.estado_archivo || 'Pendiente';
                badge.className = 'badge ' + (docData.estado_archivo === 'Aprobado' ? 'bg-success' : 'bg-secondary');

                // Link
                const link = document.getElementById('review_file_link');
                link.href = docData.ruta;

                // Title
                document.getElementById('review-form-title').textContent = `Revisión de ${formatDocType(docType)}`;

                // Switch View
                supervisionTabContent.style.display = 'none';
                reviewFormContainer.style.display = 'block';
                reviewFormContainer.classList.add('fade-in');
            } else {
                // Handle no document found (maybe show a toast)
                console.warn('No document found for this type');
                // You might want to show an alert here
            }

        } catch (error) {
            console.error('Error fetching document data:', error);
        }
    }

    function formatDocType(type) {
        // Helper to format "carta_presentacion" -> "Carta Presentación"
        return type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }

    function populateModalData(data) {
        // IDs para formularios globales de etapa
        ['idE1', 'idE2', 'idE3', 'idE4', 'idE5'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = data.id;
        });

        // Empresa
        document.getElementById('modal-nombre-empresa').textContent = data.empresa?.nombre || '';
        document.getElementById('modal-ruc-empresa').textContent = data.empresa?.ruc || '';
        document.getElementById('modal-razon_social-empresa').textContent = data.empresa?.razon_social || '';
        document.getElementById('modal-direccion-empresa').textContent = data.empresa?.direccion || '';
        document.getElementById('modal-telefono-empresa').textContent = data.empresa?.telefono || '';
        document.getElementById('modal-email-empresa').textContent = data.empresa?.correo || '';
        document.getElementById('modal-sitio_web-empresa').textContent = data.empresa?.web || '';

        // Jefe inmediato
        document.getElementById('modal-name-jefe').textContent = data.jefe_inmediato?.nombres || '';
        document.getElementById('modal-area-jefe').textContent = data.jefe_inmediato?.area || '';
        document.getElementById('modal-cargo-jefe').textContent = data.jefe_inmediato?.cargo || '';
        document.getElementById('modal-dni-jefe').textContent = data.jefe_inmediato?.dni || '';
        document.getElementById('modal-sitio_web-jefe').textContent = data.jefe_inmediato?.web || '';
        document.getElementById('modal-telefono-jefe').textContent = data.jefe_inmediato?.telefono || '';
        document.getElementById('modal-email-jefe').textContent = data.jefe_inmediato?.correo || '';

        // Conditional Sections (Desarrollo vs Convalidación)
        const esDesarrollo = data.tipo_practica === 'desarrollo';
        toggleSection('seccion-desarrollo-E2', esDesarrollo);
        toggleSection('seccion-convalidacion-E2', !esDesarrollo);
        toggleSection('seccion-desarrollo-E3', esDesarrollo);
        toggleSection('seccion-convalidacion-E3', !esDesarrollo);

        // Calificación Final (Etapa 5)
        const inputCalif = document.getElementById('calificacion-input');
        const msgCalif = document.getElementById('msg-calificado');
        const displayNota = document.getElementById('display-nota-final');
        const btnSubmit = document.getElementById('btn-submit-calificacion');

        if (inputCalif) {
            if (data.calificacion !== null && data.calificacion !== undefined) {
                inputCalif.value = data.calificacion;
                // Opcional: Bloquear si ya está calificado para evitar cambios accidentales
                // inputCalif.setAttribute('readonly', true);
                // btnSubmit.disabled = true;

                if (displayNota) displayNota.textContent = parseFloat(data.calificacion).toFixed(2);
                if (msgCalif) msgCalif.classList.remove('d-none');
            } else {
                inputCalif.value = '';
                inputCalif.removeAttribute('readonly');
                if (btnSubmit) btnSubmit.disabled = false;
                if (msgCalif) msgCalif.classList.add('d-none');
            }
        }
    }

    function toggleSection(id, show) {
        const el = document.getElementById(id);
        if (el) el.style.display = show ? 'block' : 'none';
    }

    let globalMaxStage = 1;

    function updateStepper(selectedStage) {
        const items = document.querySelectorAll('.stepper-item');

        items.forEach(item => {
            const stage = parseInt(item.getAttribute('data-stage'));
            const circle = item.querySelector('.stepper-circle');

            // Reset classes
            item.classList.remove('completed', 'current', 'locked');

            if (stage < selectedStage) {
                // Past relative to selection
                item.classList.add('completed');
                circle.innerHTML = '<i class="bi bi-check-lg"></i>';
            } else if (stage === selectedStage) {
                // Selected
                item.classList.add('current');
                circle.innerHTML = stage;
            } else {
                // Future relative to selection
                if (stage <= globalMaxStage) {
                    // Unlocked but future (show as completed style but with number, or just unlocked)
                    // The user wants it to look like est_des.blade.php which uses 'completed' class but keeps the number
                    item.classList.add('completed');
                    circle.innerHTML = stage;
                } else {
                    // Locked
                    item.classList.add('locked');
                    circle.innerHTML = '<i class="bi bi-lock-fill"></i>';
                }
            }

            // Click handlers
            if (stage <= globalMaxStage) {
                item.style.cursor = 'pointer';
                item.onclick = () => switchTab(stage);
            } else {
                item.style.cursor = 'not-allowed';
                item.onclick = null;
            }
        });
    }

    function switchTab(stage) {
        // Manually switch tabs since the nav-pills are hidden/removed
        const panes = document.querySelectorAll('.tab-pane');
        panes.forEach(pane => {
            pane.classList.remove('show', 'active');
        });

        const targetPane = document.getElementById(`content-stage-${stage}`);
        if (targetPane) {
            targetPane.classList.add('show', 'active');
        }

        // Also hide review form if open
        const reviewFormContainer = document.getElementById('review-form-container');
        const supervisionTabContent = document.getElementById('supervisionTabContent');
        if (reviewFormContainer && supervisionTabContent) {
            reviewFormContainer.style.display = 'none';
            supervisionTabContent.style.display = 'block';
        }

        // Update visual stepper to reflect this selection
        updateStepper(stage);
    }

    function updateStageAccess(estado) {
        // Set global max stage based on data
        globalMaxStage = Math.min(Math.max(parseInt(estado) || 1, 1), 5);

        // Show the current stage (max stage) by default when opening
        switchTab(globalMaxStage);
    }
});
