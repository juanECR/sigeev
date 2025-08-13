async function registrarPersona() {
  let dni = document.getElementById("dni").value;
  let nombres = document.getElementById("nombres").value;
  let apellidos = document.getElementById("apellidos").value;
  let correo = document.getElementById("correo").value;
  let telefono = document.getElementById("telefono").value;
  let fecha_nacimiento = document.getElementById("fecha_nacimiento").value;
  let genero = document.getElementById("genero").value;
  if(dni==""||nombres == ""||apellidos == "" || correo == ""|| telefono == "" ||fecha_nacimiento==""||genero==""){
        Swal.fire({
            title: "Campos vacios",
            text: "Los campos ingresados estan vacios",
            icon: "error"
            });
  }
  try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_nuevo_persona);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Persona.php?tipo=registrarPersona', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
             let modalEl = document.getElementById("modalNuevoPersona");
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
/*             modalEl.addEventListener('hidden.bs.modal', function () {
                toastr.success("Nuevo usuario registrado");
                }, { once: true });

                modal.hide(); */
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