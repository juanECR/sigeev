<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-organizadorModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objOrganizador = new OrganizadorModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarOrganizador"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        if ($_POST) {
            $tipo_documento = $_POST['tipo_documento'];
            $nro_documento = trim($_POST['nro_documento']);
            $razon_social = $_POST['razon_social'];
            $tipo = $_POST['tipo'];
            $correo = trim($_POST['correo']);
            $telefono = $_POST['telefono'];

            $razon_soci_mayus = strtoupper($razon_social);

            if ($tipo_documento == ""||$nro_documento =="" ||$razon_social == ""||$tipo== "" || $correo == "" || $telefono == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arr_OrganizadorDoc = $objOrganizador->buscarOrganizadorByNroDocumento($nro_documento);
                $arr_Organizador = $objOrganizador->buscarOrganizadorByCorreo($correo);
                if ($arr_Organizador) { 
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Este correo ya ha sido registrado');
                } else if($arr_OrganizadorDoc){
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Organizador ya se encuentra registrado');
                }else{
                    $id_organizador = $objOrganizador->registrarOrganizador($tipo_documento,$nro_documento,$razon_soci_mayus,$tipo,$correo,$telefono);
                    if ($id_organizador > 0) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar Organizador');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if($tipo == "listarOrganizadoresPaginado"){
    $arr_Respuesta = array('status' => false, 'contenido' => '', 'mensaje' => 'Error de sesión');

    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        // --- INICIO DE CAMBIOS PARA PAGINACIÓN ---

        // 1. Definir configuración y obtener página actual
        $resultados_por_pagina = 10; // O el número que prefieras
        // Recibimos el número de página desde el fetch de JavaScript
        $pagina_actual = isset($_POST['pagina']) ? (int)$_POST['pagina'] : 1;
        
        // 2. Calcular el OFFSET para la consulta SQL
        $offset = ($pagina_actual - 1) * $resultados_por_pagina;

        // 3. Obtener el total de registros y calcular el total de páginas
        $total_organizadores = $objOrganizador->contarTotalOrganizadores(); // Usamos la nueva función del modelo
        $total_paginas = ceil($total_organizadores / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arr_Organizador = $objOrganizador->listarOrganizadoresPaginado($resultados_por_pagina, $offset); // Usamos la nueva función

        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---

        if (!empty($arr_Organizador)) {
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arr_Organizador); $i++) {

                $id_organizador = $arr_Organizador[$i]->id;

                // Importante: Sanitizar la salida para prevenir XSS
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_organizador . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_organizador . ')"><i class="fas fa-trash-alt"></i></button>';
                $arr_Organizador[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Organizador;
            
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
if($tipo == "listarOrganizadores"){
    $arr_Respuesta = array('status'=> false, 'contenido'=>'' ,'msg'=>'Error_Sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)){
        $arr_organizadores = $objOrganizador->listarTodosOrganizadores();
        if(!empty($arr_organizadores)){
           $arr_Respuesta['status'] = true;
           $arr_Respuesta['contenido'] = $arr_organizadores;
           $arr_Respuesta['msg'] = 'correcto';
        }
    }
    echo json_encode($arr_Respuesta);

}

?>