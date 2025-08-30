async function restaurarPassword() {
    const correo = document.getElementById("email").value;
    try {
        const datos = new FormData();
        datos.append('correo_electronico',correo);
        datos.append('sesion', '');
        datos.append('token','');

        let respuesta = await fetch(base_url_server+'src/control/Usuario.php?tipo=restaurarPassword',{
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
    } catch (e) {
        console.log('Error Function || ' + e);
    }
    
}