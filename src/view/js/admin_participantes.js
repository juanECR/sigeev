document.addEventListener("DOMContentLoaded", function() {
    listarRolesEventoForm();
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