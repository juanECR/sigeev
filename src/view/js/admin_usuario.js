
//funciones que deven iniciarse al iniciar la pagina.
document.addEventListener("DOMContentLoaded", function() {
    ListarRolesSistema();
    listar_usuarios(1);
});

//listar options parA EL REGISTRO DE USUARIOS
async function ListarRolesSistema(){
    try {
     let form = new FormData();
     form.append('sesion',session_session);
     form.append('token',token_token);

     let respuesta = await fetch(base_url_server + 'src/control/RolesSistema.php?tipo=listarRolesSistema',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: form
     });
     json = await respuesta.json();
     if (json.status) {
            let datos = json.contenido;
             datos.forEach(item => {
                let nuevaFila =  document.createElement("option");
                //nuevaFilaid: es crear // item.Id: viene de la base de datos
                nuevaFila.value = item.id;
                nuevaFila.innerHTML = item.nombre;
                document.querySelector('#rol').appendChild(nuevaFila);
        });
     } 
     console.log(json);
    } catch (e) {
        console.log('error en la funcion'+e );
    }
}


async function registrarUsuario(){
    let dni = document.getElementById("dni").value;
    if(dni.length !== 8){
            Swal.fire({
                icon: "error",
                title: "Error, verifica tu DNI e inténtalo de nuevo",
                showConfirmButton: false,
                timer: 1500
                });
    }else{
        try {
                const datos = new FormData(frm_nuevo_usuario);
                datos.append('sesion', session_session);
                datos.append('token', token_token);
                let respuesta = await fetch(base_url_server + 'src/control/Usuario.php?tipo=registrar', {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: datos
                });
                json = await respuesta.json();
                if (json.status) {
                    let form = document.getElementById("frm_nuevo_usuario");
                    form.reset();
                    let modalEl = document.getElementById("modalNuevoUsuario");
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
                    listar_usuarios(1);
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
}


  
//LISTAR USUARIOS DEL SISTEMA
async function listar_usuarios(pagina = 1) {
    try {
        const datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('pagina', pagina); 

        let respuesta = await fetch(base_url + 'src/control/Usuario.php?tipo=listarUsuariosPaginado', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();
        const tbody = document.querySelector('#tbody_tbl_usuarios');
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
                    <td>${item.nombre}</td>
                    <td>${item.apellido}</td>
                    <td>${item.correo}</td>
                    <td>${item.telefono}</td>
                    <td>${item.rol}</td>
                    <td>${item.estado}</td>
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
        document.querySelector('#tbody_tbl_usuarios').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos.</td></tr>';
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
            listar_usuarios(parseInt(pagina));
        }
    }
});

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