async function listarUsuarios() {
    let tablaBody = document.getElementById('tbody_tbl_usuarios');
 try {
       let respuesta = await fetch(base_url_server + 'src/control/usuario.php?tipo=listarUsuarios',{
           method: 'POST',
           mode: 'cors',
           cache: 'no-cache',
    });
      json = await respuesta.json();
        if (json.status) {
           tablaBody.innerHTML ='';
           contenido.forEach(item => {
            const fila= document.createElement("tr");
            const celdas = [contenido.nombres_apellidos, contenido.correo, contenido.telefono, contenido.estado];
            celdas.forEach(valor =>{
                const td = document.createElement("td");
                td.textContent = valor;
                fila.appendChild(td);
            });
            tablaBody.appendChild(fila);
           });
        }
 } catch (error) {
       console.log("Error al inicar sesion" + e);
 }
 
}

async function listarRolesSistema(){
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
                cont ++;
                nuevaFila.innerHTML = item.nombre;
                document.querySelector('#rol').appendChild(nuevaFila);
        });
     } 
     console.log(json);
    } catch (error) {
        console.log('error en la funcion'+e );
    }
}

async function registrarUsuario(){
  let nombres = document.getElementById("nombres").value;
  let correo = document.getElementById("correo").value;
  let telefono = document.getElementById("telefono").value;
  let password = document.getElementById("password").value;
  let rol = document.getElementById("rol").value;
  if(nombres == "" || correo == ""|| telefono == "" ||password==""||rol==""){
        toastr.error('campos vacios');
        return;
  }
  try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_nuevo_usuario);
        datos.append('sesion', session_session);
        datos.append('token', token_token);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Usuario.php?tipo=registrar', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
             let modalEl = document.getElementById("modalNuevoUsuario");
            let modal = bootstrap.Modal.getInstance(modalEl);
      // Cerrar modal
            modal.hide();
            toastr.success('Nuevo usuario registrado');
/*             modalEl.addEventListener('hidden.bs.modal', function () {
                toastr.success("Nuevo usuario registrado");
                }, { once: true });

                modal.hide(); */
        } else if (json.msg == "Error_Sesion") {
            alerta_sesion();
        } else {
            toastr.error(json.mensaje);
        }
  } catch (error) {
     console.log("Oops, ocurrio un error " + e);
  }
}
  
