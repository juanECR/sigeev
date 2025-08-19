
//funciones que deven iniciarse al iniciar la pagina.
document.addEventListener("DOMContentLoaded", function() {
    listarCategoriasForm();
    listarOrganizadoresForm();
    listar_eventos(1);
});
async function registrarNuevaCategoria() {
      try {
        // capturamos datos del formulario html
        const informacion = new FormData(frm_nuevaCategoriaEvento);
        informacion.append('sesion', session_session);
        informacion.append('token', token_token);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/CategoriasEvento.php?tipo=registrarCategoria', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: informacion
        });
        json = await respuesta.json();
        if (json.status) {
             let formOrg = document.getElementById("frm_nuevaCategoriaEvento");
             formOrg.reset();
             let modalEl = document.getElementById("modalNuevoCategoria");
             let modal = bootstrap.Modal.getInstance(modalEl);
      // Cerrar modal
            modal.hide();

            let select = document.getElementById("categoria");
            select.innerHTML = '';
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
                });
                listarCategoriasForm();
        } else if (json.msg == "Error_Sesion") {
            alerta_sesion();
        } else {
            Swal.fire({
                title: "Error",
                text: json.mensaje,
                icon: "error"
                });
        }
  } catch (e) {
     console.log("Oops, ocurrio un error " + e);
  }
}

async function listarCategoriasForm() {
    try {
         let datos = new FormData();
         datos.append('sesion',session_session);
         datos.append('token',token_token);
         let respuesta = await fetch(base_url_server+'src/control/CategoriasEvento.php?tipo=listarCategorias',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
         });
         json = await respuesta.json();
         if (json.status) {
             let datos = json.contenido;
             datos.forEach(item => {
                let nuevaFila =  document.createElement("option");
                //nuevaFilaid: es crear // item.Id: viene de la base de datos
                nuevaFila.value = item.id;
                nuevaFila.innerHTML = item.nombre;
                document.querySelector('#categoria').appendChild(nuevaFila);
        });
         }
        
    } catch (e) {
        console.log('ocurrio un error de funcion' + e);
    }
}
async function listarOrganizadoresForm(){
    try {
        let valores = new FormData();
        valores.append('sesion',session_session);
        valores.append('token',token_token);
        let respuest = await fetch(base_url_server + 'src/control/Organizador.php?tipo=listarOrganizadores' ,{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: valores
        });
        let json = await respuest.json();
        if(json.status){
            let content = json.contenido;
             content.forEach(item => {
                let newFila =  document.createElement("option");
                //newFilaid: es crear // item.Id: viene de la base de datos
                newFila.value = item.id;
                newFila.innerHTML = item.razon_social;
                document.querySelector('#organizador').appendChild(newFila);
        });
        }else if(json.msg == "Error_Sesion"){
              console.log("fallo al iniciar sesion");
        }
    } catch (e) {
        console.log('Ups ocurrio un error con la funcion ' + e);
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
                    <td>${contador}</td>
                    <td>${item.titulo}</td>
                    <td>${item.fecha_inicio}</td>
                    <td>${item.fecha_fin}</td>
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


async function CrearEvento(){
      try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_nuevo_evento);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Evento.php?tipo=crearEvento', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
             let modalEl = document.getElementById("modalCrearEvento");
             let modal = bootstrap.Modal.getInstance(modalEl);
      // Cerrar modal
            modal.hide();
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
                });
                listar_eventos(1);
        } else if (json.msg == "Error_Sesion") {
            alerta_sesion();
        } else {
            Swal.fire({
                title: "Error",
                text: json.mensaje,
                icon: "error"
                });
        }
  } catch (e) {
     console.log("Oops, ocurrio un error " + e);
  }
}