document.addEventListener("DOMContentLoaded", function() {
    listarDetallesEvento();
    listarAlgunosParticipantes();
    listarcategoriasFrm();
    listarOrganizadoresFrm();
});

async function listarAlgunosParticipantes(){
    try {
        let datos = new FormData();
        datos.append('sesion',session_session);
        datos.append('token',token_token);
        datos.append('id_evento',id_evento);
     let respuesta = await fetch(base_url_server+'src/control/Participante.php?tipo=listarAlgunosParticipantes',{
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        body: datos
     });
     json = await respuesta.json();
     const caja = document.querySelector(".person-list");
     if(json.status && json.contenido.length > 0){
         let dates = json.contenido;
         dates.forEach(item => {
            let nuevaCaja = document.createElement("div");
            nuevaCaja.innerHTML =`<div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="fas fa-user-circle fa-4x text-primary"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">`+ item.nombre+' '+item.apellido+`</h5>
                                        <p class="text-muted mb-0">`+item.rol+`</p>
                                    </div>
                                 </div><hr>`;
            caja.appendChild(nuevaCaja);              
         });
       
        }else{
            caja.innerHTML = '<div colspan="9" class="text-center"><h5>Aun no hay Participantes.</h5></div>';
        }
    } catch (e) {
        console.log('error en funcion ||' + e);
    }
}

async function listarcategoriasFrm() {
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
async function listarOrganizadoresFrm(){
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

async function listarDetallesEvento() {
    let titulo = document.getElementById("titulo");
    let descripcion = document.getElementById("descripcion");
    let categoria = document.getElementById("categoria");
    let fecha_inicio = document.getElementById("fecha_inicio");
    let fecha_fin = document.getElementById("fecha_fin");
    let ubicacion = document.getElementById("ubicacion");
    let organizador = document.getElementById("organizador");
    let estado = document.getElementById("estado");
    try {
        let datos = new FormData();
        datos.append('sesion',session_session);
        datos.append('token',token_token);
        datos.append('id_evento',id_evento);

        let respuesta = await fetch(base_url_server + 'src/control/DetalleEvento.php?tipo=listarDetallesEvento',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            let datos = json.contenido;
            document.querySelector(".page-title").innerHTML = '<i class="fa fa-calendar-check text-primary mr-2"></i> '+datos.titulo+'';
            document.querySelector("#descripcion_evento").innerHTML =datos.descripcion;
            document.querySelector(".ubicacion").innerHTML ='<strong>'+datos.ubicacion+'</strong>';
            document.querySelector(".f_inicio").innerHTML ='<strong>Inicio:</strong> '+datos.fecha_inicio+'';
            document.querySelector(".f_fin").innerHTML ='<strong>Finaliza:</strong> '+datos.fecha_fin+'';
            document.querySelector(".organizador").innerHTML ='<strong>'+datos.organizador+'</strong>';
            titulo.value = datos.titulo;
            descripcion.value = datos.descripcion;
           for (let i = 0; i < categoria.options.length; i++) {
                if(categoria.options[i].value == datos.categoria_evento_id){categoria.options[i].selected = true;}
            } 
            
            fecha_inicio.value = datos.fecha_inicio;
            fecha_fin.value = datos.fecha_fin;
            ubicacion.value = datos.ubicacion;
            organizador.value = datos.organizador_id;
            estado.value = datos.estado;
        }else if(json.mensaje == "Error_sesion"){
            alerta_sesion();
        }
    } catch (e) {
        console.log('Ups ocurrio un error con la funcion' + e);
    }
}

async function  editarEvento(){
    try {
        let info = new FormData(frm_editar_evento);
        info.append('sesion',session_session);
        info.append('token',token_token);
        info.append('id_evento',id_evento);

        let respuesta = await fetch(base_url_server + 'src/control/DetalleEvento.php?tipo=actualizarEvento',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: info
        });
        json = await respuesta.json();
        if(json.status){
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
                });
        }else if(json.mensaje == "Error_Sesion"){
           alerta_sesion();
        }else{
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: json.mensaje,
                showConfirmButton: false,
                timer: 1500
                });
        }
        
    } catch (error) {
        console.log('error function async !! ' + error);
        
    }
    
}
