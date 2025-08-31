async function enviarCorreo() {
    const datos = new FormData(frm_enviar_Correo);
    datos.append('sesion', session_session);
    datos.append('token', token_token);
    try {
        let respuesta = await fetch(base_url_server + 'src/control/Comunicacion.php?tipo=enviarCorreo',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        })
        let json = await respuesta.json();
        if(json.status){
       
            Swal.fire({
                icon: "success",
                title: json.mensaje,
                timer: 1500
                });
        }else if(json.mensaje == "Error_Sesion"){
            alerta_sesion();
        }else{
            Swal.fire({
                icon: "error",
                title: json.mensaje,
                timer: 1500
                });
        }
    } catch (e) {
        console.log('Erro func async || ' + e);
    }
}