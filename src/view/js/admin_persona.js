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
             const tablaBody = document.getElementById('tbody_tbl_personas');
             tablaBody.innerHTML = ''; 
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
                listar_personas();
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

//listar productos en Productos.php tabla
async function listar_personas(){
    try {
        const datos = new FormData();
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        let respuesta = await fetch(base_url+'src/control/Persona.php?tipo=listarPersonas',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        let json = await respuesta.json();
        if (json.status) {
            let datos = json.contenido;
            let cont = 0;
     /*     let contenido_select = '<tbody> <tr><td>nombre</td><td>apelldio</td></tr></tbody>'; */
            datos.forEach(item => {
                let nuevaFila =  document.createElement("tr");
                //nuevaFilaid: es crear // item.Id: viene de la base de datos
                nuevaFila.id = "fila" +item.id;
                cont ++;
                nuevaFila.innerHTML = `
                <td>${cont}</td>
                <td>${item.dni}</td>
                <td>${item.nombres}</td>
                <td>${item.apellidos}</td>
                <td>${item.correo_electronico}</td>
                <td>${item.telefono}</td>
                <td>${item.fecha_nacimiento}</td>
                <td>${item.genero}</td>
                <td>${item.options}</td>
                `;
                document.querySelector('#tbody_tbl_personas').appendChild(nuevaFila);
        });

        }
        console.log(json);
    } catch(e) {
        console.log("OOps salio un error" + e);
    }
}
if (document.querySelector('#tbl_personas')) {
    listar_personas();
}