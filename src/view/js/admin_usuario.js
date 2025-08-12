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
  
