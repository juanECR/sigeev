async function iniciar_sesion() {
    let user = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    if (user == "" || password == "") {
        toastr.error('campos vacios');
        return;
    }
    try {
        // capturamos datos del formulario html
        const datos = new FormData(frm_login);
        //enviar datos hacia el controlador
        let respuesta = await fetch(base_url_server + 'src/control/Login.php?tipo=iniciar_sesion', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            const formData = new FormData();
            formData.append('session', json.contenido['sesion_id']);
            formData.append('usuario', json.contenido['sesion_usuario']);
            formData.append('nombres_apellidos', json.contenido['sesion_usuario_nom']);
            formData.append('rol', json.contenido['sesion_usuario_rol']);
            formData.append('token', json.contenido['sesion_token']);

            fetch(base_url + 'src/control/sesion_cliente.php?tipo=iniciar_sesion', {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: formData
            });
            location.replace(base_url);
            location.replace(base_url);
        } else {
         Swal.fire({
            icon: "error",
            title: "Oops...",
            text: json.msg,
            footer: '<a href="#">Why do I have this issue?</a>'
            });
        }
        //console.log(respuesta);
    } catch (e) {
        console.log("Error al inicar sesion" + e);
    }
}

if (document.querySelector('#frm_login')) {
    // evita que se envie el formulario
    let frm_iniciar_sesion = document.querySelector('#frm_login');
    frm_iniciar_sesion.onsubmit = function (e) {
        e.preventDefault();
        iniciar_sesion();
    }
}
async function cerrar_sesion() {
    let respuesta = await fetch(base_url + 'src/control/sesion_cliente.php?tipo=cerrar_sesion');
    json = await respuesta.json();
    if (json.status) {
        location.replace(base_url);
    }
}

async function send_email_password() {
    const datos = new FormData();
    datos.append('sesion', session_session);
    datos.append('token', token_token);
    try {
        let respuesta = await fetch(base_url_server + 'src/control/Usuario.php?tipo=sent_email_password',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        })
    } catch (e) {
        console.log('Erro func async || ' + e);
    }
}