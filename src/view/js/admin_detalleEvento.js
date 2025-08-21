document.addEventListener("DOMContentLoaded", function() {
    listarDetallesEvento();
    listarAlgunosParticipantes();
});
async function listarDetallesEvento() {
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
        }else if(json.mensaje == "Error_sesion"){
            alerta_sesion();
        }
    } catch (e) {
        console.log('Ups ocurrio un error con la funcion' + e);
    }
}

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
