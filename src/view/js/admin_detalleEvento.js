async function listarDetallesEvento(id) {
    try {
        let datos = new FormData();
        datos.append('sesion',session_session);
        datos.append('token',token_token);
        datos.append('id_evento',id);

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
