async function registrarOrganizador() {
  let documento = document.getElementById("documento").value;
  let razon_social = document.getElementById("razon_social").value;
  let tipo = document.getElementById("tipo").value;
  let correo = document.getElementById("correo").value;
  let telefono = document.getElementById("telefono").value;
  if(documento==""||razon_social == ""||tipo == "" || correo == ""|| telefono == ""){
        Swal.fire({
            title: "Campos vacios",
            text: "Los campos ingresados estan vacios",
            icon: "error"
            });
  }
  try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_nuevo_organizador);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Organizador.php?tipo=registrarOrganizador', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
             const tablaBody = document.getElementById('tbody_tbl_organizadores');
             tablaBody.innerHTML = ''; 
             let modalEl = document.getElementById("modalNuevoOrganizador");
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
                /* listar_organizadores(1); */
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