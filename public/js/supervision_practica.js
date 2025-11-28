
document.addEventListener("DOMContentLoaded", function () {
    const etapa1 = document.getElementById("etapa1");
    const etapa2 = document.getElementById("etapa2");
    const etapa3 = document.getElementById("etapa3");

    const btnEtapa2 = document.getElementById("btnEtapa2");
    const btnEtapa3 = document.getElementById("btnEtapa3");

    btnEtapa2?.addEventListener("click", () => {
        etapa1.style.display = "none";
        etapa2.style.display = "block";
        etapa3.style.display = "none";
    });

    btnEtapa3?.addEventListener("click", () => {
        etapa1.style.display = "none";
        etapa2.style.display = "none";
        etapa3.style.display = "block";
    });

    document.querySelectorAll(".btn-regresar-etapa1").forEach(btn => {
        btn.addEventListener("click", () => {
            etapa1.style.display = "block";
            etapa2.style.display = "none";
            etapa3.style.display = "none";
        });
    });

    document.querySelectorAll(".btn-regresar-etapa2").forEach(btn => {
        btn.addEventListener("click", () => {
            etapa1.style.display = "block";
            etapa2.style.display = "none";
            etapa3.style.display = "none";
        });
    });

    const modalProceso = document.getElementById('modalProceso');

    modalProceso.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const idPractica = button.getAttribute('data-id_practica');

        try {
            const response = await fetch(`/practica/${idPractica}`);
            const data = await response.json();

            // Mostrar estado
            const estado = parseInt(data.estado) || 1;
            actualizarBotones(estado);
            actualizarFormularios(estado);
            
            // Actualizar los selects de estado con el estado_practica correspondiente a cada etapa
            const etapas = ['E1', 'E2', 'E3', 'E4'];
            etapas.forEach(etapa => {
                const selectId = `estado${etapa}`;
                const selectEstado = document.getElementById(selectId);
                if (selectEstado && data.estado_practica) {
                    // Si el estado_practica es 'completo', mostrar 'Aprobado', de lo contrario usar el valor real
                    selectEstado.value = data.estado_practica === 'completo' ? 'aprobado' : data.estado_practica;
                    
                    // Si el estado_practica es 'completo', cambiar el texto de la opción seleccionada
                    if (data.estado_practica === 'completo') {
                        const option = selectEstado.querySelector(`option[value="aprobado"]`);
                        if (option) {
                            option.textContent = 'Completo';
                        }
                    }
                }
            });

            // Mostrar sección según tipo práctica
            const esDesarrollo = data.tipo_practica === 'desarrollo';
            document.getElementById('seccion-desarrollo-E2').style.display = esDesarrollo ? 'block' : 'none';
            document.getElementById('seccion-convalidacion-E2').style.display = esDesarrollo ? 'none' : 'block';
            document.getElementById('seccion-desarrollo-E3').style.display = esDesarrollo ? 'block' : 'none';
            document.getElementById('seccion-convalidacion-E3').style.display = esDesarrollo ? 'none' : 'block';

            console.log('ID Práctica:', data.id);
            // IDs para formularios
            ['idE1', 'idE2', 'idE3', 'idE4'].forEach(id => {
                document.getElementById(id).value = data.id;
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

            // Rutas de archivos - Actualizar hrefs y deshabilitar botones si no hay ruta
            const updateButton = (buttonId, filePath) => {
                const button = document.getElementById(buttonId);
                if (button) {
                    if (filePath) {
                        button.href = filePath;
                        button.removeAttribute('disabled');
                        button.classList.remove('disabled');
                        button.style.cursor = 'pointer';
                        button.style.opacity = '1';
                    } else {
                        button.removeAttribute('href');
                        button.setAttribute('disabled', 'disabled');
                        button.classList.add('disabled');
                        button.style.cursor = 'not-allowed';
                        button.style.opacity = '0.6';
                    }
                }
            };

            // Actualizar todos los botones de documentos
            updateButton('btn-ruta-fut', data.ruta_fut);
            updateButton('btn-ruta-plan-actividades', data.ruta_plan_actividades);
            updateButton('btn-ruta-informe-final', data.ruta_informe_final);
            updateButton('btn-ruta-constancia-cumplimiento', data.ruta_constancia_cumplimiento);
            updateButton('btn-ruta-carta-aceptacion-C2', data.ruta_carta_aceptacion);
            updateButton('btn-ruta-carta-aceptacion-E3', data.ruta_carta_aceptacion);
            updateButton('btn-ruta-carta-presentacion', data.ruta_carta_presentacion);
            updateButton('btn-ruta-registro-actividades', data.ruta_registro_actividades);
            updateButton('btn-ruta-control-mensual-actividades', data.ruta_control_actividades);

        } catch (error) {
            console.error('Error al obtener datos:', error);
        }
    });

    // Mostrar primera etapa por defecto
    modalProceso.addEventListener("show.bs.modal", () => {
        document.querySelectorAll('.form-etapa').forEach(form => {
            form.querySelectorAll('select, button, input').forEach(el => {
                el.removeAttribute('disabled');
                el.classList.remove('disabled');
                el.style.opacity = '1';
            });
            form.style.opacity = '1';
        });

        document.getElementById("primeraetapa").style.display = "block";
        document.getElementById("segundaetapa").style.display = "none";
        document.getElementById("terceraetapa").style.display = "none";
        document.getElementById("cuartaetapa").style.display = "none";
    });
});

