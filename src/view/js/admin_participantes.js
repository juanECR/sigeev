document.addEventListener("DOMContentLoaded", function() {
    listarRolesEventoForm();
    listar_participantes_evento(1);
});
async function registrarNuevoRolEvento() {
    try {
        let formdatos = new FormData(frm_nuevo_rol_participante);
        formdatos.append('sesion', session_session);
        formdatos.append('token', token_token);
        let respues = await fetch(base_url_server + 'src/control/RolesEvento.php?tipo=registrarNuevoRol',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: formdatos
        });
        
           json = await respues.json();
           if (json.status){
             let form = document.getElementById("frm_nuevo_rol_participante");
             form.reset();
             let modalEl = document.getElementById("modalNuevoRolParticipante");
             modal = bootstrap.Modal.getInstance(modalEl)
             modal.hide();
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
           }else if (json.msg == "Error_Sesion") {
            alerta_sesion();
            } else {
                Swal.fire({
                    title: "Error",
                    text: json.mensaje,
                    icon: "error"
                    });
            }
    } catch (e) {
        console.log('Ups, Ocurrio un error con la funcion' + e);
    }
}
async function listarRolesEventoForm(){
    try {
        let datosRoles = new FormData();
        datosRoles.append('sesion', session_session);
        datosRoles.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/RolesEvento.php?tipo=listar',{
          method : 'POST',
          mode: 'cors',
          cache: 'no-cache',
          body: datosRoles
        });
         let json = await respuesta.json();
        if(json.status){
            let valores = json.contenido;
            valores.forEach(item => {
                let newFila = document.createElement("option");
                newFila.value = item.id;
                newFila.innerHTML = item.nombre;
                document.getElementById("rolEvento").appendChild(newFila);  
            });
        }
    } catch (e) {
        console.log('ups ocurrio un error en la funcion' + e);
    } 
}

async function registrarParticipanteEvento() {
    try {
        let datos = new FormData(frm_nuevo_participante);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url_server+'src/control/Participante.php?tipo=registrarParticipanteEvento',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let form = document.getElementById("frm_nuevo_participante");
            form.reset();
            let modalEl = document.getElementById("modalNuevoParticipante");
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
                });
               /*  listar_personas(1); */
        } else if (json.mensaje == "Error_sesion") {
            alerta_sesion();
        } else {
            Swal.fire({
                title: "Error",
                text: json.mensaje,
                icon: "error"
                });
        }
    } catch (e) {
        console.log('ups, ocurrio un error con la funcion '+ e);
    }
}

//esta funcion falta completar
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

async function listar_participantes_evento(pagina = 1) { // Acepta el número de página
    try {
        const datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('pagina', pagina);
        datos.append('id_evento', id_evento);

        let respuesta = await fetch(base_url + 'src/control/Participante.php?tipo=listarParticipantesEvento', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();
        const tbody = document.querySelector('#tbody_tbl_participantes');
        tbody.innerHTML = ''; // Limpiar tabla antes de agregar nuevas filas

        if (json.status && json.contenido.length > 0) {
            let datos = json.contenido;
            // Para que el contador # siga la paginación
            const offset = (pagina - 1) * 10; // 10 es tu `resultados_por_pagina`
            
            datos.forEach((item, index) => {
                let nuevaFila = document.createElement("tr");
                nuevaFila.id = "fila" + item.id;
                
                // El contador ahora es relativo a la página
                let contador = offset + index + 1;

                nuevaFila.innerHTML = `
                    <td>${contador}</td>
                    <td>${item.dni}</td>
                    <td>${item.nombres}</td>
                    <td>${item.apellidos}</td>
                    <td>${item.telefono}</td>
                    <td>${item.fecha_nacimiento}</td>
                    <td>${item.rol}</td>
                    <td>${item.options}</td>
                `;
                tbody.appendChild(nuevaFila);
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
        document.querySelector('#tbody_tbl_participantes').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos.</td></tr>';
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
            listar_participantes_evento(parseInt(pagina));
        }
    }
});
