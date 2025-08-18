<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-eventoModel.php');
require_once('../model/admin-organizadorModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objEvento = new EventoModel();
$objOrganizador = new OrganizadorModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if ($tipo == "listarEventosPaginado") {
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error de sesión');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $resultados_por_pagina = 10; 
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;
        // 3. Obtener el total de registros y calcular el total de páginas
        $total_eventos = $objEvento->contarTotalEventos(); 
        $total_paginas = ceil($total_eventos / $resultados_por_pagina);
        // 4. Obtener solo las personas para la página actual

        $arr_Evento = $objEvento->listarEventosPaginado($resultados_por_pagina, $offset);
        if (!empty($arr_Evento)) {
            for ($i = 0; $i < count($arr_Evento); $i++) {
                $arr_Organizador = $objOrganizador->buscarOrganizadorById($arr_Evento[$i]->organizador_id);
                $id_evento = $arr_Evento[$i]->id;
                $arr_Evento[$i]->organizador = $arr_Organizador->razon_social;
                $opciones = '<a href="' . BASE_URL . 'detalle_evento/' . $id_evento . '"><button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>Detalles</button></a>';
                $arr_Evento[$i]->options = $opciones;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Evento;
            
            // AÑADIDO: Incluir información de la paginación en la respuesta JSON
            $arr_Respuesta['paginacion'] = [
                'pagina_actual' => $pagina_actual,
                'total_paginas' => $total_paginas
            ];
        } else {
            // Manejar el caso de que no haya resultados para esa página
            $arr_Respuesta['status'] = true; // Es un éxito, pero no hay contenido
            $arr_Respuesta['contenido'] = [];
            $arr_Respuesta['paginacion'] = ['pagina_actual' => 1, 'total_paginas' => 1];
        }
    }
    echo json_encode($arr_Respuesta);
}
if($tipo == "crearEvento"){
     $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $titulo = trim($_POST['titulo']);
            $descripcion = $_POST['descripcion'];
            $categoria_id = trim($_POST['categoria']);
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $ubicacion = $_POST['ubicacion'];
            $organizador_id = trim($_POST['organizador']);

            if ($titulo =="" ||$descripcion == ""||$categoria_id== "" || $fecha_inicio == "" || $fecha_fin == "" || $ubicacion == ""|| $organizador_id == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                    $id_evento = $objEvento->registrarEvento($dni,$nombres,$apellidos,$correo,$telefono,$fecha_nacimiento,$genero);
                    if ($id_evento > 0) {
                        // array con los id de los sistemas al que tendra el acceso con su rol registrado
                        // caso de administrador y director
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');
                    }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}
?>