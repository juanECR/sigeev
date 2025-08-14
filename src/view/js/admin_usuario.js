
//funciones que deven iniciarse al iniciar la pagina.
document.addEventListener("DOMContentLoaded", function() {
    ListarRolesSistema();
});


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
  let nombres = document.getElementById("nombres").value;
  let apellidos = document.getElementById("apellidos").value;
  let telefono = document.getElementById("telefono").value;
  let genero = document.getElementById("genero").value;
  let rol = document.getElementById("rol").value;

  if(nombres == "" || apellidos == ""|| telefono == "" ||genero==""||rol==""){
      Swal.fire({
      title: "Campos vacios",
      text: "Los campos ingresados estan vacios",
      icon: "error"
      });
  }
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
             const tablaBody = document.getElementById('tbody_tbl_usuarios');
             tablaBody.innerHTML = ''; 
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

               /*  listar_personas(1); */

        } else if (json.msg == "Error_Sesion") {
            alerta_sesion();
        } else {
             Swal.fire({
                title: "Error",
                text: json.mensaje,
                icon: "error"
                });
        }
  } catch (error) {
     console.log("Oops, ocurrio un error " + e);
  }
}
  