// Control de botones por etapa
document.addEventListener("DOMContentLoaded", function () {
    const botones = {
        1: document.getElementById("btn1"),
        2: document.getElementById("btn2"),
        3: document.getElementById("btn3"),
        4: document.getElementById("btn4")
    };

    const etapas = {
        1: document.getElementById("primeraetapa"),
        2: document.getElementById("segundaetapa"),
        3: document.getElementById("terceraetapa"),
        4: document.getElementById("cuartaetapa")
    };

    function ocultarTodo() {
        Object.values(etapas).forEach(etapa => etapa.style.display = "none");
    }

    function mostrarEtapa(n) {
        ocultarTodo();
        etapas[n].style.display = "block";
        
        // Actualizar todos los selects de etapas anteriores a la actual
        for (let i = 1; i <= 4; i++) {
            const selectId = `estadoE${i}`;
            const selectEstado = document.getElementById(selectId);
            if (selectEstado) {
                if (i < n) {
                    // Para etapas anteriores, forzar a mostrar 'Aprobado' y deshabilitar
                    selectEstado.value = 'aprobado';
                    const option = selectEstado.querySelector(`option[value="aprobado"]`);
                    if (option) {
                        option.textContent = 'Aprobado';
                    }
                    selectEstado.setAttribute('disabled', 'disabled');
                } else if (i === n) {
                    // Para la etapa actual, manejar según estado_practica
                    const selectedOption = selectEstado.options[selectEstado.selectedIndex];
                    if (selectedOption) {
                        selectedOption.textContent = selectedOption.value === 'aprobado' ? 'Aprobado' : 
                                                  (selectedOption.value === 'completo' ? 'Completo' : selectedOption.textContent);
                    }
                }
            }
        }
    }

    Object.entries(botones).forEach(([num, btn]) => {
        btn.addEventListener("click", () => mostrarEtapa(Number(num)));
    });
});

function actualizarBotones(estadoActual) {
    document.querySelectorAll('.btn-etapa').forEach(boton => {
        const estadoBoton = parseInt(boton.getAttribute('data-estado')) || 1;

        if (estadoBoton <= estadoActual) {
            boton.classList.remove('btn-secondary', 'btn-disabled');
            boton.classList.add('btn-info');
            boton.removeAttribute('disabled');
            boton.style.opacity = '1';
            boton.style.cursor = 'pointer';
        } else {
            boton.classList.remove('btn-info');
            boton.classList.add('btn-secondary', 'btn-disabled');
            boton.setAttribute('disabled', 'disabled');
            boton.style.opacity = '0.6';
            boton.style.cursor = 'not-allowed';
        }
    });
}

function actualizarFormularios(estadoActual) {
    document.querySelectorAll('.form-etapa').forEach(formulario => {
        const estadoFormulario = parseInt(formulario.getAttribute('data-estado')) || 1;
        const elementos = formulario.querySelectorAll('select, button, input');
        const isActive = estadoFormulario === estadoActual;

        // Actualizar clases y atributos del formulario
        formulario.classList.toggle('disabled', !isActive);
        formulario.style.opacity = isActive ? '1' : '0.6';

        // Actualizar elementos del formulario
        elementos.forEach(el => {
            if (isActive) {
                el.removeAttribute('disabled');
                el.classList.remove('disabled');
            } else {
                // Para los selects, solo deshabilitar pero mantener el valor visible
                if (el.tagName === 'SELECT') {
                    el.setAttribute('disabled', 'disabled');
                } else {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('disabled');
                }
            }
        });
    });
}
