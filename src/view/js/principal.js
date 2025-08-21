/* function Navegacion() {
    const nav = document.querySelector(".nav-item");
    if(menuActual = ""){
        nav.className = "nav-item nav-link active";
    }
} */

    document.addEventListener('DOMContentLoaded', function(){
        contarEventos();
    });

    async function contarEventos() {
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Evento.php?tipo=contarEventos',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_eventos").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        }
        
    }
    async function contarParticipantes(){
        try {
            let datos = new FormData();
            datos.append('sesion',session_session);
            datos.append('token',token_token);
            let respuesta = await fetch(base_url_server+'src/control/Participante.php?tipo=contarParticipantes',{
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                body: datos
            });
            json = await respuesta.json();
            if(json.status){
              document.querySelector(".n_participantes").innerHTML = json.total;
            }   
        } catch (e) {
            console.log('funcion error || ' + e);
        }
        
    }