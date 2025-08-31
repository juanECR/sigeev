
 document.addEventListener('DOMContentLoaded', function(){
        contarEventos();
        contarParticipantes();
        listar_eventos(1);
        constarEmpleados();
        contarTareas();
    });

    async function contarEventos() {
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Evento.php?tipo=contarEventos',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_eventos").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        }
        
    }
    async function contarParticipantes(){
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Participante.php?tipo=contarParticipantes',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_participantes").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        } 
    }
    async function constarEmpleados(){
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Empleado.php?tipo=contarEmpleados',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_empleados").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        } 
    }
    async function contarTareas(){
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Tarea.php?tipo=contarTareas',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_tareas").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        } 
    }
    
    // --- Función para construir los botones de paginación ---
function actualizarPaginacion(paginacion, contenedorId) {
    const { pagina_actual, total_paginas } = paginacion;
    const controles = document.getElementById(contenedorId);
    controles.innerHTML = ''; // Limpiar controles antiguos

    if (total_paginas <= 1) return; // No mostrar si solo hay una página

    // Botón "Anterior"
    let liAnterior = document.createElement('li');
    liAnterior.className = `page-item ${pagina_actual <= 1 ? 'disabled' : ''}`;
    liAnterior.innerHTML = `<a class="page-link" href="#" data-pagina="${pagina_actual - 1}">Anterior</a>`;
    controles.appendChild(liAnterior);

    // Números de página
    for (let i = 1; i <= total_paginas; i++) {
        let liPagina = document.createElement('li');
        liPagina.className = `page-item ${pagina_actual === i ? 'active' : ''}`;
        liPagina.innerHTML = `<a class="page-link" href="#" data-pagina="${i}">${i}</a>`;
        controles.appendChild(liPagina);
    }

    // Botón "Siguiente"
    let liSiguiente = document.createElement('li');
    liSiguiente.className = `page-item ${pagina_actual >= total_paginas ? 'disabled' : ''}`;
    liSiguiente.innerHTML = `<a class="page-link" href="#" data-pagina="${pagina_actual + 1}">Siguiente</a>`;
    controles.appendChild(liSiguiente);
}

async function listar_eventos(pagina = 1) {
    try {
        const datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('pagina', pagina); 

        let respuesta = await fetch(base_url + 'src/control/Evento.php?tipo=listarEventosPaginado', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();
        const tbody = document.querySelector('#tbody_tbl_eventos');
        tbody.innerHTML = ''; // Limpiar tabla antes de agregar nuevas filas

        if (json.status && json.contenido.length > 0) {
            let datos = json.contenido;
            // Para que el contador # siga la paginación
            const offset = (pagina - 1) * 10; // 10 es tu `resultados_por_pagina`
            
            datos.forEach((item, index) => {
                let newFila = document.createElement("tr");
                newFila.id = "fila" + item.id;
                
                switch (item.estado) {
                    case "programado":
                           item.estado = '<p class="text-info">programado</p>';
                        break;
                    case "en curso":
                          item.estado = '<p class="text-success">en curso</p>';
                        break;
                    case "finalizado":
                        item.estado = '<p class="text-tertiary">finalizado</p>';
                        break;
                    case "cancelado":
                        item.estado = '<p class="text-danger">cancelado</p>';
                        break;
                }
                // El contador ahora es relativo a la página
                let contador = offset + index + 1;

                newFila.innerHTML = `
                    <td><input class="form-check-input" type="checkbox"></td>
                    <td>${contador}</td>
                    <td>${item.fecha_inicio}</td>
                    <td>${item.titulo}</td>
                    <td>${item.ubicacion}</td>
                    <td>${item.organizador}</td>
                    <td>${item.estado}</td>
                    <td>${item.options}</td>
                `;
                tbody.appendChild(newFila);
            });
            // <-- AÑADIDO: Llamar a la función para construir la paginación
            actualizarPaginacion(json.paginacion, 'paginacion-controles');
        } else {
             tbody.innerHTML = '<tr><td colspan="9" class="text-center">No hay personas para mostrar.</td></tr>';
             // Limpiar paginación si no hay resultados
             document.getElementById('paginacion-controles').innerHTML = '';
        }
    } catch (e) {
        console.log("Oops salió un error: " + e);
        document.querySelector('#tbody_tbl_eventos').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos.</td></tr>';
    }
}

// --- AÑADIDO: Event Listener para los clics en la paginación ---
document.getElementById('paginacion-controles').addEventListener('click', function(e) {
    e.preventDefault(); // Prevenir la recarga de la página

    // Asegurarnos de que se hizo clic en un enlace (<a>)
    if (e.target.tagName === 'A') {
        const pagina = e.target.dataset.pagina;
        const isDisabled = e.target.parentElement.classList.contains('disabled');
        const isActive = e.target.parentElement.classList.contains('active');

        // Solo cargar si no es un botón deshabilitado o la página activa
        if (pagina && !isDisabled && !isActive) {
            listar_eventos(parseInt(pagina));
        }
    }
});
