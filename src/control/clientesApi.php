<?php 
session_start();
require_once('../model/admin-sesionModel.php');
require_once('../model/admin-clientesApiModel.php');
require_once('../model/adminModel.php');

$tipo = $_GET['tipo'];

//instanciar la clase categoria model
$objSesion = new SessionModel();
$objClienteApi = new ClienteApiModel();
$objAdmin = new AdminModel();

//variables de sesion
$id_sesion = $_REQUEST['sesion'];
$token = $_REQUEST['token'];

if($tipo == "registrarCliente"){
    $arr_Respuesta = array('status' => false, 'msg' => 'Error_Sesion');
    if ($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        //print_r($_POST);
        //repuesta
        if ($_POST) {
            $ruc = $_POST['ruc'];
            $razon_social = strtoupper($_POST['razon_social']);
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            if(!is_numeric($ruc)||empty($ruc)||strlen($ruc)<11){
              $arr_Respuesta = array('status' => false, 'mensaje' => 'Error ruc');
            }else
            if ($razon_social == ""|| $correo == "" || $telefono == "") {
                $arr_Respuesta = array('status' => false, 'mensaje' => 'Error, campos vacíos');
            } else {
                $arrCliente = $objClienteApi->buscarClienteApiByRuc($ruc);
                if ($arrCliente) {
                    $arr_Respuesta = array('status' => false, 'mensaje' => 'Registro Fallido, Cliente ya se encuentra registrado');
                } else {
                    $id_new_cliente = $objClienteApi->registrarCliente($ruc,$razon_social,$correo,$telefono);
                    if ($id_new_cliente > 0) {
                        // array con los id de los sistemas al que tendra el acceso con su rol registrado
                        // caso de administrador y director
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
//LISTAR TODOS LAS PERSONAS
if($tipo == "listarPersonas"){
    $arr_Respuesta = array('status'=> false, 'contenido'=>'' ,'mensaje'=>'Error sesion');
    if($objSesion->verificar_sesion_si_activa($id_sesion, $token)) {
        $arr_Persona = $objPersona->listarPersonas();
        /* $arr_Producto = $objProducto->obtener_productos(); */
        if (!empty($arr_Persona)) {
            //recordemos que el array es para agregar las opciones de las categorias
                        for ($i=0; $i < count($arr_Persona); $i++) {
                            if($arr_Persona[$i]->genero == "M"){
                                $arr_Persona[$i]->genero = "Masculino";
                            }else if($arr_Persona[$i]->genero == "F"){
                                $arr_Persona[$i]->genero = "Femenino";
                            }
                        $id_persona      = $arr_Persona[$i]->id;
                        $dni             = $arr_Persona[$i]->dni;
                        $nombres          = $arr_Persona[$i]->nombres;
                        $apellidos         = $arr_Persona[$i]->apellidos;
                        $correo_electronico    = $arr_Persona[$i]->correo_electronico;
                        $telefono             = $arr_Persona[$i]->telefono;
                        $fecha_nacimiento     = $arr_Persona[$i]->fecha_nacimiento;
                        $genero             = $arr_Persona[$i]->genero;
                        $opciones = '<a href="'.BASE_URL.'editarProducto/'.$id_persona.'"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                        <button class="btn btn-danger btn-sm" onclick="eliminar_producto('.$id_persona.')"><i class="fas fa-trash-alt"></i></button>';
                        $arr_Persona[$i]->options = $opciones;
            }
            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Persona;
        }
    }
    echo json_encode($arr_Respuesta);
}

if ($tipo == "listarPersonasPaginado") {
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
        $total_personas = $objPersona->contarTotalPersonas(); // Usamos la nueva función del modelo
        $total_paginas = ceil($total_personas / $resultados_por_pagina);

        // 4. Obtener solo las personas para la página actual
        $arr_Persona = $objPersona->listarPersonasPaginado($resultados_por_pagina, $offset); // Usamos la nueva función

        // --- FIN DE CAMBIOS PARA PAGINACIÓN ---

        if (!empty($arr_Persona)) {
            // El resto de tu lógica para formatear los datos permanece igual
            for ($i = 0; $i < count($arr_Persona); $i++) {
                if ($arr_Persona[$i]->genero == "M") {
                    $arr_Persona[$i]->genero = "Masculino";
                } else if ($arr_Persona[$i]->genero == "F") {
                    $arr_Persona[$i]->genero = "Femenino";
                }

                $id_persona = $arr_Persona[$i]->id;
                // Importante: Sanitizar la salida para prevenir XSS
                $opciones = '<a href="' . BASE_URL . 'editarProducto/' . $id_persona . '"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>
                             <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $id_persona . ')"><i class="fas fa-trash-alt"></i></button>';
                $arr_Persona[$i]->options = $opciones;
            }

            $arr_Respuesta['status'] = true;
            $arr_Respuesta['contenido'] = $arr_Persona;
            
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