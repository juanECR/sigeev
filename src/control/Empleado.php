<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-empleadoModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objEmpleado = new EmpleadoModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrar"){
    $arr_Respuesta = array('status' => false, 'mensaje' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        //repuesta
        if ($_POST) {
            $dni = trim($_POST['dni']);
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $correo = trim($_POST['correo']);
            $telefono = $_POST['telefono'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];

            if ($dni =="" ||$nombres == ""||$apellidos== "" || $correo == "" || $telefono == "" || $fecha_nacimiento == ""|| $genero == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $verificarCorreo = $objEmpleado->buscarEmpleadoByCorreo($correo);
                $verificarDni = $objEmpleado->buscarEmpleadoByDni($dni);
                if ($verificarCorreo) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Correo ya se encuentra registrado');
                } else if($verificarDni){
                       $arr_Respuesta = array('status' => false, 'mensaje' => 'Empleado ya se encuentra registrado');
                }else{
                    $id_new_empleado = $objEmpleado->registrarEmpleado($dni,$nombres,$apellidos,$correo,$telefono,$fecha_nacimiento,$genero);
                    if ($id_new_empleado > 0) {
                        $arr_Respuesta = array('status' => true, 'mensaje' => 'Registro Exitoso');
                    } else {
                        $arr_Respuesta = array('status' => false, 'mensaje' => 'Error al registrar usuario');
                    }
                }
            }
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "listarEmpleadosPaginado") {
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
        $totalEmpleados = $objEmpleado->contarTotalEmpleados(); // Usamos la nueva función del modelo
        $total_paginas = ceil($totalEmpleados / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arrEmpleado = $objEmpleado->listarEmpleadosPaginado($resultados_por_pagina, $offset); // Usamos la nueva función

        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---

        if (!empty($arrEmpleado)) {
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arrEmpleado); $i++) {
                if ($arrEmpleado[$i]->genero == "M") {
                    $arrEmpleado[$i]->genero = "Masculino";
                } else if ($arrEmpleado[$i]->genero == "F") {
                    $arrEmpleado[$i]->genero = "Femenino";
                }

                $id_empleado = $arrEmpleado[$i]->id;
                // Importante: Sanitizar la salida para prevenir XSS
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_empleado . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_empleado . ')"><i class="fas fa-trash-alt"></i></button>';
                $arrEmpleado[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arrEmpleado;
            
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

?>