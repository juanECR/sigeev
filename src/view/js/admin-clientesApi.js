
//funciones que deven iniciarse al iniciar la pagina.
document.addEventListener("DOMContentLoaded", function() {
    listarClientesApi(1);
});

let Uri = base_url_server+'src/control/clientesApi.php?tipo=';
let UriTokens = base_url_server+'src/control/tokensApi.php?tipo=';

async function registrarCliente(){
    let ruc = document.getElementById("ruc").value;
    if(ruc.length !== 11){
            Swal.fire({
                icon: "error",
                title: "Error, verifica el RUC e inténtalo de nuevo",
                showConfirmButton: false,
                timer: 1500
                });
    }else{
        try {
                const datos = new FormData(frm_nuevo_cliente);
                datos.append('sesion', session_session);
                datos.append('token', token_token);
                let respuesta = await fetch(Uri+'registrarCliente', {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: datos
                });
                json = await respuesta.json();
                if (json.status) {
                    let form = document.getElementById("frm_nuevo_cliente");
                    form.reset();
                    let modalEl = document.getElementById("modalNuevoCliente");
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
                    listarClientesApi(1);
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
async function listarClientesApi(pagina = 1) {
    try {
        const datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        datos.append('pagina', pagina); 

        let respuesta = await fetch(Uri+'listarClientesApi',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();
        const tbody = document.querySelector('#tbody_tbl_clientesApi');
        tbody.innerHTML = ''; // Limpiar tabla antes de agregar nuevas filas

        if (json.status && json.contenido.length > 0) {
            let datos = json.contenido;
            // Para que el contador # siga la paginación
            const offset = (pagina - 1) * 10; // 10 es tu `resultados_por_pagina`
            
            datos.forEach((item, index) => {
                let nuevaFila = document.createElement("tr");
                nuevaFila.id = item.id;
                
                // El contador ahora es relativo a la página
                let contador = offset + index + 1;

                nuevaFila.innerHTML = `
                    <td>${contador}</td>
                    <td>${item.ruc}</td>
                    <td>${item.razon_social}</td>
                    <td>${item.telefono}</td>
                    <td>${item.correo}</td>
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
        document.querySelector('#tbody_tbl_clientesApi').innerHTML = '<tr><td colspan="9" class="text-center text-danger">Error al cargar los datos.</td></tr>';
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
            listarClientesApi(parseInt(pagina));
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

async function buscarClienteApi(id) {
    let data = document.getElementById("data");
    let ruc = document.getElementById("new_ruc");
    let razon = document.getElementById("new_razon_social");
    let telefono = document.getElementById("new_telefono");
    let correo = document.getElementById("new_correo");
    let estado = document.getElementById("estado");
    try {
        const datos = new FormData();
                datos.append('sesion', session_session);
                datos.append('token', token_token);
                datos.append('id',id);
                let respuesta = await fetch(Uri+'buscarClienteApi', {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    body: datos
                });
                json = await respuesta.json();
                if(json.status){
                   let datos = json.contenido;
                   data.value = datos.id;
                   ruc.value = datos.ruc;
                   razon.value = datos.razon_social;
                   telefono.value = datos.telefono;
                   correo.value = datos.correo;
                   estado.value = datos.estado;
                }
    } catch (e) {
        console.log('erro fun || ' + e);     
    }
}
async function actualizarCliente() {
    try {
        const datos = new FormData(frm_act_cliente);
         datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(Uri+'actualizarCliente',{
            method: 'POST',
             mode: 'cors',
            cache: 'no-cache',
             body: datos
        });

        json = await respuesta.json();
        if(json.status){
                let form = document.getElementById("frm_act_cliente");
                    form.reset();
                    let modalEl = document.getElementById("modalEditarCliente");
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
                        listarClientesApi(1);
        }else if(json.mensaje == "Error_Sesion"){
         alerta_sesion();
        }else{
        Swal.fire({
            title: "Error",
            text: json.mensaje,
            icon: "error"
            });
        }

    } catch (e) {
        console.log('funct error ||' + e);
    }
    
}

/////////////////////////// gestion tokens api //////////////////////////////////

function asignarCliente(id){
    let data = document.getElementById("dataClient");
    data.value = id;

    listarTokensCliente(id);
}

async function listarTokensCliente(id){
    try {
        let datos = new FormData();
          datos.append('token', token_token);  
          datos.append('sesion', session_session); 
          datos.append('data', id); 
          let respue = await fetch(UriTokens +'listarTokensCliente',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
          });
          json = await respue.json();
          let bodyHtml = document.getElementById("tbody_tokens");
          if(json.status){
            bodyHtml.innerHTML = '';
            let datos = json.contenido;
            datos.forEach((item) => {
                let nuevaFila = document.createElement("tr");
                nuevaFila.id = item.id;
                
                let contador = 0;
                contador++;

                nuevaFila.innerHTML = `
                    <td>${contador}</td>
                    <td><span class="font-monospace">${item.token}</span></td>
                    <td>${item.fecha_registro}</td>
                    <td>${item.estado}</td>
                    <td class="text-center">${item.options}</td>
                `;
                bodyHtml.appendChild(nuevaFila);
            });
            
          }else if(json.mensaje == "Error_Sesion"){
           alerta_sesion();
          }else{
            bodyHtml.innerHTML = "<span class='text-danger text-center'>no hay datos<span>";
          }
        
    } catch (e) {
        console.log('erro function || '+ e);     
    }
}

function generarToken(){
    Swal.fire({
  title: "Generar Token?",
  text: "¿Deseas Generar token para este cliente?",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Si, generar token!"
}).then((result) => {
  if (result.isConfirmed) {
     generarTokenClient();
  }
});
}

async function generarTokenClient() {
    let dataClient = document.getElementById("dataClient").value;
    try {
          let datos = new FormData();
          datos.append('token', token_token);  
          datos.append('sesion', session_session); 
          datos.append('data', dataClient); 
          let respue = await fetch(UriTokens +'generarTokenClient',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
          });
          json = await respue.json();
          if(json.status){
                 Swal.fire({
                    title: "Token generado!",
                    text: json.mensaje,
                    icon: "success"
                    });
                    listarTokensCliente(dataClient);
          }else if(json.mensaje == "Error_Sesion"){
            alerta_sesion();
          }else{
                 Swal.fire({
                    title: "Error!",
                    text: json.mensaje,
                    icon: "error"
                    });
          }
     } catch (e) {
            console.log('error funct || ' + e);
     }
}

async function cambiarEstado(idtoken, estado){
     let dataClient = document.getElementById("dataClient").value;
    try {
        let datos = new FormData();
          datos.append('token', token_token);  
          datos.append('sesion', session_session); 
          datos.append('data', idtoken); 
          datos.append('status', estado); 
          let respue = await fetch(UriTokens +'cambiarEstadoToken',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
          });
          json = await respue.json();
          if(json.status){
              listarTokensCliente(dataClient);
          } else if(json.mensaje == "Error_Sesion"){
            alerta_sesion();
          }else{
                 Swal.fire({
                    title: "Error!",
                    text: json.mensaje,
                    icon: "error"
                    });
          }
        
    } catch (e) {
        console.log('error funct || ' + e);     
    }
}